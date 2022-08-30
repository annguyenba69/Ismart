@extends('layouts.admin');
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm người dùng
        </div>
        @if (session('status'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <h4 class="alert-heading">Thông báo!</h4>
            <p>{{session('status')}}</p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        <div class="card-body">
            <form action="{{url('admin/user/store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input class="form-control" type="text" name="fullname" id="fullname" value="{{old('fullname')}}">
                    @error('fullname')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" value="{{old('email')}}">
                    @error('email')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password">
                    @error('password')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirmation">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                    @error('password_confirmation')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Nhóm quyền</label>
                    <select class="form-control" id="" name="role_id">
                        <option value="">Chọn quyền</option>
                        @foreach ($roles as $role)
                        <option {{old('role_id')==$role->id?'selected':''}} value="{{$role->id}}">{{$role->name}}
                        </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" value="Thêm mới">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection