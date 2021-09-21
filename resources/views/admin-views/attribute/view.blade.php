@extends('layouts.back-end.app')
@section('title','Attribute')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <!-- Page Heading -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{ trans('messages.Attribute')}}</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class=" mb-0 text-black-50">{{ trans('messages.Attribute')}}</h4>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="id">
                            <label for="name">{{ trans('messages.Attribute')}} {{ trans('messages.Name')}} </label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Enter Attribute Name">
                        </div>

                        <a id="add" class="btn btn-primary btn-sm" style="color: white">{{ trans('messages.Add')}} <i
                                class="fa fa-plus"></i></a>
                        <a id="update" class="btn btn-primary btn-sm" style="display: none; color: #fff;">{{ trans('messages.Update')}} <i
                                class="fa fa-edit"></i></a>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('messages.Attribute')}} {{ trans('messages.Table')}} </h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="datatable"
                               class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                               style="width: 100%">
                            <thead class="thead-light">
                            <tr>
                                <th style="width: 30px">{{ trans('messages.SL#')}}</th>
                                <th>{{ trans('messages.Name')}} </th>
                                <th style="width: 60px">{{ trans('messages.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\Model\Attribute::latest()->get() as $key=>$attribute)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$attribute['name']}}</td>
                                    <td style="width: 100px">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  edit" style="cursor: pointer;"
                                                id="{{$attribute['id']}}"> {{ trans('messages.Edit')}}</a>
                                                <a class="dropdown-item delete"style="cursor: pointer;"
                                                id="{{$attribute['id']}}">  {{ trans('messages.Delete')}}</a>
                                            </div>
                                        </div>
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
    <script src="{{asset('public/assets/back-end/js/croppie.js')}}"></script>
    <script>
        fetch_attribute();

        function fetch_attribute() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.attribute.fetch')}}",
                method: 'GET',
                success: function (data) {

                    if (data.length != 0) {
                        var html = '';
                        for (var count = 0; count < data.length; count++) {
                            html += '<tr>';
                            html += '<td class="column_name" data-column_name="sl" data-id="' + data[count].id + '">' + (count + 1) + '</td>';
                            html += '<td class="column_name" data-column_name="name" data-id="' + data[count].id + '">' + data[count].name + '</td>';
                            html += '<td><div class="dropdown"><button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="tio-settings"></i></button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton"><a class="dropdown-item  edit" style="cursor: pointer;" id="' + data[count].id + '"> {{ trans('messages.Edit')}}</a><a class="dropdown-item delete"style="cursor: pointer;" id="' + data[count].id + '"> {{ trans('messages.Delete')}}</a></div></div></td></tr>';
                        }
                        $('tbody').html(html);
                    }
                }
            });
        }

        $('#add').on('click', function () {
            $('#add').attr("disabled", true);
            var name = $('#name').val();
            if (name == "") {
                Swal.fire({
                    icon: 'Error',
                    title: 'Attribute',
                    text: 'All input field is required'
                });
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.attribute.store')}}",
                method: 'POST',
                data: {
                    name: name,
                },
                success: function () {
                    toastr.success('Attribute inserted Successfully.');
                    $('#name').val('');
                    fetch_attribute();

                }
            });
        });
        $('#update').on('click', function () {
            $('#update').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#name').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.attribute.update')}}",
                method: 'POST',
                data: {
                    id: id,
                    name: name,
                },
                success: function () {
                    $('#name').val('');
                    toastr.success('Attribute updated successfully');
                    $('#update').hide();
                    $('#add').show();
                    fetch_attribute();
                }
            });
            $('#save').hide();
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure to delete this?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: 'primary',
                cancelButtonColor: 'secondary',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.attribute.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            fetch_attribute();
                            toastr.success('Attribute deleted successfully');
                        }
                    });
                }
            })
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
                url: "{{route('admin.attribute.edit')}}",
                method: 'POST',
                data: {id: id},
                success: function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    fetch_attribute()
                }
            });
        });

        // Call the dataTables jQuery plugin
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });

    </script>
@endpush
