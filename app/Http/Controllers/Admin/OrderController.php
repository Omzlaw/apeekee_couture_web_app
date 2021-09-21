<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\AdminWallet;
use App\Model\BusinessSetting;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\SellerWallet;
use App\Model\ShippingMethod;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function list($status) {
        if ($status != 'all') {
            $orders = Order::with(['customer'])->where(['order_status' => $status])->latest()->paginate(15);
        } else {
            $orders = Order::with(['customer'])->latest()->paginate(15);
        }

        return view('admin-views.order.list', compact('orders'));
    }

    public function details($id)
    {
        $order = Order::with('details', 'details.shipping', 'shipping', 'seller')->where(['id' => $id])->first();
        return view('admin-views.order.order-details', compact('order'));
    }

    public function status(Request $request)
    {
        $order = Order::find($request->id);
        $fcm_token = $order->customer->cm_firebase_token;
        $value = Helpers::order_status_update_message($request->order_status);
        try {
            if ($value) {
                $data = [
                    'title' => 'Order',
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                ];
                Helpers::send_push_notif_to_device($fcm_token, $data);
            }
        } catch (\Exception $e) {
            return response()->json([]);
        }

        if ($request->ajax()) {
            $order->order_status = $request->order_status;

            if ($request->order_status == 'returned' || $request->order_status == 'failed' || $request->order_status == 'canceled') {
                foreach ($order->details as $detail) {
                    if ($detail['is_stock_decreased'] == 1) {
                        $product = Product::find($detail['product_id']);
                        $type = $detail['variant'];
                        $var_store = [];
                        foreach (json_decode($product['variation'], true) as $var) {
                            if ($type == $var['type']) {
                                $var['qty'] += $detail['qty'];
                            }
                            array_push($var_store, $var);
                        }
                        Product::where(['id' => $product['id']])->update([
                            'variation' => json_encode($var_store),
                            'current_stock' => $product['current_stock'] + $detail['qty'],
                        ]);
                        OrderDetail::where(['id' => $detail['id']])->update([
                            'is_stock_decreased' => 0
                        ]);
                    }
                }
            } else {
                foreach ($order->details as $detail) {
                    if ($detail['is_stock_decreased'] == 0) {
                        $product = Product::find($detail['product_id']);

                        //check stock
                        foreach ($order->details as $c) {
                            $product = Product::find($c['product_id']);
                            $type = $detail['variant'];
                            foreach (json_decode($product['variation'], true) as $var) {
                                if ($type == $var['type'] && $var['qty'] < $c['qty']) {
                                    Toastr::error('Stock is insufficient!');
                                    return back();
                                }
                            }
                        }

                        $type = $detail['variant'];
                        $var_store = [];
                        foreach (json_decode($product['variation'], true) as $var) {
                            if ($type == $var['type']) {
                                $var['qty'] -= $detail['qty'];
                            }
                            array_push($var_store, $var);
                        }
                        Product::where(['id' => $product['id']])->update([
                            'variation' => json_encode($var_store),
                            'current_stock' => $product['current_stock'] - $detail['qty'],
                        ]);
                        OrderDetail::where(['id' => $detail['id']])->update([
                            'is_stock_decreased' => 1
                        ]);
                    }
                }
            }

            $order->save();
            $data = $request->order_status;
            return response()->json($data);
        }
    }

    public function payment_status(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::find($request->id);
            $order->payment_status = $request->payment_status;
            $order->save();
            $data = $request->payment_status;
            return response()->json($data);
        }
    }

    public function productStatus(Request $request)
    {
        if ($request->ajax()) {
            $order = OrderDetail::find($request->id);
            if ($order->delivery_status == 'delivered') {
                return response()->json(['success' => 0, 'message' => 'order is already delivered.'], 200);
            }
            $order->delivery_status = $request->delivery_status;
            $order->save();
            $data = $request->delivery_status;

            if ($order->seller_id != 0 && $request->delivery_status == 'delivered') {

                $commission = BusinessSetting::where('type', 'sales_commission')->first()->value;
                $commission_amount = (($order->price / 100) * $commission) * $order->qty;

                $shipping = ShippingMethod::find($order->shipping_method_id);
                $tax = $order->tax;
                $discount = $order->discount;
                $total = ($order->price * $order->qty) + $tax - $discount + ($shipping->creator_type == 'seller' ? $shipping->cost : 0);

                DB::table('seller_wallet_histories')->insert([
                    'seller_id'  => $order->seller_id,
                    'amount'     => $total - $commission_amount,
                    'order_id'   => $order->order_id,
                    'product_id' => $order->product_id,
                    'payment'    => 'received',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('admin_wallet_histories')->insert([
                    'admin_id'   => Admin::where('admin_role_id', 1)->first()->id,
                    'amount'     => $commission_amount + ($shipping->creator_type == 'admin' ? $shipping->cost : 0),
                    'order_id'   => $order->order_id,
                    'product_id' => $order->product_id,
                    'payment'    => 'received',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                if (SellerWallet::where('seller_id', $order->seller_id)->first() == false) {
                    DB::table('seller_wallets')->insert([
                        'seller_id'  => $order->seller_id,
                        'balance'    => 0,
                        'withdrawn'  => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                if (AdminWallet::where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->first() == false) {
                    DB::table('admin_wallets')->insert([
                        'admin_id'   => Admin::where('admin_role_id', 1)->first()->id,
                        'balance'    => 0,
                        'withdrawn'  => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                DB::table('seller_wallets')->where('seller_id', $order->seller_id)->increment('balance', $total - $commission_amount);
                DB::table('admin_wallets')->where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->increment('balance', $commission_amount + ($shipping->creator_type == 'admin' ? $shipping->cost : 0));

            } elseif ($order->seller_id == 0 && $request->delivery_status == 'delivered') {
                $shipping = ShippingMethod::find($order->shipping_method_id);
                $tax = $order->tax;
                $discount = $order->discount;
                $total = ($order->price * $order->qty) + $tax - $discount + $shipping->cost;

                DB::table('admin_wallet_histories')->insert([
                    'admin_id'   => Admin::where('admin_role_id', 1)->first()->id,
                    'amount'     => $total,
                    'order_id'   => $order->order_id,
                    'product_id' => $order->product_id,
                    'payment'    => 'received',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                if (AdminWallet::where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->first() == false) {
                    DB::table('admin_wallets')->insert([
                        'admin_id'   => Admin::where('admin_role_id', 1)->first()->id,
                        'balance'    => 0,
                        'withdrawn'  => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                DB::table('admin_wallets')->where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->increment('balance', $total);
            }

            return response()->json($data);
        }
    }

    public function generate_invoice($id)
    {
        $order = Order::with('shipping')->where('id', $id)->first();
        // dd($order)->toArray();

        $data["email"] = $order->customer["email"];
        $data["client_name"] = $order->customer["f_name"] . ' ' . $order->customer["l_name"];
        $data["order"] = $order;
        //return view('admin-views.order.invoice', compact('order'));
        $pdf = PDF::loadView('admin-views.order.invoice', $data);
        return $pdf->download($order->id . '.pdf');
    }

}
