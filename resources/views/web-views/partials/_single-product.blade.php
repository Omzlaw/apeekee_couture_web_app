@php($overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews))

<div class="product-card card ">

    <div class="card-header inline_product" style="cursor: pointer;"
         data-href="{{route('product',$product->slug)}}">
        @if($product->discount > 0)
            <div class="d-flex justify-content-end for-dicount-div discount-hed"> <span class="for-discoutn-value">
                    @if ($product->discount_type == 'percent')
                        {{round($product->discount,2)}}%
                    @elseif($product->discount_type =='flat')
                        {{\App\CPU\Helpers::currency_converter($product->discount)}}
                    @endif
                    {{-- {{$product->discount_type=='amount'?\App\CPU\Helpers::currency_converter($product->discount):$product->discount.' % '}} --}}
            OFF</span></div>
        @else
            <div class="d-flex justify-content-end for-dicount-div-null"> <span class="for-discoutn-value-null">
                </span></div>
        @endif
        <div class="d-flex align-items-center justify-content-center"><a class="d-block"
                                                                         href="{{route('product',$product->slug)}}">
                <img src="{{\App\CPU\ProductManager::product_image_path('thumbnail')}}/{{$product['thumbnail']}}"
                     onerror="this.src='{{asset('public/assets/front-end/img/image-place-holder.png')}}'"
                     style="height: 180px;">
            </a>
        </div>
    </div>
    <div class="card-body py-2 inline_product" style="cursor: pointer;" data-href="{{route('product',$product->slug)}}">
        <div style="position: relative;">
            <a class="product-title1" href="{{route('product',$product->slug)}}">{{$product['name']}}</a>
        </div>
        <div class="d-flex justify-content-between">
            <div class="product-price">
                <span class="text-accent">
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
            <div style="margin-top: -4px;" class="product-title">
                <span
                    class="d-inline-block font-size-sm text-body align-middle mt-1 ml-1 ">{{$overallRating[0]}}</span>
                <span class="star-rating"> <i class="sr-star czi-star-filled active"></i></span>
            </div>
        </div>
    </div>

    <div class="card-body card-body-hidden">
        <div class="text-center">
            @if(Request::is('product/*'))
                <a class="btn btn-primary btn-sm btn-block mb-2" href="{{route('product',$product->slug)}}">
                    <i class="czi-forward align-middle mr-1"></i>
                    {{trans('messages.View')}}
                </a>
            @else
                <a class="btn btn-primary btn-sm btn-block mb-2" href="javascript:"
                   onclick="quickView('{{$product->id}}')">
                    <i class="czi-eye align-middle mr-1"></i>
                    {{trans('messages.Quick')}}   {{trans('messages.View')}}
                </a>
            @endif
        </div>
    </div>
</div>

