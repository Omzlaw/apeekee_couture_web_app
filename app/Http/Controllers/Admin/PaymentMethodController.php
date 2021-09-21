<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\BusinessSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    public function index()
    {
        return view('admin-views.business-settings.payment-method.index');
    }

    public function update(Request $request, $name)
    {

        if ($name == 'cash_on_delivery') {
            $payment = BusinessSetting::where('type', 'cash_on_delivery')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'cash_on_delivery',
                    'value' => json_encode([
                        'status' => $request['status']
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'cash_on_delivery'])->update([
                    'type' => 'cash_on_delivery',
                    'value' => json_encode([
                        'status' => $request['status']
                    ]),
                    'updated_at' => now()
                ]);
            }
        } elseif ($name == 'ssl_commerz_payment') {
            $payment = BusinessSetting::where('type', 'ssl_commerz_payment')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'ssl_commerz_payment',
                    'value' => json_encode([
                        'status' => 1,
                        'store_id' => '',
                        'store_password' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'ssl_commerz_payment'])->update([
                    'type' => 'ssl_commerz_payment',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'store_id' => $request['store_id'],
                        'store_password' => $request['store_password'],
                    ]),
                    'updated_at' => now()
                ]);
            }
        } elseif ($name == 'paypal') {
            $payment = BusinessSetting::where('type', 'paypal')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'paypal',
                    'value' => json_encode([
                        'status' => 1,
                        'paypal_client_id' => '',
                        'paypal_secret' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'paypal'])->update([
                    'type' => 'paypal',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'paypal_client_id' => $request['paypal_client_id'],
                        'paypal_secret' => $request['paypal_secret'],
                    ]),
                    'updated_at' => now()
                ]);
            }
        }elseif ($name == 'stripe') {
            $payment = BusinessSetting::where('type', 'stripe')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'stripe',
                    'value' => json_encode([
                        'status' => 1,
                        'api_key' => '',
                        'published_key' => ''
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'stripe'])->update([
                    'type' => 'stripe',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'api_key' => $request['api_key'],
                        'published_key' => $request['published_key']
                    ]),
                    'updated_at' => now()
                ]);
            }
        }elseif ($name == 'razor_pay') {
            $payment = BusinessSetting::where('type', 'razor_pay')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'razor_pay',
                    'value' => json_encode([
                        'status' => 1,
                        'razor_key' => '',
                        'razor_secret' => ''
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'razor_pay'])->update([
                    'value' => json_encode([
                        'status' => $request['status'],
                        'razor_key' => $request['razor_key'],
                        'razor_secret' => $request['razor_secret']
                    ]),
                    'updated_at' => now()
                ]);
            }
        }elseif ($name == 'paytm') {
            $payment = BusinessSetting::where('type', 'paytm')->first();
            if (isset($payment) == false) {
                DB::table('business_settings')->insert([
                    'type' => 'paytm',
                    'value' => json_encode([
                        'status' => 1,
                        'paytm_merchant_id' => '',
                        'paytm_merchant_key' => '',
                        'paytm_merchant_website' => '',
                        'paytm_channel' => '',
                        'paytm_industry_type' => '',
                    ]),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            } else {
                DB::table('business_settings')->where(['type' => 'paytm'])->update([
                    'type' => 'paytm',
                    'value' => json_encode([
                        'status' => $request['status'],
                        'paytm_merchant_id' => $request['paytm_merchant_id'],
                        'paytm_merchant_key' => $request['paytm_merchant_key'],
                        'paytm_merchant_website' => $request['paytm_merchant_website'],
                        'paytm_channel' => $request['paytm_channel'],
                        'paytm_industry_type' => $request['paytm_industry_type'],
                    ]),
                    'updated_at' => now()
                ]);
            }
        }

        return back();
    }
}
