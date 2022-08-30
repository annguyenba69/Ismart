<?php

namespace App\Http\Controllers;

use App\Page;
use Illuminate\Http\Request;

class IsmartPageController extends Controller
{
    //
    function list($page_slug){
        $page = Page::where('slug', $page_slug)->first();
        return view('ismart.page.index', compact('page'));
    }
}
