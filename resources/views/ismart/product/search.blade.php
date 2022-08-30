@extends('layouts.ismart');
@section('content')
<style>
    ul.pagination {
        justify-content: center;
    }
</style>
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Kết quả tìm kiếm</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">Kết quả tìm kiếm</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix" id="list-product">
                        @foreach ($products as $product)
                        <li>
                            <a href="{{route('product.detail',['cat_id'=>$product->get_parent_category[0]->id, 'slug'=>$product->get_parent_category[0]->slug,
                             'product_id'=>$product->id, 'product_slug'=>$product->slug])}}" title="" class="thumb">
                                <img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}">
                            </a>
                            <a href="{{route('product.detail',['cat_id'=>$product->get_parent_category[0]->id, 'slug'=>$product->get_parent_category[0]->slug,
                                'product_id'=>$product->id, 'product_slug'=>$product->slug])}}" title=""
                                class="product-name">{{$product->name}}</a>
                            <div class="price">
                                <span class="new">{{currency_format($product->price)}}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{url('gio-hang/them-san-pham', $product->id)}}" title="Thêm giỏ hàng"
                                    class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail" id="nav">
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
                    <a href="?page=detail_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection