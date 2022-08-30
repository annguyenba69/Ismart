@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
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
                <a href="{{request()->fullUrlWithQuery([" status"=>"active"])}}" class="text-primary">Hoạt động<span
                        class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery([" status"=>"trash"])}}" class="text-primary">Thùng rác<span
                        class="text-muted">({{$count[1]}})</span></a>
            </div>
            <form action="{{url('admin/post/action')}}" method="POST">
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
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = $posts->perPage() *($posts->currentPage() - 1);
                        @endphp
                        @foreach ($posts as $post)
                        @php
                            $index ++;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_post[]" value="{{$post->id}}">
                            </td>
                            <td scope="row">{{$index}}</td>
                            <td><img src="{{url('/').'/'.$post->thumbnail}}" alt="" style="width: 100px"></td>
                            <td>{{limit_text($post->title,20)}}</td>
                            <td style="max-width: 110px">
                                @foreach ($post->post_categories as $post_category)
                                <span class="badge badge-success mb-1">{{$post_category->name}}</span>
                                @endforeach
                            </td>
                            <td>{{$post->user->name}}</td>
                            <td>{{date('d-m-y',strtotime($post->created_at))}}</td>
                            <td class=""><span
                                    class="badge {{$post->status=='1'?'badge-success':'badge-danger'}}">{{$post->status=="1"?"Hoạt
                                    động":'Không hoạt động'}}</span></td>
                            <td>
                                @if ($post->deleted_at == null)
                                <a href="{{url('admin/post/edit', $post->id)}}"> <button
                                        class="btn btn-success btn-sm rounded-0" type="button" data-toggle="tooltip"
                                        data-placement="top" title="Edit"><i class="fa fa-edit"></i></button></a>
                                <a href="{{url('admin/post/delete', $post->id)}}"><button
                                        class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
                                        data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></a>
                                @else
                                <a href="{{url('admin/post/restore', $post->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Restore"><i
                                        class="fas fa-undo"></i></a>
                                <a href="{{url('admin/post/delete', $post->id)}}"
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
            {{$posts->withQueryString()->links()}}
        </div>
    </div>
</div>
@endsection