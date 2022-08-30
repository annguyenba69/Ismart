<?php

namespace App;

use App\PostCat as AppPostCat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostCat extends Model
{
    //
    protected $fillable = ["name", "status", "parent_id", "user_id", "slug"];

    function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function get_data_tree($post_cats, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach ($post_cats as $key => $post_cat) {
            if ($post_cat->parent_id == $parent_id) {
                $post_cat->level = $level;
                $result[] = $post_cat;
                unset($post_cats[$key]);
                $child = self::get_data_tree($post_cats, $post_cat->id, $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }

    //Hàm kiểm tra xem danh mục cha có hoạt động
    public static function check_active_parent($parent_id)
    {
        $product_cat = AppPostCat::find($parent_id);
        if ($product_cat->status == "1") {
            return true;
        }
        return false;
    }

    //Hàm phân trang
    public static function get_paginator(Request $request, $post_cats_data_tree)
    {
        $total = count($post_cats_data_tree);
        if ($request->page) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        $num_per_page = 8;
        $off_set = ($page - 1) * $num_per_page;
        $post_cats_data_tree = array_slice($post_cats_data_tree, $off_set, $num_per_page);
        return new LengthAwarePaginator($post_cats_data_tree, $total, $num_per_page, $page, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);
    }

    //Hàm kiểm tra xem danh mục con đã hủy hoạt động hay chưa
    public static function check_inactive_children($product_cats, $parent_id)
    {
        foreach ($product_cats as $key => $product_cat) {
            if ($product_cat->parent_id == $parent_id) {
                if ($product_cat->status == "1") {
                    return false;
                    break;
                }
                unset($product_cats[$key]);
                self::check_inactive_children($product_cats, $product_cat->id);
            }
        }
        return true;
    }

    public static function check_active_all_parent($product_cats, $parent_id)
    {
        foreach ($product_cats as $key => $product_cat) {
            if ($product_cat->id == $parent_id) {
                if ($product_cat->status == "0") {
                    return false;
                    break;
                }
                unset($product_cats[$key]);
                self::check_active_all_parent($product_cats, $product_cat->parent_id);
            }
        }
        return true;
    }

    //Hàm kiểm tra xem danh mục đó có danh mục con hay không
    public static function check_children($id)
    {
        $product_cats = AppPostCat::all();
        foreach ($product_cats as $product_cat) {
            if ($product_cat->parent_id == $id) {
                return true;
                break;
            }
        }
        return false;
    }
     //Hàm lấy tất cả danh mục cha
     public static function get_all_parent($product_cats, $parent_id)
     {
         $result = [];
         foreach ($product_cats as $key => $cat) {
             if ($cat->id == $parent_id) {
                 $result[] = $cat->id;
                 unset($product_cats[$key]);
                 $parent = self::get_all_parent($product_cats, $cat->parent_id);
                 $result = array_merge($result, $parent);
             }
         }
         return $result;
     }
}
