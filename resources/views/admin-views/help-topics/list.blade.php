@extends('layouts.back-end.app')
@section('title','FAQ')
@push('css_or_js')
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/back-end')}}/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
            background-color: #377dff;
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
        .for-addFaq{
            float: right;
        }
        @media(max-width:500px){
            .for-addFaq{
                float: none !important;
            }
        }

    </style>
@endpush

@section('content')
<div class="content container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{trans('messages.Dashboard')}}</a></li>
            <li class="breadcrumb-item" aria-current="page">{{trans('messages.Dashboard')}}{{trans('messages.help_topic')}}</li>
        </ol>
    </nav>

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-2 mt-2">
        <h1 class="h3 mb-0 text-black-50">{{trans('messages.help_topic')}} {{trans('messages.List')}}  </h1>
        <button  class="btn btn-primary btn-icon-split for-addFaq" data-toggle="modal" data-target="#addModal">
            <i class="tio-add-circle"></i>
              <span class="text">{{trans('messages.Add')}} {{trans('messages.faq')}}  </span></button>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>{{trans('messages.help_topic')}} {{trans('messages.Table')}} </h5>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th scope="col">{{trans('messages.SL#')}}</th>
                                <th scope="col">{{trans('messages.Question')}}</th>
                                <th scope="col">{{trans('messages.Answer')}}</th>
                                <th scope="col">{{trans('messages.Ranking')}}</th>
                                <th scope="col">{{trans('messages.Status')}} </th>
                                <th scope="col">{{trans('messages.Action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($helps as $k=>$help)
                                <tr>
                                    <td scope="row">{{$k+1}}</td>
                                    <td>{{$help['question']}}</td>
                                    <td>{{$help['answer']}}</td>
                                    <td>{{$help['ranking']}}</td>

                                    <td>
                                        <label class="switch">
                                            <input type="checkbox" class="status status_id"
                                            data-id="{{ $help->id }}" {{$help->status == 1?'checked':''}}>
                                            <span class="slider round"></span>
                                        </label>
                                    </td>
                                    <td>
                                        {{-- @if($help->status== 1)
                                        <a class=" status_id  btn btn-success btn-sm" data-id="{{ $help->id }}">
                                            <i class="fa fa-sync"></i>
                                        </a>
                                        @else
                                        <a class=" status_id btn btn-danger btn-sm" data-id="{{ $help->id }}">
                                            <i class="fa fa-sync"></i>
                                        </a>
                                        @endif --}}
                                        
{{-- 
                                        <a href="{{ route('admin.helpTopic.delete',$help->id) }}" class="btn btn-danger btn-sm " onclick="alert('Are You sure to Delete')"  >
                                            <i class="fa fa-trash"></i> --}}
                                            <div class="dropdown">
                                                <button class="btn btn-outline-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    <i class="tio-settings"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item edit" style="cursor: pointer;" data-toggle="modal" data-target="#editModal" data-id="{{ $help->id }}">
                                                        {{ trans('messages.Edit')}}
                                                    </a>
                                                    <a class="dropdown-item delete" style="cursor: pointer;" 
                                                    id="{{$help['id']}}"> {{ trans('messages.Delete')}}</a>
                                                </div>
                                            </div>
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

    {{-- add modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="addModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Help Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.helpTopic.add-new') }}" method="post" id="addForm">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control"  name="question" placeholder="Type Question">
                        </div>


                        <div class="form-group">
                            <label>Answer</label>
                            <textarea class="form-control"  name="answer" cols="5"
                                rows="5" placeholder="Type Answer"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="control-label">Status</div>
                                    <label class="custom-switch" style="margin-left: -2.25rem;margin-top: 10px;">
                                      <input type="checkbox" name="status" id="e_status" value="1" class="custom-switch-input">
                                      <span class="custom-switch-indicator"></span>
                                      <span class="custom-switch-description">Active</span>
                                    </label>
                                  </div>
                                </div>

                            <div class="col-md-6">
                                <label for="ranking">Ranking</label>
                                <input type="number" name="ranking" class="form-control"  autofoucs>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save</button>
                </form>
               </div>
            </div>
        </div>
    </div>

    {{-- edit modal --}}

    <div class="modal fade" tabindex="-1" role="dialog" id="editModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Modal Help Topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="editForm">
                    @csrf
                    {{-- @method('put') --}}
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Question</label>
                            <input type="text" class="form-control"  name="question" placeholder="Type Question" id="e_question" class="e_name">
                        </div>


                        <div class="form-group">
                            <label>Answer</label>
                            <textarea class="form-control"  name="answer" cols="5"
                                rows="5" placeholder="Type Answer" id="e_answer"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">

                                </div>

                            <div class="col-md-4">
                                <label for="ranking">Ranking</label>
                                <input type="number" name="ranking" class="form-control" id="e_ranking" required autofoucs>
                            </div>
                            <div class="col-md-4">

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">update</button>
                </form>
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

    <script>
         $(document).ready(function() {
            $('#dataTable').DataTable();
        });
        $(document).on('click', ".status_id", function(){
          let id=$(this).attr('data-id');

          $.ajax({
              url:"status/"+id,
              type:'get',
              dataType:'json',
              success:function(res)
              {
                toastr.success(res.success);
                  window.location.reload();
              }

          });

        });
        $(document).on('click','.edit',function(){
           let id=$(this).attr("data-id");
           console.log(id);
           $.ajax({
               url:"edit/"+id,
               type:"get",
               data:{"_token":"{{ csrf_token() }}"},
               dataType:"json",
               success:function(data){
                   console.log(data);
                   $("#e_question").val(data.question);
                   $("#e_answer").val(data.answer);
                   $("#e_ranking").val(data.ranking);


                 $("#editForm").attr("action","update/"+data.id);


               }
           });
       });
       $(document).on('click', '.delete', function () {
            var id = $(this).attr("id");
            Swal.fire({
                title: 'Are you sure delete this FAQ?',
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
                        url: "{{route('admin.helpTopic.delete')}}",
                        method: 'POST',
                        data: {id: id},
                        success: function () {
                            toastr.success('FAQ deleted successfully');
                            location.reload();
                        }
                    });
                }
            })
        });


    </script>
@endpush
