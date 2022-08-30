<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCat;
use Illuminate\Http\Request;

class IsmartProductController extends Controller
{
    //
    function index($cat_id, $slug, Request $request)
    {
        $products = ProductCat::find($cat_id);
        $name = "";
        $condition_1 = "";
        $condition_2 = [];
        if ($products != null) {
            if ($request->input('order')) {
                $order = $request->input('order');
                if ($order == 1) {
                    $name = 'name';
                    $condition_1 = 'asc';
                } else if ($order == 2) {
                    $name = 'name';
                    $condition_1 = 'desc';
                } else if ($order == 3) {
                    $name = 'price';
                    $condition_1 = 'desc';
                } else {
                    $name = 'price';
                    $condition = 'asc';
                }
            }
            if ($request->input('r-price')) {
                $r_price = $request->input('r-price');
                if ($r_price == 1) {
                    $r_price_start = 0;
                    $r_price_end = 5000000;
                } else if ($r_price == 2) {
                    $r_price_start = 5000000;
                    $r_price_end = 10000000;
                } else if ($r_price == 3) {
                    $r_price_start = 10000000;
                    $r_price_end = 20000000;
                } else {
                    $r_price_start = 20000000;
                    $r_price_end = null;
                }
                if ($r_price_end != null) {
                    $condition_2 = [
                        ['price', '>', $r_price_start],
                        ['price', '<=', $r_price_end]
                    ];
                } else {
                    $condition_2 = [
                        ['price', '>', $r_price_start]
                    ];
                }
            }
            $parent_categories = ProductCat::where('parent_id', 0)->get();
            $product_cat = $products;
            if (!empty($condition_1) && !empty($name)) {
                $products = $products->products()->where('status_public', '1')->where($condition_2)->orderBy($name, $condition_1)->paginate(8);
            } else {
                $products = $products->products()->where('status_public', '1')->where($condition_2)->paginate(8);
            }
            return view('ismart.product.index', compact('parent_categories', 'products', 'product_cat'));
        } else {
            return redirect('error-404');
        }
    }

    function detail($cat_id, $slug, $product_id, $product_slug)
    {
        $product = Product::find($product_id);
        if ($product != null) {
            $product_cat = ProductCat::find($cat_id);
            $parent_categories = ProductCat::where('parent_id', 0)->get();
            $related_products = $product_cat->products()->where('status_public', '1')->get()->take(6);
            return view('ismart.product.detail', compact('parent_categories', 'product', 'product_cat', 'related_products'));
        } else {
            return redirect('error-404');
        }
    }

    function index_pagging(Request $request)
    {
        $product_cat_id = $request->get('product_cat_id');
        $product_cat = ProductCat::find($product_cat_id);
        $products = $product_cat->products()->paginate(8);
        $base_url = url('/') . '/';
        $base_url_add_cart = $base_url . 'gio-hang/them-san-pham/';
        $result = "";
        foreach ($products as $product) {
            $result .= '<li>';
            $result .= '<a href="' . $base_url . $product_cat->id . '-' . $product_cat->slug . '/' . $product->id . '-' . $product->slug . '" title="" class="thumb">';
            $result .= '<img src="' . $base_url . $product->product_thumbnail_details[0]->thumbnail . '"></a>';
            $result .= '<a href="' . $base_url . $product_cat->id . '-' . $product_cat->slug . '/' . $product->id . '-' . $product->slug . ' " title=""class="product-name">' . $product->name . '</a>';
            $result .= '<div class="price"><span class="new">' . currency_format($product->price) . '</span></div>';
            $result .= '<div class="action clearfix"><a href="' . $base_url_add_cart . $product->id . '" title="Thêm giỏ hàng"class="add-cart fl-left">Thêm giỏ hàng</a>';
            $result .= '<a href="' . '" title="Mua ngay" class="buy-now fl-right">Mua ngay</a></div></li>';
        }
        $num_per_page = 8;
        $total_records = $product_cat->products()->get()->count();
        $total_page = ceil($total_records / $num_per_page);
        $url_with_out_query = url()->current();
        $page = $request->input('page');
        $nav = get_pagging($total_page, $page, $url_with_out_query);
        return response()->json([
            'result' => $result,
            'nav' => $nav
        ]);
    }

