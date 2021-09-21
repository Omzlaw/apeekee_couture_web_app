@extends('layouts.back-end.app')
@section('title','Payment Method')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.payment_method')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{trans('messages.payment_method')}}</h4>
    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{trans('messages.system_default')}} {{trans('messages.payment_method')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('cash_on_delivery'))
                    <form action="{{route('admin.business-settings.payment-method.update',['cash_on_delivery'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{trans('messages.cash_on_delivery')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label
                                    style="padding-left: 10px">{{trans('messages.Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label
                                    style="padding-left: 10px">{{trans('messages.Inactive')}}</label>
                                <br>
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{trans('messages.save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{trans('messages.SSLCOMMERZ')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('ssl_commerz_payment'))
                    <form action="{{route('admin.business-settings.payment-method.update',['ssl_commerz_payment'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{trans('messages.ssl_commerz_payment')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Inactive')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Store')}} {{trans('messages.ID')}} </label><br>
                                <input type="text" class="form-control" name="store_id" value="{{env('APP_MODE')=='demo'?'':$config['store_id']}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Store')}} {{trans('messages.password')}}</label><br>
                                <input type="text" class="form-control" name="store_password"
                                       value="{{env('APP_MODE')=='demo'?'':$config['store_password']}}">
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{trans('messages.save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{trans('messages.Paypal')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('paypal'))
                    <form action="{{route('admin.business-settings.payment-method.update',['paypal'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{trans('messages.Paypal')}} {{trans('messages.Payment')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Inactive')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Paypal')}} {{trans('messages.Client')}}{{trans('messages.ID')}}  </label><br>
                                <input type="text" class="form-control" name="paypal_client_id"
                                       value="{{env('APP_MODE')=='demo'?'':$config['paypal_client_id']}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Paypal')}} {{trans('messages.Secret')}} </label><br>
                                <input type="text" class="form-control" name="paypal_secret"
                                       value="{{env('APP_MODE')=='demo'?'':$config['paypal_secret']}}">
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{trans('messages.save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{trans('messages.Stripe')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('stripe'))
                    <form action="{{route('admin.business-settings.payment-method.update',['stripe'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{trans('messages.stripe')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Inactive')}} </label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Published')}}{{trans('messages.Key')}}  </label><br>
                                <input type="text" class="form-control" name="published_key"
                                       value="{{env('APP_MODE')=='demo'?'':$config['published_key']}}">
                            </div>

                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.api_key')}}</label><br>
                                <input type="text" class="form-control" name="api_key"
                                       value="{{env('APP_MODE')=='demo'?'':$config['api_key']}}">
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{trans('messages.save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6 pt-4">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{trans('messages.razor_pay')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('razor_pay'))
                    <form action="{{route('admin.business-settings.payment-method.update',['razor_pay'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{trans('messages.razor_pay')}}</label>
                            </div>
                            <div class="form-group mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label style="padding-left: 10px">{{trans('messages.Inactive')}} </label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Key')}}  </label><br>
                                <input type="text" class="form-control" name="razor_key"
                                       value="{{env('APP_MODE')=='demo'?'':$config['razor_key']}}">
                            </div>

                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.secret')}}</label><br>
                                <input type="text" class="form-control" name="razor_secret"
                                       value="{{env('APP_MODE')=='demo'?'':$config['razor_secret']}}">
                            </div>
                            <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                    onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}"
                                    class="btn btn-primary mb-2">{{trans('messages.save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--<div class="row" style="padding-bottom: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5 class="text-center">{{trans('messages.Paytm')}}</h5>
                    @php($config=\App\CPU\Helpers::get_business_settings('paytm'))
                    <form action="{{route('admin.business-settings.payment-method.update',['paytm'])}}"
                          method="post">
                        @csrf
                        @if(isset($config))
                            <div class="form-group mb-2">
                                <label class="control-label">{{trans('messages.paytm')}}</label>
                            </div>
                            <div class="form-group col-md-12 mb-2 mt-2">
                                <input type="radio" name="status" value="1" {{$config['status']==1?'checked':''}}>
                                <label
                                    style="padding-left: 10px">{{trans('messages.Active')}}</label>
                                <br>
                            </div>
                            <div class="form-group col-md-12 mb-2">
                                <input type="radio" name="status" value="0" {{$config['status']==0?'checked':''}}>
                                <label
                                    style="padding-left: 10px">{{trans('messages.Inactive')}}</label>
                                <br>
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Merchant')}} {{trans('messages.ID')}}</label><br>
                                <input type="text" class="form-control" name="paytm_merchant_id"
                                       value="{{$config['paytm_merchant_id']}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.merchant_key')}}</label><br>
                                <input type="text" class="form-control" name="paytm_merchant_key"
                                       value="{{$config['paytm_merchant_key']}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Website')}}</label><br>
                                <input type="text" class="form-control" name="paytm_merchant_website"
                                       value="{{$config['paytm_merchant_website']}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.Channel')}}</label><br>
                                <input type="text" class="form-control" name="paytm_channel"
                                       value="{{$config['paytm_channel']}}">
                            </div>
                            <div class="form-group mb-2">
                                <label style="padding-left: 10px">{{trans('messages.industry')}}{{trans('messages.Type')}} </label><br>
                                <input type="text" class="form-control" name="paytm_industry_type"
                                       value="{{$config['paytm_industry_type']}}">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>--}}
</div>
@endsection

@push('script')

@endpush
