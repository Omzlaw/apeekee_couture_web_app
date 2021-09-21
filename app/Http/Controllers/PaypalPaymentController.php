<?php

namespace App\Http\Controllers;

use App\CPU\CartManager;
use App\Model\Order;
use App\Model\Product;
use App\Model\ShippingMethod;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;

class PaypalPaymentController extends Controller
{
    public function __construct()
    {
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithpaypal(Request $request)
    {
        $cart = session('cart');
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items_array = [];

        $item = new Item();
        $item->setName('Products')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice(CartManager::cart_grand_total($cart) - $coupon_discount);
        array_push($items_array, $item);

        $item_list = new ItemList();
        $item_list->setItems($items_array);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal(CartManager::cart_grand_total($cart) - $coupon_discount);

        $tran = Str::random(6) . '-' . rand(1, 1000);
        session()->put('transaction_ref', $tran);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($tran);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paypal-status'))
            ->setCancelUrl(URL::route('home'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
                return Redirect::away($redirect_url);
            }

        } catch (\Exception $ex) {
            Toastr::error('Payment process is failed.');
            return back();
        }

        Session::put('error', 'Unknown error occurred');
        return back();

    }

    public function getPaymentStatus(Request $request)
    {
        $cart = session('cart');
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $customer_info = session('customer_info');
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        if (empty($request['PayerID']) || empty($request['token'])) {
            Session::put('error', 'Payment failed');
            return back();
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request['PayerID']);

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            if (session()->has('payment_mode') && \session('payment_mode') == 'app') {
                DB::table('orders')
                    ->where(['id'=>\session('order_id')])->update([
                        'payment_status' => 'paid',
                        'order_status' => 'confirmed',
                        'payment_method' => 'paypal',
                        'transaction_ref' => $request['paymentId'],
                        'updated_at' => now()
                    ]);
                return redirect()->route('payment-success');
            }

            $order_id = 100000 + Order::all()->count() + 1;
            DB::table('orders')
                ->insertGetId([
                    'id' => $order_id,
                    'customer_id' => auth('customer')->id(),
                    'customer_type' => 'customer',
                    'payment_status' => 'paid',
                    'order_amount' => CartManager::cart_grand_total($cart) - $coupon_discount,
                    'order_status' => 'confirmed',
                    'payment_method' => 'paypal',
                    'discount_amount' => session()->has('coupon_discount') ? session('coupon_discount') : 0,
                    'discount_type' => session()->has('coupon_discount') ? 'coupon_discount' : '',
                    'shipping_address' => $customer_info['address_id'],
                    'transaction_ref' => $request['paymentId'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            foreach ($cart as $c) {
                $product = Product::where('id', $c['id'])->first();
                $or_d = [
                    'order_id' => $order_id,
                    'product_id' => $c['id'],
                    'seller_id' => $product->added_by == 'seller' ? $product->user_id : '0',
                    'product_details' => $product,
                    'qty' => $c['quantity'],
                    'price' => $c['price'],
                    'tax' => $c['tax'] * $c['quantity'],
                    'discount' => $c['discount'] * $c['quantity'],
                    'discount_type' => 'discount_on_product',
                    'variant' => $c['variant'],
                    'variation' => json_encode($c['variations']),
                    'delivery_status' => 'pending',
                    'shipping_method_id' => $c['shipping_method_id'],
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                DB::table('order_details')->insert($or_d);
            }

            session()->forget('cart');
            session()->forget('coupon_code');
            session()->forget('coupon_discount');
            session()->forget('payment_method');
            session()->forget('shipping_method_id');

            return view('web-views.checkout-complete', compact('order_id'));
        }

        return Redirect::route('/');
    }


    //for app
    public function payWithpaypalApp(Request $request)
    {
        $order = Order::find(session('order_id'));

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $items_array = [];

        $item = new Item();
        $item->setName('Products')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($order['order_amount']);
        array_push($items_array, $item);

        $item_list = new ItemList();
        $item_list->setItems($items_array);

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($order['order_amount']);

        $tran = Str::random(6) . '-' . rand(1, 1000);
        session()->put('transaction_ref', $tran);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription($tran);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::route('paypal-status'))
            ->setCancelUrl(URL::route('home'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        try {
            $payment->create($this->_api_context);

            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }

            /** add payment ID to session **/
            Session::put('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
                return Redirect::away($redirect_url);
            }

        } catch (\Exception $ex) {
            Toastr::error('Payment process is failed.');
            return back();
        }

        Session::put('error', 'Unknown error occurred');
        return back();

    }

    public function success()
    {
        if (session()->has('payment_mode') && \session('payment_mode') == 'app') {
            return redirect()->route('payment-success');
        }
        if (auth('customer')->check()) {
            Toastr::success('Payment success.');
            return redirect('/account-oder');
        }
        return response()->json(['message' => 'Payment succeeded'], 200);
    }

    public function fail()
    {
        if (session()->has('payment_mode') && \session('payment_mode') == 'app') {
            return redirect()->route('payment-fail');
        }

        if (auth('customer')->check()) {
            Toastr::error('Payment failed.');
            return redirect('/account-oder');
        }
        return response()->json(['message' => 'Payment failed'], 403);
    }
}
