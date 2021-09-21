@extends('layouts.back-end.app')
@section('title','Category')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
         @media(max-width:375px){
            #category-icon-modal .modal-content{
              width: 367px !important;
            margin-left: 0 !important;
        }
       
        }

   @media(max-width:500px){
    #category-icon-modal .modal-content{
              width: 400px !important;
            margin-left: 0 !important;
        }
      
      
   }
    </style>
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
        <h4 class=" mb-0 text-black-50">{{ trans('messages.category')}}</h4>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('messages.category_form')}}
                </div>
                <div class="card-body">
                    <form action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" id="id" name="id">
                                    <label for="name">{{ trans('messages.name')}}</label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}"
                                            placeholder="Enter Category Name" required>
                                </div>  
                                <div class="form-group">
                                    <label>{{ trans('messages.icon')}}</label><br>
                                    <div class="custom-file">
                                        <input type="file" name="image" id="FileUploader" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                        <label class="custom-file-label" for="FileUploader">{{trans('messages.choose')}} {{trans('messages.file')}}</label>
                                    </div> 
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <center>
                                    <img style="width: auto;border: 1px solid; border-radius: 10px; max-height:200px;" id="Imageviewer"
                                        src="{{asset('public\assets\back-end\img\400x400\img2.jpg')}}" alt="banner image"/>
                                </center>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            <button id="add" class="btn btn-primary"  type = "subbmit" style="color: white">{{ trans('messages.save')}}</button>
                            <a id="update" class="btn btn-primary"
                               style="display: none; color: #fff;">{{ trans('messages.update')}}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--modal-->
    @include('shared-partials.image-process._image-crop-modal',['modal_id'=>'category-icon-modal'])
    <!--modal-->
    <div class="row" style="margin-top: 20px" id="cate-table">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{ trans('messages.category_table')}}</h5>
                </div>
                <div class="card-body" style="padding: 0">
                    <div class="table-responsive">
                        <table id="columnSearchDatatable"
                               class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <thead class="thead-light">
                            <tr>
                                <th>{{ trans('messages.sl')}}</th>
                                <th>{{ trans('messages.name')}}</th>
                                <th>{{ trans('messages.slug')}}</th>
                                <th>{{ trans('messages.icon')}}</th>
                                <th style="width:15%;">{{ trans('messages.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category['name']}}</td>
                                    <td>{{$category['slug']}}</td>
                                    <td>
                                    <img width="64" onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     src="{{asset('storage/app/public/category')}}/{{$category['icon']}}"></td>
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
        /*fetch_category();*/

        function fetch_category() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.category.fetch')}}",
                method: 'GET',
                success: function (data) {

                    if (data.length != 0) {
                        var html = '';
                        for (var count = 0; count < data.length; count++) {
                            html += '<tr>';
                            html += '<td class="column_name" data-column_name="sl" data-id="' + data[count].id + '">' + (count + 1) + '</td>';
                            html += '<td class="column_name" data-column_name="name" data-id="' + data[count].id + '">' + data[count].name + '</td>';
                            html += '<td class="column_name" data-column_name="slug" data-id="' + data[count].id + '">' + data[count].slug + '</td>';
                            html += '<td class="column_name" data-column_name="icon" data-id="' + data[count].id + '"><img src="{{asset('storage/app/public/category/')}}/' + data[count].icon + '" class="img-thumbnail" height="40" width="40" alt=""></td>';
                            html += '<td><a type="button" class="btn btn-primary btn-xs edit" id="' + data[count].id + '"><i class="fa fa-edit text-white"></i></a> <a type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fa fa-trash text-white"></i></a></td></tr>';
                        }
                        $('tbody').html(html);
                    }
                }
            });
        }

        // $('#add').on('click', function () {
        //     $('#add').attr("disabled", true);
        //     var name = $('#name').val();
        //     var form = $(this).parents("form");
        //     var formData = new FormData(form[0]);
        //     if (name == "") {
        //         toastr.error('Category Name Is Requeired.');
        //         return false;
        //     }
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "{{route('admin.category.store')}}",
        //         method: 'POST',
        //         data: formData,
        //         dataType:'JSON',
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function () {
        //             toastr.success('Category inserted Successfully.');
        //             $('#name').val('');
        //             $('#image-set').val('');
        //             $('.call-when-done').click();
        //             fetch_category();
        //             location.reload();
        //         }
        //     });
        // });

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
                url: "{{route('admin.category.update')}}",
                method: 'POST',
                data: {
                    id: id,
                    name: name,
                },
                success: function (data) {
                    $('#name').val('');
                    $.ajax({
                        type: 'get',
                        url: '{{route('image-remove',[0,'category_icon_modal'])}}',
                        dataType: 'json',
                        success: function (data) {
                            if (data.success === 1) {
                                $("#img-suc").hide();
                                $("#img-err").hide();
                                $("#crop").hide();
                                $("#show-images").html(data.images);
                                $("#image-count").text(data.count);
                            } else if (data.success === 0) {
                                $("#img-suc").hide();
                                $("#img-err").show();
                            }
                        },
                    });
                    toastr.success('Category updated Successfully.');
                    $('#update').hide();
                    $('#cate-table').show();
                    $('#add').show();
                    fetch_category();
                    location.reload();
                }
            });
            $('#save').hide();
        });


        $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure?',
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
                        url: "{{route('admin.category.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            fetch_category();
                            toastr.success('Category deleted Successfully.');
                            location.reload();
                        }
                    });
                }
            })
        });

        $(document).on('click', '.edit', function () {
            // $('#update').show();
            var id = $(this).attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('admin.category.edit')}}",
                method: 'POST',
                data: {id: id},
                success: function (data) {
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#Imageviewer').attr('src', "{{asset('storage/app/public/category')}}/"+data.icon);
                    $('#cate-table').hide();
                    $('#add').html("{{ trans('messages.update')}}");
                    $("form").attr('action', "{{route('admin.category.update')}}");
                    fetch_category()
                }
            });
        });

        function imagereadURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#Imageviewer').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#FileUploader").change(function () {
            imagereadURL(this);
        });
    </script>
    <!-- Page level custom scripts -->
    @include('shared-partials.image-process._script',[
    'id'=>'category-icon-modal',
    'height'=>320,
    'width'=>320,
    'multi_image'=>true,
    'route'=>route('image-upload')
    ])
@endpush
