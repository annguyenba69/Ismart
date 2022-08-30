@extends("layouts.admin")
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa bài viết
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
            <form action="{{url('admin/post/update', $post->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control" type="text" name="title" id="title"
                        value="{{old('title',$post->title)}}">
                    @error('title')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Nội dung bài viết</label>
                    <textarea name="content" class="form-control" id="content" cols="30" rows="5"
                        style="height: 600px">{{old('content', $post->content)}}</textarea>
                    @error('content')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="post_cat_id">
                        <option value="">Chọn danh mục</option>
                        @foreach ($post_cats_data_tree as $post_cat)
                        <option {{old('post_cat_id', get_last_child_cat($post->post_categories)->id) ==
                            $post_cat->id?'selected':''}}
                            value="{{$post_cat->id}}">{{str_repeat('---/',$post_cat->level).$post_cat->name}}
                        </option>
                        @endforeach
                    </select>
                    @error('post_cat_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="file">Hình ảnh</label>
                    <input type="file" name="file" id="file">
                    <input type="hidden" name="thumbnail_post" id="thumbnail_post" value="{{$post->thumbnail}}">
                    @error('thumbnail_post')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="show-post-thumbnail">
                        <img src="{{url('/').'/'.$post->thumbnail}}" alt="" style="width: 120px">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="0"
                            {{$post->status == "0"?'checked':''}}>
                        <label class="form-check-label" for="exampleRadios1">
                            Chờ duyệt
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="1"
                            {{$post->status == "1"?'checked':''}}>
                        <label class="form-check-label" for="exampleRadios2">
                            Công khai
                        </label>
                    </div>
                    @error('status')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#file").change(function(){
                var input_file = $("#file");
                var file_to_upload = input_file[0].files[0]; // tra ra FileList chua thong tin cac file  
                    var form_data = new FormData();               
                        form_data.append('file', file_to_upload);
                $.ajax({
                url: `{{url('admin/post/upload_image')}}`,
                type: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    if(data.status == "1"){
                        $("#thumbnail_post").val(data.thumbnail);
                    $(".show-post-thumbnail").html(data.thumbnails_html);
                    }else{
                        $(".show-post-thumbnail").html(data.error);
                        $("#thumbnail_post").val("");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                    }
                });
            });
        });
</script>
@endsection