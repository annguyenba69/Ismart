<?php

namespace App;

use App\Mail\SendMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Order extends Model
{
    //
    protected $fillable = ['name', 'phone', 'address', 'status_id', 'email', 'note', 'payment_method_id'];

    public static function total_price($order_id){
        $total = 0;
        $list_order_product = OrderProduct::all();
        foreach($list_order_product as $order_product){
            if($order_product->order_id == $order_id){
                $total += $order_product->total;
            }
        }
        return $total;
    }

    function order_status(){
        return $this->belongsTo('App\OrderStatus','status_id');
    }

    function products()
    {
        return $this->belongsToMany('App\Product')->withPivot('quantity', 'total');
    }

    public static function send_mail_check_out($email, $data){
        Mail::to($email)->send(new SendMail($data));
    }
}
