<?php

namespace App\Http\Controllers;

use App\PostCat;
use App\ProductCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminPostCatController extends Controller
{
    //
    function list(Request $request)
    {
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        $post_cats = PostCat::where('name', 'LIKE', "%$keyword%")->get();
        $post_cats_data_tree = PostCat::get_data_tree(PostCat::all());
        $post_cats_data_tree_paginate = PostCat::get_paginator($request ,PostCat::get_data_tree($post_cats));
        return view('admin.post.post-cat', compact('post_cats_data_tree','post_cats_data_tree_paginate'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                "name" => "required|string|max:40",
                "parent_id" => "required|integer",
                "status" => "required"
            ],
            [
                "required" => ":attribute không được để trống",
                "max" => ":attribute tối đá :max kí tự",
                "integer" => ":attribute phải là số",
            ],
            [
                "name" => "Tên danh mục",
                "parent_id" => "Danh mục cha",
                "status" => "Trạng thái danh mục"
            ]
        );
        $status = $request->input("status");
        if ($request->input("parent_id") != "0") {
            if (!PostCat::check_active_parent($request->input("parent_id"))) {
                $status = "0";
            }
        }
        PostCat::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent_id'),
            'status' => $status,
            'slug' => Str::slug($request->input('name')),
            'user_id'=>Auth::id()
        ]);
        return redirect("admin/post/cat/list")->with('status', 'Thêm mới danh mục thành công')
            ->with('class', 'alert-success');
    }

    function action($id)
    {
        $post_cat = PostCat::find($id);
        if ($post_cat != null) {
            if ($post_cat->status == "1") {
                if (PostCat::check_inactive_children(PostCat::all(), $post_cat->id)) {
                    $post_cat->update(['status' => "0"]);
                    return redirect("admin/post/cat/list")->with('status', 'Tắt hoạt động danh mục thành công')
                        ->with('class', 'alert-success');
                } else {
                    return redirect("admin/post/cat/list")->with('status', 'Bạn phải tắt hoạt động của danh mục con')
                        ->with('class', 'alert-danger');
                }
            } else {
                if (PostCat::check_active_all_parent(PostCat::all(), $post_cat->parent_id)) {
                    $post_cat->update(['status' => "1"]);
                    return redirect("admin/post/cat/list")->with('status', 'Bật hoạt động danh mục thành công')
                        ->with('class', 'alert-success');
                } else {
                    return redirect("admin/post/cat/list")->with('status', 'Bạn phải bật hoạt động của danh mục cha')
                        ->with('class', 'alert-danger');
                }
            }
        } else {
            return redirect("admin/product/cat/list")->with('status', 'Không tìm thấy danh mục')
                ->with('class', 'alert-danger');
        }
    }

    function delete($id){
        $post_cat = PostCat::find($id);
        if($post_cat != null){
            if(PostCat::check_children($post_cat->id)){
                return redirect("admin/post/cat/list")->with('status', 'Bạn phải xóa hết danh mục con')
                ->with('class', 'alert-danger');
            }else{
                $post_cat->delete();
                return redirect("admin/post/cat/list")->with('status', 'Xóa danh mục thành công')
                ->with('class', 'alert-success');
            }
        }else{
            return redirect("admin/product/cat/list")->with('status', 'Không tìm thấy danh mục')
            ->with('class', 'alert-danger');
        }
    }
}
