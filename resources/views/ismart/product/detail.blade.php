@extends('layouts.ismart')
@section('content')
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">{{$product_cat->name}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <a href="" title="" id="main-thumb">
                            <img id="zoom" src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}"
                                style="max-width: 350px"
                                data-zoom-image="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}" />
                        </a>
                        <div id="list-thumb">
                            @foreach ($product->product_thumbnail_details as $thumbnail)
                            <a href="" data-image="{{url('/').'/'.$thumbnail->thumbnail}}"
                                data-zoom-image="{{url('/').'/'.$thumbnail->thumbnail}}">
                                <img id="zoom" src="{{url('/').'/'.$thumbnail->thumbnail}}" />
                            </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="public/images/img-pro-01.png" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{$product->name}}</h3>
                        <div class="desc">
                            <p>{!!$product->description!!}</p>
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            @if ($product->status_warehouse == "1")
                            <span class="status" style="padding: 5px 15px; background-color: antiquewhite">Còn
                                hàng</span>
                            @else
                            <span class="status" style="padding: 5px 15px; background-color: burlywood">Hết hàng</span>
                            @endif
                        </div>
                        <p class="price">{{currency_format($product->price)}}</p>
                        <form action="{{url('gio-hang/them-san-pham', $product->id)}}" method="GET">
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" name="num-order" value="1" id="num-order" min="0">
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                            </div>
                            <input type="submit" value="Thêm giỏ hàng" title="Thêm giỏ hàng" class="add-cart">
                        </form>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    {!!$product->detail!!}
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($related_products as $product)
                        <li>
                            <a href="{{route('product.detail',['cat_id'=>$product_cat->id,'slug'=>$product_cat->slug,
                            'product_id'=>$product->id, 'product_slug'=>$product->slug])}}" title="" class="thumb">
                                <img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}">
                            </a>
                            <a href="" title="" class="product-name">{{$product->name}}</a>
                            <div class="price">
                                <span class="new">{{currency_format($product->price)}}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{url('gio-hang/them-san-pham', $product->id)}}" title=""
                                    class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="category-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Danh mục sản phẩm</h3>
                </div>
                <div class="secion-detail">
                    <ul class="list-item">
                        @foreach ($parent_categories as $category)
                        <li>
                            <a href="{{route('product.show',['cat_id'=>$category->id,'slug'=>$category->slug])}}"
                                title="">{{$category->name}}</a>
                            @if ($category->subcategories->isNotEmpty())
                            @include('ismart.home.subcategories', ['subcategories'=>$category->subcategories])
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection