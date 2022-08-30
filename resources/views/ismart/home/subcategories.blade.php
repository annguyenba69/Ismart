<ul class="sub-menu">
    @foreach ($subcategories as $category)
    <li>
        <a href="{{route('product.show',['cat_id'=>$category->id,'slug'=>$category->slug])}}" title="">{{$category->name}}</a>
        @if ($category->subcategories->isNotEmpty())
            @include('ismart.home.subcategories', ['subcategories'=>$category->subcategories])
        @endif
    </li>
    @endforeach
</ul>