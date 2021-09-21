<?php

namespace App\Http\Controllers;

use App\Model\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class UpdateController extends Controller
{
    public function update_software_index(){
        return view('update.update-software');
    }

    public function update_software(){
        Artisan::call('migrate', ['--force' => true]);
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        if (BusinessSetting::where(['type' => 'fcm_topic'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'fcm_topic',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'fcm_project_id'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'fcm_project_id',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'push_notification_key'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'push_notification_key',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_pending_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_pending_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_confirmation_msg'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_confirmation_msg',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_processing_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_processing_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'out_for_delivery_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'out_for_delivery_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'order_delivered_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'order_delivered_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'delivery_boy_assign_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'delivery_boy_assign_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'delivery_boy_start_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'delivery_boy_start_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'delivery_boy_delivered_message'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'delivery_boy_delivered_message',
                'value' => json_encode([
                    'status' => 0,
                    'message' => ''
                ])
            ]);
        }
        if (BusinessSetting::where(['type' => 'terms_and_conditions'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'terms_and_conditions',
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'razor_pay'])->first() == false) {
            BusinessSetting::insert([
                'type' => 'razor_pay',
                'value' => '{"status":"1","razor_key":"","razor_secret":""}'
            ]);
        }
        if (BusinessSetting::where(['type' => 'minimum_order_value'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'minimum_order_value'], [
                'value' => 1
            ]);
        }
        if (BusinessSetting::where(['type' => 'about_us'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'about_us'], [
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'privacy_policy'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'privacy_policy'], [
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'terms_and_conditions'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'terms_and_conditions'], [
                'value' => ''
            ]);
        }
        if (BusinessSetting::where(['type' => 'seller_registration'])->first() == false) {
            DB::table('business_settings')->updateOrInsert(['type' => 'seller_registration'], [
                'value' => 1
            ]);
        }

        return redirect('/admin/auth/login');
    }
}
