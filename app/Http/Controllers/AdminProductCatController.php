<?php

namespace App\Http\Controllers;

use App\ProductCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProductCatController extends Controller
{
    //
    function list(Request $request)
    {
        $keyword = "";
        if($request->input("keyword")){
            $keyword = $request->input("keyword");
        }
        $product_cats = ProductCat::where("name", "LIKE", "%$keyword%")->get();
        $product_cats_data_tree = ProductCat::get_data_tree(ProductCat::all());
        $product_cats_data_tree_pagination = ProductCat::get_paginator($request, ProductCat::get_data_tree($product_cats));
        return view('admin.product.product-cat', compact("product_cats_data_tree_pagination", "product_cats_data_tree"));
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
            if (!ProductCat::check_active_parent($request->input("parent_id"))) {
                $status = "0";
            }
        }
        ProductCat::create([
            "name" => $request->input('name'),
            "parent_id" => $request->input("parent_id"),
            "status" => $status,
            "user_id" => Auth::id(),
            "slug" => Str::slug($request->input("name"))
        ]);
        return redirect("admin/product/cat/list")->with('status', 'Thêm mới danh mục thành công')
            ->with('class', 'alert-success');
    }

    function action($id)
    {
        $product_cat = ProductCat::find($id);
        if ($product_cat != null) {
            if ($product_cat->status == "1") {
                if (ProductCat::check_inactive_children(ProductCat::all(), $product_cat->id)) {
                    $product_cat->update(['status' => "0"]);
                    return redirect("admin/product/cat/list")->with('status', 'Tắt hoạt động danh mục thành công')
                        ->with('class', 'alert-success');
                } else {
                    return redirect("admin/product/cat/list")->with('status', 'Bạn phải tắt hoạt động của danh mục con')
                        ->with('class', 'alert-danger');
                }
            } else {
                if (ProductCat::check_active_all_parent(ProductCat::all(), $product_cat->parent_id)) {
                    $product_cat->update(['status' => "1"]);
                    return redirect("admin/product/cat/list")->with('status', 'Bật hoạt động danh mục thành công')
                        ->with('class', 'alert-success');
                } else {
                    return redirect("admin/product/cat/list")->with('status', 'Bạn phải bật hoạt động của danh mục cha')
                        ->with('class', 'alert-danger');
                }
            }
        } else {
            return redirect("admin/product/cat/list")->with('status', 'Không tìm thấy danh mục')
                ->with('class', 'alert-danger');
        }
    }

    function delete($id){
        $product_cat = ProductCat::find($id);
        if($product_cat != null){
            if(ProductCat::check_children($product_cat->id)){
                return redirect("admin/product/cat/list")->with('status', 'Bạn phải xóa hết danh mục con')
                ->with('class', 'alert-danger');
            }else{
                $product_cat->delete();
                return redirect("admin/product/cat/list")->with('status', 'Xóa danh mục thành công')
                ->with('class', 'alert-success');
            }
        }else{
            return redirect("admin/product/cat/list")->with('status', 'Không tìm thấy danh mục')
            ->with('class', 'alert-danger');
        }
    }
}
