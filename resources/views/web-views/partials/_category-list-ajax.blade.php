@if($category->childes->count()>0)
    @foreach($category->childes as $c)
        <div class="col-md-3 mt-4">
            <label class="text-center"
                   onclick="location.href='{{route('products',['id'=> $c['id'],'data_from'=>'category','page'=>1])}}'"
                   style="padding: 10px;border: 1px solid black;width: 100%;cursor: pointer">
                {{$c['name']}}
            </label>
            <ul class="list-group">
                @foreach($c->childes as $child)
                    <li class="list-group-item" style="cursor: pointer"
                        onclick="location.href='{{route('products',['id'=> $child['id'],'data_from'=>'category','page'=>1])}}'">
                        {{$child['name']}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@else
    <div class="col-md-12 text-center mt-5">
        <a href="{{route('products',['id'=> $category['id'],'data_from'=>'category','page'=>1])}}" class="btn btn-primary">View Products</a>
    </div>
@endif
