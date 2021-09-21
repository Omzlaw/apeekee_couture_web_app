<?php

namespace App\Http\Controllers\Admin;

use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use App\Model\SocialMedia;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusinessSettingsController extends Controller
{
    public function index()
    {
        return view('admin-views.business-settings.general-settings');
    }

    public function about_us()
    {
        $about_us = BusinessSetting::where('type', 'about_us')->first();
        return view('admin-views.business-settings.about-us', [
            'about_us' => $about_us,
        ]);

    }

    public function about_usUpdate(Request $data)
    {
        $validatedData = $data->validate([
            'about_us' => 'required',
        ]);
        BusinessSetting::where('type', 'about_us')->update(['value' => $data->about_us]);
        Toastr::success('About Us updated successfully!');
        return back();
    }

    // Social Media
    public function social_media()
    {
        // $about_us = BusinessSetting::where('type', 'about_us')->first();
        return view('admin-views.business-settings.social-media');
    }

    public function fetch(Request $request)
    {
        if ($request->ajax()) {
            $data = SocialMedia::where('status', 1)->orderBy('id', 'desc')->get();
            return response()->json($data);
        }
    }

    public function social_media_store(Request $request)
    {
        $check = SocialMedia::where('name', $request->name)->first();
        if ($check != null) {
            return response()->json([
                'error' => 1,
            ]);
        }
        if ($request->name == 'google-plus') {
            $icon = 'fa fa-google-plus-square';
        }
        if ($request->name == 'facebook') {
            $icon = 'fa fa-facebook';
        }
        if ($request->name == 'twitter') {
            $icon = 'fa fa-twitter';
        }
        if ($request->name == 'pinterest') {
            $icon = 'fa fa-pinterest';
        }
        if ($request->name == 'instagram') {
            $icon = 'fa fa-instagram';
        }
        if ($request->name == 'linkedin') {
            $icon = 'fa fa-linkedin';
        }
        $social_media = new SocialMedia;
        $social_media->name = $request->name;
        $social_media->link = $request->link;
        $social_media->icon = $icon;
        $social_media->save();
        return response()->json([
            'success' => 1,
        ]);
    }

    public function social_media_edit(Request $request)
    {
        $data = SocialMedia::where('id', $request->id)->first();
        return response()->json($data);
    }

    public function social_media_update(Request $request)
    {
        $social_media = SocialMedia::find($request->id);
        $social_media->name = $request->name;
        $social_media->link = $request->link;
        $social_media->save();
        return response()->json();
    }

    public function social_media_delete(Request $request)
    {

        try {
            $br = SocialMedia::find($request->id);
            $br->delete();
        } catch (Exception $e) {

        }

        Toastr::success('Removed successfully!');
        // return back();
        return response()->json();
    }

    public function social_media_status_update(Request $request)
    {
        SocialMedia::where(['id' => $request['id']])->update([
            'active_status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function terms_condition()
    {
        $terms_condition = BusinessSetting::where('type', 'terms_condition')->get();
        return view('admin-views.business-settings.terms-condition', compact('terms_condition'));
    }

    public function updateTermsCondition(Request $data)
    {
        $validatedData = $data->validate([
            'value' => 'required',
        ]);
        BusinessSetting::where('type', 'terms_condition')->update(['value' => $data->value]);
        Toastr::success('Terms and Condition Updated successfully!');
        return redirect()->back();
    }

    public function companyInfo()
    {
        $company_name = BusinessSetting::where('type', 'company_name')->first();
        $company_email = BusinessSetting::where('type', 'company_email')->first();
        $company_phone = BusinessSetting::where('type', 'company_phone')->first();
        return view('admin-views.business-settings.website-info', [
            'company_name'  => $company_name,
            'company_email' => $company_email,
            'company_phone' => $company_phone,
        ]);
    }

    public function updateCompany(Request $data)
    {
        $validatedData = $data->validate([
            'company_name' => 'required',
        ]);
        BusinessSetting::where('type', 'company_name')->update(['value' => $data->company_name]);
        Toastr::success('Company Updated successfully!');
        return redirect()->back();
    }

    public function updateCompanyEmail(Request $data)
    {
        $validatedData = $data->validate([
            'company_email' => 'required',
        ]);
        BusinessSetting::where('type', 'company_email')->update(['value' => $data->company_email]);
        Toastr::success('Company Email Updated successfully!');
        return redirect()->back();
    }

    public function updateCompanyCopyRight(Request $data)
    {
        $validatedData = $data->validate([
            'company_copyright_text' => 'required',
        ]);
        BusinessSetting::where('type', 'company_copyright_text')->update(['value' => $data->company_copyright_text]);
        Toastr::success('Company Copy Right Updated successfully!');
        return redirect()->back();
    }

    public function update(Request $request, $name)
    {

        if ($name == 'download_app_apple_stroe') {
            $download_app_store = BusinessSetting::where('type', 'download_app_apple_stroe')->first();
            if (isset($download_app_store) == false) {
                DB::table('business_settings')->insert([
                    'type'       => 'download_app_apple_stroe',
                    'value'      => json_encode([
                        'status' => 1,
                        'link'   => '',

                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'download_app_apple_stroe'])->update([
                    'type'       => 'download_app_apple_stroe',
                    'value'      => json_encode([
                        'status' => $request['status'],
                        'link'   => $request['link'],

                    ]),
                    'updated_at' => now(),
                ]);
            }
        } elseif ($name == 'download_app_google_stroe') {
            $download_app_store = BusinessSetting::where('type', 'download_app_google_stroe')->first();
            if (isset($download_app_store) == false) {
                DB::table('business_settings')->insert([
                    'type'       => 'download_app_google_stroe',
                    'value'      => json_encode([
                        'status' => 1,
                        'link'   => '',

                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'download_app_google_stroe'])->update([
                    'type'       => 'download_app_google_stroe',
                    'value'      => json_encode([
                        'status' => $request['status'],
                        'link'   => $request['link'],

                    ]),
                    'updated_at' => now(),
                ]);
            }
        }
        Toastr::success('App Store Updated successfully');

        return back();
    }

    public function updateCompanyPhone(Request $data)
    {
        $validatedData = $data->validate([
            'company_phone' => 'required',
        ]);
        BusinessSetting::where('type', 'company_phone')->update(['value' => $data->company_phone]);
        Toastr::success('Company Phone Updated successfully!');
        return redirect()->back();
    }

    public function uploadWebLogo(Request $data)
    {
        $img = BusinessSetting::where(['type' => 'company_web_logo'])->pluck('value')[0];
        if($data->image)
        {
            $img = ImageManager::update('company/', $img, 'png', $data->file('image'));
        }

        BusinessSetting::where(['type' => 'company_web_logo'])->update([
            'value' => $img,
        ]);
        return back();
    }

    public function uploadFooterLog(Request $data)
    {
        $img = BusinessSetting::where(['type' => 'company_footer_logo'])->pluck('value')[0];
        if($data->image)
        {
            $img = ImageManager::update('company/', $img, 'png', $data->file('image'));
        }

        BusinessSetting::where(['type' => 'company_footer_logo'])->update([
            'value' => $img,
        ]);
        Toastr::success('Footer Logo updated successfully!');
        return back();

    }
    public function uploadFavIcon(Request $data)
    {
        $img = BusinessSetting::where(['type' => 'company_fav_icon'])->pluck('value')[0];

        if($data->image)
        {
            $img = ImageManager::update('company/', $img, 'png', $data->file('image'));
        }

        BusinessSetting::where(['type' => 'company_fav_icon'])->update([
            'value' => $img,
        ]);
        Toastr::success('Fav Icon updated successfully!');
        return back();

    }

    public function uploadMobileLogo(Request $data)
    {
        $img = BusinessSetting::where(['type' => 'company_mobile_logo'])->pluck('value')[0];
        if($data->image)
        {
            $img = ImageManager::update('company/', $img, 'png', $data->file('image'));
        }
        BusinessSetting::where(['type' => 'company_mobile_logo'])->update([
            'value' => $img,
        ]);
        return back();
    }

    public function update_colors(Request $request)
    {
        $colors = BusinessSetting::where('type', 'colors')->first();
        if (isset($colors)) {
            BusinessSetting::where('type', 'colors')->update([
                'value' => json_encode(
                    [
                        'primary'   => $request['primary'],
                        'secondary' => $request['secondary'],
                    ]),
            ]);
        } else {
            DB::table('business_settings')->insert([
                'type'  => 'colors',
                'value' => json_encode(
                    [
                        'primary'   => $request['primary'],
                        'secondary' => $request['secondary'],
                    ]),
            ]);
        }
        Toastr::success('Color  updated!');
        return back();
    }
    public function fcm_index()
    {
        if (BusinessSetting::where(['type' => 'fcm_topic'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'fcm_topic',
                'value' => '',
            ]);
        }
        if (BusinessSetting::where(['type' => 'fcm_project_id'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'fcm_project_id',
                'value' => '',
            ]);
        }
        if (BusinessSetting::where(['type' => 'push_notification_key'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'push_notification_key',
                'value' => '',
            ]);
        }

        if (BusinessSetting::where(['type' => 'order_pending_message'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'order_pending_message',
                'value' => json_encode([
                    'status'  => 0,
                    'message' => '',
                ]),
            ]);
        }

        if (BusinessSetting::where(['type' => 'order_confirmation_msg'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'order_confirmation_msg',
                'value' => json_encode([
                    'status'  => 0,
                    'message' => '',
                ]),
            ]);
        }

        if (BusinessSetting::where(['type' => 'order_processing_message'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'order_processing_message',
                'value' => json_encode([
                    'status'  => 0,
                    'message' => '',
                ]),
            ]);
        }

        if (BusinessSetting::where(['type' => 'out_for_delivery_message'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'out_for_delivery_message',
                'value' => json_encode([
                    'status'  => 0,
                    'message' => '',
                ]),
            ]);
        }

        if (BusinessSetting::where(['type' => 'order_delivered_message'])->first() == false) {
            BusinessSetting::insert([
                'type'  => 'order_delivered_message',
                'value' => json_encode([
                    'status'  => 0,
                    'message' => '',
                ]),
            ]);
        }

        return view('admin-views.business-settings.fcm-index');
    }

    public function update_fcm(Request $request)
    {
        DB::table('business_settings')->updateOrInsert(['type' => 'fcm_project_id'], [
            'value' => $request['fcm_project_id'],
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'push_notification_key'], [
            'value' => $request['push_notification_key'],
        ]);

        Toastr::success('Settings updated!');
        return back();
    }

    public function update_fcm_messages(Request $request)
    {
        DB::table('business_settings')->updateOrInsert(['type' => 'order_pending_message'], [
            'value' => json_encode([
                'status'  => $request['pending_status'],
                'message' => $request['pending_message'],
            ]),
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'order_confirmation_msg'], [
            'value' => json_encode([
                'status'  => $request['confirm_status'],
                'message' => $request['confirm_message'],
            ]),
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'order_processing_message'], [
            'value' => json_encode([
                'status'  => $request['processing_status'],
                'message' => $request['processing_message'],
            ]),
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'out_for_delivery_message'], [
            'value' => json_encode([
                'status'  => $request['out_for_delivery_status'],
                'message' => $request['out_for_delivery_message'],
            ]),
        ]);

        DB::table('business_settings')->updateOrInsert(['type' => 'order_delivered_message'], [
            'value' => json_encode([
                'status'  => $request['delivered_status'],
                'message' => $request['delivered_message'],
            ]),
        ]);

        Toastr::success('Message updated!');
        return back();
    }

    public function seller_settings()
    {
        $sales_commission = BusinessSetting::where('type', 'sales_commission')->first();
        if (!isset($sales_commission)) {
            DB::table('business_settings')->insert(['type' => 'sales_commission', 'value' => 0]);
        }

        $seller_registration = BusinessSetting::where('type', 'seller_registration')->first();
        if (!isset($seller_registration)) {
            DB::table('business_settings')->insert(['type' => 'seller_registration', 'value' => 1]);
        }

        return view('admin-views.business-settings.seller-settings');
    }

    public function sales_commission(Request $data)
    {
        $validatedData = $data->validate([
            'commission' => 'required|min:0',
        ]);
        $sales_commission = BusinessSetting::where('type', 'sales_commission')->first();

        if (isset($sales_commission)) {
            BusinessSetting::where('type', 'sales_commission')->update(['value' => $data->commission]);
        } else {
            DB::table('business_settings')->insert(['type' => 'sales_commission', 'value' => $data->commission]);
        }

        Toastr::success('Sales commission Updated successfully!');
        return redirect()->back();
    }

    public function seller_registration(Request $data)
    {
        $seller_registration = BusinessSetting::where('type', 'seller_registration')->first();
        if (isset($seller_registration)) {
            BusinessSetting::where(['type'=>'seller_registration'])->update(['value' => $data->seller_registration]);
        } else {
            DB::table('business_settings')->insert([
                'type' => 'seller_registration',
                'value' => $data->seller_registration,
                'updated_at'=>now()
            ]);
        }

        Toastr::success('Seller registration Updated successfully!');
        return redirect()->back();
    }
}
