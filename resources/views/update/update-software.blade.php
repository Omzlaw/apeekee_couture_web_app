@extends('layouts.blank')

@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-md-12">
                <div class="mar-ver pad-btm text-center">
                    <h1 class="h3">6valley Software Update</h1>
                </div>
                <div class="text-center">
                    <a href="{{route('update-system')}}" class="btn btn-info text-light">
                        Update Now <i class="fa fa-forward"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
