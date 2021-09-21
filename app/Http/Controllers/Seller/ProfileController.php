<?php

namespace App\Http\Controllers\Seller;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Seller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function view()
    {
        $data = Seller::where('id', auth('seller')->id())->first();
        return view('seller-views.profile.view', compact('data'));
    }

    public function edit($id)
    {
        $data = Seller::where('id', $id)->first();
        return view('seller-views.profile.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $seller = Seller::find($id);
        $seller->f_name = $request->f_name;
        $seller->l_name = $request->l_name;
        $seller->phone = $request->phone;
        if ($request->image) {
            $seller->image = ImageManager::update('seller/', $seller->image, 'png', $request->file('image'));
        }
        $seller->save();

        Toastr::info('Profile updated successfully!');
        return back();
    }

    public function settings_password_update(Request $request)
    {
        $request->validate([
            'password' => 'required|same:confirm_password|min:8',
            'confirm_password' => 'required',
        ]);

        $seller = Seller::find(auth('seller')->id());
        $seller->password = bcrypt($request['password']);
        $seller->save();
        Toastr::success('Seller password updated successfully!');
        return back();
    }

    public function bank_update(Request $request, $id)
    {
        $bank = Seller::find($id);
        $bank->bank_name = $request->bank_name;
        $bank->branch = $request->branch;
        $bank->holder_name = $request->holder_name;
        $bank->account_no = $request->account_no;
        $bank->save();
        Toastr::success('Bank Info updated');
        return redirect()->route('seller.profile.view');
    }

    public function bank_edit($id)
    {
        $data = Seller::where('id', $id)->first();
        return view('seller-views.profile.bankEdit', compact('data'));
    }

}
