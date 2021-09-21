@foreach($products as $product)
    @if(!empty($product['product_id']))
        @php($product=$product->product)
    @endif
    <div class="col-md-4 col-sm-6 px-3 mb-5">
        @if(!empty($product))
            @include('web-views.partials._single-product',['p'=>$product])
        @endif
        <hr class="d-sm-none">
    </div>
@endforeach
