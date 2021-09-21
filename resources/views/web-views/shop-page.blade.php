@extends('layouts.front-end.app')

@section('title','Shop Page')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}"/>
    <meta property="og:title" content="{{ $shop->name}} "/>
    <meta property="og:url" content="{{route('shopView',[$shop['id']])}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/shop')}}/{{$shop->image}}"/>
    <meta property="twitter:title" content="{{route('shopView',[$shop['id']])}}"/>
    <meta property="twitter:url" content="{{route('shopView',[$shop['id']])}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link href="{{asset('public/assets/front-end')}}/css/home.css" rel="stylesheet">
    <style>
        .headerTitle {
            font-size: 34px;
            font-weight: bolder;
            margin-top: 3rem;
        }

        .page-item.active .page-link {
            background-color: {{$web_config['primary_color']}}              !important;
        }

        .page-item.active > .page-link {
            box-shadow: 0 0 black !important;
        }

    </style>
@endpush

@section('content')
    <!-- Page Title-->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="h3 text-dark mb-0 headerTitle text-uppercase">SELLER</h3>
                {{-- <div class="row">
                    <div class="col-md-6">

                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap mt-5 float-right">
                            <form class="" id="search-form" action="{{ route('products') }}" method="GET">
                                <input hidden name="data_from" >
                                <div class="form-inline flex-nowrap mr-3 mr-sm-4 pb-3">
                                    <label style="font-weight: 600;font-size: 18px;padding-right: 9px; color:#030303; "
                                           class=" opacity-75 text-nowrap mr-2 d-none d-sm-block" for="sorting">
                                        Sort by
                                    </label>
                                    <select style="background: whitesmoke; appearance: auto;"
                                            class="form-control custom-select" onchange="filter(this.value)">
                                        <option value="latest">Latest</option>
                                        <option value="low-high">Low - Hight Price</option>
                                        <option value="high-low">High - Low Price</option>
                                        <option value="a-z">A - Z Order</option>
                                        <option value="z-a">Z - A Order</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container pb-5 mb-2 mb-md-4">
        <div class="row">
            <!-- Content  -->
            <section class="col-lg-12">
                <div class="seller-header-image">
                </div>

                <div class="mt-4 mb-2">
                    <div class="row seller_footer">
                        <div class="col-md-10" style="display: inline-flex">
                            <img style="height: 65px; border-radius: 2px;"
                                 src="{{asset('storage/app/public/shop')}}/{{$shop->image}}"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 alt="">
                            <h6 class="ml-4 font-weight-bold mt-3">{{ $shop->name}}</h6>
                        </div>
                        <div class="col-md-2">
                            @if (auth('customer')->id() == '')
                                <div class="d-flex">
                                    <a href="{{route('customer.auth.login')}}" class="btn btn-primary btn-block">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        {{trans('messages.Contact')}} {{trans('messages.Seller')}}
                                    </a>
                                </div>
                            @else
                                <div class="d-flex">
                                    <button class="btn btn-primary btn-block" data-toggle="modal"
                                            data-target="#exampleModal">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        {{trans('messages.Contact')}} {{trans('messages.Seller')}}
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="card-header">
                                Write Something
                            </div>
                            <div class="modal-body">
                                <form action="{{route('messages_store')}}" method="post" id="chat-form">
                                    @csrf
                                    <input value="{{$shop->id}}" name="shop_id" hidden>
                                    <input value="{{$shop->seller_id}}}" name="seller_id" hidden>

                                    <textarea name="message" class="form-control"></textarea>
                                    <br>
                                    <button class="btn btn-primary" style="color: white;">
                                        Send
                                    </button>
                                </form>
                            </div>
                            <div class="card-footer">
                                <a href="{{route('chat-with-seller')}}" class="btn btn-primary">
                                    {{trans('messages.go_to')}} {{trans('messages.chatbox')}}
                                </a>
                                <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <hr>
        <div class="mt-3">
            {{--<form class="" id="search-form" action="{{ route('products') }}" method="GET">
                <input hidden name="data_from">
                <div class="form-inline flex-nowrap mr-3 mr-sm-4 pb-3">
                    <label style="font-weight: 600;font-size: 18px;padding-right: 9px; color:#030303; "
                           class=" opacity-75 text-nowrap mr-2 d-none d-sm-block" for="sorting">
                        Sort by
                    </label>
                    <select style="background: whitesmoke; appearance: auto;"
                            class="form-control custom-select" onchange="filter(this.value)">
                        <option value="latest">Latest</option>
                        <option value="low-high">Low - Hight Price</option>
                        <option value="high-low">High - Low Price</option>
                        <option value="a-z">A - Z Order</option>
                        <option value="z-a">Z - A Order</option>
                    </select>
                </div>
            </form>--}}
        </div>
        <!-- Products grid-->
        <div class="row mt-3" id="ajax-products">
            @include('web-views.products._ajax-products',['products'=>$products])
        </div>
        <hr class="my-3">
        <!-- Pagination-->
        <div class="row">
            <div class="col-md-12">
                <div class="justify-content-center center-block align-content-center">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- <script>
        function filter(value) {
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    min_price: '{{$data['min_price']}}',
                    max_price: '{{$data['max_price']}}',
                    sort_by: value
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        function searchByPrice() {
            let min = $('#min_price').val();
            let max = $('#max_price').val();
            $.get({
                url: '{{url('/')}}/products',
                data: {
                    id: '{{$data['id']}}',
                    name: '{{$data['name']}}',
                    data_from: '{{$data['data_from']}}',
                    sort_by: '{{$data['sort_by']}}',
                    min_price: min,
                    max_price: max,
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (response) {
                    $('#ajax-products').html(response.view);
                    $('#paginator-ajax').html(response.paginator);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $("#search-brand").on("keyup", function () {
            var value = this.value.toLowerCase().trim();
            $("#lista1 div>li").show().filter(function () {
                return $(this).text().toLowerCase().trim().indexOf(value) == -1;
            }).hide();
        });
    </script> --}}

    <script>
        $('#chat-form').on('submit', function (e) {
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: '{{route('messages_store')}}',
                data: $('#chat-form').serialize(),
                success: function (respons) {

                    toastr.success('send successfully', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    $('#chat-form').trigger('reset');
                }
            });

        });
    </script>
@endpush
