@extends('layouts.back-end.app')

@section('title','Withdraw Request')

@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.Withdraw')}}  </li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class=" mb-0 text-black-50">{{trans('messages.Withdraw')}} {{trans('messages.Table')}}</h4>
    </div>
 <div class="row" style="margin-top: 20px">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>{{ trans('messages.Withdraw Request Table')}}</h5>
            </div>
            <div class="card-body" style="padding: 0">
                <div class="table-responsive">
                    <table id="datatable"
                           class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                           style="width: 100%">
                        <thead class="thead-light">
                        <tr>
                            <th>{{trans('messages.SL#')}}</th>
                            <th>{{trans('messages.amount')}}</th>
                            {{-- <th>{{trans('messages.note')}}</th> --}}
                            <th>{{ trans('messages.Name') }}</th>
                            <th>{{trans('messages.request_time')}}</th>
                            <th>{{trans('messages.status')}}</th>
                            <th style="width: 5px">{{trans('messages.Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($withdraw_req as $k=>$wr)
                            <tr>
                                <td scope="row">{{$k+1}}</td>
                                <td>{{\App\CPU\BackEndHelper::usd_to_currency($wr['amount'])}}</td>
                                {{-- <td>{{$wr->transaction_note}}</td> --}}
                                <td><a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}">{{ $wr->seller->f_name . ' ' . $wr->seller->l_name }}</a></td>
                                <td>{{$wr->created_at}}</td>
                                <td>
                                    @if($wr->approved==0)
                                        <label class="badge badge-primary">Pending</label>
                                    @elseif($wr->approved==1)
                                        <label class="badge badge-success">Approved</label>
                                    @else
                                        <label class="badge badge-danger">Denied</label>
                                    @endif
                                </td>
                                <td>
                                    @if($wr->approved==0)
                                        <a href="{{route('admin.sellers.withdraw_view',[$wr['id'],$wr->seller['id']])}}"
                                           class="btn btn-primary btn-sm">
                                           {{trans('messages.View')}}
                                        </a>
                                    @else
                                        <label>complete</label>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{$withdraw_req->links()}}
            </div>
        </div>
    </div>
   
     </div>
</div>
@endsection