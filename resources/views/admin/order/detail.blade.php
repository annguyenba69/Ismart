@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 py-4">Thông tin đơn hàng</h5>
        </div>
        @if (session('status'))
        <div class="alert alert-dismissible {{session('class')}}" role="alert">
            <h4 class="alert-heading">Thông báo!</h4>
            <p>{{session('status')}}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card-body">
            <h5 class="mb-3">Thông tin khách hàng</h5>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Địa chỉ</th>
                        <th scope="col">Email</th>
                        <th scope="col">Thời gian đặt hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$order->name}}</td>
                        <td>{{$order->id}}</td>
                        <td>{{$order->phone}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->email}}</td>
                        <td>{{date('d-m-y', strtotime($order->created_at))}}</td>
                    </tr>
                </tbody>
            </table>
            <h5 class="mt-4 mb-3">Tình trạng đơn hàng</h5>
            <form action="{{url('admin/order/update', $order->id)}}" method="POST" class="form-inline">
                @csrf
                <div class="col-4 pl-0">
                    <select class="custom-select" name="status_id">
                        @foreach ($order_status as $status)
                        <option {{$order->status_id == $status->id?'selected':''}}
                            value="{{$status->id}}">{{$status->name}}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Cập nhật" name="btn-submit" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-5">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 py-4">Chi tiết đơn hàng</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $index = 0;
                    @endphp
                    @foreach ($order->products as $product)
                    @php
                        $index ++;
                    @endphp
                    <tr>
                        <td>{{$index}}</td>
                        <td><img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}" alt="" style="width: 120px"></td>
                        <td>{{$product->name}}</td>
                        <td>{{currency_format($product->price)}}</td>
                        <td>{{$product->pivot->quantity}}</td>
                        <td>{{currency_format($product->pivot->total)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 class="text-right mt-4 text-success">Tổng giá trị đơn hàng: <span>{{currency_format($order->total_price($order->id))}}</span></h5>
        </div>
    </div>
</div>
@endsection