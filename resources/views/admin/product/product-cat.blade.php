@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if (session('status'))
            <div class="alert alert-dismissible {{session('class')}}" role="alert">
                <h4 class="alert-heading">Thông báo!</h4>
                <p>{{session('status')}}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh mục sản phẩm
                </div>
                <div class="card-body">
                    <form action="{{url('admin/product/cat/store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="parent_id">
                                <option value="0">Chọn danh mục</option>
                                @foreach ($product_cats_data_tree as $product_cat)
                                <option value="{{$product_cat->id}}">
                                    {{str_repeat('---/',$product_cat->level).$product_cat->name}}</option>
                                @endforeach
                            </select>
                            @error('parent_id')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0"
                                    checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="exampleRadios2"
                                    value="1">
                                <label class="form-check-label" for="exampleRadios2">
                                    Công khai
                                </label>
                            </div>
                            @error('status')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <h5 class="m-0 ">Danh mục sản phẩm</h5>
                    <div class="form-search mt-4">
                        <form action="" class="form-inline">
                            <input type="{{url('admin/product/cat/index')}}" class="form-control form-search" placeholder="Tìm kiếm" name="keyword"
                                value="{{request()->input('keyword')}}">
                            <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên Danh Mục</th>
                                <th scope="col">Trạng Thái</th>
                                <th scope="col">Người Tạo</th>
                                <th scope="col">Ngày Tạo</th>
                                <th scope="col">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $index =
                            $product_cats_data_tree_pagination->perPage()*($product_cats_data_tree_pagination->currentPage()
                            - 1)
                            @endphp
                            @foreach ($product_cats_data_tree_pagination as $product_cat)
                            @php
                            $index++
                            @endphp
                            <tr>
                                <th scope="row">{{$index}}</th>
                                <td>{{str_repeat('---/',$product_cat->level).$product_cat->name}}</td>
                                <td class="{{$product_cat->status==1?'text-success':'text-danger'}}">
                                    {{$product_cat->status==1?'Hoạt động':'Không hoạt động'}}</td>
                                <td>{{$product_cat->user->name}}</td>
                                <td>{{date('d-m-y', strtotime($product_cat->created_at))}}</td>
                                <td>
                                    <a href="{{url('admin/product/cat/action',$product_cat->id)}}"
                                        class="btn btn-sm rounded-0 text-white {{$product_cat->status=='1'?'btn-success':'btn-warning'}}" type="button"
                                        data-toggle="tooltip" data-placement="top" title="{{$product_cat->status=='1'?'Active':'InActive'}}">
                                        @if ($product_cat->status == "1")
                                        <i class="fas fa-check-circle"></i>
                                        @else
                                        <i class="fas fa-exclamation-circle"></i>
                                        @endif
                                    </a>
                                    <a href="{{url('admin/product/cat/delete',$product_cat->id)}}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$product_cats_data_tree_pagination->links()}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection