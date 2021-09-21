<?php
$overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews);
$rating = \App\CPU\ProductManager::get_rating($product->reviews);
$productReviews = \App\CPU\ProductManager::get_product_review($product->id);
?>
<style>
    .product-title2 {
        font-family: 'Roboto', sans-serif !important;
        font-weight: 400 !important;
        font-size: 22px !important;
        color: #000000 !important;
        position: relative;
        display: inline-block;
        word-wrap: break-word;
        overflow: hidden;
        max-height: 1.2em; /* (Number of lines you want visible) * (line-height) */
        line-height: 1.2em;
    }

    .cz-product-gallery {
        display: block;
    }

    .cz-preview {
        width: 100%;
        margin-top: 0;
        margin-left: 0;
        max-height: 100% !important;
    }

    .cz-preview-item.active {
        border: 1px solid #E2F0FF;
        border-radius: 3px;
        padding: 10%;
    }

    .cz-preview-item > img {
        width: 80%;
    }

    .details {
        border: 1px solid #E2F0FF;
        border-radius: 3px;
        padding: 16px;
    }

    img, figure {
        max-width: 100%;
        vertical-align: middle;
    }

    .cz-thumblist-item.active {
        border-color: {{$web_config['primary_color']}};
        padding: 10%;
    }

    .cz-thumblist-item {
        display: block;
        position: relative;
        width: 64px;
        height: 64px;
        margin: .625rem;
        transition: border-color 0.2s ease-in-out;
        border: 1px solid #E2F0FF;
        border-radius: .3125rem;
        text-decoration: none !important;
        overflow: hidden;
    }

    .for-hover-bg:hover {
        border: 2px solid{{$web_config['primary_color']}};
    }

    .for-hover-bg {
        font-size: 18px;
        height: 45px;
        color: {{$web_config['primary_color']}};
        border: 2px solid{{$web_config['secondary_color']}};
    }

    .cz-thumblist-item > img {
        display: block;
        width: 80%;
        transition: opacity .2s ease-in-out;
        max-height: 58px;
        opacity: .6;
    }

    @media (max-width: 767.98px) and (min-width: 576px) {
        .cz-preview-item > img {
            width: 100%;
        }
    }

    @media (max-width: 575.98px) {
        .cz-thumblist {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -ms-flex-pack: center;
            justify-content: center;
            margin-right: -1rem;
            margin-left: 0;
            padding-top: 1rem;
            padding-right: 22px;
            padding-bottom: 10px;
        }

        .cz-thumblist-item {
            margin: 0px;
        }

        .cz-thumblist {
            padding-top: 8px !important;
        }

        .cz-preview-item > img {
            width: 100%;
        }
    }
