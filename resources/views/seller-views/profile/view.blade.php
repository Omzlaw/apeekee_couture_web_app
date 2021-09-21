@extends('layouts.back-end.app-seller')
@section('title','Bandk Info View')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('seller.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.seller')}}</li>
                <li class="breadcrumb-item">{{trans('messages.my_bank_info')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-black-50">{{trans('messages.my_bank_info')}}</h1>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0  ">{{trans('messages.my_bank_info')}}  </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mt-4">
                            <h4>{{trans('messages.bank_name')}}
                                : {{$data->bank_name ? $data->bank_name : 'No Data found'}}</h4>
                            <h6>{{trans('messages.Branch')}} : {{$data->branch ? $data->branch : 'No Data found'}}</h6>
                            <h6>{{trans('messages.holder_name')}}
                                : {{$data->holder_name ? $data->holder_name : 'No Data found'}}</h6>
                            <h6>{{trans('messages.account_no')}}
                                : {{$data->account_no ? $data->account_no : 'No Data found'}}</h6>


                            <a class="btn btn-primary"
                               href="{{route('seller.profile.bankInfo',[$data->id])}}">{{trans('messages.Edit')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <!-- Page level plugins -->
@endpush
