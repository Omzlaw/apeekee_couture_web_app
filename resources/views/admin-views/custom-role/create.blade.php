@extends('layouts.back-end.app')
@section('title','Create Role')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.custom_role')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">{{trans('messages.custom_role')}}</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{trans('messages.role_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.custom-role.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{trans('messages.role_name')}}</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="Ex : Store" required>
                        </div>

                        <label for="name">{{trans('messages.module_permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="product" class="form-check-input"
                                           id="product">
                                    <label class="form-check-label" for="product">{{trans('messages.Products')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order">
                                    <label class="form-check-label" for="order">{{trans('messages.Order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category">
                                    <label class="form-check-label" for="category">{{trans('messages.category')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="brand" class="form-check-input"
                                           id="brand">
                                    <label class="form-check-label" for="brand">{{trans('messages.brand')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="deal" class="form-check-input"
                                           id="deal">
                                    <label class="form-check-label" for="deal">{{trans('messages.deal')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="seller" class="form-check-input"
                                           id="seller">
                                    <label class="form-check-label" for="seller">{{trans('messages.Sellers')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee">
                                    <label class="form-check-label" for="employee">{{trans('messages.Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input"
                                           id="coupon">
                                    <label class="form-check-label" for="coupon">{{trans('messages.Coupon')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="messagess" class="form-check-input"
                                           id="messagess">
                                    <label class="form-check-label" for="messagess">{{trans('messages.messages')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role">
                                    <label class="form-check-label" for="custom_role">{{trans('messages.custom_role')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="business_settings" class="form-check-input"
                                           id="business_settings">
                                    <label class="form-check-label" for="business_settings">{{trans('messages.business_settings')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="notification" class="form-check-input"
                                           id="notification">
                                    <label class="form-check-label" for="notification">{{trans('messages.Notification')}} </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner">
                                    <label class="form-check-label" for="banner">{{trans('messages.Banner')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute">
                                    <label class="form-check-label" for="attribute">{{trans('messages.Attribute')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="customerList" class="form-check-input"
                                           id="customerList">
                                    <label class="form-check-label" for="customerList">{{trans('messages.Customer')}} {{trans('messages.List')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="productReview" class="form-check-input"
                                           id="productReview">
                                    <label class="form-check-label" for="productReview">{{trans('messages.Product')}} {{trans('messages.Review')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                               id="report">
                                        <label class="form-check-label" for="report">{{trans('messages.Report')}}</label>
                                    </div>
                                </div>
                            
                        </div>

                        <button type="submit" class="btn btn-primary">{{trans('messages.Submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{trans('messages.roles_table')}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">SL#</th>
                                <th scope="col">{{trans('messages.role_name')}}</th>
                                <th scope="col">{{trans('messages.modules')}}</th>
                                <th scope="col">{{trans('messages.created_at')}}</th>
                                <th scope="col">{{trans('messages.status')}}</th>
                                <th scope="col" style="width: 50px">{{trans('messages.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rl as $k=>$r)
                                <tr>
                                    <th scope="row">{{$k+1}}</th>
                                    <td>{{$r['name']}}</td>
                                    <td class="text-capitalize">
                                        @if($r['module_access']!=null)
                                            @foreach((array)json_decode($r['module_access']) as $m)
                                                {{str_replace('_',' ',$m)}} <br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{date('d-M-y',strtotime($r['created_at']))}}</td>
                                    <td>{{\App\CPU\Helpers::status($r['status'])}}</td>
                                    <td>
                                        <a href="{{route('admin.custom-role.update',[$r['id']])}}"
                                           class="btn btn-primary btn-sm">
                                            {{trans('messages.Edit') }}
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
    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endpush
