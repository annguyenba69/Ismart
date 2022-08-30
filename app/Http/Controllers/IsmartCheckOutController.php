<?php

namespace App\Http\Controllers;

use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class IsmartCheckOutController extends Controller
{
    //
    function checkout()
    {
        if (Cart::content()->isNotEmpty()) {
            $carts = Cart::content();
            return view('ismart.checkout.checkout', compact('carts'));
        } else {
            return redirect('gio-hang')->with('status', 'Bạn không có sản phẩm nào để thanh toán')
                ->with('class', 'alert-danger');
        }
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:40',
                'email' => 'required|email',
                'calc_shipping_provinces' => 'required',
                'calc_shipping_district' => 'required',
                'address-detail' => 'required',
                'phone' => 'required|numeric',
                'payment-method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max kí tự',
                'numeric' => ':attribute phải là số',
                'email' => ':attribute phải là định dạng email'
            ],
            [
                'fullname' => 'Họ và tên',
                'email' => 'Email',
                'calc_shipping_provinces' => 'Tỉnh / Thành phố',
                'calc_shipping_district' => 'Quận / Huyện',
                'address-detail' => 'Địa chỉ chi tiết',
                'phone' => 'Số điện thoại',
                'payment-method' => 'Phương thức thanh toán'
            ]
        );
        $list_products_order_id = [];
        foreach (Cart::content() as $product) {
            $list_products_order_id[$product->id] = ['quantity' => $product->qty, 'total' => $product->total(0, '.', '')];;
        }
        $address = $request->input('address-detail') . ", " . $request->input('district') . ", " . $request->input('province');
        $order = new Order();
        $order->name = $request->input('fullname');
        $order->phone = $request->input('phone');
        $order->address = $address;
        $order->status_id = "1";
        $order->email = $request->input('email');
        if ($request->input('note')) {
            $order->note = $request->input('note');
        }
        $order->payment_method_id = $request->input('payment-method');
        $order->save();
        $order->products()->attach($list_products_order_id);
        $payment_method_string = "";
        if ($request->input('payment-method') == "1") {
            $payment_method_string = "Thanh toán tại nhà";
        } else {
            $payment_method_string = "Thanh toán tại cửa hàng";
        }
        $data = [
            "id" => $order->id,
            "email" => $request->input('email'),
            "name" => $request->input('fullname'),
            "phone" => $request->input('phone'),
            "address" => $address,
            "payment_method" => $payment_method_string,
            "detail_order" => Cart::content(),
            "created_at" => $order->created_at
        ];
        Order::send_mail_check_out($request->input('email'), $data);
        Cart::destroy();
        return redirect('checkout/thong-bao');
    }

    function message(){
        return view('ismart.checkout.message');
    }
}
