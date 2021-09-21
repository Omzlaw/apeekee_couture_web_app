<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Viewport-->
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="">
    <link rel="icon" type="image/png" sizes="32x32" href="">
    <link rel="icon" type="image/png" sizes="16x16" href="">

    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/theme.min.css">
    <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/slick.css">
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css"/>
    @stack('css_or_js')
</head>
<!-- Body-->
<body class="toolbar-enabled">
<!-- Page Content-->
<div class="container pb-5 mb-2 mb-md-4">
    <div class="row mt-5">
        @php($config=\App\CPU\Helpers::get_business_settings('ssl_commerz_payment'))
        @if($config['status'])
            <div class="col-md-6 mb-4" style="cursor: pointer">
                <div class="card">
                    <div class="card-body" style="height: 100px">
                        <form action="{{ url('/pay-ssl-app') }}" method="POST" class="needs-validation">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                            <button class="btn btn-block" type="submit">
                                <img width="150"
                                     src="{{asset('public/assets/front-end/img/sslcomz.png')}}"/>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
        @if($config['status'])
            <div class="col-md-6 mb-4" style="cursor: pointer">
                <div class="card">
                    <div class="card-body" style="height: 100px">
                        <form class="needs-validation" method="POST" id="payment-form"
                              action="{{route('pay-paypal-app')}}">
                            {{ csrf_field() }}
                            <button class="btn btn-block" type="submit">
                                <img width="150"
                                     src="{{asset('public/assets/front-end/img/paypal.png')}}"/>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endif


        @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
        @if($config['status'])
            <div class="col-md-6 mb-4" style="cursor: pointer">
                <div class="card">
                    <div class="card-body" style="height: 100px">
                        @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                        <form class="needs-validation" method="POST" id="payment-form"
                              action="{{route('pay-stripe')}}">
                            {{ csrf_field() }}
                            <button class="btn btn-block" type="button"
                                    onclick="$('.stripe-button-el').click()">
                                <img width="150" style="margin-top: -10px"
                                     src="{{asset('public/assets/front-end/img/stripe.png')}}"/>
                            </button>
                            @php($order=\App\Model\Order::find(session('order_id')))
                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="{{$config['published_key']}}"
                                    data-amount="{{($order['order_amount'])*100}}"
                                    data-name="{{$order->customer->f_name}}"
                                    data-description=""
                                    data-image=""
                                    data-locale="auto"
                                    data-currency="USD">
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        @php($config=\App\CPU\Helpers::get_business_settings('razor_pay'))
        @php($order=\App\Model\Order::find(session('order_id')))
        @php($amount=$order->order_amount)
        @php($inr=\App\Model\Currency::where(['symbol'=>'₹'])->first())
        @php($usd=\App\Model\Currency::where(['code'=>'usd'])->first())
        @if(isset($inr) && isset($usd) && $config['status'])
            @php($rate=$usd['exchange_rate']/$inr['exchange_rate'])
            <div class="col-md-6 mb-4" style="cursor: pointer">
                <div class="card">
                    <div class="card-body" style="height: 100px">
                        <form action="{!!route('payment-razor')!!}" method="POST">
                        @csrf
                        <!-- Note that the amount is in paise = 50 INR -->
                            <!--amount need to be in paisa-->
                            <script src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="{{ \Illuminate\Support\Facades\Config::get('razor.razor_key') }}"
                                    data-amount="{{(round($amount/$rate))*100}}"
                                    data-buttontext="Pay {{($amount)*100}} INR"
                                    data-name="{{\App\Model\BusinessSetting::where(['type'=>'company_name'])->first()->value}}"
                                    data-description=""
                                    data-image="{{asset('storage/app/public/company/'.\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)}}"
                                    data-prefill.name="{{$order->customer->f_name}}"
                                    data-prefill.email="{{$order->customer->email}}"
                                    data-theme.color="#ff7529">
                            </script>
                        </form>
                        <button class="btn btn-block" type="button"
                                onclick="$('.razorpay-payment-button').click()">
                            <img width="150"
                                 src="{{asset('public/assets/front-end/img/razor.png')}}"/>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery-2.2.4.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
{{--Toastr--}}
<script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
<script src="{{asset('public/assets/front-end')}}/js/sweet_alert.js"></script>

<script>
    setInterval(function () {
        $('.stripe-button-el').hide()
    }, 10)

    setTimeout(function () {
        $('.stripe-button-el').hide();
        $('.razorpay-payment-button').hide();
    }, 10)

</script>

</body>
</html>
