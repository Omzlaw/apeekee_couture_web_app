@extends('layouts.back-end.app')
@section('title','Currency')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/select2/css/select2.min.css')}}" rel="stylesheet">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
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
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
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

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .modal-backdrop {
            position: inherit;
            top: 0;
            left: 0;
            z-index: unset;
            width: 100vw;
            height: 100vh;
            background-color: #000;
        }
    </style>
@endpush

@section('content')
    <div class="content container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">{{trans('messages.Currency')}}</li>
            </ol>
        </nav>
        <!-- Page Heading -->


        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h4 class="mb-0 text-black-50">{{trans('messages.Currency')}}</h4>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addCurrency">
                <i class="tio-add-circle"></i> {{trans('messages.Add')}} {{trans('messages.New')}} {{trans('messages.Currency')}}
            </button>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-center">{{trans('messages.system_default_currency')}}</h5>
                    </div>
                    <div class="card-body">
                        <form class="form-inline_" action="{{route('admin.currency.system-currency-update')}}"
                              method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <select style="width: 100%" class="form-control js-example-responsive"
                                                name="currency_id">
                                            @foreach (App\Model\Currency::where('status', 1)->get() as $key => $currency)
                                                <option
                                                    value="{{ $currency->id }}" {{\App\Model\BusinessSetting::where('type', 'system_default_currency')->first()->value == $currency->id?'selected':''}} >{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <button type="submit"
                                                class="btn btn-primary mb-2">{{trans('messages.Save')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top: 20px">
            <div class="col-md-12">

                <div class="card">

                    <div class="card-header">
                        <div class="row justify-content-between pl-4 pr-4">
                            <div>
                                <h5>{{trans('messages.Currency')}} {{trans('messages.table')}} </h5>
                            </div>
                            <div>


                                <!-- Modal -->
                                <div class="modal fade" id="addCurrency" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content mt-5 " style="color: black;">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel">{{trans('messages.Currency')}}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('admin.currency.store')}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" name="name" class="form-control"
                                                                       id="name" placeholder="Enter currency Name">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="text" name="symbol" class="form-control"
                                                                       id="symbol" placeholder="Enter currency symbol">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <input type="text" name="code" class="form-control"
                                                                       id="code" placeholder="Enter currency code">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <input type="number" min="1" max="1000000"
                                                                       name="exchange_rate"
                                                                       class="form-control" id="exchange_rate"
                                                                       placeholder="Enter currency exchange rate">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group text-center">
                                                        <button type="submit" id="add" class="btn btn-primary"
                                                                style="color: white">{{trans('messages.Save')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table_id" class="display table table-hover " style="width:100%">
                                <thead>
                                <tr>
                                    <th scope="col">{{trans('messages.SL#')}}</th>
                                    <th scope="col">{{trans('messages.currency_name')}}</th>
                                    <th scope="col">{{trans('messages.currency_symbol')}}</th>
                                    <th scope="col">{{trans('messages.currency_code')}}</th>
                                    <th scope="col">{{trans('messages.exchange_rate(1 USD= ?)')}}</th>
                                    <th scope="col">{{trans('messages.status')}}</th>
                                    <th scope="col">{{trans('messages.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(App\Model\Currency::orderBy('id','asc')->get() as $key =>$data)
                                    <div class="modal fade" id="editCurrency{{$data->id}}" tabindex="-1"
                                         role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content mt-5">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">{{trans('messages.Currency')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{route('admin.currency.update')}}" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="hidden" id="id" name="id"
                                                                           value="{{$data->id}}">
                                                                    <input type="text" name="name"
                                                                           class="form-control" id="name"
                                                                           value="{{$data->name}}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="text" name="symbol"
                                                                           class="form-control" id="symbol"
                                                                           value="{{$data->symbol}}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="text" name="code"
                                                                           class="form-control" id="code"
                                                                           value="{{$data->code}}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="number" min="1" max="1000000"
                                                                           name="exchange_rate"
                                                                           class="form-control" id="exchange_rate"
                                                                           value="{{$data->exchange_rate}}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group text-center">
                                                            <button type="submit" id="add" class="btn btn-primary"
                                                                    style="color: white">Save
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr class="text-center">
                                        <td>{{ $key +1 }}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->symbol}}</td>
                                        <td>{{$data->code}}</td>
                                        <td>{{$data->exchange_rate}}</td>
                                        <td><label class="switch">
                                                <input type="checkbox" class="status"
                                                       id="{{$data->id}}" <?php if ($data->status == 1) echo "checked" ?>><span
                                                    class="slider round">
                                            </span>
                                            </label>
                                        </td>
                                        <td>
                                            <a type="button" class="btn btn-primary btn-sm btn-xs edit"
                                               data-toggle="modal"
                                               data-target="#editCurrency{{$data->id}}">Edit</a>

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
    <!-- Page level custom scripts -->
    <script src="{{ asset('public/assets/select2/js/select2.min.js')}}"></script>
    <script>
        $(".js-example-theme-single").select2({
            theme: "classic"
        });

        $(".js-example-responsive").select2({
            width: 'resolve'
        });
    </script>

    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#table_id').DataTable();

        });
        $('#add').on('click', function () {
            var name = $('#name').val();
            var symbol = $('#symbol').val();
            var code = $('#code').val();
            var exchange_rate = $('#exchange_rate').val();
            if (name == "" || symbol == "" || code == "" || exchange_rate == "") {
                alert('All input field is required');
                return false;
            } else {
                return true;
            }
        });
        $('#update').on('click', function () {
            var id = $('#id').val();
            var name = $('#name').val();
            var symbol = $('#symbol').val();
            var code = $('#code').val();
            var exchange_rate = $('#exchange_rate').val();
            if (name == "" || symbol == "" || code == "" || exchange_rate == "") {
                alert('All input field is required');
                return false;
            }
            return true;
        });
        $(document).on('click', '.edit', function () {
            $('#update').show();
            $('#add').hide();
            var id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.currency.edit')}}",
                method: 'POST',
                data: {id: id},
                success: function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#code').val(data.code);
                    $('#symbol').val(data.symbol);
                    $('#exchange_rate').val(data.exchange_rate);
                    fetch_currency()
                }
            });
        });
        $(document).on('change', '.status', function () {
            var id = $(this).attr("id");
            if ($(this).prop("checked") == true) {
                var status = 1;
            } else if ($(this).prop("checked") == false) {
                var status = 0;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.currency.status')}}",
                method: 'POST',
                data: {
                    id: id,
                    status: status
                },
                success: function () {
                    toastr.success('Currency status updated successfully');
                    location.reload();
                }
            });
        });
    </script>
@endpush
