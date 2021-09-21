@extends('layouts.back-end.app')
@section('title','Withdraw information View')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">

@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item"
                    aria-current="page">{{trans('messages.seller')}} {{trans('messages.Withdraw')}}</li>
            </ol>
        </nav>

        <!-- Page Heading -->
        <div class="d-sm-flex row align-items-center justify-content-between mb-2">
            <div class="col-md-6">
                <h4 class=" mb-0 text-black-50">{{trans('messages.seller')}} {{trans('messages.Withdraw')}} {{trans('messages.information')}}</h4>
            </div>

        </div>
        <div class="row mt-3">

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0">{{trans('messages.my_bank_info')}} </h3>
                    </div>
                    <div class="card-body">
                        <div class="col-md-8 mt-2">
                            <h4>{{trans('messages.bank_name')}}
                                : {{$seller->seller->bank_name ? $seller->seller->bank_name : 'No Data found'}}</h4>
                            <h6>{{trans('messages.Branch')}}
                                : {{$seller->seller->branch ? $seller->seller->branch : 'No Data found'}}</h6>
                            <h6>{{trans('messages.holder_name')}}
                                : {{$seller->seller->holder_name ? $seller->seller->holder_name : 'No Data found'}}</h6>
                            <h6>{{trans('messages.account_no')}}
                                : {{$seller->seller->account_no ? $seller->seller->account_no : 'No Data found'}}</h6>
                        </div>
                    </div>
                </div>
            </div>
            @if($seller->seller->shop)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="h3 mb-0">{{trans('messages.Shop')}} {{trans('messages.info')}}</h3>
                        </div>
                        <div class="card-body">
                            <h5>{{trans('messages.seller_b')}} : {{$seller->seller->shop->name}}</h5>
                            <h5>{{trans('messages.Phone')}} : {{$seller->seller->shop->contact}}</h5>
                            <h5>{{trans('messages.address')}} : {{$seller->seller->shop->address}}</h5>
                            <h5 class="text-capitalize badge badge-success">{{trans('messages.balance')}}
                                : {{\App\CPU\Convert::default($seller->seller->wallet->balance)}} {{\App\CPU\currency_symbol()}}
                            </h5>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0 "> {{trans('messages.Seller')}} {{trans('messages.info')}}</h3>
                    </div>
                    <div class="card-body">
                        <h5>{{trans('messages.name')}} : {{$seller->seller->f_name}} {{$seller->seller->l_name}}</h5>
                        <h5>{{trans('messages.Email')}} : {{$seller->seller->email}}</h5>
                        <h5>{{trans('messages.Phone')}} : {{$seller->seller->phone}}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                {{-- {{ $seller }} --}}

                <div class="card">
                    <div class="card-header">
                        <h3 class="h3 mb-0">{{trans('messages.Withdraw')}} {{trans('messages.information')}} </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="text-capitalize">{{trans('messages.amount')}}
                            : {{\App\CPU\Convert::default($seller->amount)}} {{\App\CPU\currency_symbol()}}</h5>
                        <h5>{{trans('messages.request_time')}} : {{$seller->created_at}}</h5>
                        {{-- {{ $seller->id }} --}}
                        @if ($seller->approved== 0)

                            <div class="text-center mt-3">
                                <form class="d-inline-block" action="{{route('admin.sellers.withdraw_status')}}"
                                      method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$seller->id}}">
                                    <input type="hidden" name="approved" value="1">
                                    <button type="submit" class="btn btn-primary">{{trans('messages.Approve')}}</button>
                                </form>
                                <form class="d-inline-block" action="{{route('admin.sellers.withdraw_status')}}"
                                      method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$seller->id}}">
                                    <input type="hidden" name="approved" value="2">
                                    <button type="submit" class="btn btn-danger">{{trans('messages.Denied')}}</button>
                                </form>
                            </div>
                        @else
                            <div class="text-center col-sm-3  mt-3">

                                @if($seller->approved==1)
                                    <label
                                        class="badge badge-success p-2 rounded-bottom">{{trans('messages.Approved')}}</label>
                                @else
                                    <label
                                        class="badge badge-danger p-2 rounded-bottom">{{trans('messages.Denied')}}</label>
                                @endif
                                {{-- <div class=" bg-primary text-light p-2 rounded-bottom" >{{trans('messages.Approved')}}</div> --}}
                            </div>
                        @endif
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
        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
