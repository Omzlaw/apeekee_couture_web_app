@extends('layouts.back-end.app')
@section('title','Sub Category')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.category')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h4 class=" mb-0 text-black-50">{{ trans('messages.sub_category')}}</h4>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('messages.sub_category_form')}}
                </div>
                <div class="card-body">
                    <form>
                        @csrf
                        <div class="form-group">
                            <input type="hidden" id="id">
                            <label for="name">{{ trans('messages.select_category_name')}}</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="0" selected disabled>Select Category</option>
                                @foreach (App\Model\Category::where('position',0)->get() as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="hidden" id="id">
                            <label for="name">{{ trans('messages.name')}}</label>
                            <input type="text" name="name" class="form-control" id="name" required
                                   placeholder="Enter Category Name">
                        </div>

                        <div class="card-footer">
                            <a id="add" class="btn btn-primary" style="color: white">{{ trans('messages.save')}}</a>
                            <a id="update" class="btn btn-primary"
                               style="display: none; color: #fff;">{{ trans('messages.update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px" id="cate-table">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('messages.sub_category_table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">{{ trans('messages.sl')}}</th>
                                <th scope="col">{{ trans('messages.name')}}</th>
                                <th scope="col">{{ trans('messages.slug')}}</th>
                                {{--                                <th scope="col">icon</th>--}}
                                <th scope="col" style="width: 80px">{{ trans('messages.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category['name']}}</td>
                                    <td>{{$category['slug']}}</td>
                                    <td>

                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                <i class="tio-settings"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item  edit" style="cursor: pointer;"
                                                id="{{$category['id']}}"> {{ trans('messages.Edit')}}</a>
                                                <a class="dropdown-item delete"style="cursor: pointer;"
                                                id="{{$category['id']}}">  {{ trans('messages.Delete')}}</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer">
                    {{$categories->links()}}
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
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>

    <script>
        fetch_category();

        function fetch_category() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.sub-category.fetch')}}",
                method: 'GET',
                success: function (data) {
                    if (data.length != 0) {
                        var html = '';
                        for (var count = 0; count < data.length; count++) {
                            html += '<tr>';
                            html += '<td class="column_name" data-column_name="sl" data-id="' + data[count].id + '">' + (count + 1) + '</td>';
                            html += '<td class="column_name" data-column_name="name" data-id="' + data[count].id + '">' + data[count].name + '</td>';
                            html += '<td class="column_name" data-column_name="slug" data-id="' + data[count].id + '">' + data[count].slug + '</td>';
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
            var parent_id = $('#parent_id').val();
            if (name == "" || parent_id == null) {
                toastr.error('Category Name Is Requeired.');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.sub-category.store')}}",
                method: 'POST',
                data: {
                    name: name,
                    parent_id: parent_id
                },
                success: function () {
                    $('#name').val('');
                    document.getElementById('parent_id').value = 0;
                    toastr.success('Sub Category inserted Successfully.');
                    fetch_category();
                }
            });
        });

        $('#update').on('click', function () {
            $('#update').attr("disabled", true);
            var id = $('#id').val();
            var name = $('#name').val();
            var parent_id = $('#parent_id').val();
            if (name == "" || parent_id == null) {

                toastr.error('Category Name Is Requeired.');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.sub-category.update')}}",
                method: 'POST',
                data: {
                    id: id,
                    name: name,
                    parent_id: parent_id,
                },
                success: function () {
                    $('#name').val('');
                    document.getElementById('parent_id').value = 0;
                    toastr.success('Sub Category updated Successfully.');
                    $('#update').hide();
                    $('#add').show();
                    fetch_category();
                    $('#cate-table').show();
                }
            });
            $('#save').hide();
        });


        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure to delete this sub category?',
                text: "You won't be able to revert this!",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{route('admin.sub-category.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            fetch_category();
                            toastr.success('Sub Category deleted Successfully.');

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
                url: "{{route('admin.sub-category.edit')}}",
                method: 'POST',
                data: {id: id},
                success: function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#cate-table').hide();
                    document.getElementById('parent_id').value = data.parent_id;
                    fetch_category()
                }
            });
        });
    </script>
@endpush
