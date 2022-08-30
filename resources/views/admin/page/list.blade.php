@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách trang</h5>
            <div class="form-search ">
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
            <form action="{{url('admin/page/action')}}" method="POST">
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
                            <th scope="col">Tên trang</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $index = $pages->perPage() * ($pages->currentPage() - 1);
                        @endphp
                        @foreach ($pages as $page)
                        @php
                        $index ++;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_pages[]" value="{{$page->id}}">
                            </td>
                            <td scope="row">{{$index}}</td>
                            <td>{{$page->name}}</td>
                            <td><span class="badge {{$page->status=="
                                    1"?"badge-success":"badge-danger"}}">{{$page->status=="1"?"Hoạt động":"Không hoạt
                                    động"}}</span></td>
                            <td>{{$page->user->name}}</td>
                            <td>{{date('d-m-y', strtotime($page->created_at))}}</td>
                            <td>
                                @if ($page->deleted_at == null)
                                <a href="{{url('admin/page/edit', $page->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                @else
                                <a href="{{url('admin/page/restore', $page->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Restore"><i
                                        class="fas fa-undo"></i></a>
                                @endif
                                <a href="{{url('admin/page/delete', $page->id)}}"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            {{$pages->withQueryString()->links()}}
        </div>
    </div>
</div>
@endsection