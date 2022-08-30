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
                    Thêm ảnh Slider
                </div>
                <div class="card-body">
                    <form action="{{url('admin/slider/store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Thêm ảnh</label>
                            <input type="file" name="file" id="">
                            @error('file')
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
                <div class="card-header font-weight-bold">
                    Danh sách ảnh Slider
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Người tạo</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $index = $sliders->perPage() * ($sliders->currentPage() - 1);
                            @endphp
                            @foreach ($sliders as $slider)
                            @php
                                $index++;
                            @endphp
                            <tr>
                                <th scope="row">{{$index}}</th>
                                <td><img src="{{url('/').'/'.$slider->thumbnail}}" alt="" style="width: 120px"></td>
                                <td><span
                                        class="badge {{$slider->status=='1'?'badge-success':'badge-warning'}}">{{$slider->status
                                        =='1'?'Công khai':'Chờ duyệt'}}</span></td>
                                <td>{{$slider->user->name}}</td>
                                <td>{{date('d-m-y', strtotime($slider->created_at))}}</td>
                                <td>
                                    @if ($slider->status == 1)
                                    <a href="{{url('admin/slider/action', $slider->id)}}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Active"><i
                                            class="fas fa-check"></i></a>
                                    @else
                                    <a href="{{url('admin/slider/action', $slider->id)}}"
                                        class="btn btn-warning btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Pending"> <i
                                            class="fas fa-exclamation-circle"></i></a>
                                    @endif
                                    <a href="{{url('admin/slider/delete', $slider->id)}}"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                            class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection