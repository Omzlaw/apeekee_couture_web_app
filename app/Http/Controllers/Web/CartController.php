<?php

namespace App\Http\Controllers\Web;


use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Color;
use App\Model\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';
        $quantity = 0;
        $price = 0;

        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $price = json_decode($product->variation)[$i]->price - Helpers::get_product_discount($product, json_decode($product->variation)[$i]->price);
                    $quantity = json_decode($product->variation)[$i]->qty;
                }
            }
        } else {
            $price = $product->unit_price - Helpers::get_product_discount($product, $product->unit_price);
            $quantity = $product->current_stock;
        }

        return array('price' => \App\CPU\Helpers::currency_converter($price * $request->quantity), 'quantity' => $quantity);
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        $data = array();
        $data['id'] = $product->id;
        $str = '';
        $variations = [];
        $price = 0;
        //chek if out of stock
        if ($product['current_stock'] < $request['quantity']) {
            return response()->json([
                'data' => 0
            ]);
        }
        //check the color enabled or disabled for the product
        if ($request->has('color')) {
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
            $variations['color'] = $str;
        }
        //Gets all the choice values of customer choice option and generate a string like Black-S-Cotton
        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            $data[$choice->name] = $request[$choice->name];
            $variations[$choice->title] = $request[$choice->name];
            if ($str != null) {
                $str .= '-' . str_replace(' ', '', $request[$choice->name]);
            } else {
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }
        $data['variations'] = $variations;
        $data['variant'] = $str;
        if ($request->session()->has('cart')) {
            if (count($request->session()->get('cart')) > 0) {
                foreach ($request->session()->get('cart') as $key => $cartItem) {
                    if ($cartItem['id'] == $request['id'] && $cartItem['variant'] == $str) {
                        return response()->json([
                            'data' => 1
                        ]);
                    }
                }

            }
        }
        //Check the string and decreases quantity for the stock
        if ($str != null) {
            $count = count(json_decode($product->variation));
            for ($i = 0; $i < $count; $i++) {
                if (json_decode($product->variation)[$i]->type == $str) {
                    $price = json_decode($product->variation)[$i]->price;
                    if (json_decode($product->variation)[$i]->qty < $request['quantity']) {
                        // $variations->$str->qty -= $request['quantity'];
                        // $product->variations = json_encode($variations);
                        // $product->save();
                        return response()->json([
                            'data' => 0
                        ]);
                    }
                    // else {
                    //     return response()->json([
                    //         'data' => 1
                    //     ]);
                    // }
                }
            }
        } else {
            $price = $product->unit_price;
        }

        $tax = ($price * $product->tax) / 100;
        $shipping_id = 1;
        $shipping_cost = 0;

        $data['quantity'] = $request['quantity'];
        $data['shipping_method_id'] = $shipping_id;
        $data['price'] = $price;
        $data['tax'] = $tax;
        $data['slug'] = $product->slug;
        $data['name'] = $product->name;
        $data['discount'] = Helpers::get_product_discount($product, $price);
        $data['shipping_cost'] = $shipping_cost;
        $data['thumbnail'] = $product->thumbnail;

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            $cart->push($data);
        } else {
            $cart = collect([$data]);
            $request->session()->put('cart', $cart);
        }

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateNavCart()
    {
        return view('layouts.front-end.partials.cart');
    }

    public function updateToolbar()
    {
        return view('layouts.front-end.partials._toolbar');
    }
    //removes from Cart
    public function removeFromCart(Request $request)
    {
        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart', collect([]));
            $cart->forget($request->key);
            $request->session()->put('cart', $cart);
        }

        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('shipping_method_id');

        return view('layouts.front-end.partials.cart_details');
    }

    //updated the quantity for a cart item
    public function updateQuantity(Request $request)
    {
        $status = 1;
        $qty = 0;
        $cart = $request->session()->get('cart', collect([]));
        $cart = $cart->map(function ($object, $key) use ($request, &$status, &$qty) {
            if ($key == $request->key) {
                $product = Product::find($object['id']);
                $count = count(json_decode($product->variation));
                if ($count) {
                    for ($i = 0; $i < $count; $i++) {
                        if (json_decode($product->variation)[$i]->type == $object['variant']) {
                            if (json_decode($product->variation)[$i]->qty < $request->quantity) {
                                $status = 0;
                                $qty = $object['quantity'];
                            } else {
                                $object['quantity'] = $request->quantity;
                            }
                        }
                    }
                } else if ($product['current_stock'] < $request->quantity) {
                    $status = 0;
                    $qty = $object['quantity'];
                } else {
                    $object['quantity'] = $request->quantity;
                }
            }
            return $object;
        });

        if ($status == 0) {
            return response()->json([
                'data' => $status,
                'qty' => $qty,
            ]);
        }

        $request->session()->put('cart', $cart);

        session()->forget('coupon_code');
        session()->forget('coupon_discount');

        return view('layouts.front-end.partials.cart_details');
    }
}
