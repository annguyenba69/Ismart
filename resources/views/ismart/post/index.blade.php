@extends('layouts.ismart')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Bài viết</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @foreach ($posts as $post)
                        <li class="clearfix">
                            <a href="{{route('post.detail',['post_id'=>$post->id,'post_slug'=>$post->slug])}}" title="" class="thumb fl-left">
                                <img src="{{url('/').'/'.$post->thumbnail}}" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="{{route('post.detail',['post_id'=>$post->id,'post_slug'=>$post->slug])}}" title="" class="title">{{$post->title}}</a>
                                <span class="create-date">{{$post->created_at}}</span>
                                <p>Danh Mục: <span class="text-muted">{{$post->post_parent_category[0]->name}}</span>
                                </p>
                                <div>
                                    <p class="desc">{!!limit_text($post->content,50)!!}</p>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                {{$posts->links()}}
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
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
                    <a href="?page=detail_blog_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection