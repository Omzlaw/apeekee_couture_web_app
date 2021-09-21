@extends('layouts.back-end.app')
@section('title','Seller Information')
@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        #company-footer-Logo .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        #company-mobile-Logo .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        #company-web-Logo .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        #company-fav-icon .modal-content {
            width: 1116px !important;
            margin-left: -264px !important;
        }

        @media (max-width: 768px) {
            #company-footer-Logo .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }

            #company-mobile-Logo .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }

            #company-web-Logo .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }

            #company-fav-icon .modal-content {
                width: 698px !important;
                margin-left: -75px !important;
            }


        }

        @media (max-width: 375px) {
            #company-footer-Logo .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #company-mobile-Logo .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #company-web-Logo .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

            #company-fav-icon .modal-content {
                width: 367px !important;
                margin-left: 0 !important;
            }

        }

        @media (max-width: 500px) {
            #company-footer-Logo .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #company-mobile-Logo .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #company-web-Logo .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }

            #company-fav-icon .modal-content {
                width: 400px !important;
                margin-left: 0 !important;
            }


        }

        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item"
                    aria-current="page">{{trans('messages.seller_settings')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0 text-black-50">{{trans('messages.sales')}} {{trans('messages.comission')}} {{trans('messages.Informations')}} </h4>
        </div>

        <div class="row" style="padding-bottom: 20px">
            @php($commission=\App\Model\BusinessSetting::where('type','sales_commission')->first())
            <div class="col-md-6">
                <div class="card-header">
                    <h5>Sales Commission</h5>
                </div>
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <form action="{{route('admin.business-settings.seller-settings.update-seller-settings')}}"
                              method="post">
                            @csrf
                            <label>Sales Commission ( % )</label>
                            <input class="form-control" name="commission"
                                   value="{{isset($commission)?$commission->value:0}}"
                                   min="0" max="100">
                            <hr>
                            <button type="submit"
                                    class="btn btn-primary float-right ml-3">{{trans('messages.Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>

            @php($seller_registration=\App\Model\BusinessSetting::where('type','seller_registration')->first()->value)
            <div class="col-md-6">
                <div class="card-header">
                    <h5>Seller Registration</h5>
                </div>
                <div class="card">
                    <div class="card-body" style="padding: 20px">
                        <form action="{{route('admin.business-settings.seller-settings.update-seller-registration')}}"
                              method="post">
                            @csrf
                            <label>Seller Registration on/off</label>
                            <div class="form-check">
                                <input class="form-check-input" name="seller_registration" type="radio" value="1"
                                       id="defaultCheck1" {{$seller_registration==1?'checked':''}}>
                                <label class="form-check-label" for="defaultCheck1">
                                    Turn on
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="seller_registration" type="radio" value="0"
                                       id="defaultCheck2" {{$seller_registration==0?'checked':''}}>
                                <label class="form-check-label" for="defaultCheck2">
                                    Turn off
                                </label>
                            </div>
                            <hr>
                            <button type="submit"
                                    class="btn btn-primary float-right ml-3">{{trans('messages.Save')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--modal-->
        @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'company-web-Logo'])
        @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'company-mobile-Logo'])
        @include('shared-partials.image-process._image-crop-modal', ['modal_id'=>'company-footer-Logo'])
        @include('shared-partials.image-process._image-crop-modal', ['modal_id'=>'company-fav-icon'])
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script>
        function readWLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerWL').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadWL").change(function () {
            readWLURL(this);
        });

        function readWFLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerWFL').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadWFL").change(function () {
            readWFLURL(this);
        });

        function readMLURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerML').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadML").change(function () {
            readMLURL(this);
        });

        function readFIURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewerFI').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUploadFI").change(function () {
            readFIURL(this);
        });


        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });

    </script>

    @include('shared-partials.image-process._script',[
        'id'=>'company-web-Logo',
        'height'=>200,
        'width'=>784,
        'multi_image'=>false,
        'route'=>route('image-upload')
        ])
    @include('shared-partials.image-process._script',[
        'id'=> 'company-footer-Logo',
        'height'=>200,
        'width'=>784,
        'multi_image'=>false,
        'route' => route('image-upload')

    ])
    @include('shared-partials.image-process._script',[
        'id'=> 'company-fav-icon',
        'height'=>100,
        'width'=>100,
        'multi_image'=>false,
        'route' => route('image-upload')

    ])
    @include('shared-partials.image-process._script',[
       'id'=>'company-mobile-Logo',
       'height'=>200,
       'width'=>784,
       'multi_image'=>false,
       'route'=>route('image-upload')
       ])

    <script>
        $(document).ready(function () {
            $('.color-var-select').select2({
                templateResult: colorCodeSelect,
                templateSelection: colorCodeSelect,
                escapeMarkup: function (m) {
                    return m;
                }
            });

            function colorCodeSelect(state) {
                var colorCode = $(state.element).val();
                if (!colorCode) return state.text;
                return "<span class='color-preview' style='background-color:" + colorCode + ";'></span>" + state.text;
            }
        });
    </script>
@endpush
