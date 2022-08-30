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
                        <a href="" title="">{{$product_cat->name}}</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left">{{$product_cat->name}}</h3>
                    <input type="hidden" name="" id="product_cat_id" value="{{$product_cat->id}}">
                    <input type="hidden" name="" id="product_cat_slug" value="{{$product_cat->slug}}">
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix" id="list-product">
                        @foreach ($products as $product)
                        <li>
                            <a href="{{route('product.detail',['cat_id'=>$product_cat->id, 'slug'=>$product_cat->slug,
                             'product_id'=>$product->id, 'product_slug'=>$product->slug])}}" title="" class="thumb">
                                <img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}">
                            </a>
                            <a href="{{route('product.detail',['cat_id'=>$product_cat->id, 'slug'=>$product_cat->slug,
                                'product_id'=>$product->id, 'product_slug'=>$product->slug])}}" title=""
                                class="product-name">{{$product->name}}</a>
                            <div class="price">
                                <span class="new">{{currency_format($product->price)}}</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{url('gio-hang/them-san-pham', $product->id)}}" title="Thêm giỏ hàng"
                                    class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="{{url('gio-hang/mua-ngay',$product->id)}}" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail" id="nav">
                    {{$products->links()}}
                    {{-- <nav>
                        <ul class="pagination filter">
                            <li class="page-item">
                                <a class="page-link" href="http://localhost:8080/Laravel/ismart/phan-trang-ajax?page=1"
                                    rel="prev" aria-label="« Previous">‹</a>
                            </li>
                            <li class="page-item active"><a class="page-link"
                                    href="http://localhost:8080/Laravel/ismart/phan-trang-ajax?page=1">1</a></li>
                            <li class="page-item "><a class="page-link"
                                    href="http://localhost:8080/Laravel/ismart/phan-trang-ajax?page=2">2</a></li>
                            <li class="page-item "><a class="page-link"
                                    href="http://localhost:8080/Laravel/ismart/phan-trang-ajax?page=3">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="http://localhost:8080/Laravel/ismart/phan-trang-ajax?page=3"
                                    rel="next" aria-label="Next »">›</a>
                            </li>
                        </ul>
                    </nav> --}}
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
            <div class="section" id="filter-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <table>
                        <thead>
                            <tr>
                                <td colspan="2">Sắp xếp</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="radio" name="order" value="1" class="order" {{request()->input('order')==1?'checked':''}}></td>
                                <td>Từ A-Z</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="order" value="2" class="order" {{request()->input('order')==2?'checked':''}}></td>
                                <td>Từ Z-A</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="order" value="3" class="order" {{request()->input('order')==3?'checked':''}}></td>
                                <td>Giá cao xuống thấp</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="order" value="4" class="order" {{request()->input('order')==4?'checked':''}}></td>
                                <td>Giá thấp lên cao</td>
                            </tr>
                        </tbody>
                        <thead>
                            <tr>
                                <td colspan="2">Giá</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="radio" name="r-price" value="1" class="r-price" {{request()->input('r-price')==1?'checked':''}}></td>
                                <td>Dưới 5.000.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="r-price" value="2" class="r-price" {{request()->input('r-price')==1?'checked':''}}></td>
                                <td>5.000.000đ - 10.000.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="r-price" value="3" class="r-price" {{request()->input('r-price')==1?'checked':''}}></td>
                                <td>10.000.000đ - 20.000.000đ</td>
                            </tr>
                            <tr>
                                <td><input type="radio" name="r-price" value="4" class="r-price" {{request()->input('r-price')==1?'checked':''}}></td>
                                <td>Trên 20.000.000đ</td>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="Lọc" class="btn btn-primary btn-block" id="filter">
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
<script>
    $(document).ready(function(){
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var product_cat_id = $("#product_cat_id").val();
            // var product_cat_slug = $("#product_cat_slug").val();
            $.ajax({
                type: 'POST',
                cache: false,
                url: `{{url('phan-trang-ajax?page=${page}')}}`,
                data: {
                    'page': page,
                    'product_cat_id': product_cat_id
                },
                success: function(data){
                    $("ul#list-product").html(data.result);
                    $("#nav").html(data.nav);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        });
        $("#filter").click(function(){
            var r_price = $(".r-price:checked").val();
            var product_cat_id = $("#product_cat_id").val();
            var order = $(".order:checked").val();
            var data = {};
            if(typeof r_price !== 'undefined' && order !== 'undefined'){
                data = {
                    'r_price':r_price,
                    'order': order,
                    'product_cat_id':product_cat_id
                }
            }else if(typeof r_price !== 'undefined'){
                data = {
                    'r_price':r_price,
                    'product_cat_id':product_cat_id
                }
            }else if(typeof order !== 'undefined'){
                data = {
                    'order': order,
                    'product_cat_id': product_cat_id
                }
            }
            $.ajax({
            type: 'POST',
            cache: false,
            url: `{{url('loc-ajax?page=1')}}`,
            data: data,
            success:function(data){
                if(data.status == 'success'){
                    $("ul#list-product").html(data.result);
                    $("#nav").html("");
                }else{
                    console.log(data.status);
                }
                console.log(data.status);
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
        });
        });
    });
</script>
@endsection