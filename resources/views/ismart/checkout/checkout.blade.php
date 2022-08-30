@extends('layouts.ismart')
@section('content')
<div id="main-content-wp" class="checkout-page">
    <div class="section" id="breadcrumb-wp">
        <div class="wp-inner">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="?page=home" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Thanh toán</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <form action="{{url('checkout/store')}}" method="POST">
        @csrf
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <form method="POST" action="" name="form-checkout">
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="fullname" id="fullname" value="{{old('fullname')}}">
                                @error('fullname')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{old('email')}}">
                                @error('email')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="email">Tỉnh / Thành phố</label>
                                <select name="calc_shipping_provinces" required="" style="    width: 100%;
                                padding: 6px 12px;
                                border: 1px solid #cccccc;">
                                    <option value="">Tỉnh / Thành phố</option>
                                </select>
                                @error('billing_address_1')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="email">Quận / Huyện</label>
                                <select name="calc_shipping_district" required="" style="    width: 100%;
                                padding: 6px 12px;
                                border: 1px solid #cccccc;">
                                    <option value="">Quận / Huyện</option>
                                </select>
                                @error('billing_address_2')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <input class="billing_address_1" name="province" type="hidden" value="">
                            <input class="billing_address_2" name="district" type="hidden" value="">
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col fl-left">
                                <label for="address">Địa chỉ chi tiết</label>
                                <input type="text" name="address-detail" id="address" value="{{old('address-detail')}}">
                                @error('address-detail')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                            <div class="form-col fl-right">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" value="{{old('phone')}}">
                                @error('phone')
                                <small class="text-danger">{{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col">
                                <label for="notes">Ghi chú</label>
                                <textarea name="note" id="" class="note" cols="77" rows="6">{{old('note')}}</textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td>Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                            <tr class="cart-item">
                                <td class="product-name">{{$cart->name}}<strong class="product-quantity">x
                                        {{$cart->qty}}</strong>
                                </td>
                                <td class="product-total">{{$cart->total(0,'.',',').'đ'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td>Tổng đơn hàng:</td>
                                <td><strong class="total-price">{{Cart::total(0,'.',',').'đ'}}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="payment-checkout-wp">
                        <ul id="payment_methods">
                            <li>
                                <input type="radio" id="payment-home" name="payment-method" value="1" {{old('payment-method')=='1'?'checked':''}}>
                                <label for="payment-home">Thanh toán tại nhà</label>
                            </li>
                            <li>
                                <input type="radio" id="direct-payment" name="payment-method" value="2" {{old('payment-method')=='2'?'checked':''}}>
                                <label for="direct-payment">Thanh toán tại cửa hàng</label>
                            </li>
                        </ul>
                        @error('payment-method')
                        <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="place-order-wp clearfix">
                        <input type="submit" id="order-now" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js"></script>
<script>
    //<![CDATA[
        if (address_2 = localStorage.getItem('address_2_saved')) {
          $('select[name="calc_shipping_district"] option').each(function() {
            if ($(this).text() == address_2) {
              $(this).attr('selected', '')
            }
          })
          $('input.billing_address_2').attr('value', address_2)
        }
        if (district = localStorage.getItem('district')) {
          $('select[name="calc_shipping_district"]').html(district)
          $('select[name="calc_shipping_district"]').on('change', function() {
            var target = $(this).children('option:selected')
            target.attr('selected', '')
            $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
            address_2 = target.text()
            $('input.billing_address_2').attr('value', address_2)
            district = $('select[name="calc_shipping_district"]').html()
            localStorage.setItem('district', district)
            localStorage.setItem('address_2_saved', address_2)
          })
        }
        $('select[name="calc_shipping_provinces"]').each(function() {
          var $this = $(this),
            stc = ''
          c.forEach(function(i, e) {
            e += +1
            stc += '<option value=' + e + '>' + i + '</option>'
            $this.html('<option value="">Tỉnh / Thành phố</option>' + stc)
            if (address_1 = localStorage.getItem('address_1_saved')) {
              $('select[name="calc_shipping_provinces"] option').each(function() {
                if ($(this).text() == address_1) {
                  $(this).attr('selected', '')
                }
              })
              $('input.billing_address_1').attr('value', address_1)
            }
            $this.on('change', function(i) {
              i = $this.children('option:selected').index() - 1
              var str = '',
                r = $this.val()
              if (r != '') {
                arr[i].forEach(function(el) {
                  str += '<option value="' + el + '">' + el + '</option>'
                  $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>' + str)
                })
                var address_1 = $this.children('option:selected').text()
                var district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('address_1_saved', address_1)
                localStorage.setItem('district', district)
                $('input.billing_address_1').attr('value', address_1)
                $('select[name="calc_shipping_district"]').on('change', function() {
                  var target = $(this).children('option:selected')
                  target.attr('selected', '')
                  $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
                  var address_2 = target.text()
                  $('input.billing_address_2').attr('value', address_2)
                  district = $('select[name="calc_shipping_district"]').html()
                  localStorage.setItem('district', district)
                  localStorage.setItem('address_2_saved', address_2)
                })
              } else {
                $('select[name="calc_shipping_district"]').html('<option value="">Quận / Huyện</option>')
                district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('district', district)
                localStorage.removeItem('address_1_saved', address_1)
              }
            })
          })
        })
        //]]>
</script>
@endsection