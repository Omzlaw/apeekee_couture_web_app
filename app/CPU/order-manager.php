<?php

namespace App\CPU;

use App\Model\Order;
use App\Model\Product;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderManager
{
    public static function track_order($order_id)
    {
        return Order::where(['id' => $order_id])->first();
    }

    public static function place_order($customer_id, $email, $customer_info, $cart, $payment_method, $discount)
    {
        try {
            $or = [
                'id' => 100000 + Order::all()->count() + 1,
                'customer_id' => $customer_id,
                'customer_type' => 'customer',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'payment_method' => $payment_method,
                'transaction_ref' => null,
                'discount_amount' => $discount,
                'discount_type' => $discount == 0 ? null : 'coupon_discount',
                'order_amount' => CartManager::cart_grand_total($cart) - $discount,
                'shipping_address' => $customer_info['address_id'],
                'created_at' => now(),
                'updated_at' => now()
            ];

            $o_id = DB::table('orders')->insertGetId($or);

            foreach ($cart as $c) {
                $product = Product::where('id', $c['id'])->first();
                $or_d = [
                    'order_id' => $o_id,
                    'product_id' => $c['id'],
                    'seller_id' => $product->added_by == 'seller' ? $product->user_id : '0',
                    'product_details' => $product,
                    'qty' => $c['quantity'],
                    'price' => $c['price'],
                    'tax' => $c['tax']*$c['quantity'],
                    'discount' => $c['discount']*$c['quantity'],
                    'discount_type' => 'discount_on_product',
                    'variant' => $c['variant'],
                    'variation' => json_encode($c['variations']),
                    'delivery_status' => 'pending',
                    'shipping_method_id' => $c['shipping_method_id'],
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                if ($c['variations'] != null) {
                    $type = $c['variations'][0]['type'];
                    $var_store = [];
                    foreach (json_decode($product['variation'], true) as $var) {
                        if ($type == $var['type']) {
                            $var['qty'] -= $c['quantity'];
                        }
                        array_push($var_store, $var);
                    }
                    Product::where(['id' => $product['id']])->update([
                        'variation' => json_encode($var_store),
                    ]);
                }

                Product::where(['id' => $product['id']])->update([
                    'current_stock' => $product['current_stock'] - $c['quantity']
                ]);

                DB::table('order_details')->insert($or_d);
            }

            $fcm_token = User::where(['id'=>$customer_id])->first()->cm_firebase_token;
            $value = \App\CPU\Helpers::order_status_update_message('pending');
            try {
                if ($value) {
                    $data = [
                        'title' => 'Order',
                        'description' => $value,
                        'order_id' => $o_id,
                        'image' => '',
                    ];
                    Helpers::send_push_notif_to_device($fcm_token, $data);
                }
            } catch (\Exception $e) {
            }

            Mail::to($email)->send(new \App\Mail\OrderPlaced($o_id));
        } catch (\Exception $e) {
        }

        return $o_id;
    }
}
