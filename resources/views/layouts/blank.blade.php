<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>
        @yield('title')
    </title>
    <!-- SEO Meta Tags-->
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- Viewport-->
    <meta name="_token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon and Touch Icons-->
    <link rel="apple-touch-icon" sizes="180x180" href="">
    <link rel="icon" type="image/png" sizes="32x32" href="">
    <link rel="icon" type="image/png" sizes="16x16" href="">

    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/simplebar/dist/simplebar.min.css"/>
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/tiny-slider/dist/tiny-slider.css"/>
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/drift-zoom/dist/drift-basic.min.css"/>
    <link rel="stylesheet" media="screen"
          href="{{asset('public/assets/front-end')}}/vendor/lightgallery.js/dist/css/lightgallery.min.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css"/>
    <!-- Main Theme Styles + Bootstrap-->
    <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/theme.min.css">
    <link rel="stylesheet" media="screen" href="{{asset('public/assets/front-end')}}/css/slick.css">
    <link rel="stylesheet" href="{{asset('public/assets/back-end')}}/css/toastr.css"/>
    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/master.css"/>


</head>
<!-- Body-->
<body class="toolbar-enabled">

{{--loader--}}
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="loading" style="display: none;">
                <div style="position: fixed;z-index: 9999; left: 40%;top: 37% ;width: 100%">
                    <img width="200" src="{{asset('public/assets/front-end/img/loader.gif')}}">
                </div>
            </div>
        </div>
    </div>
</div>
{{--loader--}}

<!-- Page Content-->
@yield('content')

<!-- Back To Top Button-->
<a class="btn-scroll-top" href="#top" data-scroll>
    <span class="btn-scroll-top-tooltip text-muted font-size-sm mr-2">Top</span><i
        class="btn-scroll-top-icon czi-arrow-up"> </i>
</a>

<!-- Vendor scrits: js libraries and plugins-->
{{--<script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery.slim.min.js"></script>--}}
<script src="{{asset('public/assets/front-end')}}/vendor/jquery/dist/jquery-2.2.4.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script
    src="{{asset('public/assets/front-end')}}/vendor/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/simplebar/dist/simplebar.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/tiny-slider/dist/min/tiny-slider.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

<script src="{{asset('public/assets/front-end')}}/vendor/drift-zoom/dist/Drift.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/lightgallery.js/dist/js/lightgallery.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/vendor/lg-video.js/dist/lg-video.min.js"></script>
{{--Toastr--}}
<script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
<!-- Main theme script-->
<script src="{{asset('public/assets/front-end')}}/js/theme.min.js"></script>
<script src="{{asset('public/assets/front-end')}}/js/slick.min.js"></script>

<script src="{{asset('public/assets/front-end')}}/js/sweet_alert.js"></script>
{{--Toastr--}}
<script src={{asset("public/assets/back-end/js/toastr.js")}}></script>
{!! Toastr::message() !!}

@if ($errors->any())
    <script>
        @foreach($errors->all() as $error)
        toastr.error('{{$error}}', Error, {
            CloseButton: true,
            ProgressBar: true
        });
        @endforeach
    </script>
@endif
</body>
</html>
