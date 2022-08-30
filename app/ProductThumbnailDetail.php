<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductThumbnailDetail extends Model
{
    //
    protected $fillable = [
        'product_id', 'thumbnail'
    ];
}
