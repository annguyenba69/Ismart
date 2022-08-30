@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search">
                <form action="{{url('admin/user/list')}}" class="form-inline">
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
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Hoạt Động<span
                        class="text-muted">({{$count[0]}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Thùng Rác<span
                        class="text-muted">({{$count[1]}})</span></a>
            </div>
            <form action="{{url('admin/user/action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="action">
                        <option>Chọn</option>
                        @foreach ($list_action as $key=>$action)
                        <option value="{{$key}}">{{$action}}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $t = $users->perPage() * ($users->currentPage() - 1);
                        @endphp
                        @foreach ($users as $user)
                        @php
                        $t++;
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="list_user[]" value="{{$user->id}}">
                            </td>
                            <th scope="row">{{$t}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role->name}}</td>
                            <td>{{date('d-m-Y', strtotime($user->created_at))}}</td>
                            <td>
                                @if ($user->deleted_at == null)
                                <a href="{{url('admin/user/edit', $user->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                @else
                                <a href="{{url('admin/user/restore', $user->id)}}"
                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Restore"><i
                                        class="fas fa-undo"></i></a>
                                @endif
                                @if (Auth::id() != $user->id && $user->deleted_at == null)
                                <a href="{{url('admin/user/delete', $user->id)}}"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                                @elseif(Auth::id()!= $user->id)
                                <a href="{{url('admin/user/forcedelete', $user->id)}}"
                                    class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Delete"><i
                                        class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
            <nav aria-label="Page navigation example">
                {{$users->withQueryString()->links()}}
            </nav>
        </div>
    </div>
</div>
@endsection