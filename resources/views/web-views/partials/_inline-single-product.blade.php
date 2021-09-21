<style>
    .product {
        background-color: #fcfcfc;
        border: 2px solid #efefef;
        margin-bottom: 10px;
    }

    .product_pic {
        width: 40%;
    }

    .product_details {
        width: 60%;
        padding: 5px;
    }

    .image_center {
        height: 126px;
    }

    .image_center img {
        min-width: 100px;
        vertical-align: middle;
    }

    .product-title {
        position: relative;
    }

    .product-title > a{
        color: #373f50;
    }
    .star-rating > i{
        font-size: 8px!important;
    }

    .ptr1 {
        position: relative;
        display: inline-block;
        word-wrap: break-word;
        overflow: hidden;
        max-height: 2.4em; /* (Number of lines you want visible) * (line-height) */
        line-height: 1.2em;
        /*text-align:justify;*/
    }

    .ptr {
        font-weight: 600;
        font-size: 16px !important;
    }

    .inline_product_image {
        height: 100px;
    }

    .ptp {
        font-weight: 700;
        font-size: 16px !important;
    }
    .star-rating .sr-star{
        margin: 0!important;
    }

    @media (max-width: 768px) {
        .product_pic {
            width: 200px !important;
        }

        .product {
            margin-right: 16px;
        }

        .product_details {
            width: 100% !important;
        }
    }


</style>
<div class="d-flex product justify-content-between inline_product" style="cursor: pointer;"
     data-href="{{route('product',$product->slug)}}">
    <div class="product_pic d-flex align-items-center justify-content-center" style=" text-align: center;">
        <a href="{{route('product',$product->slug)}}" class="image_center">
            <img class="inline_product_image"
                 onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                 src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}" width="100%" style="height: 100%;">
        </a>
    </div>
    <div class="product_details">
        <h3 class="product-title">
            <a class="ptr ptr1" href="{{route('product',$product->slug)}}">{{$product['name']}}</a>
        </h3>
        @php($overallRating=\App\CPU\ProductManager::get_overall_rating($product->reviews))
        <h6 class="ptr">
            <span class="d-inline-block text-body align-middle mt-1 mr-2"
                  style="color: #fea96e !important; font-size: 10px!important;">{{$overallRating[0]}} </span>
            <span class="star-rating">
                    @if (round($overallRating[0])==5)
                    @for ($i = 0; $i < 5; $i++)
                        <i class="sr-star czi-star-filled active"></i>
                    @endfor
                @endif
                @if (round($overallRating[0])==4)
                    @for ($i = 0; $i < 4; $i++)
                        <i class="sr-star czi-star-filled active"></i>
                    @endfor
                    <i class="sr-star czi-star"></i>
                @endif
                @if (round($overallRating[0])==3)
                    @for ($i = 0; $i < 3; $i++)
                        <i class="sr-star czi-star-filled active"></i>
                    @endfor
                    @for ($j = 0; $j < 2; $j++)
                        <i class="sr-star czi-star"></i>
                    @endfor
                @endif
                @if (round($overallRating[0])==2)
                    @for ($i = 0; $i < 2; $i++)
                        <i class="sr-star czi-star-filled active"></i>
                    @endfor
                    @for ($j = 0; $j < 3; $j++)
                        <i class="sr-star czi-star"></i>
                    @endfor
                @endif
                @if (round($overallRating[0])==1)
                    @for ($i = 0; $i < 4; $i++)
                        <i class="sr-star czi-star-filled active"></i>
                    @endfor
                    <i class="sr-star czi-star"></i>
                @endif
                @if (round($overallRating[0])==0)
                    @for ($i = 0; $i < 5; $i++)
                        <i class="sr-star czi-star"></i>
                    @endfor
                @endif
            </span>
        </h6>
        <div class="product-price">
            <span class="text-accent ptp">
            {{\App\CPU\Helpers::currency_converter(
            $product->unit_price-(\App\CPU\Helpers::get_product_discount($product,$product->unit_price))
            )}}
            </span>
            @if($product->discount > 0)
                <strike style="font-size: 12px!important;color: grey!important;">
                    {{\App\CPU\Helpers::currency_converter($product->unit_price)}}
                </strike>
            @endif
        </div>
    </div>
</div>

