@extends('layouts.front-end.app')

@section('title','Choose Payment Method')

@push('css_or_js')
    <style>
        .stripe-button-el {
            display: none !important;
        }

        .razorpay-payment-button {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header" style="background: #dcdcdc;line-height: 1px">
                    <span>{{ trans('messages.payment_method')}}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                @include('web-views.partials._checkout-steps',['step'=>3])
                <!-- Payment methods accordion-->
                    <h2 class="h6 pb-3 mb-2 mt-5">{{trans('messages.choose_payment')}}</h2>

                    <div class="row">
                        @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                        @if($config['status'])
                            <div class="col-md-6 mb-4" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body" style="height: 100px">
                                        <a class="btn btn-block"
                                           href="{{route('checkout-complete',['payment_method'=>'cash_on_delivery'])}}">
                                            <img width="150" style="margin-top: -10px"
                                                 src="{{asset('public/assets/front-end/img/cod.png')}}"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @php($config=\App\CPU\Helpers::get_business_settings('ssl_commerz_payment'))
                        @if($config['status'])
                            <div class="col-md-6 mb-4" style="cursor: pointer">
                                <div class="card">
                                    <div class="card-body" style="height: 100px">
                                        <form action="{{ url('/pay-ssl') }}" method="POST" class="needs-validation">
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
                                              action="{{route('pay-paypal')}}">
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



                        @php($coupon_discount = session()->has('coupon_discount') ? session('coupon_discount') : 0)
                        @php($value = \App\CPU\CartManager::cart_grand_total(session('cart')) - $coupon_discount)

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
                                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                    data-key="{{$config['published_key']}}"
                                                    data-amount="{{($value-$coupon_discount)*100}}"
                                                    data-name="{{auth('customer')->user()->f_name}}"
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
                        @php($amount=$value-$coupon_discount)
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
                                                    data-prefill.name="{{auth('customer')->user()->f_name}}"
                                                    data-prefill.email="{{auth('customer')->user()->email}}"
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
                    <!-- Navigation (desktop)-->
                    <div class="row">
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a class="btn btn-secondary btn-block" href="{{route('checkout-shipping')}}">
                                <span class="d-none d-sm-inline">Back to Shipping</span>
                                <span class="d-inline d-sm-none">Back</span>
                            </a>
                        </div>
                        <div class="col-4"></div>
                    </div>
                </div>
            </section>
            <!-- Sidebar-->
            @include('web-views.partials._order-summary')
        </div>
    </div>
@endsection

@push('script')
    <script>
        setTimeout(function () {
            $('.stripe-button-el').hide();
            $('.razorpay-payment-button').hide();
        }, 10)
    </script>
@endpush
