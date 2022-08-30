@extends('layouts.admin');
@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[0]}}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG GIAO HÀNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[1]}}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[2]}}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{currency_format($total_revenue)}}</h5>
                    <p class="card-text">Doanh số hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{$count[3]}}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class=" table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mã</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Tổng giá trị</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $index = $orders->perPage() * ($orders->currentPage() - 1);
                    @endphp
                    @foreach ($orders as $order)
                    @php
                    $index++
                    @endphp
                    <tr>
                        <td>
                            <input type="checkbox">
                        </td>
                        <td>{{$index}}</td>
                        <td>{{$order->id}}</td>
                        <td>{{$order->name}}</td>
                        <td> {{$order->phone}}</td>
                        <td>{{currency_format($order->total_price($order->id))}}</td>
                        <td>
                            @if ($order->status_id == "1")
                            <span class="badge badge-danger">{{$order->order_status->name}}</span>
                            @elseif($order->status_id == "2")
                            <span class="badge badge-warning">{{$order->order_status->name}}</span>
                            @elseif($order->status_id == "3")
                            <span class="badge badge-success">{{$order->order_status->name}}</span>
                            @else
                            <span class="badge badge-dark">{{$order->order_status->name}}</span>
                            @endif
                        </td>
                        <td>{{date('d-m-y', strtotime($order->created_at))}}</td>
                        <td>
                            <a href="{{url('admin/order/detail', $order->id)}}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Detail"><i class="fas fa-eye"></i></a>
                            <a href="{{url('admin/order/delete', $order->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                    class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$orders->withQueryString()->links()}}
        </div>
    </div>
</div>
@endsection