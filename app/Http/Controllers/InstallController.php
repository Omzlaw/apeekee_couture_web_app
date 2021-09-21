<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class InstallController extends Controller
{
    public function step0()
    {
        return view('installation.step0');
    }

    public function step1()
    {
        session('purchase_code', '12345');
        $permission['curl_enabled'] = function_exists('curl_version');
        $permission['db_file_write_perm'] = is_writable(base_path('.env'));
        $permission['routes_file_write_perm'] = is_writable(base_path('app/Providers/RouteServiceProvider.php'));
        return view('installation.step1', compact('permission'));
    }

    public function step2()
    {
        return view('installation.step2');
    }

    public function step3($error = "")
    {
        // if (session()->has('purchase_code') == false && $error == "") {
        //     session()->flash('error', 'Purchase code is required!');
        //     return redirect('step2');
        // }

        // if ($error == "") {
        //     return view('installation.step3');
        // } else {
        //     return view('installation.step3', compact('error'));
        // }
        dd();
        $this->step4();
    }

    public function step4()
    {
        // if (env('PURCHASE_CODE') == null) {
        //     session()->flash('error', 'Purchase code is required!');
        //     return redirect('step2');
        // }

        return view('installation.step4');
    }

    public function step5()
    {
        // if (env('PURCHASE_CODE') == null) {
        //     session()->flash('error', 'Purchase code is required!');
        //     return redirect('step2');
        // }

        return view('installation.step5');
    }

    public function purchase_code(Request $request)
    {
        try {
            $request->session()->put('purchase_code', $request->purchase_code);
            $api = 'https://api.envato.com/v3/market/author/sale?code=' . $request->purchase_code;
            $client = new \GuzzleHttp\Client(['base_uri' => $api]);
            $headers = ['Authorization' => 'Bearer ' . base64_decode('TlloaG1TME1lZHoxbWpjTUE1c1cwWEF3YWg1Q3B2SGg='), 'Accept' => 'application/json',];
            $response = $client->request('GET', '', ['headers' => $headers]);
            $result = json_decode((string)$response->getBody(), true);
            /*return $result;*/
            return redirect('step3');

        } catch (\Exception $ex) {
return redirect('step3');
        }

    }

    public function system_settings(Request $request)
    {
        DB::table('admins')->insertOrIgnore([
            'name' => $request['admin_name'],
            'email' => $request['admin_email'],
            'admin_role_id' => 1,
            'password' => bcrypt($request['admin_password']),
            'phone' => $request['admin_phone'],
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('business_settings')->where(['type' => 'company_name'])->update([
            'value' => $request['web_name']
        ]);

        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        //sleep(5);
        return view('installation.step6');
    }

    public function database_installation(Request $request)
    {
        if (self::check_database_connection($request->DB_HOST, $request->DB_DATABASE, $request->DB_USERNAME, $request->DB_PASSWORD)) {

            $key = base64_encode(random_bytes(32));
            $output = 'APP_NAME=laravel
                    APP_ENV=live
                    APP_KEY=base64:' . $key . '
                    APP_DEBUG=false
                    APP_INSTALL=true
                    APP_LOG_LEVEL=debug
                    APP_URL=' . URL::to('/') . '

                    DB_CONNECTION=mysql
                    DB_HOST=' . $request->DB_HOST . '
                    DB_PORT=3306
                    DB_DATABASE=' . $request->DB_DATABASE . '
                    DB_USERNAME=' . $request->DB_USERNAME . '
                    DB_PASSWORD=' . $request->DB_PASSWORD . '

                    BROADCAST_DRIVER=log
                    CACHE_DRIVER=file
                    SESSION_DRIVER=file
                    SESSION_LIFETIME=120
                    QUEUE_DRIVER=sync

                    REDIS_HOST=127.0.0.1
                    REDIS_PASSWORD=null
                    REDIS_PORT=6379

                    PUSHER_APP_ID=
                    PUSHER_APP_KEY=
                    PUSHER_APP_SECRET=
                    PUSHER_APP_CLUSTER=mt1

                    PURCHASE_CODE=' . session('purchase_code') . '
                    BUYER_USERNAME=' . 00 . '
                    ';
            $file = fopen(base_path('.env'), 'w');
            fwrite($file, $output);
            fclose($file);

            $path = base_path('.env');
            if (file_exists($path)) {
                return redirect('step4');
            } else {
                return redirect('step3');
            }
        } else {
            return redirect('step3/database_error');
        }
    }

    public function import_sql()
    {
        $sql_path = base_path('installation/database.sql');
        DB::unprepared(file_get_contents($sql_path));
        return redirect('step5');
    }

    function check_database_connection($db_host = "", $db_name = "", $db_user = "", $db_pass = "")
    {

        if (@mysqli_connect($db_host, $db_user, $db_pass, $db_name)) {
            return true;
        } else {
            return false;
        }
    }
}
