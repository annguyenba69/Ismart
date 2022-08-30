<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminPostController extends Controller
{
    //
    function list(Request $request)
    {
        $keyword = "";
        $list_action = ['delete'=> 'Xóa tạm thời'];
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        if($request->input('status') == 'trash'){
            $posts = Post::onlyTrashed()->where('title','LIKE', "%$keyword%")->paginate(8);
            $list_action = ['restore'=>'Khôi phục', 'forceDelete'=> 'Xóa vĩnh viễn'];
        }else{
            $posts = Post::where('title','LIKE', "%$keyword%")->paginate(8);
        }
        $count_active_post = Post::count();
        $count_trash_post = Post::onlyTrashed()->count();
        $count = [$count_active_post, $count_trash_post];
        return view('admin.post.list', compact('posts','count', 'list_action'));
    }

    function add()
    {
        $post_cats_data_tree = PostCat::get_data_tree(PostCat::where('status', '1')->get());
        return view('admin.post.add', compact('post_cats_data_tree'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'thumbnail_post' => 'required',
                'post_cat_id' => 'required|integer',
                'status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tự',
                'integer' => ':attribute phải là số'
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'content' => 'Nội dung bài viết',
                'post_cat_id' => 'Danh mục bài viết',
                'status' => 'Trạng thái bài viết',
                'thumbnail_post' => 'Hình ảnh bài viết'
            ]
        );
        $post = new Post;
        $post->title =  $request->input('title');
        $post->content = $request->input('content');
        $post->status = $request->input('status');
        $post->slug = Str::slug($request->input('title'));
        $post->thumbnail = $request->input('thumbnail_post');
        $post->user_id = Auth::id();
        $post->save();
        $post_cat = PostCat::find($request->input('post_cat_id'));
        $array_list_cat[] = $post_cat->id;
        $array_list_cat = array_merge($array_list_cat, PostCat::get_all_parent(PostCat::all(), $post_cat->parent_id));
        $post->post_categories()->attach($array_list_cat);
        return redirect("admin/post/add")->with('status', 'Thêm mới bài viết thành công')
            ->with('class', 'alert-success');
    }

    function upload_image(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validate->fails()) {
            $error = "<small class='text-danger'>Đuôi File không hợp lệ</small>";
            return response()->json([
                "status" => "0",
                "error" => $error
            ]);
        } else {
            $thumbnail = "";
            if ($request->hasFile('file')) {
                $file = $request->file;
                $file_name = time() . '_' . $request->file->getClientOriginalName();
                $file->move('public/uploads', $file_name);
                $thumbnail = 'public/uploads/' . $file_name;
            }
            $base_url = url('/') . '/';
            $thumbnails_html = "<img src='" . $base_url . $thumbnail . "'style='width: 120px'>";
            return response()->json([
                "status" => "1",
                "thumbnails_html" => $thumbnails_html,
                "thumbnail" => $thumbnail
            ]);
        }
    }


    function edit($id)
    {
        $post = Post::find($id);
        if ($post != null) {
            $post_cats_data_tree = PostCat::get_data_tree(PostCat::where('status', '1')->get());
            return view('admin.post.edit', compact('post', 'post_cats_data_tree'));
        } else {
            return redirect("admin/post/list")->with('status', 'Không tìm thấy bài viết cần chỉnh sửa')
                ->with('class', 'alert-danger');
        }
    }

    function update($id, Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'thumbnail_post' => 'required',
                'post_cat_id' => 'required|integer',
                'status' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tự',
                'integer' => ':attribute phải là số'
            ],
            [
                'title' => 'Tiêu đề bài viết',
                'content' => 'Nội dung bài viết',
                'post_cat_id' => 'Danh mục bài viết',
                'status' => 'Trạng thái bài viết',
                'thumbnail_post' => 'Hình ảnh bài viết'
            ]
        );
        $post = Post::find($id);
        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'thumbnail' => $request->input('thumbnail_post'),
            'status' => $request->input('status')
        ]);
        $post_cat = PostCat::find($request->input('post_cat_id'));
        $array_list_cat[] = $post_cat->id;
        $array_list_cat = array_merge($array_list_cat, PostCat::get_all_parent(PostCat::all(), $post_cat->parent_id));
        $post->post_categories()->sync($array_list_cat);
        return redirect('admin/post/list')->with('status', 'Cập nhật thông tin bài viết thành công')
            ->with('class', 'alert-success');
    }

    function delete($id){
        $post = Post::withTrashed()->find($id);
        if($post != null){
            if($post->deleted_at == null){
                if(Post::check_active_post($post)){
                    return redirect("admin/post/list")->with('status', 'Bạn phải hủy hoạt động bài viết thì mới xóa được')
                    ->with('class', 'alert-danger');
                }else{
                    $post->delete();
                    return redirect("admin/post/list")->with('status', 'Xóa tạm thời thành công bài viết')
                    ->with('class', 'alert-success');
                }
            }else{
                $post->forceDelete();
                return redirect("admin/post/list?status=trash")->with('status', 'Xóa vĩnh viễn thành công bài viết')
                ->with('class', 'alert-success');
            }
        }else{
            return redirect("admin/post/list")->with('status', 'Không tìm thấy bài viết cần xóa')
                ->with('class', 'alert-danger');
        }
    }

    function restore($id){
        $post = Post::onlyTrashed()->find($id);
        if($post != null){
            $post->restore();
            return redirect("admin/post/list?status=trash")->with('status', 'Khôi phục thành công bài viết')
            ->with('class', 'alert-success');
        }else{
            return redirect("admin/post/list?status=trash")->with('status', 'Không tìm thấy bài viết cần khôi phục')
            ->with('class', 'alert-danger');
        }
    }

    function action(Request $request){
        if($request->input('list_post')){
            $list_posts_id = $request->input('list_post');
            $action = $request->input('action');
            if($action == 'delete'){
                if(Post::check_inactive_all_posts($list_posts_id)){
                    Post::destroy($list_posts_id);
                    return redirect('admin/post/list')->with('status', 'Xóa tạm thời thành công các danh mục được chọn')
                    ->with('class', 'alert-success');
                }else{
                    return redirect('admin/post/list')->with('status', 'Bạn cần phải hủy hoạt động tất cả các bài viết được chọn thì mới xóa được')
                    ->with('class', 'alert-danger');
                }
            }else if($action == 'restore'){
                Post::onlyTrashed()->whereIn('id' ,$list_posts_id)->restore();
                return redirect('admin/post/list?status=trash')->with('status', 'Khôi phục thành công các bài viết được chọn')
                ->with('class', 'alert-success');
            }else if($action == 'forceDelete'){
                Post::onlyTrashed()->whereIn('id', $list_posts_id)->forceDelete();
                return redirect('admin/post/list?status=trash')->with('status', 'Xóa vĩnh viễn thành công các bài viết được chọn')
                ->with('class', 'alert-success');
            }else{
                return redirect('admin/post/list')->with('status', 'Bạn phải chọn hành động cần thao tác')
                ->with('class', 'alert-danger');
            }
        }else{
            return redirect('admin/post/list')->with('status', 'Bạn phải chọn các bài viết cần thao tác')
            ->with('class', 'alert-danger');
        }
    }
}
