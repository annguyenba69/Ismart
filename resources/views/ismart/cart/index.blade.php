@extends('layouts.ismart')
@section('content')
<div id="main-content-wp" class="cart-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="{{url('trang-chu')}}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{url('gio-hang')}}" title="">Giỏ hàng</a>
                    </li>
                </ul>
            </div>
            @if (session('status'))
            <div class="alert {{session('class')}} mt-2" role="alert">
                {{session('status')}}
            </div>
            @endif
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <div class="section" id="info-cart-wp">
            <div class="section-detail table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <td>Mã sản phẩm</td>
                            <td>Ảnh sản phẩm</td>
                            <td>Tên sản phẩm</td>
                            <td>Giá sản phẩm</td>
                            <td>Số lượng</td>
                            <td colspan="2">Thành tiền</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>
                                <a href="" title="" class="thumb">
                                    <img src="{{url('/').'/'.$product->options->thumbnail}}" alt="">
                                </a>
                            </td>
                            <td>
                                <a href="" title="" class="name-product">{{$product->name}}</a>
                            </td>
                            <td>{{currency_format($product->price)}}</td>
                            <td>
                                <input type="number" name="num-order" value="{{$product->qty}}" class="num-order"
                                    id="num-order" min="1" data-row-id = {{$product->rowId}}>
                            </td>
                            <td id="{{$product->rowId}}">{{currency_format($product->total)}}</td>
                            <td>
                                <a href="{{url('gio-hang/xoa-san-pham', $product->rowId)}}" title=""
                                    class="del-product"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <p id="total-price" class="fl-right">Tổng giá:
                                        <span>{{Cart::total(0,'.',',').'đ'}}</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                <div class="clearfix">
                                    <div class="fl-right">
                                        <a href="{{url('gio-hang/xoa-tat-ca')}}" title="" id="update-cart">Xóa giỏ
                                            hàng</a>
                                        <a href="{{url('checkout')}}" title="" id="checkout-cart">Thanh toán</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="section" id="action-cart-wp">
            <div class="section-detail">
                <p class="title">Click vào <span>"Thanh toán"</span> để hoàn tất mua hàng.
                </p>
                <a href="{{url('trang-chu')}}" title="" id="buy-more">Mua tiếp</a><br />
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(".num-order").change(function(){
                var num_order = $(this).val();
                var row_id = $(this).attr('data-row-id');
                $.ajax({
                url: `{{url('gio-hang/cap-nhat-gio-hang')}}`,
                type: 'POST',
                data: {
                    'num_order': num_order,
                    'row_id': row_id
                },
                cache: false,
                success: function(data){
                    $("#total-price span").html(data.cart_total);
                    $(`#${row_id}`).html(data.sub_total);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    }
                });
            });
        });
</script>
@endsection