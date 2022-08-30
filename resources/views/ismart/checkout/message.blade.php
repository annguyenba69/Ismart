@extends('layouts.ismart');
@section('content')
    <div class="message-content">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <img style="margin: 0px auto" src="{{asset('/images/message.png')}}" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <h2 class="font-weight-bold text-success" style="font-size: 25px">Đặt hàng thành công!</h2>
                    <p>Cảm ơn quý khách đã tin tưởng và đặt hàng tại hệ thống Ismart</p>
                    <p>Chúng tôi sẽ liên hệ tới quý khách hàng trong thời gian sớm nhất</p>
                    <p>Xin chân thành cảm ơn</p>
                    <a href="{{url('trang-chu')}}">Quay trở lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
@endsection