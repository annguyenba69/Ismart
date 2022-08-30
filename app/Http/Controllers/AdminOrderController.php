<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderProduct;
use App\OrderStatus;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //
    function list(Request $request)
    {
        $keyword = "";
        if($request->input('keyword')){
            $keyword = $request->input('keyword');
        }
        if ($request->input('status') == 'pending') {
            $orders = Order::where('status_id', '1')->where('name', 'LIKE', "%$keyword%")->paginate(8);
        } else if ($request->input('status') == 'delivery') {
            $orders = Order::where('status_id', '2')->where('name', 'LIKE', "%$keyword%")->paginate(8);
        } else if ($request->input('status') == 'success') {
            $orders = Order::where('status_id', '3')->where('name', 'LIKE', "%$keyword%")->paginate(8);
        } else if ($request->input('status') == 'cancel') {
            $orders = Order::where('status_id', '4')->where('name', 'LIKE', "%$keyword%")->paginate(8);
        } else {
            $orders = Order::where('name', 'LIKE', "%$keyword%")->paginate(8);
        }
        $count_total = Order::count();
        $count_pending_order  = Order::where('status_id', '1')->count();
        $count_delivery_order  = Order::where('status_id', '2')->count();
        $count_success_order = Order::where('status_id', '3')->count();
        $count_cancel_order  = Order::where('status_id', '4')->count();
        $count = [$count_total, $count_pending_order, $count_delivery_order, $count_success_order, $count_cancel_order];
        return view('admin.order.list', compact('orders', 'count'));
    }

    function detail($id)
    {
        $order = Order::find($id);
        if ($order != null) {
            $order_status = OrderStatus::all();
            return view('admin.order.detail', compact('order_status', 'order'));
        } else {
            return redirect('admin/order/list')->with('status', 'Không tìm thấy hóa đơn cần thao tác')
                ->status('class', 'text-danger');
        }
    }

    function update($id, Request $request)
    {
        $order = Order::find($id);
        if ($order != null) {
            $order->update([
                'status_id' => $request->input('status_id')
            ]);
            return redirect(url()->previous())->with('status', 'Cập nhật trạng thái đơn hàng thành công')
                ->with('class', 'alert-success');
        } else {
            return redirect('admin/order/list')->with('status', 'Không tìm thấy hóa đơn cần thao tác')
                ->with('class', 'alert-danger');
        }
    }

    function delete($id)
    {
        $order = Order::find($id);
        if ($order != null) {
            $order->delete();
            return redirect(url()->previous())->with('status', 'Xóa thành công đơn hàng')
                ->with('class', 'alert-success');
        } else {
            return redirect(url()->previous())->with('status', 'Không tìm thấy hóa đơn cần thao tác')
                ->with('class', 'alert-danger');
        }
    }
}
