<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\User;
use Brian2694\Toastr\Facades\Toastr;

class CustomerController extends Controller
{
    public function customer_list()
    {
        $customers = User::with(['orders'])->latest()->get();
        return view('admin-views.customer.list', compact('customers'));
    }

    public function view($id)
    {
        $customer = User::find($id);
        if (isset($customer)) {
            $orders = Order::latest()->where(['customer_id' => $id])->paginate(5);
            return view('admin-views.customer.customer-view', compact('customer', 'orders'));
        }
        Toastr::error('Customer not found!');
        return back();
    }
}