</style>
<div class="modal-header">
    <h4 class="modal-title product-title">
        <a class="product-title2" href="{{route('product',$product->slug)}}" data-toggle="tooltip"
           data-placement="right"
           title="Go to product page">{{$product['name']}}
            <i class="czi-arrow-right font-size-lg ml-2"></i>
        </a>
    </h4>
    <button class="close call-when-done" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row ">
        <!-- Product gallery-->
        <div class="col-lg-6 col-md-6">
            <div class="cz-product-gallery">
                <div class="cz-preview">
                    @if($product->images!=null && json_decode($product->images)>0)
                        @foreach (json_decode($product->images) as $key => $photo)
                            <div
                                class="cz-preview-item d-flex align-items-center justify-content-center  {{$key==0?'active':''}}"
                                id="image{{$key}}">
                                <img class="cz-image-zoom img-responsive"
                                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                     src="{{asset("storage/app/public/product/$photo")}}"
                                     data-zoom="{{asset("storage/app/public/product/$photo")}}"
                                     alt="Product image" width="">
                                <div class="cz-image-zoom-pane"></div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="cz">
                    <div class="container">
                        <div class="row">
                            <div class="table-responsive" data-simplebar style="max-height: 515px; padding: 0px;">
                                <div class="d-flex">
                                    @if($product->images!=null && json_decode($product->images)>0)
                                        @foreach (json_decode($product->images) as $key => $photo)
                                            <div class="cz-thumblist">
                                                <a class="cz-thumblist-item  {{$key==0?'active':''}} d-flex align-items-center justify-content-center "
                                                   href="#image{{$key}}">
                                                    <img src="{{asset("storage/app/public/product/$photo")}}"
                                                         onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                                                         alt="Product thumb">
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- Product details-->
        <div class="col-lg-6 col-md-6 mt-md-0 mt-sm-3">
            <div class="details">
                <a href="{{route('product',$product->slug)}}" class="h3 mb-2 product-title">{{$product->name}}</a>
                <div class="d-flex align-items-center mb-2 pro">
                    <span
                        class="d-inline-block font-size-sm text-body align-middle mt-1 mr-2 pr-2">{{$overallRating[0]}}</span>
                    <div class="star-rating">
                        @if ($overallRating[0]==5)
                            @for ($i = 0; $i < 5; $i++)
                                <i class="sr-star czi-star-filled active"></i>
                            @endfor
                        @endif
                        @if ($overallRating[0]==4)
                            @for ($i = 0; $i < 4; $i++)
                                <i class="sr-star czi-star-filled active"></i>
                            @endfor
                            <i class="sr-star czi-star"></i>
                        @endif
                        @if ($overallRating[0]==3)
                            @for ($i = 0; $i < 3; $i++)
                                <i class="sr-star czi-star-filled active"></i>
                            @endfor
                            @for ($j = 0; $j < 2; $j++)
                                <i class="sr-star czi-star"></i>
                            @endfor
                        @endif
                        @if ($overallRating[0]==2)
                            @for ($i = 0; $i < 2; $i++)
                                <i class="sr-star czi-star-filled active"></i>
                            @endfor
                            @for ($j = 0; $j < 3; $j++)
                                <i class="sr-star czi-star"></i>
                            @endfor
                        @endif
                        @if ($overallRating[0]==1)
                            @for ($i = 0; $i < 4; $i++)
                                <i class="sr-star czi-star-filled active"></i>
                            @endfor
                            <i class="sr-star czi-star"></i>
                        @endif
                        @if ($overallRating[0]==0)
                            @for ($i = 0; $i < 5; $i++)
                                <i class="sr-star czi-star"></i>
                            @endfor
                        @endif
                    </div>
                    <span class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1 mr-2 pl-2 pr-2">{{$overallRating[1]}} Reviews</span>
                    <span style="width: 0px;height: 10px;border: 0.5px solid #707070; margin-top: 6px"></span>
                    <span class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1 mr-2 pl-2 pr-2">{{$countOrder}} orders  </span>
                    <span style="width: 0px;height: 10px;border: 0.5px solid #707070; margin-top: 6px">    </span>
                    <span class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1 mr-2 pl-2 pr-2">  {{$countWishlist}}  wish</span>

                </div>
                <div class="mb-3">
                    <span class="h3 font-weight-normal text-accent mr-1">
                        {{\App\CPU\Helpers::get_price_range($product) }}
                    </span>
                    @if($product->discount > 0)
                        <strike style="font-size: 12px!important;color: grey!important;">
                            {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                        </strike>
                    @endif
                </div>

                @if($product->discount > 0)
                    <div class="mb-3">
                        <strong>
                            Discount : {{\App\CPU\Helpers::currency_converter(\App\CPU\Helpers::get_product_discount($product,$product['unit_price']))}}
                        </strong>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>
                        TAX : {{ \App\CPU\Helpers::currency_converter(
                                    \App\CPU\Helpers::tax_calculation($product->unit_price,$product->tax,$product->tax_type)
                                )}}
                    </strong>
                </div>

                <form id="add-to-cart-form" class="mb-2">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <div class="position-relative mr-n4 mb-3">
                        @if (count(json_decode($product->colors)) > 0)
                            <div class="row no-gutters">
                                <div class="col-2">
                                    <div class="product-description-label mt-2">{{__('Color')}}:
                                    </div>
                                </div>
                                <div class="col-10">
                                    <ul class="list-inline checkbox-color mb-1">
                                        @foreach (json_decode($product->colors) as $key => $color)
                                            <li>
                                                <input type="radio"
                                                       id="{{ $product->id }}-color-{{ $key }}"
                                                       name="color" value="{{ $color }}"
                                                       @if($key == 0) checked @endif>
                                                <label style="background: {{ $color }};"
                                                       for="{{ $product->id }}-color-{{ $key }}"
                                                       data-toggle="tooltip"></label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @php
                            $qty = 0;
                            foreach (json_decode($product->variation) as $key => $variation) {
                                $qty += $variation->qty;
                            }
                        @endphp

                    </div>
                    @foreach (json_decode($product->choice_options) as $key => $choice)
                        <div class="row no-gutters">
                            <div class="col-2">
                                <div class="product-description-label mt-2 ">{{ $choice->title }}:
                                </div>
                            </div>
                            <div class="col-10">
                                <ul class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-2">
                                    @foreach ($choice->options as $key => $option)
                                        <li>
                                            <input type="radio"
                                                   id="{{ $choice->name }}-{{ $option }}"
                                                   name="{{ $choice->name }}" value="{{ $option }}"
                                                   @if($key == 0) checked @endif>
                                            <label
                                                for="{{ $choice->name }}-{{ $option }}">{{ $option }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach

                <!-- Quantity + Add to cart -->
                    <div class="row no-gutters">
                        <div class="col-2">
                            <div class="product-description-label mt-2">{{__('Quantity')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="input-group input-group--style-2 pr-3"
                                     style="width: 160px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button"
                                                data-type="minus" data-field="quantity"
                                                disabled="disabled" style="padding: 10px">
                                            -
                                        </button>
                                    </span>
                                    <input type="text" name="quantity"
                                           class="form-control input-number text-center cart-qty-field"
                                           placeholder="1" value="1" min="1" max="100">
                                    <span class="input-group-btn">
                                        <button class="btn btn-number" type="button" data-type="plus"
                                                data-field="quantity" style="padding: 10px">
                                           +
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row no-gutters d-none mt-2" id="chosen_price_div">
                        <div class="col-2">
                            <div class="product-description-label">{{__('Total Price')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-price">
                                <strong id="chosen_price"></strong>
                            </div>
                        </div>
                    </div>
                    {{--to do--}}
                    <div class="row" style="display: none">
                        <div class="col-md-12">
                            <div id="accordion">
                                <div class="card mt-2 mb-2">
                                    <div class="card-header" id="headingTwo">
                                        <h5 class="mb-0">
                                            <a href="javascript:" style="font-size: 15px" class="collapsed"
                                               data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                               aria-controls="collapseTwo">
                                                Select Shipping Method
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo"
                                         data-parent="#accordion">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                @foreach(\App\CPU\ProductManager::get_shipping_methods($product) as $key=>$shipping)
                                                    <li class="list-group-item" style="cursor: pointer;"
                                                        onclick="$('#sh-{{$shipping['id']}}').prop( 'checked', true )">
                                                        <input type="radio" name="shipping_method_id"
                                                               id="sh-{{$shipping['id']}}"
                                                               value="{{$shipping['id']}}" {{$key==0?'checked':''}}>
                                                        <span class="checkmark" style="margin-right: 10px"></span>
                                                        {{$shipping['title']}} ( Duration
                                                        : {{$shipping['duration']}},
                                                        Cost
                                                        : {{\App\CPU\Helpers::currency_converter($shipping['cost'])}}
                                                        )
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-2">

                        <button class="btn btn-secondary" onclick="buy_now()"
                                type="button"
                                style="width:37%; height: 45px">
                            {{trans('messages.buy_now')}}
                        </button>
                        <button class="btn btn-primary"
                                onclick="addToCart()"
                                type="button"
                                style="width:37%; height: 45px">
                            {{trans('messages.Add')}} {{trans('messages.To')}} {{trans('messages.Cart')}}
                        </button>

                        <button type="button" onclick="addWishlist('{{$product['id']}}')" class="btn for-hover-bg"
                                style="">
                            <i class="fa fa-heart-o mr-2" aria-hidden="true"></i>
                            <span class="countWishlist-{{$product['id']}}">{{$countWishlist}}</span>
                        </button>

                    </div>
                </form>
                <!-- Product panels-->
                {{--<div style="margin-left: -1%" class="sharethis-inline-share-buttons"></div>--}}
            </div>
        </div>
    </div>
</div>
<script src="{{asset('public/assets/front-end')}}/js/theme.min.js"></script>
<script type="text/javascript">
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function () {
        getVariantPrice();
    });
</script>

<script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons"
        async="async"></script>
