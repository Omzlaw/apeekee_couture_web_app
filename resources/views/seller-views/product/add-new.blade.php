@extends('layouts.back-end.app-seller')

@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
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
            background-color: #4af3ce;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #60f3ca;
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
        #product-images-modal .modal-content{
              width: 1116px !important;
            margin-left: -264px !important;
        }
        #thumbnail-image-modal .modal-content{
              width: 1116px !important;
            margin-left: -264px !important;
        }
        @media(max-width:768px){
            #product-images-modal .modal-content{
                width: 698px !important;
    margin-left: -75px !important;
        }

        #thumbnail-image-modal .modal-content{
            width: 698px !important;
    margin-left: -75px !important;
        }
        }
        @media(max-width:375px){
            #product-images-modal .modal-content{
              width: 367px !important;
            margin-left: 0 !important;
        }
        #thumbnail-image-modal .modal-content{
              width: 367px !important;
            margin-left: 0 !important;
        }
        }

   @media(max-width:500px){
    #product-images-modal .modal-content{
              width: 400px !important;
            margin-left: 0 !important;
        }
        #thumbnail-image-modal .modal-content{
              width: 400px !important;
            margin-left: 0 !important;
        }
        .btn-for-m{
            margin-bottom: 10px;
        }
       .parcent-margin{
           margin-left: 0px !important;
       }
   }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="{{route('seller.product.list')}}">Product</a></li>
                <li class="breadcrumb-item">Add new</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-black-50">{{trans('messages.Product')}}</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-md-12">

                <form class="product-form" action="{{route('seller.product.add-new')}}" method="post" enctype="multipart/form-data"
                      id="product_form">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>{{trans('messages.General Info')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">{{trans('messages.Product Name')}}</label>
                                <input type="text" name="name" value="{{old('name')}}" class="form-control" id="name" placeholder="Ex : LUX">
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="name">{{trans('messages.Category')}}</label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="category_id"
                                            onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-category-select','select')">
                                            <option value="0" selected disabled>---Select---</option>
                                            @foreach($cat as $c)
                                                <option value="{{$c['id']}}">{{$c['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">{{trans('messages.Sub Category')}}</label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="sub_category_id" id="sub-category-select"
                                            onchange="getRequest('{{url('/')}}/seller/product/get-categories?parent_id='+this.value,'sub-sub-category-select','select')">

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name">{{trans('messages.Sub Sub Category')}}</label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="sub_sub_category_id" id="sub-sub-category-select">

                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">{{trans('messages.Brand')}}</label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="brand_id">
                                            <option value="{{null}}" selected disabled>---Select---</option>
                                            @foreach($br as $b)
                                                <option value="{{$b['id']}}">{{$b['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name">{{trans('messages.Unit')}}</label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="unit">
                                            @foreach(\App\CPU\Helpers::units() as $x)
                                                <option value="{{$x}}">{{$x}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{--<center>
                                <div class="form-group" id="select-img">
                                    <button type="button" class="btn btn-info" data-toggle="modal"
                                            data-target="#image-crop-modal" data-whatever="@mdo" id="image-count">
                                        Upload Image ( 0 )
                                    </button>
                                </div>
                            </center>--}}

                            {{--<button type="submit" class="btn btn-primary">Submit</button>--}}
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4>Variations</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="colors">
                                            {{trans('messages.Colors')}} :
                                        </label>
                                        <label class="switch">
                                            <input type="checkbox" class="status" name="colors_active" value="{{old('colors_active')}}" >
                                            <span class="slider round"></span>
                                        </label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="colors[]" multiple="multiple" id="colors-selector" disabled>
                                            @foreach (\App\Model\Color::orderBy('name', 'asc')->get() as $key => $color)
                                                <option value="{{ $color->code }}">
                                                    {{$color['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="attributes" style="padding-bottom: 3px">
                                            {{trans('messages.Attributes')}} :
                                        </label>
                                        <select
                                            class="form-control js-select2-custom"
                                            name="choice_attributes[]" id="choice_attributes" multiple="multiple">
                                            @foreach (\App\Model\Attribute::orderBy('name', 'asc')->get() as $key => $a)
                                                <option value="{{ $a['id']}}">
                                                    {{$a['name']}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-2 mb-2">
                                        <div class="customer_choice_options" id="customer_choice_options">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4>{{trans('messages.Product price & stock')}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="control-label">{{trans('messages.Unit price')}}</label>
                                        <input type="number" min="0" value="0" step="0.01"
                                               placeholder="{{trans('messages.Unit price')}}"
                                               name="unit_price" value="{{old('unit_price')}}"  class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label
                                            class="control-label">{{trans('messages.Purchase price')}}</label>
                                        <input type="number" min="0" value="0" step="0.01"
                                               placeholder="{{trans('messages.Purchase price')}}"
                                               name="purchase_price" value="{{old('purchase_price')}}"  class="form-control" required>
                                    </div>
                                </div>

                                <div class="row pt-4">
                                    <div class="col-md-6">
                                        <label class="control-label">{{trans('messages.Tax')}}</label>
                                        <label class="badge badge-info">{{trans('messages.Percent')}} ( % )</label>
                                        <input type="number" min="0" value="0" step="0.01"
                                               placeholder="{{trans('messages.Tax')}}}" name="tax" value="{{old('tax')}}"
                                               class="form-control">
                                        <input name="tax_type" value="percent" style="display: none">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="control-label">{{trans('messages.Discount')}}</label>
                                        <input type="number" min="0" value="0" step="0.01"
                                               placeholder="{{trans('messages.Discount')}}" name="discount" value="{{old('discount')}}"
                                               class="form-control">
                                    </div>
                                    <div class="col-md-2" style="padding-top: 30px;">
                                        <select
                                            class="form-control js-select2-custom"
                                            name="discount_type">
                                            <option value="flat">{{trans('messages.Flat')}}</option>
                                            <option value="percent">{{trans('messages.Percent')}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="sku_combination" id="sku_combination">

                                </div>
                                <div class="row pt-4">
                                    <div class="col-md-6" id="quantity">
                                        <label class="control-label">{{trans('messages.total')}} {{trans('messages.Quantity')}}</label>
                                        <input type="number" min="0" value="0" step="1"
                                               placeholder="{{trans('messages.Quantity')}}"
                                               name="current_stock" value="{{old('current_stock')}}" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4>Product Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="col-xl-12">
                                    <textarea name="details" id="editor" cols="30" rows="10">{{old('details')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{{trans('messages.Upload product images')}}</label><small
                                            style="color: red">* ( {{trans('messages.ratio')}} 1:1 )</small>
                                    </div>
                                    <div  class="p-2 border border-dashed"  style="max-width:430px;">
                                        <div class="row" id="coba"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">{{trans('messages.Upload thumbnail')}}</label><small
                                            style="color: red">* ( {{trans('messages.ratio')}} 1:1 )</small>
                                    </div> 
                                    <div style="max-width:200px;">
                                        <div class="row" id="thumbnail"></div>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12" style="padding-top: 20px">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/tags-input.min.js"></script>
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script src="{{asset('public/assets/back-end/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        $(function () {
            $("#coba").spartanMultiImagePicker({
                fieldName: 'images[]',
                maxCount: 4,
                rowHeight: 'auto',
                groupClassName: 'col-6',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });

            $("#thumbnail").spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: 'auto',
                groupClassName: 'col-12',
                maxFileSize: '',
                placeholderImage: {
                    image: '{{asset('public/assets/back-end/img/400x400/img2.jpg')}}',
                    width: '100%',
                },
                dropFileLabel: "Drop Here",
                onAddRow: function (index, file) {

                },
                onRenderedPreview: function (index) {

                },
                onRemoveRow: function (index) {

                },
                onExtensionErr: function (index, file) {
                    toastr.error('Please only input png or jpg type file', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                onSizeErr: function (index, file) {
                    toastr.error('File size too big', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                }
            });
        });

        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script>
        function getRequest(route, id, type) {
            $.get({
                url: route,
                dataType: 'json',
                success: function (data) {
                    if (type == 'select') {
                        $('#' + id).empty().append(data.select_tag);
                    }
                },
            });
        }

        $('input[name="colors_active"]').on('change', function () {
            if (!$('input[name="colors_active"]').is(':checked')) {
                $('#colors-selector').prop('disabled', true);
            } else {
                $('#colors-selector').prop('disabled', false);
            }
        });

        $('#choice_attributes').on('change', function () {
            $('#customer_choice_options').html(null);
            $.each($("#choice_attributes option:selected"), function () {
                //console.log($(this).val());
                add_more_customer_choice_option($(this).val(), $(this).text());
            });
        });

        function add_more_customer_choice_option(i, name) {
            let n = name.split(' ').join('');
            $('#customer_choice_options').append('<div class="row"><div class="col-md-3"><input type="hidden" name="choice_no[]" value="' + i + '"><input type="text" class="form-control" name="choice[]" value="' + n + '" placeholder="{{trans('Choice Title') }}" readonly></div><div class="col-lg-9"><input type="text" class="form-control" name="choice_options_' + i + '[]" placeholder="{{trans('Enter choice values') }}" data-role="tagsinput" onchange="update_sku()"></div></div>');

            $("input[data-role=tagsinput], select[multiple][data-role=tagsinput]").tagsinput();
        }
        $('#colors-selector').on('change', function () {
            update_sku();
        });

        $('input[name="unit_price"]').on('keyup', function () {
            update_sku();
        });
        

        function update_sku() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: '{{route('seller.product.sku-combination')}}',
                data: $('#product_form').serialize(),
                success: function (data) {
                    $('#sku_combination').html(data.view);
                    $('#sku_combination').addClass('pt-4');
                    if (data.length > 1) {
                        $('#quantity').hide();
                    } else {
                        $('#quantity').show();
                    }
                }
            });
        };

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

    <script>
        $('#product_form').submit(function (e) {
            e.preventDefault();
            for ( instance in CKEDITOR.instances ) {
                CKEDITOR.instances[instance].updateElement();
            }
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('seller.product.add-new')}}',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('product added successfully!', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setInterval(function () {
                            location.href = '{{route('seller.product.list')}}';
                        }, 2000);
                    }
                }
            });
        });
    </script>
@endpush