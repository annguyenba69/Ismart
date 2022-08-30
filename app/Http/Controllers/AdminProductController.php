<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCat;
use App\ProductThumbnailDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    //
    function list(Request $request)
    {
        $keyword = "";
        $list_action = ["delete" => "Xóa tạm thời"];
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        if ($request->input('status') == 'trash') {
            $products = Product::onlyTrashed()->where('name', 'LIKE', "%$keyword%")->paginate(8);
            $list_action = ["restore" => "Khôi phục", "forceDelete" => "Xóa vĩnh viễn"];
        } else {
            $products = Product::where('name', 'LIKE', "%$keyword%")->paginate(8);
        }
        $count_active_product = Product::count();
        $count_trash_product = Product::onlyTrashed()->count();
        $count = [$count_active_product, $count_trash_product];
        return view('admin.product.list', compact('products', 'list_action', 'count'));
    }

    function add()
    {
        $product_cats = ProductCat::where('status','1')->get();
        $product_cats_data_tree = ProductCat::get_data_tree($product_cats);
        return view('admin.product.add', compact("product_cats_data_tree"));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|string',
                'price' => 'required|numeric',
                'description' => 'required|string',
                'detail' => 'required|string',
                'product_cat_id' => 'required',
                'filename' => 'required',
                'filename.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
                'status_public' => 'required',
                'status_feature' => 'required',
                'status_warehouse' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tự',
                'numeric' => ':attribute phải là số',
                'mimes' => ':attribute phải là hình ảnh định dạng (jpg, jpeg, png)',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'detail' => 'Chi tiết sản phẩm',
                'product_cat_id' => 'Danh mục sản phẩm',
                'filename' => 'Hình ảnh sản phẩm',
                'filename.*' => 'Hình ảnh sản phẩm',
                'status_public' => 'Trạng thái công khai',
                'status_feature' => 'Trạng thái nổi bật',
                'status_warehouse' => 'Trạng thái kho hàng'
            ]
        );
        $thumbnails = [];
        if ($request->hasFile('filename')) {
            foreach ($request->file('filename') as $file) {
                $file_name = time() . '_' . $file->getClientOriginalName();
                $file->move('public/uploads', $file_name);
                $thumbnails[] = 'public/uploads/' . $file_name;
            }
        }
        $product = new Product;
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->detail = $request->input('detail');
        $product->slug = Str::slug($request->input('name'));
        $product->status_public = $request->input('status_public');
        $product->status_feature = $request->input('status_feature');
        $product->status_warehouse = $request->input('status_warehouse');
        $product->user_id = Auth::id();
        $product->save();
        $product_cat = ProductCat::find($request->input('product_cat_id'));
        $array_list_cat[] = $product_cat->id;
        $array_list_cat = array_merge($array_list_cat, ProductCat::get_all_parent(ProductCat::all(), $product_cat->parent_id));
        $product->product_categories()->attach($array_list_cat);
        foreach ($thumbnails as $thumbnail) {
            $product_thumbnail = new ProductThumbnailDetail;
            $product_thumbnail->thumbnail = $thumbnail;
            $product->product_thumbnail_details()->save($product_thumbnail);
        }
        return redirect("admin/product/add")->with('status', 'Thêm sản phẩm thành công')
            ->with('class', 'alert-success');
    }

    function edit($id)
    {
        $product = Product::find($id);
        if ($product != null) {
            $product_cats = ProductCat::where('status', '1')->get();
            $product_cats_data_tree = ProductCat::get_data_tree($product_cats);
            return view('admin.product.edit', compact('product_cats_data_tree', 'product'));
        } else {
            return redirect("admin/product/list")->with('status', 'Không tìm thấy sản phẩm cần chỉnh sửa')
                ->with('class', 'alert-danger');
        }
    }

    function update($id, Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|string',
                'price' => 'required|numeric',
                'description' => 'required|max:255|string',
                'detail' => 'required|string',
                'product_cat_id' => 'required',
                'status_public' => 'required',
                'status_feature' => 'required',
                'status_warehouse' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tự',
                'numeric' => ':attribute phải là số',
                'mimes' => ':attribute phải là hình ảnh định dạng (jpg, jpeg, png)',
            ],
            [
                'name' => 'Tên sản phẩm',
                'price' => 'Giá sản phẩm',
                'description' => 'Mô tả sản phẩm',
                'detail' => 'Chi tiết sản phẩm',
                'product_cat_id' => 'Danh mục sản phẩm',
                'status_public' => 'Trạng thái công khai',
                'status_feature' => 'Trạng thái nổi bật',
                'status_warehouse' => 'Trạng thái kho hàng'
            ]
        );
        $thumbnails = [];
        if ($request->input('thumbnail_details')) {
            $thumbnails = explode(",", $request->input("thumbnail_details"));
        }
        $product = Product::find($id);
        $product->update([
            "name" => $request->input('name'),
            "price" => $request->input('price'),
            "description" => $request->input('description'),
            "detail" => $request->input('detail'),
            "slug" => Str::slug($request->input('name')),
            "status_public" => $request->input('status_public'),
            "status_feature" => $request->input('status_feature'),
            "status_warehouse" => $request->input('status_warehouse')
        ]);
        if (!empty($thumbnails)) {
            $product->product_thumbnail_details()->delete();
            foreach ($thumbnails as $thumbnail) {
                $product->product_thumbnail_details()->create(['thumbnail' => $thumbnail]);
            }
        }
        $product_cat = ProductCat::find($request->input('product_cat_id'));
        $array_list_cat[] = $product_cat->id;
        $array_list_cat = array_merge($array_list_cat, ProductCat::get_all_parent(ProductCat::all(), $product_cat->parent_id));
        $product->product_categories()->sync($array_list_cat);
        return redirect("admin/product/list")->with('status', 'Cập nhật thông tin sản phẩm thành công')
            ->with('class', 'alert-success');
    }

    function upload_image(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'filename' => 'required',
            'filename.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if ($validate->fails()) {
            $error = "<small class='text-danger'>Đuôi File không hợp lệ</small>";
            return response()->json([
                "status" => "0",
                "error" => $error
            ]);
        } else {
            $thumbnails = [];
            if ($request->hasFile('filename')) {
                foreach ($request->file('filename') as $file) {
                    if ($file->extension())
                        $file_name = time() . '_' . $file->getClientOriginalName();
                    $file->move('public/uploads', $file_name);
                    $thumbnails[] = 'public/uploads/' . $file_name;
                }
            }
            $base_url = url('/') . '/';
            $thumbnails_html = "";
            foreach ($thumbnails as $thumbnail) {
                $thumbnails_html .= "<img src='" . $base_url . $thumbnail . "'style='width: 120px'>";
            }
            return response()->json([
                "status" => "1",
                "thumbnails_html" => $thumbnails_html,
                "thumbnails" => $thumbnails
            ]);
        }
    }

    function delete($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product != null) {
            if ($product->deleted_at == null) {
                if (Product::check_active_products($product)) {
                    return redirect("admin/product/list")->with('status', 'Bạn phải hủy hoạt động sản phẩm thì mới xóa được')
                        ->with('class', 'alert-danger');
                } else {
                    $product->delete();
                    return redirect("admin/product/list")->with('status', 'Xóa tạm thời thành công sản phẩm')
                        ->with('class', 'alert-success');
                }
            } else {
                $product->forceDelete();
                return redirect("admin/product/list?status=trash")->with('status', 'Xóa vĩnh viễn thành công sản phẩm')
                    ->with('class', 'alert-success');
            }
        } else {
            return redirect("admin/product/list")->with('status', 'Không tìm thấy sản phẩm cần xóa')
                ->with('class', 'alert-danger');
        }
    }

    function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product != null) {
            $product->restore();
            return redirect("admin/product/list?status=trash")->with('status', 'Khôi phục thành công sản phẩm')
                ->with('class', 'alert-success');
        } else {
            return redirect("admin/product/list?status=trash")->with('status', 'Không tìm thấy sản phẩm cần khôi phục')
                ->with('class', 'alert-danger');
        }
    }

    function action(Request $request)
    {
        if ($request->input('list_product')) {
            $list_product_id = $request->input('list_product');
            $action = $request->input('action');
            if ($action == 'delete') {
                if (Product::check_inactive_all_products($list_product_id)) {
                    Product::destroy($list_product_id);
                    return redirect("admin/product/list")->with('status', 'Xóa tạm thời thành công các sản phẩm được chọn')
                        ->with('class', 'alert-success');
                } else {
                    return redirect("admin/product/list")->with('status', 'Bạn cần phải hủy hoạt động toàn bộ các sản phẩm cần xóa')
                        ->with('class', 'alert-danger');
                }
            } else if ($action == "restore") {
                Product::onlyTrashed()->whereIn('id', $list_product_id)->restore();
                return redirect("admin/product/list?status=trash")->with('status', 'Khôi phục thành công các sản phẩm được chọn')
                    ->with('class', 'alert-success');
            } else if ($action == "forceDelete") {
                Product::onlyTrashed()->whereIn('id', $list_product_id)->forceDelete();
                return redirect("admin/product/list?status=trash")->with('status', 'Xóa vĩnh viễn thành công các sản phẩm được chọn')
                    ->with('class', 'alert-success');
            } else {
                return redirect("admin/product/list")->with('status', 'Bạn phải chọn thao tác cần thực hiện')
                    ->with('class', 'alert-danger');
            }
        } else {
            return redirect("admin/product/list")->with('status', 'Bạn cần phải chọn các sản phẩm cần thao tác')
                ->with('class', 'alert-danger');
        }
    }
}
