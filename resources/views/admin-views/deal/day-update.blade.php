@extends('layouts.back-end.app')
@section('title','Deal Update')
@push('css_or_js')
    <link href="{{asset('public/assets/back-end/css/tags-input.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/back-end/css/custom.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
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
    </style>
@endpush

@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Deal of the Day</li>
            <li class="breadcrumb-item">Update Deal</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{ trans('messages.deal_of_the_day')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('messages.deal_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.deal.day-update',[$deal['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">{{ trans('messages.title')}}</label>
                                    <input type="text" name="title" value="{{$deal->title}}" required
                                           class="form-control" id="title"
                                           placeholder="Ex : LUX">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="name">{{ trans('messages.product')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="product_id">
                                        @foreach (\App\Model\Product::orderBy('name', 'asc')->get() as $key => $product)
                                            <option value="{{ $product->id }}" {{$deal['product_id']==$product->id?'selected':''}}>
                                                {{$product['name']}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{--<div class="row">
                                <div class="col-md-6">
                                    <label for="name">{{ trans('messages.discount')}}</label>
                                    <input type="number" name="discount" value="{{$deal['discount_type']=='amount'?\App\CPU\BackEndHelper::usd_to_currency($deal['discount']):$deal['discount']}}" required
                                           class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="name">{{ trans('messages.discount_type')}}</label>
                                    <select
                                        class="js-example-basic-multiple js-states js-example-responsive form-control"
                                        name="discount_type">
                                        <option value="amount" {{$deal['discount_type']=='amount'?'selected':''}}>Amount</option>
                                        <option value="percentage" {{$deal['discount_type']=='percentage'?'selected':''}}>Percentage</option>
                                    </select>
                                </div>
                            </div>--}}
                        </div>

                        <div class="card-footer pl-0">
                            <button type="submit"
                                    class="btn btn-primary float-right">{{ trans('messages.update')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{asset('public/assets/back-end')}}/js/select2.min.js"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>
@endpush
