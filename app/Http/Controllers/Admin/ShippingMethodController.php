<?php

namespace App\Http\Controllers\Admin;

use App\CPU\BackEndHelper;
use App\Http\Controllers\Controller;
use App\Model\ShippingMethod;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShippingMethodController extends Controller
{
    public function index()
    {
        $shipping_methods = ShippingMethod::where(['creator_type' => 'admin'])->whereNotIn('id', [1])->get();
        return view('admin-views.shipping-method.add-new', compact('shipping_methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|max:200',
            'duration' => 'required',
            'cost'     => 'numeric',
        ]);

        DB::table('shipping_methods')->insert([
            'creator_id'   => auth('admin')->id(),
            'creator_type' => 'admin',
            'title'        => $request['title'],
            'duration'     => $request['duration'],
            'cost'         => BackEndHelper::currency_to_usd($request['cost']),
            'status'       => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        Toastr::success('Successfully added.');
        return back();
    }

    public function status_update(Request $request)
    {
        ShippingMethod::where(['id' => $request['id']])->update([
            'status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function edit($id)
    {
        if ($id != 1) {
            $method = ShippingMethod::where(['id' => $id])->first();
            return view('admin-views.shipping-method.edit', compact('method'));
        }
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|max:200',
            'duration' => 'required',
            'cost'     => 'numeric',
        ]);

        DB::table('shipping_methods')->where(['id' => $id])->update([
            'creator_id'   => auth('admin')->id(),
            'creator_type' => 'admin',
            'title'        => $request['title'],
            'duration'     => $request['duration'],
            'cost'         => BackEndHelper::currency_to_usd($request['cost']),
            'status'       => 1,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        Toastr::success('Successfully updated.');
        return redirect()->route('admin.business-settings.shipping-method.add');
    }

    // public function delete($id)
    // {
    //     try {
    //         ShippingMethod::where(['id' => $id])->delete();
    //     } catch (\Exception $e) {

    //     }
    //     Toastr::success('Successfully removed.');
    //     return back();
    // }
    public function delete(Request $request)
    {

        $shipping = ShippingMethod::find($request->id);

        $shipping->delete();
        return response()->json();
    }
}
