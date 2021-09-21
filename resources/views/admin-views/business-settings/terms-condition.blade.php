@extends('layouts.back-end.app')
@section('title','Terms & Condition')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
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
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
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
    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.terms_and_condition')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class="mb-0 text-black-50">{{trans('messages.general_business_settings')}}</h4>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between pl-4 pr-4">
                        <div>
                            <h2>{{trans('messages.terms_and_condition')}}</h2>
                        </div>
                    </div>
                </div>

                <form action="{{route('admin.business-settings.update-terms')}}" method="post">
                    @csrf
                    <div class="card-body">
                        @foreach($terms_condition as $terms_condition)
                        <div class="form-group">
                            <div class="col-md-12">
                                <label for="editor">{{trans('messages.terms_and_condition')}}</label><textarea class="form-control" id="editor" name="value">{{$terms_condition->value}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input class="form-control btn-primary" type="submit" name="btn">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

