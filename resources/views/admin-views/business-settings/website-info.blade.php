@extends('layouts.back-end.app')
@section('title','Website Information')
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

        #company-footer-Logo .modal-content{
                 width: 1116px !important;
               margin-left: -264px !important;
           }

           #company-mobile-Logo .modal-content{
                 width: 1116px !important;
               margin-left: -264px !important;
           }
           #company-web-Logo .modal-content{
                 width: 1116px !important;
               margin-left: -264px !important;
           }
           #company-fav-icon .modal-content{
                 width: 1116px !important;
               margin-left: -264px !important;
           }
           @media(max-width:768px){
               #company-footer-Logo .modal-content{
                   width: 698px !important;
       margin-left: -75px !important;
           }
           #company-mobile-Logo .modal-content{
                   width: 698px !important;
       margin-left: -75px !important;
           }
           #company-web-Logo .modal-content{
                   width: 698px !important;
       margin-left: -75px !important;
           }
           #company-fav-icon .modal-content{
                   width: 698px !important;
       margin-left: -75px !important;
           }


           }
           @media(max-width:375px){
               #company-footer-Logo .modal-content{
                 width: 367px !important;
               margin-left: 0 !important;
           }
           #company-mobile-Logo .modal-content{
                 width: 367px !important;
               margin-left: 0 !important;
           }
           #company-web-Logo .modal-content{
                 width: 367px !important;
               margin-left: 0 !important;
           }
           #company-fav-icon .modal-content{
                 width: 367px !important;
               margin-left: 0 !important;
           }

           }

      @media(max-width:500px){
       #company-footer-Logo .modal-content{
                 width: 400px !important;
               margin-left: 0 !important;
           }
           #company-mobile-Logo .modal-content{
                 width: 400px !important;
               margin-left: 0 !important;
           }
           #company-web-Logo .modal-content{
                 width: 400px !important;
               margin-left: 0 !important;
           }
           #company-fav-icon .modal-content{
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
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item"
                aria-current="page">{{trans('messages.Website')}} {{trans('messages.Info')}} </li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{trans('messages.Website')}} {{trans('messages.Informations')}} </h4>
    </div>

    <div class="modal fade" id="companyName" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{trans('messages.rename_your_website')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.business-settings.web-config.company-update')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="control-label">{{trans('messages.name')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input class="form-control" type="text" name="company_name"
                                   value="{{$company_name->value}}">
                        </div>
                        <button type="submit" class="btn btn-primary float-right">{{trans('messages.Update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="companyEmail" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">{{trans('messages.rename_company')}} {{trans('messages.Email')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.business-settings.web-config.company-email-update')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="control-label">{{trans('messages.name')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input class="form-control" type="text" name="company_email"
                                   value="{{$company_email->value}}">
                        </div>
                        <button type="submit" class="btn btn-primary float-right">{{trans('messages.Update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="companyPhone" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="exampleModalLabel">{{trans('messages.rename_company')}}  {{trans('messages.Phone')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.business-settings.web-config.company-phone-update')}}" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <label class="control-label">{{trans('messages.name')}}</label>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <input class="form-control" type="text" name="company_phone"
                                   value="{{$company_phone->value}}">
                        </div>
                        <button type="submit" class="btn btn-primary float-right">{{trans('messages.Update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-bottom: 20px;">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">{{trans('messages.apple_store')}} {{trans('messages.Status')}}</h5>
                </div>
                <div class="card-body" style="padding: 20px">

                    @php($config=\App\CPU\Helpers::get_business_settings('download_app_apple_stroe'))
                    <form
                        action="{{route('admin.business-settings.web-config.app-store-update',['download_app_apple_stroe'])}}"
                        method="post">
                        @csrf
                        @if(isset($config))

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
                                <label style="padding-left: 10px">{{trans('messages.link')}}</label><br>
                                <input type="text" class="form-control" name="link" value="{{$config['link']}}"
                                       required>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Save')}}</button>
                        @else
                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Configure')}}</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">{{trans('messages.google_play_store')}} {{trans('messages.Status')}}</h5>
                </div>
                <div class="card-body" style="padding: 20px">

                    @php($config=\App\CPU\Helpers::get_business_settings('download_app_google_stroe'))
                    <form
                        action="{{route('admin.business-settings.web-config.app-store-update',['download_app_google_stroe'])}}"
                        method="post">
                        @csrf
                        @if(isset($config))

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
                                <label style="padding-left: 10px">{{trans('messages.link')}}</label><br>
                                <input type="text" class="form-control" name="link" value="{{$config['link']}}"
                                       required>
                            </div>

                            <button type="submit" class="btn btn-primary mb-2">{{trans('messages.Save')}}</button>
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
                    <h5>{{trans('messages.name')}} : {{$company_name->value}}</h5>
                    <button type="submit" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#companyName">{{trans('messages.Edit')}}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5>{{trans('messages.Email')}}: {{$company_email->value}}</h5>
                    <button type="submit" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#companyEmail">{{trans('messages.Edit')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5>{{trans('messages.Phone')}}: {{$company_phone->value}}</h5>
                    <button type="submit" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#companyPhone">{{trans('messages.Edit')}}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="modal fade" id="companyCopyRight" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"
                                id="exampleModalLabel">{{trans('messages.rename_company')}} {{trans('messages.copy_right')}} {{trans('messages.Text')}}   </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.business-settings.web-config.company-copy-right-update')}}"
                                  method="post">
                                @csrf
                                <div class="form-group mb-2">
                                    <label
                                        class="control-label">{{trans('messages.copy_right')}} {{trans('messages.Text')}} </label>
                                </div>
                                <div class="form-group mb-2 mt-2">
                                    @php($company_copyright_text=\App\Model\BusinessSetting::where(['type'=>'company_copyright_text'])->first())
                                    <input class="form-control" type="text" name="company_copyright_text"
                                           value="{{$company_copyright_text->value}}">
                                </div>
                                <button type="submit"
                                        class="btn btn-info float-right">{{trans('messages.Update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body" style="padding: 20px">
                    <h5>{{trans('messages.copy_right')}} {{$company_copyright_text->value}}</h5>
                    <button type="submit" class="btn btn-primary float-right" data-toggle="modal"
                            data-target="#companyCopyRight">{{trans('messages.Edit')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{trans('messages.Web')}} {{trans('messages.logo')}} </h5>
                </div>
                <div class="card-body" style="padding: 20px">
                    <center>
                        <img width="200" id="viewerWL"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_web_logo'])->pluck('value')[0]}}">
                    </center>
                    <hr>
                    <form action="{{route('admin.business-settings.web-config.company-web-logo-upload')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="custom-file col-9">
                                <input type="file" name="image" id="customFileUploadWL" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileUploadWL">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                            </div>
                            <div class="col-3">
                                <button type="submit"
                                    class="btn btn-primary float-right ml-3">{{trans('messages.Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{trans('messages.Mobile')}} {{trans('messages.logo')}}</h5>
                </div>
                <div class="card-body" style="padding: 20px">
                    <center>
                        <img width="200" id="viewerML"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_mobile_logo'])->pluck('value')[0]}}">
                    </center>
                    <hr>
                    <form action="{{route('admin.business-settings.web-config.company-mobile-logo-upload')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="custom-file col-9">
                                <input type="file" name="image" id="customFileUploadML" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileUploadML">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                            </div>
                            <div class="col-3">
                                <button type="submit"
                                    class="btn btn-primary float-right ml-3">{{trans('messages.Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{trans('messages.web_footer')}} {{trans('messages.logo')}} </h5>
                </div>
                <div class="card-body" style="padding: 20px">
                    <center>
                        <img width="200" id="viewerWFL"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_footer_logo'])->pluck('value')[0]}}">
                    </center>
                    <hr>
                    <form action="{{route('admin.business-settings.web-config.company-footer-logo-upload')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="custom-file col-9">
                                <input type="file" name="image" id="customFileUploadWFL" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileUploadWFL">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                            </div>
                            <div class="col-3">
                                <button type="submit"
                                    class="btn btn-primary float-right ml-3">{{trans('messages.Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>{{trans('messages.web_fav_icon')}} </h5>
                </div>
                <div class="card-body" style="padding: 20px">
                    <center>
                        <img width="60" id="viewerFI"
                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                             src="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'company_fav_icon'])->pluck('value')[0]}}">
                    </center>
                    <hr>
                    <form action="{{route('admin.business-settings.web-config.company-fav-icon')}}"
                          method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="custom-file col-9">
                                <input type="file" name="image" id="customFileUploadFI" class="custom-file-input"
                                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileUploadFI">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                            </div>
                            <div class="col-3">
                                <button type="submit"
                                    class="btn btn-primary float-right ml-3">{{trans('messages.Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="row" style="padding-bottom: 20px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body" style="padding: 20px">
                    @php($colors=\App\Model\BusinessSetting::where(['type'=>'colors'])->first())
                    @if(isset($colors))
                        @php($data=json_decode($colors['value']))
                    @else
                        @php(\Illuminate\Support\Facades\DB::table('business_settings')->insert([
                                'type'=>'colors',
                                'value'=>json_encode(
                                    [
                                        'primary'=>null,
                                        'secondary'=>null,
                                    ])
                            ]))
                        @php($colors=\App\Model\BusinessSetting::where(['type'=>'colors'])->first())
                        @php($data=json_decode($colors['value']))
                    @endif
                    <h4>{{trans('messages.web_color_setup')}}</h4>
                    <form action="{{route('admin.business-settings.web-config.update-colors')}}" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>{{trans('messages.Primary')}}</label>
                            <input type="color" name="primary" value="{{ $data->primary }}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{trans('messages.Secondary')}}</label>
                            <input type="color" name="secondary" value="{{ $data->secondary }}" class="form-control">
                        </div>
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
