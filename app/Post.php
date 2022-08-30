<?php

namespace App;

use App\Post as AppPost;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    //
    protected $fillable = ['title','content','status','user_id','slug','thumbnail'];
    use SoftDeletes;

    function post_categories(){
        return $this->belongsToMany('App\PostCat');
    }

    function post_parent_category(){
        return $this->belongsToMany('App\PostCat')->where('parent_id', '0');
    }

    function user(){
        return $this->belongsTo('App\User');
    }
    //Hàm lấy tất cả danh mục cha
    public static function get_all_parent($product_cats, $parent_id)
    {
        $result = [];
        foreach ($product_cats as $key => $cat) {
            if ($cat->id == $parent_id) {
                $result[] = $cat->id;
                unset($product_cats[$key]);
                $parent = self::get_all_parent($product_cats, $cat->parent_id);
                $result = array_merge($result, $parent);
            }
        }
        return $result;
    }

    public static function check_active_post($post)
    {
        if ($post->status == "1")
            return true;
        return false;
    }

    public static function check_inactive_all_posts($list_posts_id){
        foreach($list_posts_id as $post_id){
            if(AppPost::find($post_id)->status == "1"){
                return false;
                break;
            }
        }
        return true;
    }
}
