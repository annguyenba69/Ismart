<?php

namespace App;

use App\Product as AppProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'name', 'price', 'description', 'detail', 'slug', 'status_public', 'status_feature', 'status_warehouse', 'user_id'
    ];

    function product_categories()
    {
        return $this->belongsToMany("App\ProductCat");
    }

    function product_thumbnail_details()
    {
        return $this->hasMany("App\ProductThumbnailDetail");
    }

    function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function check_active_products($product)
    {
        if ($product->status_public == "1")
            return true;
        return false;
    }

    public static function check_inactive_all_products($list_product_id){
        foreach($list_product_id as $product_id){
            if(AppProduct::find($product_id)->status_public == "1"){
                return false;
                break;
            }
        }
        return true;
    }

    function get_parent_category(){
        return $this->belongsToMany('App\ProductCat')->where('parent_id', '0');
    }
}
