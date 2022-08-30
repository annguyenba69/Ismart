@extends("layouts.admin")
@section("content")
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
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
            <form action="{{url('admin/product/update', $product->id)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="name">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name"
                                value="{{old('name', $product->name)}}">
                            @error('name')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input class="form-control" type="text" name="price" id="price"
                                value="{{old('price', $product->price)}}">
                            @error('price')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="description">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" id="description" cols="30"
                                rows="5">{{$product->description}}</textarea>
                            @error('description')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="detail">Chi tiết sản phẩm</label>
                    <textarea name="detail" class="form-control" id="detail" cols="30" rows="5"
                        style="height: 600px">{{$product->detail}}</textarea>
                    @error('detail')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Danh mục</label>
                    <select class="form-control" id="" name="product_cat_id">
                        <option>Chọn danh mục</option>
                        @foreach ($product_cats_data_tree as $product_cat)
                        <option {{get_last_child_cat($product->product_categories)->id == $product_cat->id?'selected':''}}
                            value="{{$product_cat->id}}">
                            {{str_repeat("---/",$product_cat->level).$product_cat->name}}</option>
                        @endforeach
                    </select>
                    @error('product_cat_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Hình ảnh</label>
                    <input type="file" name="filename[]" id="filename" multiple='multiple'>
                    <input type="hidden" name="thumbnail_details" value="" id="thumbnail_details">
                    @error('filename')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="show-product-thumbnail">
                        @foreach ($product->product_thumbnail_details as $product_thumbnail_detail)
                        <img src="{{url('/').'/'.$product_thumbnail_detail->thumbnail}}" alt="" style="width: 120px">
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_public" id="status_public_0"
                                    value="0" {{$product->status_public=='0'?'checked':''}}>
                                <label class="form-check-label" for="status_public_0">
                                    Chờ duyệt
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_public" id="status_public_1"
                                    value="1" {{$product->status_public=='1'?'checked':''}}>
                                <label class="form-check-label" for="status_public_1">
                                    Công khai
                                </label>
                            </div>
                            @error('status_public')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Sản phẩm nổi bật</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_feature" id="status_feature_0"
                                    value="0" {{$product->status_feature=='0'?'checked':''}}>
                                <label class="form-check-label" for="status_feature_0">
                                    Không
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_feature" id="status_feature_1"
                                    value="1" {{$product->status_feature=='1'?'checked':''}}>
                                <label class="form-check-label" for="status_feature_1">
                                    Có
                                </label>
                            </div>
                            @error('status_feature')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="">Kho hàng</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_warehouse"
                                    id="status_warehouse_0" value="0" {{$product->status_warehouse=='0'?'checked':''}}>
                                <label class="form-check-label" for="status_warehouse_0">
                                    Hết hàng
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_warehouse"
                                    id="status_warehouse_1" value="1" {{$product->status_warehouse=='1'?'checked':''}}>
                                <label class="form-check-label" for="status_warehouse_1">
                                    Còn hàng
                                </label>
                            </div>
                            @error('status_warehouse')
                            <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhập</button>
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
            $("#filename").change(function(){
                var input_file = $("#filename");
                var file_to_upload = input_file[0].files; // tra ra FileList chua thong tin cac file
                if(file_to_upload.length > 0){
                    var form_data = new FormData();
                    for(var i =0; i<file_to_upload.length; i++){
                        var file = file_to_upload[i];
                        form_data.append('filename[]', file, file.name);
                    }
                }
                $.ajax({
                url: `{{url('admin/product/upload_image')}}`,
                type: 'POST',
                data: form_data,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data){
                    if(data.status == "1"){
                        console.log(data.thumbnails);
                    $(".show-product-thumbnail").html(data.thumbnails_html);
                    $("#thumbnail_details").val(data.thumbnails);
                    }else{
                        $(".show-product-thumbnail").html(data.error);
                        $("#thumbnail_details").val("");
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