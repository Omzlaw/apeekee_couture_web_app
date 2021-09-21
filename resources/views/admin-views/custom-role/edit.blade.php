@extends('layouts.back-end.app')
@section('title','Edit Role')
@push('css_or_js')

@endpush

@section('content')
<div class="content container-fluid"> 
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Role Update</li>
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
                <div class="card-body">
                    <form action="{{route('admin.custom-role.update',[$role['id']])}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="name">{{trans('messages.role_name')}}</label>
                            <input type="text" name="name" value="{{$role['name']}}" class="form-control" id="name" aria-describedby="emailHelp"
                                   placeholder="Ex : Store">
                        </div>

                        <label for="module">{{trans('messages.module_permission')}} : </label>
                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="product" class="form-check-input"
                                           id="product" {{in_array('product',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="product">{{trans('messages.product')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="order" class="form-check-input"
                                           id="order" {{in_array('order',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="order">{{trans('messages.Order')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="category" class="form-check-input"
                                           id="category" {{in_array('category',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="category">{{trans('messages.category')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="brand" class="form-check-input"
                                           id="brand" {{in_array('brand',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="brand">{{trans('messages.brand')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="deal" class="form-check-input"
                                           id="deal" {{in_array('deal',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="deal">{{trans('messages.deal')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="seller" class="form-check-input"
                                           id="seller" {{in_array('seller',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="seller">{{trans('messages.Seller')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="employee" class="form-check-input"
                                           id="employee" {{in_array('employee',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="employee">{{trans('messages.Employee')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="coupon" class="form-check-input"
                                           id="coupon" {{in_array('coupon',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="coupon">{{trans('messages.Coupon')}}</label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="messages" class="form-check-input"
                                           id="messages" {{in_array('messages',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="messages">{{trans('messages.messages')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="custom_role" class="form-check-input"
                                           id="custom_role" {{in_array('custom_role',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="custom_role">{{trans('messages.custom_role')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="business_settings" class="form-check-input"
                                           id="business_settings" {{in_array('business_settings',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="business_settings">{{trans('messages.business_settings')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="notification" class="form-check-input"
                                           id="notification" {{in_array('notification',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="notification">{{trans('messages.Notification')}} </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="banner" class="form-check-input"
                                           id="banner" {{in_array('banner',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="banner">{{trans('messages.Banner')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="attribute" class="form-check-input"
                                           id="attribute" {{in_array('attribute',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="attribute">{{trans('messages.Attribute')}}</label>
                                </div>
                            </div>
                            

                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="customerList" class="form-check-input"
                                           id="customerList" {{in_array('customerList',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="customerList">{{trans('messages.Customer')}} {{trans('messages.List')}}</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-check">
                                    <input type="checkbox" name="modules[]" value="productReview" class="form-check-input"
                                           id="productReview" {{in_array('productReview',(array)json_decode($role['module_access']))?'checked':''}}>
                                    <label class="form-check-label" for="productReview">{{trans('messages.Product')}} {{trans('messages.Review')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                                <div class="col-md-3">
                                    <div class="form-group form-check">
                                        <input type="checkbox" name="modules[]" value="report" class="form-check-input"
                                               id="report" {{in_array('report',(array)json_decode($role['module_access']))?'checked':''}}>
                                        <label class="form-check-label" for="report">{{trans('messages.Report')}}</label>
                                    </div>
                                </div>
                            
                        </div>
                            
                        </div>

                        <button type="submit" class="btn btn-primary">{{trans('messages.update')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')

@endpush
