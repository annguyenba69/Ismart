@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search">
                <form action="#" class="form-inline">
                    <input type="" class="form-control form-search" placeholder="Tìm kiếm" name="keyword"
                        value="{{request()->input('keyword')}}">
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
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Hoạt động<span
                        class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Thùng rác<span
                        class="text-muted">({{$count[1]}})</span></a>
            </div>
            <form action="{{url('admin/product/action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="action">
                        <option value="">Chọn</option>
                        @foreach ($list_action as $key=>$action)
                        <option value="{{$key}}">{{$action}}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $index = $products->perPage() *($products->currentPage() - 1);
                        @endphp
                        @foreach ($products as $product)
                        @php
                        $index++;
                        @endphp
                        <tr class="">
                            <td>
                                <input type="checkbox" name="list_product[]" value="{{$product->id}}">
                            </td>
                            <td>{{$index}}</td>
                            <td><img src="{{url('/').'/'.$product->product_thumbnail_details[0]->thumbnail}}" alt=""
                                    style="max-width: 80px"></td>
                            <td><a href="#">{{$product->name}}</a></td>
                            <td>{{currency_format($product->price)}}</td>
                            <td style="max-width: 110px">
                                @foreach ($product->product_categories as $product_cat)
                                <span class="badge badge-success mb-1">{{$product_cat->name}}</span>
                                @endforeach
                            </td>
                            <td>{{$product->user->name}}</td>
                            <td>{{date('d-m-Y', strtotime($product->created_at))}}</td>
                            <td><span
                                    class="badge {{$product->status_public=='1'?'badge-success':'badge-danger'}}">{{$product->status_public=='1'?'Hoạt
                                    động':'Không hoạt động'}}</span></td>
                            <td>
                                @if ($product->deleted_at == null)
                                <a href="{{url('admin/product/edit', $product->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{url('admin/product/delete', $product->id)}}"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                                @else
                                <a href="{{url('admin/product/restore', $product->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Restore"><i
                                        class="fas fa-undo"></i></a>
                                <a href="{{url('admin/product/delete', $product->id)}}"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Permanent Delete"><i
                                        class="fa fa-trash"
                                        onclick="return confirm('Hành động này sẽ xóa vĩnh viễn sản phẩm')"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            {{$products->withQueryString()->links()}}
        </div>
    </div>
</div>
@endsection