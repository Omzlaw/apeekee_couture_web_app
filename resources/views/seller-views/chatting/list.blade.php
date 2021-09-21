@extends('layouts.back-end.app-seller')
@section('title','Chat List')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Chattins</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-0 text-black-50">Chatting List</h1>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Chatting Table</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">SL#</th>
                                <th scope="col">Image</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Message</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($chattings as $k=>$chatting)
                                <tr>
                                    <td scope="row">{{$k+1}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm view"
                                           href="">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href=""
                                           class="btn btn-danger btn-sm " onclick="alert('Are You sure to Delete')">
                                            <i class="fa fa-trash"></i>
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


@endsection

@push('script')
    <!-- Page level plugins -->
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('public/assets/back-end')}}/js/demo/datatables-demo.js"></script>


    </script>
@endpush
