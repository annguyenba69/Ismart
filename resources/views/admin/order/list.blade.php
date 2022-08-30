@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search">
                <form action="{{url('admin/order/list')}}" method="GET" class="form-inline">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm theo tên" name="keyword" value="{{request()->input('keyword')}}">
                    <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
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
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'all'])}}" class="text-primary">Toàn bộ<span class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'pending'])}}" class="text-primary">Đang xử lý<span class="text-muted">({{$count[1]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'delivery'])}}" class="text-primary">Đang giao hàng<span class="text-muted">({{$count[2]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'success'])}}" class="text-primary">Hoàn thành<span class="text-muted">({{$count[3]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'cancel'])}}" class="text-primary">Hủy đơn<span class="text-muted">({{$count[4]}})</span></a>
            </div>
            <table class="mt-5 table table-striped table-checkall">
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