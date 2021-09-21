@extends('layouts.back-end.app')
@section('title','Seller View')
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
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.sellers_verification')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex row align-items-center justify-content-between mb-2">
        <div class="col-md-6"> 
             <h4 class=" mb-0 text-black-50">{{trans('messages.sellers_verification')}}</h4>
            </div>
      <div class="col-md-6 ">
        @if ($seller->status=="pending")
        <div class="mt-4 pr-2 float-right">
            <div class="text-center">
                <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$seller->id}}">
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="btn btn-primary">{{trans('messages.accept')}}</button>
                </form>
                <form class="d-inline-block" action="{{route('admin.sellers.updateStatus')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$seller->id}}">
                    <input type="hidden" name="status" value="suspended">
                    <button type="submit" class="btn btn-danger">{{trans('messages.reject')}}</button>
                </form>
            </div>
        </div>
   
    @endif
</div>
    </div>

    <div class="row" >
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{trans('messages.Seller')}} {{trans('messages.info')}}
                </div>
                <div class="card-body">
                    <h5>{{trans('messages.name')}} : {{$seller->f_name}} {{$seller->l_name}}</h5>
                    <h5>{{trans('messages.Email')}} : {{$seller->email}}</h5>
                    <h5>{{trans('messages.Phone')}} : {{$seller->phone}}</h5>
                </div>
            </div>
        </div>
        @if($seller->shop)
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{trans('messages.Shop')}} {{trans('messages.info')}}
                </div>
                <div class="card-body">
                    <h5>{{trans('messages.seller_b')}} : {{$seller->shop->name}}</h5>
                    <h5>{{trans('messages.Phone')}} : {{$seller->shop->contact}}</h5>
                    <h5>{{trans('messages.address')}} : {{$seller->shop->address}}</h5>
                </div>
            </div>
        </div>
        @endif
    
     

    </div>
    <div class="row mt-3">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="h3 mb-0  ">{{trans('messages.my_bank_info')}} </h3>
                </div>
                <div class="card-body">
                    <div class="col-md-8 mt-4">
                        
                        <h4>{{trans('messages.bank_name')}}: {{$seller->bank_name ? $seller->bank_name : 'No Data found'}}</h4>
                        <h6>{{trans('messages.Branch')}}  : {{$seller->branch ? $seller->branch : 'No Data found'}}</h6>
                        <h6>{{trans('messages.holder_name')}} : {{$seller->holder_name ? $seller->holder_name : 'No Data found'}}</h6>
                        <h6>{{trans('messages.account_no')}}  : {{$seller->account_no ? $seller->account_no : 'No Data found'}}</h6>
                      

                       
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>
</div>
@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
