<?php

namespace App\Providers;

use App\Model\BusinessSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class PaymentConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $data = BusinessSetting::where(['type' => 'paytm'])->first();
            $paytm = json_decode($data['value'], true);
            if ($paytm) {
                $config = array(
                    'env' => 'production', // values : (local | production)
                    'merchant_id' => $paytm['paytm_merchant_id'],
                    'merchant_key' => $paytm['paytm_merchant_key'],
                    'merchant_website' => $paytm['paytm_merchant_website'],
                    'channel' => $paytm['paytm_channel'],
                    'industry_type' => $paytm['paytm_industry_type'],
                );
                Config::set('paytm', $config);
            }

            $data = BusinessSetting::where(['type' => 'paypal'])->first();
            $paypal = json_decode($data['value'], true);
            if ($paypal) {
                $config = array(
                    'client_id' => $paypal['paypal_client_id'], // values : (local | production)
                    'secret' => $paypal['paypal_secret'],
                    'settings' => array(
                        'mode' => env('PAYPAL_MODE', 'live'), //live||sandbox
                        'http.ConnectionTimeOut' => 30,
                        'log.LogEnabled' => true,
                        'log.FileName' => storage_path() . '/logs/paypal.log',
                        'log.LogLevel' => 'ERROR'
                    ),
                );
                Config::set('paypal', $config);
            }

            $data = BusinessSetting::where(['type' => 'ssl_commerz_payment'])->first();
            $ssl = json_decode($data['value'], true);
            if ($ssl) {
                $config = array(
                    'projectPath' => env('PROJECT_PATH'),
                    'apiDomain' => env("API_DOMAIN_URL", "https://securepay.sslcommerz.com"),
                    'apiCredentials' => [
                        'store_id' => $ssl['store_id'],
                        'store_password' => $ssl['store_password'],
                    ],
                    'apiUrl' => [
                        'make_payment' => "/gwprocess/v4/api.php",
                        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
                        'order_validate' => "/validator/api/validationserverAPI.php",
                        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
                        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
                    ],
                    'connect_from_localhost' => env("IS_LOCALHOST", false), // For Sandbox, use "true", For Live, use "false"
                    'success_url' => '/success',
                    'failed_url' => '/fail',
                    'cancel_url' => '/cancel',
                    'ipn_url' => '/ipn',
                );
                Config::set('sslcommerz', $config);
            }

            $data = BusinessSetting::where(['type' => 'razor_pay'])->first();
            $razor = json_decode($data['value'], true);
            if ($razor) {
                $config = array(
                    'razor_key' => env('RAZOR_KEY', $razor['razor_key']),
                    'razor_secret' => env('RAZOR_SECRET', $razor['razor_secret'])
                );
                Config::set('razor', $config);
            }

        } catch (\Exception $ex) {

        }
    }
}
