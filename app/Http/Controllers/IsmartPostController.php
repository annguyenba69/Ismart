<?php

namespace App\Http\Controllers;

use App\Post;
use App\Product;
use Illuminate\Http\Request;

class IsmartPostController extends Controller
{
    //
    function index(){
        $featured_products = Product::where('status_feature', '1')->where('status_public', '1')->get()->take(8);
        $posts = Post::where('status', '1')->paginate(5);
        return view('ismart.post.index',compact('posts','featured_products'));
    }

    function detail($post_id,$post_slug){
        $featured_products = Product::where('status_feature', '1')->where('status_public', '1')->get()->take(8);
        $post = Post::where('status', '1')->where('id', $post_id)->first();
        return view('ismart.post.detail',compact('post','featured_products'));
    }
}