    function filter_ajax(Request $request)
    {
        $name = "";
        $condition_1 = "";
        $condition_2 = [];
        if ($request->get('r_price')) {
            $r_price = $request->get('r_price');
            if ($r_price == 1) {
                $r_price_start = 0;
                $r_price_end = 5000000;
            } else if ($r_price == 2) {
                $r_price_start = 5000000;
                $r_price_end = 10000000;
            } else if ($r_price == 3) {
                $r_price_start = 10000000;
                $r_price_end = 20000000;
            } else {
                $r_price_start = 20000000;
                $r_price_end = null;
            }
            if ($r_price_end != null) {
                $condition_2 = [
                    ['price', '>', $r_price_start],
                    ['price', '<=', $r_price_end]
                ];
            } else {
                $condition_2 = [
                    ['price', '>', $r_price_start]
                ];
            }
        }
        if ($request->get('order')) {
            $order = $request->get('order');
            if ($order == 1) {
                $name = 'name';
                $condition_1 = 'asc';
            } else if ($order == 2) {
                $name = 'name';
                $condition_1 = 'desc';
            } else if ($order == 3) {
                $name = 'price';
                $condition_1 = 'desc';
            } else {
                $name = 'price';
                $condition_1 = 'asc';
            }
        }
        if ($request->get('product_cat_id')) {
            $product_cat = ProductCat::find($request->get('product_cat_id'));
            if (!empty($condition_1) && !empty($name)) {
                $products = $product_cat->products()->where('status_public', '1')->where($condition_2)->orderBy($name, $condition_1)->paginate(8);
               
            } else {
                $products = $product_cat->products()->where('status_public', '1')->where($condition_2)->paginate(8);
                
            }
        }
        $base_url = url('/') . '/';
        $base_url_add_cart = $base_url . 'gio-hang/them-san-pham/';
        $result = "";
        foreach ($products as $product) {
            $result .= '<li>';
            $result .= '<a href="' . $base_url . $product_cat->id . '-' . $product_cat->slug . '/' . $product->id . '-' . $product->slug . '" title="" class="thumb">';
            $result .= '<img src="' . $base_url . $product->product_thumbnail_details[0]->thumbnail . '"></a>';
            $result .= '<a href="' . $base_url . $product_cat->id . '-' . $product_cat->slug . '/' . $product->id . '-' . $product->slug . ' " title=""class="product-name">' . $product->name . '</a>';
            $result .= '<div class="price"><span class="new">' . currency_format($product->price) . '</span></div>';
            $result .= '<div class="action clearfix"><a href="' . $base_url_add_cart . $product->id . '" title="Thêm giỏ hàng"class="add-cart fl-left">Thêm giỏ hàng</a>';
            $result .= '<a href="' . '" title="Mua ngay" class="buy-now fl-right">Mua ngay</a></div></li>';
        }
        if ($request->get('product_cat_id')) {
            return response()->json([
                'status'=> 'success',
                'result'=>$result,
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message'=> 'Bạn phải chọn chức năng lọc'
            ]);
        }
    }

    function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::select('name')->where('name', 'like', "%$keyword%")->get();
        return Response()->json($products);
    }

    function search_product(Request $request){
        if($request->input('keyword')){
            $parent_categories = ProductCat::where('parent_id', 0)->get();
            $keyword = $request->input('keyword');
            $products = Product::where('name', 'LIKE', "%$keyword%")->get();
            return view('ismart.product.search', compact('products','parent_categories'));
        }else{
            return redirect('trang-chu');
        }
    }
}
