@extends('layouts.ismart');
@section('content')
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    @foreach ($sliders as $slider)
                    <div class="item">
                        <img src="{{url('/').'/'.$slider->thumbnail}}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($featured_products as $product)
                        <li>
                            <a href="{{route('product.detail',['cat_id'=>$product->get_parent_category[0]->id,
                             'slug'=>$product->get_parent_category[0]->slug, 'product_id'=>$product->id,
                              'product_slug'=>$product->slug])}}" title="" class="thumb">
                                <img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}">
                            </a>
                            <a href="{{route('product.detail',['cat_id'=>$product->get_parent_category[0]->id,
                                'slug'=>$product->get_parent_category[0]->slug, 'product_id'=>$product->id,
                                 'product_slug'=>$product->slug])}}" title="" class="product-name">{{$product->name}}</a>
                            <div class="price">
                                <span class="new">{{currency_format($product->price)}}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{url('gio-hang/them-san-pham', $product->id)}}" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{url('gio-hang/mua-ngay',$product->id)}}" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Điện thoại</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($phones as $phone)
                        <li>
                            <a href="{{route('product.detail',['cat_id'=>$phone->get_parent_category[0]->id,
                                'slug'=>$phone->get_parent_category[0]->slug, 'product_id'=>$phone->id,
                                 'product_slug'=>$phone->slug])}}" title="" class="thumb">
                                <img src="{{url('/').'/'.$phone->product_thumbnail_details[0]->thumbnail}}">
                            </a>
                            <a href="{{route('product.detail',['cat_id'=>$phone->get_parent_category[0]->id,
                                'slug'=>$phone->get_parent_category[0]->slug, 'product_id'=>$phone->id,
                                 'product_slug'=>$phone->slug])}}" title="" class="product-name">{{$phone->name}}</a>
                            <div class="price">
                                <span class="new">{{currency_format($phone->price)}}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{url('gio-hang/them-san-pham', $phone->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{url('gio-hang/mua-ngay',$phone->id)}}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Laptop</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        @foreach ($laptops as $laptop)
                        <li>
                            <a href="{{route('product.detail',['cat_id'=>$laptop->get_parent_category[0]->id,
                                'slug'=>$laptop->get_parent_category[0]->slug, 'product_id'=>$laptop->id,
                                 'product_slug'=>$laptop->slug])}}" title="" class="thumb">
                                <img src="{{url('/').'/'.$laptop->product_thumbnail_details[0]->thumbnail}}">
                            </a>
                            <a href="{{route('product.detail',['cat_id'=>$laptop->get_parent_category[0]->id,
                                'slug'=>$laptop->get_parent_category[0]->slug, 'product_id'=>$laptop->id,
                                 'product_slug'=>$laptop->slug])}}" title="" class="product-name">{{$laptop->name}}</a>
                            <div class="price">
                                <span class="new">{{currency_format($laptop->price)}}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{url('gio-hang/them-san-pham', $laptop->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{url('gio-hang/mua-ngay',$laptop->id)}}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
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
                            <a href="{{route('product.show',['cat_id'=>$category->id,'slug'=>$category->slug])}}" title="">{{$category->name}}</a>
                            @if ($category->subcategories->isNotEmpty())
                            @include('ismart.home.subcategories', ['subcategories'=>$category->subcategories])
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($featured_products as $product)
                        <li class="clearfix">
                            <a href="{{route('product.detail',['cat_id'=>$product->get_parent_category[0]->id,
                                'slug'=>$product->get_parent_category[0]->slug, 'product_id'=>$product->id,
                                 'product_slug'=>$product->slug])}}" title="" class="thumb fl-left">
                                <img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('product.detail',['cat_id'=>$product->get_parent_category[0]->id,
                                    'slug'=>$product->get_parent_category[0]->slug, 'product_id'=>$product->id,
                                     'product_slug'=>$product->slug])}}" title="" class="product-name">{{$product->name}}</a>
                                <div class="price">
                                    <span class="new">{{currency_format($product->price)}}</span>
                                </div>
                                <a href="{{url('gio-hang/mua-ngay',$product->id)}}" title="" class="buy-now">Mua ngay</a>
                            </div>
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