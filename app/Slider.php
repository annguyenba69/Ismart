<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    //
    protected $fillable = ['thumbnail', 'status', 'user_id'];

    function user(){
        return $this->belongsTo('App\User');
    }
}
