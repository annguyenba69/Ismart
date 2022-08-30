<?php

namespace App\Http\Controllers;

use App\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class IsmartCartController extends Controller
{
    //
    function index()
    {
        $carts = Cart::content();
        return view('ismart.cart.index', compact('carts'));
    }

    function add($id, Request $request)
    {
        $product = Product::find($id);
        if ($product != null && $product->status_warehouse == "1" && $product->status_public == "1") {
            $qty = 1;
            if ($request->input('num-order')) {
                $qty = $request->input('num-order');
            }
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $qty,
                'price' => $product->price,
                'options' => [
                    'thumbnail' => $product->product_thumbnail_details[0]->thumbnail
                ]
            ]);
            return redirect('gio-hang')->with('status', 'Thêm sản phẩm thành công vào giỏ hàng')
                ->with('class', 'alert-success');
        } else {
            return redirect('gio-hang')->with('status', 'Không tìm thấy sản phẩm cần mua, hoặc đã hết hàng')
                ->with('class', 'alert-danger');
        }
    }

    function buynow($id){
        $product = Product::find($id);
        if ($product != null && $product->status_warehouse == "1" && $product->status_public == "1") {
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->price,
                'options' => [
                    'thumbnail' => $product->product_thumbnail_details[0]->thumbnail
                ]
            ]);
            return redirect('checkout');
        } else {
            return redirect('gio-hang')->with('status', 'Không tìm thấy sản phẩm cần mua, hoặc đã hết hàng')
                ->with('class', 'alert-danger');
        }
    }

    function delete($rowId)
    {
        Cart::remove($rowId);
        return redirect('gio-hang')->with('status', 'Xóa sản phẩm thành công khỏi giỏ hàng')
            ->with('class', 'alert-success');
    }

    function destroy()
    {
        Cart::destroy();
        return redirect('gio-hang')->with('status', 'Xóa tất cả sản phẩm thành công khỏi giỏ hàng')
            ->with('class', 'alert-success');
    }

    function update(Request $request)
    {
        $num_order = $request->get('num_order');
        $row_id = $request->get('row_id');
        Cart::update($row_id, $num_order);
        return response()->json([
            "sub_total" => Cart::get($row_id)->total(0, '.', ','),
            "cart_total" => Cart::total(0, '.', ',')
        ]);
    }
}
