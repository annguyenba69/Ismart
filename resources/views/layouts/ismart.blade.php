<!DOCTYPE html>
<html>

<head>
    <title>ISMART STORE</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--
    <link href="{{asset('css/bootstrap/bootstrap-theme.min.css')}}" rel="stylesheet" type="text/css" />
    --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{asset('css/bootstrap/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/carousel/owl.carousel.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/carousel/owl.theme.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('style.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('responsive.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{asset('js/jquery-2.2.4.min.js')}}" type="text/javascript"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.devbridge-autocomplete/1.4.10/jquery.autocomplete.min.js">
    </script>
    <script src="{{asset('js/bootstrap/bootstrap.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/elevatezoom-master/jquery.elevatezoom.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/carousel/owl.carousel.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/main.js')}}" type="text/javascript"></script>
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">H??nh th???c thanh to??n</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{url('trang-chu')}}" title="">Trang ch???</a>
                                </li>
                                @foreach (get_parent_categories() as $category)
                                <li>
                                    <a href="{{route('product.show',['cat_id'=>$category->id, 'slug'=>$category->slug])}}"
                                        title="">{{$category->name}}</a>
                                </li>
                                @endforeach
                                <li>
                                    <a href="{{url('post/danh-sach')}}" title="">B??i vi???t</a>
                                </li>
                                @foreach (get_pages() as $page)
                                <li>
                                    <a href="{{url('trang',$page->slug)}}" title="">{{$page->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{url('trang-chu')}}" title="" id="logo" class="fl-left"><img
                                src="{{asset('')}}images/logo.png" /></a>
                        <div id="search-wp" class="fl-left">
                            <form method="GET" action="{{url('search_result')}}">
                                <input type="text" name="keyword" id="keyword"
                                    placeholder="Nh???p t??? kh??a t??m ki???m t???i ????y!">
                                <button type="submit" id="sm-s">T??m ki???m</button>
                            </form>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <div id="advisory-wp" class="fl-left">
                                <span class="title">T?? v???n</span>
                                <span class="phone">0987.654.321</span>
                            </div>
                            <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                            <a href="?page=cart" title="gi??? h??ng" id="cart-respon-wp" class="fl-right">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span id="num">2</span>
                            </a>
                            <div id="cart-wp" class="fl-right">
                                <div id="btn-cart">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num">{{Cart::count()}}</span>
                                </div>
                                <div id="dropdown">
                                    <p class="desc">C?? <span>{{Cart::count()}} s???n ph???m</span> trong gi??? h??ng</p>
                                    @foreach (Cart::content() as $product)
                                    <ul class="list-cart">
                                        <li class="clearfix">
                                            <a href="" title="" class="thumb fl-left">
                                                <img src="{{url('/').'/'.$product->options->thumbnail}}" alt="">
                                            </a>
                                            <div class="info fl-right">
                                                <a href="" title="" class="product-name">{{$product->name}}</a>
                                                <p class="price">{{currency_format($product->price)}}</p>
                                                <p class="qty">S??? l?????ng: <span>{{$product->qty}}</span></p>
                                            </div>
                                        </li>
                                    </ul>
                                    @endforeach
                                    <div class="total-price clearfix">
                                        <p class="title fl-left">T???ng:</p>
                                        <p class="price fl-right">{{Cart::total(0,'.',',').'??'}}</p>
                                    </div>
                                    <div class="action-cart clearfix">
                                        <a href="{{url('gio-hang')}}" title="Gi??? h??ng" class="view-cart fl-left">Gi???
                                            h??ng</a>
                                        <a href="?page=checkout" title="Thanh to??n" class="checkout fl-right">Thanh
                                            to??n</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
            <div id="footer-wp">
                <div id="foot-body">
                    <div class="wp-inner clearfix">
                        <div class="block" id="info-company">
                            <h3 class="title">ISMART</h3>
                            <p class="desc">ISMART lu??n cung c???p lu??n l?? s???n ph???m ch??nh h??ng c?? th??ng tin r?? r??ng, ch??nh
                                s??ch ??u ????i c???c l???n cho kh??ch h??ng c?? th??? th??nh vi??n.</p>
                            <div id="payment">
                                <div class="thumb">
                                    <img src="{{asset('images/img-foot.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="block menu-ft" id="info-shop">
                            <h3 class="title">Th??ng tin c???a h??ng</h3>
                            <ul class="list-item">
                                <li>
                                    <p>106 - Tr???n B??nh - C???u Gi???y - H?? N???i</p>
                                </li>
                                <li>
                                    <p>0987.654.321 - 0989.989.989</p>
                                </li>
                                <li>
                                    <p>vshop@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="block menu-ft policy" id="info-shop">
                            <h3 class="title">Ch??nh s??ch mua h??ng</h3>
                            <ul class="list-item">
                                <li>
                                    <a href="" title="">Quy ?????nh - ch??nh s??ch</a>
                                </li>
                                <li>
                                    <a href="" title="">Ch??nh s??ch b???o h??nh - ?????i tr???</a>
                                </li>
                                <li>
                                    <a href="" title="">Ch??nh s??ch h???i vi???n</a>
                                </li>
                                <li>
                                    <a href="" title="">Giao h??ng - l???p ?????t</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block" id="newfeed">
                            <h3 class="title">B???ng tin</h3>
                            <p class="desc">????ng k?? v???i chung t??i ????? nh???n ???????c th??ng tin ??u ????i s???m nh???t</p>
                            <div id="form-reg">
                                <form method="GET" action="">
                                    <input type="email" name="email" id="email" placeholder="Nh???p email t???i ????y">
                                    <button type="submit" id="sm-reg">????ng k??</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="foot-bot">
                    <div class="wp-inner">
                        <p id="copyright">?? B???n quy???n thu???c v??? unitop.vn | Php Master</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-respon">
            <a href="?page=home" title="" class="logo">VSHOP</a>
            <div id="menu-respon-wp">
                <ul class="" id="main-menu-respon">
                    <li>
                        <a href="?page=home" title>Trang ch???</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title>??i???n tho???i</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="?page=category_product" title="">Iphone</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Samsung</a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="?page=category_product" title="">Iphone X</a>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Iphone 8</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Nokia</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?page=category_product" title>M??y t??nh b???ng</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title>Laptop</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title>????? d??ng sinh ho???t</a>
                    </li>
                    <li>
                        <a href="?page=blog" title>Blog</a>
                    </li>
                    <li>
                        <a href="#" title>Li??n h???</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="btn-top"><img src="{{asset('images/icon-to-top.png')}}" alt="" /></div>
        <div id="fb-root"></div>
        <script>
            (function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
        </script>
</body>
<script>
    $(function () {
$("#keyword").autocomplete({
    serviceUrl:"{{url('search')}}",
    paramName: "keyword",
    onSelect: function(suggestion) {
        $("#keyword").val(suggestion.value);
    },
    transformResult: function(response) {
        return {
            suggestions: $.map($.parseJSON(response), function(item) {
                return {
                    value: item.name,
                };
            })
        };
    },
});
})
</script>
<style>
    .autocomplete-suggestions {
        border: 1px solid #999;
        background: #FFF;
        overflow: auto;
        width:
    }

    .autocomplete-suggestion {
        padding: 2px 5px;
        white-space: nowrap;
        overflow: hidden;
    }

    .autocomplete-selected {
        background: #F0F0F0;
    }

    /*.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }*/
    .autocomplete-group {
        padding: 2px 5px;
    }

    .autocomplete-group strong {
        display: block;
        border-bottom: 1px solid #000;
    }

    #keyword {
        display: inline-block;
        width: 400px;
        border: none;
        outline: none;
        padding: 8px 20px;
        line-height: normal;
    }
</style>

</html>