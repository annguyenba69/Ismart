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
                    Thêm danh mục
                </div>
                <div class="card-body">
                    <form action="{{url('admin/post/cat/store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên danh mục</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="">Danh mục cha</label>
                            <select class="form-control" id="" name="parent_id">
                                <option value="0">Chọn danh mục</option>
                                @foreach ($post_cats_data_tree as $post_cat)
                                <option value="{{$post_cat->id}}">
                                    {{str_repeat('---/',$post_cat->level).$post_cat->name}}</option>
                                @endforeach
                            </select>
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
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                    <h5 class="m-0 ">Danh mục bài viết</h5>
                    <div class="form-search mt-4">
                        <form action="" class="form-inline">
                            <input type="" class="form-control form-search" placeholder="Tìm kiếm" name="keyword"
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
                                <th scope="col">Tên danh mục</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = $post_cats_data_tree_paginate->perPage() * ($post_cats_data_tree_paginate->currentPage()-1);
                            @endphp
                            @foreach ($post_cats_data_tree_paginate as $post_cat)
                            @php
                                $index ++;
                            @endphp
                            <tr>
                                <th scope="row">{{$index}}</th>
                                <td>{{str_repeat('---/',$post_cat->level).$post_cat->name}}</td>
                                <td class="{{$post_cat->status=='1'?'text-success':'text-danger'}}">
                                    {{$post_cat->status=='1'?'Hoạt động':'Không hoạt động'}}</td>
                                <td>{{$post_cat->user->name}}</td>
                                <td>{{date('d-m-y', strtotime($post_cat->created_at))}}</td>
                                <td>
                                    <a href="{{url('admin/post/cat/action',$post_cat->id)}}"
                                        class="btn btn-sm rounded-0 text-white {{$post_cat->status=='1'?'btn-success':'btn-warning'}}"
                                        type="button" data-toggle="tooltip" data-placement="top"
                                        title="{{$post_cat->status=='1'?'Active':'InActive'}}">
                                        @if ($post_cat->status == "1")
                                        <i class="fas fa-check-circle"></i>
                                        @else
                                        <i class="fas fa-exclamation-circle"></i>
                                        @endif
                                    </a>
                                    <a href="{{url('admin/post/cat/delete',$post_cat->id)}}"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$post_cats_data_tree_paginate->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection