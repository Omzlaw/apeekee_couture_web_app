@extends('layouts.front-end.app')

@section('title','Review Order')

@push('css_or_js')
    <style>
        .stripe-button-el {
            display: none !important;
        }
        .razorpay-payment-button{
            display: none!important;
        }
    </style>
@endpush

@section('content')
    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <div class="col-md-12 mb-5 pt-5">
                <div class="feature_header" style="background: #dcdcdc;line-height: 1px">
                    <span>{{ trans('messages.checkout_review')}}</span>
                </div>
            </div>
            <section class="col-lg-8">
                <hr>
                <div class="checkout_details mt-3">
                @include('web-views.partials._checkout-steps',['step'=>4])
                <!-- Order details-->
                    <h2 class="h6 pt-1 pb-3 mb-3 mt-5">{{ trans('messages.review_your_order')}}</h2>
                    <!-- Item-->
                    @foreach(\App\CPU\CartManager::get_cart() as $cart)
                        <?php
                        $products = \App\CPU\ProductManager::get_product($cart['id']);
                        ?>
                        <div class="d-sm-flex justify-content-between align-items-center my-4 pb-3 border-bottom">

                            <div
                                class="media media-ie-fix d-block d-sm-flex align-items-center text-center text-sm-left">
                                <a
                                    class="d-inline-block mx-auto mr-sm-4" href="javascript:" style="width: 10rem;">
                                    <img
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$products['thumbnail']}}"
                                        alt="Product"></a>
                                <div class="media-body pt-2">
                                    <h3 class="product-title font-size-base mb-2">
                                        <a href="javascript:">{{$products['name']}}</a>
                                    </h3>
                                    <small>
                                        QTY : {{$cart['quantity']}}
                                    </small>
                                    @foreach($cart['variations'] as $key1 =>$variation)
                                        <div class="font-size-sm"><span
                                                class="text-muted mr-2">{{$key1}} :</span>{{$variation}}</div>
                                    @endforeach
                                    <div
                                        class=" text-accent">{{ \App\CPU\Helpers::currency_converter($cart['price']-$cart['discount']) }}</div>
                                    @if($cart['discount'] > 0)
                                        <strike style="font-size: 12px!important;color: grey!important;">
                                            {{\App\CPU\Helpers::currency_converter($cart['price'])}}
                                        </strike>
                                    @endif
                                </div>
                            </div>
                        </div>
                @endforeach
                <!-- Item-->
                    <!-- Client details-->
                    <div class="bg-secondary rounded-lg px-4 pt-4 pb-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="h6">{{ trans('messages.Ship')}} {{ trans('messages.to')}} :</h4>
                                @php($data=session('customer_info'))
                                @php($address=\App\Model\ShippingAddress::find($data['address_id']))
                                @if(isset($address))
                                    <ul class="list-unstyled font-size-sm">
                                        <li><span
                                                class="text-muted">{{ trans('messages.Client')}}:&nbsp;</span>{{$address['contact_person_name']}}
                                        </li>
                                        <li><span
                                                class="text-muted">{{ trans('messages.address')}}:&nbsp;</span>{{$address['address']}}
                                        </li>
                                        <li><span
                                                class="text-muted">{{ trans('messages.Phone')}}:&nbsp;</span>{{$address['phone']}}
                                        </li>
                                    </ul>
                                @else
                                    <ul class="list-unstyled font-size-sm">
                                        <li>
                                            <span class="text-muted">{{ trans('messages.Client')}}:&nbsp;</span>
                                            {{auth('customer')->user()->f_name}}
                                        </li>
                                        <li><span
                                                class="text-muted">{{ trans('messages.address')}}:&nbsp;</span>{{$data['shipping_address']}}
                                        </li>
                                        <li><span
                                                class="text-muted">{{ trans('messages.Phone')}}:&nbsp;</span>{{auth('customer')->user()->phone}}
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <h4 class="h6">{{ trans('messages.payment_method')}}:</h4>
                                <ul class="list-unstyled font-size-sm">
                                    @if(session()->has('payment_method') && session('payment_method')=='cash_on_delivery')
                                        <li><span
                                                class="text-muted">{{ trans('messages.cash_on_delivery')}}&nbsp;</span>
                                        </li>
                                    @elseif(session()->has('payment_method') && session('payment_method')=='ssl_commerz_payment')
                                        <li><span class="text-muted">{{ trans('messages.SSLCOMMERZ')}}</span></li>
                                    @elseif(session()->has('payment_method') && session('payment_method')=='paypal')
                                        <li><span class="text-muted">{{ trans('messages.Paypal')}}</span></li>
                                    @elseif(session()->has('payment_method') && session('payment_method')=='stripe')
                                        <li><span class="text-muted">{{ trans('messages.Stripe')}}</span></li>
                                    @elseif(session()->has('payment_method') && session('payment_method')=='paytm')
                                        <li><span class="text-muted">{{ trans('messages.Paytm')}}</span></li>
                                    @elseif(session()->has('payment_method') && session('payment_method')=='razor_pay')
                                        <li><span class="text-muted">{{ trans('messages.razor_pay')}}</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Navigation (desktop)-->
                    <div class="row">
                        <div class="col-6">
                            <a class="btn btn-secondary btn-block"
                               href="{{route('checkout-payment')}}">
                                <i class="czi-arrow-left mt-sm-0 mr-1"></i>
                                <span
                                    class="d-none d-sm-inline">{{ trans('messages.Back')}} {{ trans('messages.to')}} {{ trans('messages.Payment')}}  </span>
                                <span class="d-inline d-sm-none">{{ trans('messages.Back')}}</span></a>
                        </div>
                        <div class="col-6">
                            @if(session('payment_method')=='cash_on_delivery')
                                <a class="btn btn-primary btn-block" href="{{route('checkout-complete')}}">
                                    <span
                                        class="d-none d-sm-inline">{{ trans('messages.Complete')}} {{ trans('messages.Order')}}</span>
                                    <span class="d-inline d-sm-none">{{ trans('messages.Complete')}}</span>
                                    <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                                </a>
                            @elseif(session('payment_method')=='ssl_commerz_payment')
                                <form action="{{ url('/pay-ssl') }}" method="POST" class="needs-validation">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token"/>
                                    <button class="btn btn-primary btn-block" type="submit">
                                        <span
                                            class="d-none d-sm-inline">{{ trans('messages.Complete')}} {{ trans('messages.Order')}}</span>
                                        <span class="d-inline d-sm-none">{{ trans('messages.Complete')}}</span>
                                        <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                                    </button>
                                </form>
                            @elseif(session('payment_method')=='paypal')
                                <form class="needs-validation" method="POST" id="payment-form"
                                      action="{{route('pay-paypal')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary btn-block" type="submit">
                                        <span
                                            class="d-none d-sm-inline">{{ trans('messages.Complete')}} {{ trans('messages.Order')}}</span>
                                        <span class="d-inline d-sm-none">{{ trans('messages.Complete')}}</span>
                                        <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                                    </button>
                                </form>
                            @elseif(session('payment_method')=='stripe')
                                @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                                <form class="needs-validation" method="POST" id="payment-form"
                                      action="{{route('pay-stripe')}}">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary btn-block" type="button"
                                            onclick="$('.stripe-button-el').click()">
                                        <span
                                            class="d-none d-sm-inline">{{ trans('messages.Complete')}} {{ trans('messages.Order')}}</span>
                                        <span class="d-inline d-sm-none">{{ trans('messages.Complete')}}</span>
                                        <i class="czi-arrow-right mt-sm-0 ml-1"></i>
                                    </button>

                                    @php($sub_total=0)
                                    @php($total_tax=0)
                                    @php($total_shipping_cost=0)
                                    @php($total_discount_on_product=0)
                                    @if(session()->has('cart') && count( session()->get('cart')) > 0)
                                        @foreach(session('cart') as $key => $cartItem)
                                            @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
                                            @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                                            @php($total_shipping_cost+=$cartItem['shipping_cost'])
                                            @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
                                        @endforeach
                                    @endif
                                    @php($coupon_dis=session()->has('coupon_discount')?session('coupon_discount'):0)

                                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                            data-key="{{$config['published_key']}}"
                                            data-amount="{{($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)*100}}"
                                            data-name="{{auth('customer')->user()->f_name}}"
                                            data-description=""
                                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                            data-locale="auto"
                                            data-currency="usd">
                                    </script>
                                </form>
                            @elseif(session('payment_method')=='razor_pay')
                                @php($config=\App\CPU\Helpers::get_business_settings('razor_pay'))

                                @php($sub_total=0)
                                @php($total_tax=0)
                                @php($total_shipping_cost=0)
                                @php($total_discount_on_product=0)
                                @if(session()->has('cart') && count( session()->get('cart')) > 0)
                                    @foreach(session('cart') as $key => $cartItem)
                                        @php($sub_total+=$cartItem['price']*$cartItem['quantity'])
                                        @php($total_tax+=$cartItem['tax']*$cartItem['quantity'])
                                        @php($total_shipping_cost+=$cartItem['shipping_cost'])
                                        @php($total_discount_on_product+=$cartItem['discount']*$cartItem['quantity'])
                                    @endforeach
                                @endif
                                @php($coupon_dis=session()->has('coupon_discount')?session('coupon_discount'):0)

                                <form action="{!!route('payment-razor')!!}" method="POST">
                                @csrf
                                <!-- Note that the amount is in paise = 50 INR -->
                                    <!--amount need to be in paisa-->
                                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                                            data-key="{{ \Illuminate\Support\Facades\Config::get('razor.razor_key') }}"
                                            data-amount="{{($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)*100}}"
                                            data-buttontext="Pay {{($sub_total+$total_tax+$total_shipping_cost-$coupon_dis-$total_discount_on_product)*100}} INR"
                                            data-name="{{\App\Model\BusinessSetting::where(['type'=>'company_name'])->first()->value}}"
                                            data-description=""
                                            data-image="{{asset('storage/app/public/company/'.\App\Model\BusinessSetting::where(['type'=>'company_web_logo'])->first()->value)}}"
                                            data-prefill.name="{{auth('customer')->user()->f_name}}"
                                            data-prefill.email="{{auth('customer')->user()->email}}"
                                            data-theme.color="#ff7529">
                                    </script>
                                </form>

                                <button class="btn btn-primary btn-block" type="button"
                                        onclick="$('.razorpay-payment-button').click()">
                                    <i class="czi-card"></i> Pay Now
                                </button>
                            @endif
                        </div>
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
