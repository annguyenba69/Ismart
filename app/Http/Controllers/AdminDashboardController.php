<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    
    //
    function list(){
        $orders= Order::orderBy('id', 'desc')->paginate(8);
        $count_pending_orders = Order::where('status_id', '1')->count();
        $count_delivery_orders = Order::where('status_id', '2')->count();
        $count_success_orders = Order::where('status_id', '3')->count();
        $count_cancel_orders = Order::where('status_id', '4')->count();
        $total_revenue = 0;
        $success_orders = Order::where('status_id', '3')->get();
        if($success_orders->isNotEmpty()){
            foreach($success_orders as $order){
                $total_revenue += $order->products()->sum('total');
            }
        }
        $count = [$count_pending_orders, $count_delivery_orders, $count_success_orders, $count_cancel_orders];
        return view('admin.dashboard.list', compact('orders', 'count','total_revenue'));
    }
}
