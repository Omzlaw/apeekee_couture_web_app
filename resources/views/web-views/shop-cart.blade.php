@extends('layouts.front-end.app')

@section('title','My Shopping Cart')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="{{$web_config['name']->value}} "/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="{{$web_config['name']->value}}"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/shop-cart.css"/>
@endpush

@section('content')
    <div class="container pb-5 mb-2 mt-3" id="cart-summary">
        @include('layouts.front-end.partials.cart_details')
    </div>
@endsection

@push('script')
    <script>
        cartQuantityInitialize();
    </script>
@endpush
