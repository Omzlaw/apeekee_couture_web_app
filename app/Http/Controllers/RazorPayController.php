<?php

namespace App\Http\Controllers;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\Model\Order;
use App\Model\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use Redirect;
use Session;

class RazorPayController extends Controller
{
    public function payWithRazorpay()
    {
        return view('razor-pay');
    }

    public function payment(Request $request)
    {
        $customer_info = session('customer_info');
        $cart = session('cart');
        $coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;

        try {
            $api = new Api(config('razor.razor_key'), config('razor.razor_secret'));
            $payment = $api->payment->fetch($request['razorpay_payment_id']);

            if (count($request->all()) && !empty($request['razorpay_payment_id'])) {
                $response = $api->payment->fetch($request['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));

                if (session()->has('payment_mode') && session('payment_mode') == 'app') {
                    DB::table('orders')->where(['id' => session('order_id')])->update([
                        'customer_type' => 'customer',
                        'payment_status' => 'paid',
                        'order_status' => 'confirmed',
                        'payment_method' => 'razor_pay',
                        'transaction_ref' => $request['tran_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $order_id = session('order_id');
                } else {
                    $order_id = DB::table('orders')
                        ->insertGetId([
                            'id' => 100000 + Order::all()->count() + 1,
                            'customer_id' => auth('customer')->id(),
                            'customer_type' => 'customer',
                            'payment_status' => 'paid',
                            'order_amount' => CartManager::cart_grand_total($cart) - $coupon_discount,
                            'order_status' => 'confirmed',
                            'payment_method' => 'razor_pay',
                            'discount_amount' => session()->has('coupon_discount') ? session('coupon_discount') : 0,
                            'discount_type' => session()->has('coupon_discount') ? 'coupon_discount' : '',
                            'transaction_ref' => $response['id'],
                            'shipping_address' => $customer_info['address_id'],
                            'created_at' => now(),
                            'updated_at' => now(),
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
                }

                $order = Order::find($order_id);
                $fcm_token = $order->customer->cm_firebase_token;
                $value = Helpers::order_status_update_message('confirmed');
                if ($value) {
                    $data = [
                        'title' => 'Order',
                        'description' => $value,
                        'order_id' => $order['id'],
                        'image' => '',
                    ];
                    Helpers::send_push_notif_to_device($fcm_token, $data);
                }
            }

            session()->forget('cart');
            session()->forget('coupon_code');
            session()->forget('coupon_discount');
            session()->forget('payment_method');
            session()->forget('shipping_method_id');

        } catch (\Exception $exception) {
            Toastr::error('Payment process failed');
            return back();
        }

        if (session()->has('payment_mode') && session('payment_mode') == 'app') {
            return redirect()->route('payment-success');
        }

        return view('web-views.checkout-complete', compact('order_id'));
    }

    public function success()
    {
        if (auth('customer')->check()) {
            Toastr::success('Payment success.');
            return redirect('/account-oder');
        }
        return response()->json(['message' => 'Payment succeeded'], 200);
    }

    public function fail()
    {
        if (auth('customer')->check()) {
            Toastr::error('Payment failed.');
            return redirect('/account-oder');
        }
        return response()->json(['message' => 'Payment failed'], 403);
    }
}
