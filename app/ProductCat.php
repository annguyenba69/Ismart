<?php

namespace App;

use App\ProductCat as AppProductCat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCat extends Model
{
    //
    protected $fillable = ['name', 'status', 'parent_id', 'user_id', 'slug'];

    //Hàm lấy về thông tin user khởi tạo
    function user()
    {
        return $this->belongsTo('App\User');
    }

    //Hàm đệ quy danh mục đa cấp
    public static function get_data_tree($product_cats, $parent_id = 0, $level = 0)
    {
        $result = [];
        foreach ($product_cats as $key => $cat) {
            if ($cat->parent_id == $parent_id) {
                $cat->level = $level;
                $result[] = $cat;
                unset($product_cats[$key]);
                $child = self::get_data_tree($product_cats, $cat->id, $level + 1);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }

    //Hàm phân trang
    public static function get_paginator(Request $request, $product_cats_data_tree)
    {
        $total = count($product_cats_data_tree);
        if ($request->page) {
            $page = $request->page;
        } else {
            $page = 1;
        }
        $num_per_page = 8;
        $off_set = ($page - 1) * $num_per_page;
        $post_cats_data_tree = array_slice($product_cats_data_tree, $off_set, $num_per_page);
        return new LengthAwarePaginator($post_cats_data_tree, $total, $num_per_page, $page, [
            'path' => $request->url(),
            'query' => $request->query()
        ]);
    }

    //Hàm kiểm tra xem danh mục cha có hoạt động
    public static function check_active_parent($parent_id)
    {
        $product_cat = AppProductCat::find($parent_id);
        if ($product_cat->status == "1") {
            return true;
        }
        return false;
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

    //Hàm kiểm tra xem danh mục cha đã bật hoạt động hết hay chưa
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
        $product_cats = AppProductCat::all();
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

    public function subcategories()
    {
        return $this->hasMany('App\ProductCat', 'parent_id')->where('status', '1');
    }

    public function products(){
        return $this->belongsToMany('App\Product');
    }
}
