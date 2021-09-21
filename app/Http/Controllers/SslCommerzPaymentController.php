<?php

namespace App\Http\Controllers;

use App\CPU\CartManager;
use App\CPU\Convert;
use App\CPU\Helpers;
use App\Library\sslcommerz\SslCommerzNotification;
use App\Model\Order;
use App\Model\Product;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function App\CPU\convert_price;

class SslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
        $value = CartManager::cart_grand_total(session('cart')) - $coupon_discount;

        $post_data = array();
        $post_data['total_amount'] = Convert::usdTobdt($value);
        $post_data['currency'] = 'BDT';
        $post_data['tran_id'] = Str::random(6) . '-' . rand(1, 1000); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = auth('customer')->user()->f_name . ' ' . auth('customer')->user()->l_name;
        $post_data['cus_email'] = auth('customer')->user()->email;
        $post_data['cus_add1'] = auth('customer')->user()->street_address == null ? 'address' : auth('customer')->user()->street_address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "";
        $post_data['cus_phone'] = auth('customer')->user()->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Shipping";
        $post_data['ship_add1'] = "address 1";
        $post_data['ship_add2'] = "address 2";
        $post_data['ship_city'] = "City";
        $post_data['ship_state'] = "State";
        $post_data['ship_postcode'] = "ZIP";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Country";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        try {
            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data, 'hosted');
            if (!is_array($payment_options)) {
                Toastr::error('Gateway is not supported your currency.');
                return back();
            }
        } catch (\Exception $exception) {
            Toastr::error('Misconfiguration or data is missing!');
            return back();
        }
    }

    public function success(Request $request)
    {
        $customer_info = session('customer_info');
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        try {
            $sslc = new SslCommerzNotification();
            $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

            if (session()->has('payment_mode') && session('payment_mode') == 'app') {
                DB::table('orders')->where(['id' => session('order_id')])->update([
                    'customer_type' => 'customer',
                    'payment_status' => 'paid',
                    'order_status' => 'confirmed',
                    'payment_method' => 'sslcommerz',
                    'transaction_ref' => $request['tran_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                if ($validation == TRUE) {
                    return redirect()->route('payment-success');
                } else {
                    return redirect()->route('payment-fail');
                }
            } else {
                $order_id = 100000 + Order::all()->count() + 1;
                DB::table('orders')->insertGetId([
                    'id' => $order_id,
                    'customer_id' => auth('customer')->id(),
                    'order_amount' => Convert::bdtTousd($request['amount']),
                    'customer_type' => 'customer',
                    'payment_status' => 'paid',
                    'order_status' => 'confirmed',
                    'payment_method' => 'sslcommerz',
                    'discount_amount' => session()->has('coupon_discount') ? session('coupon_discount') : 0,
                    'discount_type' => session()->has('coupon_discount') ? 'coupon_discount' : '',
                    'shipping_address' => $customer_info['address_id'],
                    'transaction_ref' => $request['tran_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                foreach (session('cart') as $c) {
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
                        'updated_at' => now(),
                    ];
                    DB::table('order_details')->insert($or_d);
                }
                $order_detials = DB::table('orders')
                    ->where('transaction_ref', $tran_id)
                    ->select('id', 'transaction_ref', 'order_status', 'order_amount')->first();
                if ($validation == TRUE) {
                    session()->forget('cart');
                    session()->forget('coupon_code');
                    session()->forget('coupon_discount');
                    session()->forget('payment_method');
                    session()->forget('shipping_method_id');
                    $order_id = $order_detials->id;
                    return view('web-views.checkout-complete', compact('order_id'));
                } else {
                    DB::table('orders')
                        ->where('transaction_ref', $tran_id)
                        ->update(['order_status' => 'failed']);
                    Toastr::error('Payment failed!');
                    return back();
                }
            }
        } catch (\Exception $exception) {
            if (session()->has('payment_mode') && session('payment_mode') == 'app') {
                return redirect()->route('payment-fail');
            }
            Toastr::info('Your session is expired!');
            return back();
        }
    }

    public function fail(Request $request)
    {
        try {
            $order_detials = DB::table('orders')
                ->where('transaction_ref', $request['tran_id'])
                ->select('transaction_ref', 'order_status', 'order_amount')->first();
            if ($order_detials->order_status == 'pending') {
                DB::table('orders')
                    ->where('transaction_ref', $request['tran_id'])
                    ->update(['order_status' => 'failed']);
                Toastr::warning('Transaction is Falied');
            } else if ($order_detials->order_status == 'processing' || $order_detials->order_status == 'complete') {
                Toastr::warning('Transaction is already Successful');
            } else {
                Toastr::warning('Transaction is Invalid');
            }
            session()->forget('cart');
            session()->forget('coupon_code');
            session()->forget('coupon_discount');
            session()->forget('payment_method');
            session()->forget('shipping_method_id');
        } catch (\Exception $exception) {
            if (session()->has('payment_mode') && session('payment_mode') == 'app') {
                return redirect()->route('payment-fail');
            }
            Toastr::error('Payment process failed!');
            return back();
        }

        if (session()->has('payment_mode') && session('payment_mode') == 'app') {
            return redirect()->route('payment-fail');
        }
        return view('web-views.payment-failed');
    }

    public function cancel(Request $request)
    {
        try {
            $order_detials = DB::table('orders')
                ->where('transaction_ref', $request['tran_id'])
                ->select('transaction_ref', 'order_status', 'order_amount')->first();
            if ($order_detials->order_status == 'pending') {
                DB::table('orders')
                    ->where('transaction_ref', $request['tran_id'])
                    ->update(['order_status' => 'canceled']);
                Toastr::warning('Transaction is Cancel');
            } else if ($order_detials->order_status == 'processing' || $order_detials->order_status == 'complete') {
                Toastr::warning('Transaction is already Successful');
            } else {
                Toastr::warning('Transaction is Invalid');
            }
            session()->forget('cart');
            session()->forget('coupon_code');
            session()->forget('coupon_discount');
            session()->forget('payment_method');
            session()->forget('shipping_method_id');
        } catch (\Exception $exception) {
            if (session()->has('payment_mode') && session('payment_mode') == 'app') {
                return redirect()->route('payment-fail');
            }
            Toastr::error('Payment process cancelled!');
            return back();
        }
        if (session()->has('payment_mode') && session('payment_mode') == 'app') {
            return redirect()->route('payment-fail');
        }
        return view('web-views.payment-failed');
    }

    //for app
    public function index_app(Request $request)
    {
        $order = Order::find(session('order_id'));
        $customer = User::find(session('customer_id'));
        $value = $order->order_amount;

        $post_data = array();
        $post_data['total_amount'] = $value;
        $post_data['currency'] = 'USD';
        $post_data['tran_id'] = Str::random(6) . '-' . rand(1, 1000); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $customer->l_name;
        $post_data['cus_email'] = $customer->email;
        $post_data['cus_add1'] = $customer->street_address == null ? 'address' : $customer->street_address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "";
        $post_data['cus_phone'] = $customer->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Shipping";
        $post_data['ship_add1'] = "address 1";
        $post_data['ship_add2'] = "address 2";
        $post_data['ship_city'] = "City";
        $post_data['ship_state'] = "State";
        $post_data['ship_postcode'] = "ZIP";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Country";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        try {
            $sslc = new SslCommerzNotification();
            $payment_options = $sslc->makePayment($post_data, 'hosted');
            if (!is_array($payment_options)) {
                Toastr::error('Gateway is not supported your currency.');
                return back();
            }
        } catch (\Exception $exception) {
            Toastr::error('Misconfiguration or data is missing!');
            return back();
        }
    }

}
