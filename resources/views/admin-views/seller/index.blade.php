@extends('layouts.back-end.app')
@section('title','Seller List')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.Sellers')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class=" mb-0 text-black-50">{{trans('messages.Sellers')}}</h4>
    </div>

    <div class="row" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{trans('messages.seller_table')}}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">{{trans('messages.SL#')}}</th>
                                <th scope="col">{{trans('messages.name')}}</th>
                                <th scope="col">{{trans('messages.Phone')}}</th>
                                <th scope="col">{{trans('messages.Email')}}</th>
                                <th scope="col">{{trans('messages.status')}}</th>
                                <th scope="col">{{trans('messages.orders')}}</th>
                                <th scope="col">{{trans('messages.Products')}}</th>
                                <th scope="col" style="width: 50px">{{trans('messages.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                                @foreach($sellers as $key=>$seller)
                                    <tr>
                                        <td scope="col">{{$i++}}</td>
                                        <td scope="col">{{$seller->f_name}} {{$seller->l_name}}</td>
                                        <td scope="col">{{$seller->phone}}</td>
                                        <td scope="col">{{$seller->email}}</td>
                                        <td scope="col">{{$seller->status}}</td>
                                        <td scope="col">
                                            <a href="{{route('admin.sellers.order-list',[$seller['id']])}}" class="btn btn-outline-primary btn-block">
                                                <i class="tio-shopping-cart-outlined"></i>( {{$seller->orders->count()}} )
                                            </a>
                                        </td>
                                        <td scope="col">
                                            <a href="{{route('admin.sellers.product-list',[$seller['id']])}}" class="btn btn-outline-primary btn-block">
                                                <i class="tio-premium-outlined mr-1"></i>( {{$seller->product->count()}} )
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-primary" href="{{route('admin.sellers.verification',$seller->id)}}">
                                                {{trans('messages.View')}}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
