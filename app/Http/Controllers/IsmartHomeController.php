<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductCat;
use App\Slider;
use Illuminate\Http\Request;

class IsmartHomeController extends Controller
{
    //
    function index(){
        $parent_categories = ProductCat::where('parent_id', 0)->get();
        $featured_products = Product::where('status_feature', '1')->where('status_public', '1')->get()->take(8);
        $phones = ProductCat::find(1)->products()->where('status_public', '1')->get()->take(8);
        $laptops = ProductCat::find(2)->products()->where('status_public', '1')->get()->take(8);
        $sliders = Slider::where('status', '1')->get();
        return view('ismart.home.index', compact('parent_categories', 'featured_products', 'phones','laptops','sliders'));
    }
}
