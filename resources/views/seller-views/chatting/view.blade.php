@extends('layouts.back-end.app')
@section('title','Chat View')
@push('css_or_js')
    <link href="{{asset('public/assets/back-end')}}/css/select2.min.css" rel="stylesheet"/>
    <link href="{{asset('public/assets/back-end/css/croppie.css')}}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Message view</li>
        </ol>
    </nav>
    <!-- Page Heading -->
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 mb-0 text-black-50">View User Message</h1>
        </div>

        <!-- Content Row -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body mt-3 ml-4">
                        <div class="row ">
                            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                <img style="height: 8rem; width: 9rem;" class="img-circle"
                                     src="{{asset('public/assets/front-end')}}/img/contacts/blank.jpg"
                                     alt="User Pic">
                            </div>


                            <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                <strong style="margin-right: 20px">{{$contact->subject}}</strong>
                                @if($contact->seen==1)
                                    <label style="color: green; border: 1px solid;padding: 2px;border-radius: 10px">Seen</label>
                                @else
                                    <label style="color: red; border: 1px solid;padding: 2px;border-radius: 10px">Not Seen Yet</label>
                                @endif
                                <br>
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>User name:</td>
                                        <td>{{$contact->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Mobile Number:</td>
                                        <td>{{$contact->mobile_number}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{$contact->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Message</td>
                                        <td><p style="font-width:16px;"> {{$contact->message}}</p></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <form action="{{route('admin.contact.update',$contact->id)}}" method="post">
                            @csrf
                            <div class="form-group" style="display: none">
                                <div class="row">
                                    <div class="col-md-10">
                                        <h4>Feedback</h4>
                                        <textarea class="form-control " name="feedback" id="" rows="5"
                                                  placeholder="Please send a Feedback">{{$contact->feedback}}</textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-success float-right">
                                    <i class="fa fa-check"></i> Seen
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>







@endsection

@push('script')

@endpush
