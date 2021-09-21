@extends('layouts.front-end.app')

@section('title','Welcome To '. $web_config['name']->value.' Home')

@push('css_or_js')
    <meta property="og:image" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="og:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="og:url" content="{{env('APP_URL')}}">
    <meta property="og:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <meta property="twitter:card" content="{{asset('storage/app/public/company')}}/{{$web_config['web_logo']->value}}"/>
    <meta property="twitter:title" content="Welcome To {{$web_config['name']->value}} Home"/>
    <meta property="twitter:url" content="{{env('APP_URL')}}">
    <meta property="twitter:description" content="{!! substr($web_config['about']->value,0,100) !!}">

    <link rel="stylesheet" href="{{asset('public/assets/front-end')}}/css/home.css"/>
    <style>
        .cz-countdown-days {
            color: white !important;
            background-color: {{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 3px !important;
        }

        .cz-countdown-hours {
            color: white !important;
            background-color: {{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 3px !important;
        }

        .discount-top-f {
            text-align: end;
            /* margin-top: 5px; */
            margin-bottom: 5px;
        }

        .cz-countdown-minutes {
            color: white !important;
            background-color: {{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px;
            margin-right: 3px !important;
        }

        .cz-countdown-seconds {
            color: {{$web_config['primary_color']}};
            border: 1px solid{{$web_config['primary_color']}};
            padding: 0px 6px;
            border-radius: 3px !important;
        }

        .flash_deal_product_details .flash-product-price {
            font-weight: 700;
            font-size: 18px;
            color: {{$web_config['primary_color']}};
        }

        .for-discoutn-value {
            background: {{$web_config['primary_color']}};

        }

        .featured_deal_left {
            height: 130px;
            background: {{$web_config['primary_color']}} 0% 0% no-repeat padding-box;
            padding: 10px 100px;
            text-align: center;
        }

        .featured_deal {
            min-height: 130px;

        }

        .category_div:hover {
            color: {{$web_config['secondary_color']}};
        }

        .deal_of_the_day {
            /* filter: grayscale(0.5); */
            opacity: .8;
            background: {{$web_config['secondary_color']}};
            border-radius: 3px;
        }

        .deal-title {
            font-size: 12px;

        }

        .for-flash-deal-img img {
            max-width: none;
        }

        @media (max-width: 375px) {
            .cz-countdown {
                display: flex !important;

            }

            .cz-countdown .cz-countdown-seconds {

                margin-top: -5px !important;
            }

            .for-feature-title {
                font-size: 20px !important;
            }
        }

        @media (max-width: 600px) {
            .flash_deal_title {
                font-weight: 600;
                font-size: 18px;
                text-transform: uppercase;
            }

            .cz-countdown .cz-countdown-value {
                font-family: "Roboto", sans-serif;
                font-size: 11px !important;
                font-weight: 700 !important;
            }

            .featured_deal {
                opacity: 1 !important;
            }

            .cz-countdown {
                display: inline-block;
                flex-wrap: wrap;
                font-weight: normal;
                margin-top: 4px;
                font-size: smaller;
            }

            .view-btn-div-f {

                margin-top: 6px;
                float: right;
            }

            .view-btn-div {
                float: right;
            }

            .viw-btn-a {
                font-size: 10px;
                font-weight: 600;
            }


            .for-mobile {
                display: none;
            }

            .featured_for_mobile {
                max-width: 95%;
                margin-top: 20px;
            }
        }

        @media (max-width: 360px) {
            .featured_for_mobile {
                max-width: 96%;
                margin-top: 11px;
            }

            .featured_deal {
                opacity: 1 !important;
            }
        }

        @media (max-width: 375px) {
            .featured_for_mobile {
                max-width: 96%;
                margin-top: 11px;
            }

            .featured_deal {
                opacity: 1 !important;
            }

            .for-iphone-mobile {
                margin-left: 2%;
            }
        }

        @media (min-width: 768px) {
            .displayTab {
                display: block !important;
            }
        }

        @media (max-width: 800px) {
            .for-tab-view-img {
                width: 40%;
            }

            .for-tab-view-img {
                width: 105px;
            }

            .widget-title {
                font-size: 19px !important;
            }
        }

        .featured_deal_carosel .carousel-inner {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <!-- Hero (Banners + Slider)-->
    <section class="bg-transparent mt-4 mb-4">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <div class="banner_card">
                        <div class="row">
                            <div class="col-lg-9 col-md-8 pr-md-1">
                                @php($main_banner=\App\Model\Banner::where('banner_type','Main Banner')->where('published',1)->orderBy('id','desc')->get())
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach($main_banner as $key=>$banner)
                                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$key}}"
                                                class="{{$key==0?'active':''}}">
                                            </li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach($main_banner as $key=>$banner)
                                            <div class="carousel-item {{$key==0?'active':''}}">
                                                <a href="{{$banner['url']}}">
                                                    <img class="d-block w-100" style="max-height: 350px"
                                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                         src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                                                         alt="">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                       data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                       data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>


                                <div class="cz-carousel">
                                    <div class="d-flex flex-nowrap">
                                        @foreach(\App\Model\Banner::where('banner_type','Footer Banner')->where('published',1)->orderBy('id','desc')->take(3)->get() as $banner)
                                            <div class="footer_banner">
                                                <a data-toggle="modal" data-target="#quick_banner{{$banner->id}}"
                                                   style="cursor: pointer;">
                                                    <img class="d-block mx-auto footer_banner_img"
                                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                         src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}"
                                                         width="315">
                                                </a>

                                            </div>
                                            <div class="modal fade" id="quick_banner{{$banner->id}}" tabindex="-1"
                                                 role="dialog" aria-labelledby="exampleModalLongTitle"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <p class="modal-title"
                                                               id="exampleModalLongTitle">{{ trans('messages.banner_photo')}}</p>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img class="d-block mx-auto"
                                                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                 src="{{asset('storage/app/public/banner')}}/{{$banner['photo']}}">
                                                            @if ($banner->url!="")
                                                                <div class="text-center mt-2">
                                                                    <a href="{{$banner->url}}"
                                                                       class="btn btn-outline-accent">{{trans('messages.Explore')}} {{trans('messages.Now')}}</a>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- Banner group-->
                            <div class="col-lg-3 col-md-4 pl-md-1 pt-sm-3 pt-3 pt-md-0"
                                 style="overflow: hidden;max-height: 532px">
                                <div class="table-responsive banner_product" data-simplebar style=" padding: 0px;">
                                    <div class="d-flex d-md-block justify-content-between">
                                        @foreach($random_products as $product)
                                            @include('web-views.partials._inline-single-product',['product'=>$product])
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--flash deal--}}
    @php($flash_deals=\App\Model\FlashDeal::with(['products.product.reviews'])->where(['status'=>1])->where(['deal_type'=>'flash_deal'])->whereDate('start_date','<=',date('Y-m-d'))->whereDate('end_date','>=',date('Y-m-d'))->first())

    @if (isset($flash_deals))
        <div class="container pt-3 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="flash_deal pt-2">
                        <div class="container">
                            <div class="row d-flex justify-content-between fd">
                                <div class="col-xl-6 col-4">
                                    <div class="d-inline-flex displayTab">
                                        <span class="flash_deal_title mr-3">
                                            {{$flash_deals['title']}}
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-8">
                                    <div class="view_all view-btn-div-f float-right">
                                        <div class="pr-2">
                                                      <span class="cz-countdown"
                                                            data-countdown="{{isset($flash_deals)?date('m/d/Y',strtotime($flash_deals['end_date'])):''}} 11:59:00 PM">
                                                <span class="cz-countdown-days">
                                                    <span class="cz-countdown-value"></span>
                                                </span>
                                                <span class="cz-countdown-value">:</span>
                                                <span class="cz-countdown-hours">
                                                    <span class="cz-countdown-value"></span>
                                                </span>
                                                <span class="cz-countdown-value">:</span>
                                                <span class="cz-countdown-minutes">
                                                    <span class="cz-countdown-value"></span>
                                                </span>
                                                <span class="cz-countdown-value">:</span>
                                                <span class="cz-countdown-seconds">
                                                    <span class="cz-countdown-value"></span>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="pl-2">
                                            <a class="btn btn-outline-accent btn-sm viw-btn-a"
                                               href="{{route('flash-deals',[isset($flash_deals)?$flash_deals['id']:0])}}">{{ trans('messages.view_all')}}
                                                <i class="czi-arrow-right ml-1 mr-n1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach($flash_deals->products as $key=>$deal)
                                    @if($key<3 && $deal->product)
                                        @php($overallRating = \App\CPU\ProductManager::get_overall_rating(isset($deal)?$deal->product->reviews:null))
                                        <div class="col-sm-6 col-md-4">
                                            <div class="flash_deal_product "
                                                 style="cursor: pointer;"
                                                 data-href="{{route('product',$deal->product->slug)}}">
                                                @if($deal->product->discount > 0)
                                                    <div class="inline_product discount-top-f"> <span
                                                            class="for-discoutn-value">
                                                @if ($deal->product->discount_type == 'percent')
                                                                {{round($deal->product->discount)}}%
                                                            @elseif($deal->product->discount_type =='flat')
                                                                {{\App\CPU\Helpers::currency_converter($deal->product->discount)}}
                                                            @endif
                                                            {{-- {{$deal->product->discount_type=='percent'?\App\CPU\Helpers::currency_converter($deal->product->discount):$deal->product->discount.' % '}}  --}}
                                                OFF</span></div>
                                                @else
                                                    <div class="inline_product"> <span class="for-discoutn-value-null">
                                                </span></div>
                                                @endif
                                                <div class="inline_product d-flex" style="cursor: pointer;"
                                                     data-href="{{route('product',$deal->product->slug)}}">
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <img class="img-for-tab" width="145"
                                                             style="height: 160px!important;"
                                                             src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$deal->product['thumbnail']}}"
                                                             onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                             alt="Product"/>
                                                    </div>
                                                    <div
                                                        class="flash_deal_product_details pl-2 pr-1 d-flex align-items-center">

                                                        <div>
                                                            <h6 class="flash-product-title">
                                                                <a href="{{route('product',$deal->product->slug)}}">{{$deal->product['name']}}</a>
                                                            </h6>
                                                            <div class="flash-product-price">
                                                                {{\App\CPU\Helpers::currency_converter($deal->product->unit_price-\App\CPU\Helpers::get_product_discount($deal->product,$deal->product->unit_price))}}
                                                                @if($deal->product->discount > 0)
                                                                    <strike
                                                                        style="font-size: 12px!important;color: grey!important;">
                                                                        {{\App\CPU\Helpers::currency_converter($deal->product->unit_price)}}
                                                                    </strike>
                                                                @endif
                                                            </div>
                                                            <h6 class="flash-product-review">
                                                        <span
                                                            class="d-inline-block review-count align-middle mt-1 mr-1">{{$overallRating[0]}}
                                                        </span>
                                                                <span class="star-rating">
                                                            <i class="sr-star czi-star-filled active"></i>
                                                        </span>
                                                            </h6>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Products grid (featured products)-->
    @if($featured_products->count() > 0)
        <section class="container pt-3 mb-2">
            <!-- Heading-->
            <div class="row pb-2">
                <div class="col-8">
                    <div class="feature_header">
                        <span class="for-feature-title">{{ trans('messages.featured_products')}}</span>
                    </div>
                </div>
                <div class="col-4">
                    <div class="view_all view-btn-div pull-right">
                        <div>
                            <a class="btn btn-outline-accent btn-sm viw-btn-a"
                               href="{{route('products',['data_from'=>'featured','page'=>1])}}">
                                {{ trans('messages.view_all')}}
                                <i class="czi-arrow-right ml-1 mr-n1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Grid-->
            <div class="row pt-2 mx-n2">
                @foreach($featured_products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        @include('web-views.partials._single-product',['product'=>$product])
                        <hr class="d-sm-none">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{--featured deal--}}
    @php($featured_deals=\App\Model\FlashDeal::with(['products.product.reviews'])->where(['status'=>1])->where(['deal_type'=>'feature_deal'])->first())

    @if(isset($featured_deals))
        <div class="container mb-2">
            <div class="row">
                <div class="col-xl-12">
                    <div class="featured_deal">

                        <div class="row">
                            <div class="col-xl-3 col-md-4">
                                <div class="d-flex align-items-center justify-content-center featured_deal_left">
                                    <h1 class="featured_deal_title">{{ trans('messages.featured_deal')}}</h1>
                                </div>
                            </div>
                            <div class="col-xl-9 col-md-8 for-iphone-mobile">
                                <div id="carouselExampleInterval" class="carousel slide featured_deal_carosel"
                                     data-ride="carousel">
                                    <div class="carousel-inner">
                                        @php($increment=0)
                                        @while($increment<count($featured_deals->products))
                                            <div class="carousel-item {{$increment==0?'active':''}}"
                                                 data-interval="10000">
                                                <div class="row">
                                                    @if(!empty($featured_deals->products[$increment]))
                                                        <div class="col-md-6">
                                                            <div
                                                                class=" d-flex featured_for_mobile  align-items-center justify-content-center mr-1"
                                                                style="height: 129px;border: 1px solid #c5bfbf;border-radius: 10px; ">
                                                                <div
                                                                    class="featured_deal_product d-flex align-items-center justify-content-between inline_product"
                                                                    data-href="{{route('product',$featured_deals->products[$increment]->product->slug)}}">

                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="featured_product_pic "
                                                                                 style=" text-align: center;">
                                                                                <a href="#" class="image_center">
                                                                                    <img style="padding: 10px"
                                                                                         src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$featured_deals->products[$increment]->product['thumbnail']}}"
                                                                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                                         class="d-block w-100"
                                                                                         alt="...">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <div class="featured_product_details ">
                                                                                <h3 class="featured_product-title">
                                                                                    <a class="ptr" href="#">
                                                                                        {{$featured_deals->products[$increment]->product['name']}}
                                                                                    </a>
                                                                                </h3>
                                                                                <div class="featured_product-price">
                                                                        <span class="text-accent ptp">
                                                                            {{\App\CPU\Helpers::currency_converter(
                                                                            $featured_deals->products[$increment]->product->unit_price-(\App\CPU\Helpers::get_product_discount($featured_deals->products[$increment]->product,$featured_deals->products[$increment]->product->unit_price))
                                                                            )}}
                                                                        </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if(!empty($featured_deals->products[$increment+1]))
                                                        <div class="col-md-6 d-md-block d-sm-none for-mobile">
                                                            <div
                                                                class=" d-flex  align-items-center justify-content-center mr-1"
                                                                style="height: 129px;border: 1px solid #c5bfbf;border-radius: 10px;">
                                                                <div
                                                                    class="featured_deal_product d-flex align-items-center justify-content-between inline_product"
                                                                    data-href="{{route('product',$featured_deals->products[$increment+1]->product->slug)}}">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="featured_product_pic "
                                                                                 style=" text-align: center;">
                                                                                <a href="#" class="image_center">
                                                                                    <img
                                                                                        src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$featured_deals->products[$increment+1]->product['thumbnail']}}"
                                                                                        onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                                                        class="d-block w-100" alt="...">
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            <div class="featured_product_details">
                                                                                <h3 class="featured_product-title">
                                                                                    <a class="ptr" href="#">
                                                                                        {{$featured_deals->products[$increment+1]->product['name']}}
                                                                                    </a>
                                                                                </h3>
                                                                                <div class="featured_product-price">
                                                                        <span class="text-accent ptp">
                                                                             {{\App\CPU\Helpers::currency_converter(
                                                                            $featured_deals->products[$increment+1]->product->unit_price-(\App\CPU\Helpers::get_product_discount($featured_deals->products[$increment+1]->product,$featured_deals->products[$increment+1]->product->unit_price))
                                                                            )}}
                                                                        </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @php($increment+=2)
                                        @endwhile
                                    </div>

                                    <a class="carousel-control-prev" href="#carouselExampleInterval" role="button"
                                       data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleInterval" role="button"
                                       data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{--deal of the day--}}
    <div class="container pt-4 mb-4">
        <div class="row">
            <div class="col-xl-3 col-md-4 pb-4">
                <div class="deal_of_the_day">
                    @if(isset($deal_of_the_day))
                        <h1 style="color: white"> {{ trans('messages.deal_of_the_day') }}</h1>
                        <center>
                            <strong style="font-size: 21px!important;color: {{$web_config['primary_color']}}">
                                {{$deal_of_the_day->discount_type=='amount'?\App\CPU\Helpers::currency_converter($deal_of_the_day->discount):$deal_of_the_day->discount.' % '}}
                                OFF
                            </strong>
                        </center>
                        <div class="d-flex justify-content-center align-items-center" style="padding-top: 37px">
                            <img style="height: 206px;"
                                 src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$deal_of_the_day->product['thumbnail']}}"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 alt="">
                        </div>
                        <div style="text-align: center; padding-top: 26px;">
                            <h5 style="font-weight: 600; color: {{$web_config['primary_color']}}">
                                {{substr($deal_of_the_day->product['name'],0,40)}} {{strlen($deal_of_the_day->product['name'])>40?'...':''}}
                            </h5>
                            <span class="text-accent">
                                {{\App\CPU\Helpers::currency_converter(
                                    $deal_of_the_day->product->unit_price-(\App\CPU\Helpers::get_product_discount($deal_of_the_day->product,$deal_of_the_day->product->unit_price))
                                )}}
                            </span>
                            @if($deal_of_the_day->product->discount > 0)
                                <strike style="font-size: 12px!important;color: grey!important;">
                                    {{\App\CPU\Helpers::currency_converter($deal_of_the_day->product->unit_price)}}
                                </strike>
                            @endif

                        </div>
                        <div class="pt-3 pb-2" style="text-align: center;">
                            <button class="buy_btn"
                                    onclick="location.href='{{route('product',$deal_of_the_day->product->slug)}}'">{{trans('messages.buy_now')}}
                            </button>
                        </div>
                    @else
                        @php($product=\App\Model\Product::inRandomOrder()->first())
                        @if(isset($product))
                            <h1 style="color: white"> {{ trans('messages.recommended_product') }}</h1>
                            <div class="d-flex justify-content-center align-items-center" style="padding-top: 55px">
                                <img style="height: 206px;"
                                     src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     alt="">
                            </div>
                            <div style="text-align: center; padding-top: 60px;" class="pb-2">
                                <button class="buy_btn" onclick="location.href='{{route('product',$product->slug)}}'">
                                    {{trans('messages.buy_now')}}
                                </button>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="container mt-2">
                    <div class="row p-0">
                        <div class="col-md-3 p-0 text-center mobile-padding">
                            <img style="height: 29px;" src="{{asset("storage/app/public/png/delivery.png")}}" alt="">
                            <div class="deal-title">3 Days <br><span>Fast Delivery</span></div>
                        </div>

                        <div class="col-md-3 p-0 text-center">
                            <img style="height: 29px;" src="{{asset("storage/app/public/png/money.png")}}" alt="">
                            <div class="deal-title">Money Back <br><span>Gurrantey</span></div>
                        </div>
                        <div class="col-md-3 p-0 text-center">
                            <img style="height: 29px;" src="{{asset("storage/app/public/png/Genuine.png")}}" alt="">
                            <div class="deal-title">100% Genuine<br><span>Product</span></div>
                        </div>
                        <div class="col-md-3 p-0 text-center">
                            <img style="height: 29px;" src="{{asset("storage/app/public/png/Payment.png")}}" alt="">
                            <div class="deal-title">Authentic<br><span>Payment</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-md-8 pb-4">
                <div class="row">
                    <div class="col-8">
                        <div class="feature_header">
                            <span class="for-feature-title">{{ trans('messages.latest_products')}}</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="view_all view-btn-div pull-right">
                            <div>
                                <a class="btn btn-outline-accent btn-sm viw-btn-a"
                                   href="{{route('products',['data_from'=>'latest'])}}">{{ trans('messages.view_all')}}
                                    <i class="czi-arrow-right ml-1 mr-n1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid-->
                <hr class="view_border">
                <div class="row pt-2 mx-n2">
                    @foreach($latest_products as $product)
                        <div class="col-xl-4 col-sm-6 mb-4 deal_latest_product">
                            @include('web-views.partials._single-product',['product'=>$product])
                            <hr class="d-sm-none">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{--categries--}}
    <section class="container mt-2">
        <!-- Heading-->
        <div class="row">
            <div class="col-8">
                <div class="feature_header">
                    <span>{{ trans('messages.categories')}}</span>
                </div>
            </div>
            <div class="col-4">
                <div class="view_all view-btn-div pull-right">
                    <div>
                        <a class="btn btn-outline-accent btn-sm viw-btn-a"
                           href="{{route('categories')}}">{{ trans('messages.view_all')}}
                            <i class="czi-arrow-right ml-1 mr-n1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="view_border">
        <!-- Grid-->
        <div class="row pt-2 mx-n2">
            @foreach($categories as $category)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 px-2 mb-3 text-center inline_product"
                     style="cursor: pointer"
                     data-href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}">
                    <div class="category_div" style="height: 215px; ">
                        <div style="margin-top: 20%;">
                            <img style="vertical-align: middle;" width="80"
                                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset("storage/app/public/category/$category->icon")}}"
                                 alt="{{$category->name}}">
                        </div>
                        <div class="mt-3">
                            <p>{{$category->name}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </section>

    {{--brands--}}
    <section class="container pt-3">
        <!-- Heading-->
        <div class="row">
            <div class="col-8">
                <div class="feature_header">
                    <span> {{trans('messages.brands')}}</span>
                </div>
            </div>
            <div class="col-4">
                <div class="view_all view-btn-div pull-right">
                    <div>
                        <a class="btn btn-outline-accent btn-sm viw-btn-a" href="{{route('brands')}}">
                            {{ trans('messages.view_all')}}
                            <i class="czi-arrow-right ml-1 mr-n1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <hr class="view_border">
        <!-- Grid-->
        <div class="row pt-2 mx-n2">
            @foreach($brands as $brand)
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 px-2 mb-3 text-center">
                    <a href="{{route('products',['id'=> $brand['id'],'data_from'=>'brand','page'=>1])}}" class="">
                        <div class="brand_div d-flex align-items-center justify-content-center" style="height:200px ">
                            <img onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                 src="{{asset("storage/app/public/brand/$brand->image")}}" alt="{{$brand->name}}">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Product widgets-->
    <section class="container pb-4 pb-md-5">
        <div class="row">
            <!-- Bestsellers-->
            <div class="col-12 col-sm-6 col-md-4 mb-2 py-3">
                <div class="widget">
                    <div class="d-flex justify-content-between">
                        <h3 class="widget-title">{{ trans('messages.bestsellings')}}</h3>
                        <div>
                            <a class="btn btn-outline-accent btn-sm"
                               href="{{route('products',['data_from'=>'best-selling','page'=>1])}}">{{ trans('messages.view_all')}}
                                <i class="czi-arrow-right ml-1 mr-n1"></i>
                            </a>
                        </div>
                    </div>
                    @foreach($bestSellProduct as $key=>$bestSell)
                        @if($bestSell->product && $key<4)
                            <div class="media align-items-center pt-2 pb-2  inline_product"
                                 data-href="{{route('product',$bestSell->product->slug)}}">
                                <a class="d-block mr-2" href="{{route('product',$bestSell->product->slug)}}">
                                    <img style="height: 54px;"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$bestSell->product['thumbnail']}}"
                                         alt="Product"/>
                                </a>
                                <div class="media-body">
                                    <h6 class="widget-product-title">
                                        <a class="ptr"
                                           href="{{route('product',$product->slug)}}">{{$bestSell->product['name']}}</a>
                                    </h6>
                                    <div class="widget-product-meta">
                                        <span class="text-accent">
                                            {{\App\CPU\Helpers::currency_converter(
                                            $bestSell->product->unit_price-(\App\CPU\Helpers::get_product_discount($bestSell->product,$bestSell->product->unit_price))
                                            )}}

                                            @if($bestSell->product->discount > 0)
                                                <strike style="font-size: 12px!important;color: grey!important;">
                                                    {{\App\CPU\Helpers::currency_converter($bestSell->product->unit_price)}}
                                                </strike>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach

                </div>
            </div>
            <!-- New arrivals-->
            <div class="col-12 col-sm-6 col-md-4 mb-2 py-3">
                <div class="widget">
                    <div class="d-flex justify-content-between">
                        <h3 class="widget-title">{{trans('messages.new_arrivals')}}</h3>
                        <div>
                            <a class="btn btn-outline-accent btn-sm"
                               href="{{route('products',['data_from'=>'latest','page'=>1])}}">{{ trans('messages.view_all')}}
                                <i
                                    class="czi-arrow-right ml-1 mr-n1"></i>
                            </a>
                        </div>
                    </div>
                    @foreach($latest_products as $key=>$product)
                        @if($key<4)
                            <div class="media align-items-center pt-2 pb-2  inline_product"
                                 data-href="{{route('product',$product->slug)}}">
                                <a class="d-block mr-2" href="{{route('product',$product->slug)}}">
                                    <img style="height: 54px;"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                                         alt="Product"/>
                                </a>
                                <div class="media-body">
                                    <h6 class="widget-product-title">
                                        <a class="ptr"
                                           href="{{route('product',$product->slug)}}">{{$product['name']}}</a>
                                    </h6>
                                    <div class="widget-product-meta">
                                          <span class="text-accent">
                                            {{\App\CPU\Helpers::currency_converter(
                                            $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
                                            )}}
                                              @if($product->discount > 0)
                                                  <strike style="font-size: 12px!important;color: grey!important;">
                                                    {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                                                </strike>
                                              @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <!-- Top rated-->
            <div class="col-12 col-sm-6 col-md-4 mb-2 py-3">
                <div class="widget">
                    <div class="d-flex justify-content-between">
                        <h3 class="widget-title">{{trans('messages.top_rated')}}</h3>
                        <div><a class="btn btn-outline-accent btn-sm"
                                href="{{route('products',['data_from'=>'top-rated','page'=>1])}}">{{ trans('messages.view_all')}}
                                <i class="czi-arrow-right ml-1 mr-n1"></i></a></div>
                    </div>
                    @foreach($topRated as $key=>$top)
                        @if($top->product && $key<4)
                            <div class="media align-items-center pt-2 pb-2 inline_product"
                                 data-href="{{route('product',$top->product->slug)}}">
                                <a class="d-block mr-2" href="{{route('product',$top->product->slug)}}">
                                    <img style="height: 54px;"
                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                         src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$top->product['thumbnail']}}"
                                         alt="Product"/>
                                </a>
                                <div class="media-body">
                                    <h6 class="widget-product-title">
                                        <a class="ptr"
                                           href="{{route('product',$top->product->slug)}}">{{$top->product['name']}}</a>
                                    </h6>
                                    <div class="widget-product-meta">
                                       <span class="text-accent">
                                            {{\App\CPU\Helpers::currency_converter(
                                            $top->product->unit_price-(\App\CPU\Helpers::get_product_discount($top->product,$top->product->unit_price))
                                            )}}

                                           @if($top->product->discount > 0)
                                               <strike style="font-size: 12px!important;color: grey!important;">
                                                    {{\App\CPU\Helpers::currency_converter($top->product->unit_price)}}
                                                </strike>
                                           @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')

@endpush
