<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    //
    protected $fillable = ['name', 'slug', 'user_id', 'status', 'content'];
    use SoftDeletes;

    function user(){
        return $this->belongsTo('App\User');
    }

    public static function check_inactive_list_page($list_page_id){
        foreach($list_page_id as $page_id){
            if(Page::find($page_id)-> status == "1"){
                return false;
                break;
            }
        }
        return true;
    }

}
