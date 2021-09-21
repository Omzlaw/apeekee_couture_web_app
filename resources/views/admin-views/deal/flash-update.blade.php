@extends('layouts.back-end.app')
@section('title','Flash Deal Update')
@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
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
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
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
        #banner-image-modal .modal-content{
              width: 1116px !important;
            margin-left: -264px !important;
        }
       
        @media(max-width:768px){
            #banner-image-modal .modal-content{
                width: 698px !important;
    margin-left: -75px !important;
        }
        
      
        }
        @media(max-width:375px){
            #banner-image-modal .modal-content{
              width: 367px !important;
            margin-left: 0 !important;
        }
       
        }

   @media(max-width:500px){
    #banner-image-modal .modal-content{
              width: 400px !important;
            margin-left: 0 !important;
        }
      
      
   }

    </style>
@endpush

@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Flash Deal</li>
            <li class="breadcrumb-item">Update Deal</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{ trans('messages.flash_deals')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('messages.deal_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.deal.update',[$deal['id']])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" name="deal_type" value="flash_deal"  class="d-none">
                                    <label for="name">{{ trans('messages.title')}}</label>
                                    <input type="text" name="title" value="{{$deal->title}}" required
                                           class="form-control" id="title"
                                           placeholder="Ex : LUX">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{ trans('messages.start_date')}}</label>
                                    <input type="date" value="{{date('Y-m-d',strtotime($deal['start_date']))}}" name="start_date" required
                                           class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{ trans('messages.end_date')}}</label>
                                    <input type="date" value="{{date('Y-m-d', strtotime($deal['end_date']))}}" name="end_date" required
                                           class="form-control">
                                </div>
                            </div>

                            {{--to do--}}
                            {{--<div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{ trans('messages.background_color')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                        name="background_color">
                                        @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                            <option
                                                value="{{ $color->code }}" {{$deal['background_color']==$color->code?'selected':''}}>
                                                {{$color['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{ trans('messages.text_color')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control color-var-select"
                                        name="text_color">
                                        @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                            <option
                                                value="{{ $color->code }}" {{$deal['text_color']==$color->code?'selected':''}}>
                                                {{$color['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>--}}

                            <div class="row">
                                {{--to do--}}
                                {{--<div class="col-md-12" style="padding-top: 20px">
                                    <input type="checkbox" name="featured"
                                        {{$deal['featured']==1?'checked':''}}>
                                    <label for="featured">{{ trans('messages.featured')}}</label>
                                </div>--}}
                                <div class="col-md-12 pt-3">
                                    <label for="name">{{trans('messages.Upload')}} {{trans('messages.Image')}}</label>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="customFileUpload" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="customFileUpload">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                                    </div>
                                </div>
                                <div class="col-md-12" style="padding-top: 20px">
                                    <center>
                                        <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="viewer"
                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'" src="{{asset('storage/app/public/deal')}}/{{$deal['banner']}}" alt="banner image"/>
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer pl-0">
                            <button type="submit"
                                    class="btn btn-primary ">{{ trans('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'banner-image-modal','width'=>1100,'margin_left'=>'-65%'])
</div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#viewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileUpload").change(function () {
            readURL(this);
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <!-- Page level custom scripts -->

    <script>
        $(document).ready(function () {
            // color select select2
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

    @include('shared-partials.image-process._script',[
     'id'=>'banner-image-modal',
     'height'=>170,
     'width'=>1050,
     'multi_image'=>false,
     'route'=>route('image-upload')
     ])
@endpush
