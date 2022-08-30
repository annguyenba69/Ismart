<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IsmartHomeController@index');


Auth::routes();


Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    //ADMIN
    //AdminDashboardController
    Route::get('admin/dashboard/list', 'AdminDashboardController@list');

    //AdminUserController
    Route::get('admin/user/list', 'AdminUserController@list');

    Route::get('admin/user/add', 'AdminUserController@add');

    Route::post('admin/user/store', 'AdminUserController@store');

    Route::get('admin/user/edit/{id}', 'AdminUserController@edit');

    Route::post('admin/user/update/{id}', 'AdminUserController@update');

    Route::get('admin/user/delete/{id}', 'AdminUserController@delete');

    Route::get('admin/user/restore/{id}', 'AdminUserController@restore');

    Route::get('admin/user/forcedelete/{id}', 'AdminUserController@force_delete');

    Route::post('admin/user/action', 'AdminUserController@action');


    //AdminProductController
    Route::get('admin/product/list', 'AdminProductController@list');

    Route::get('admin/product/add', 'AdminProductController@add');

    Route::post('admin/product/store', 'AdminProductController@store');

    Route::get('admin/product/edit/{id}', 'AdminProductController@edit');

    Route::post('admin/product/update/{id}', 'AdminProductController@update');

    Route::post('admin/product/upload_image', 'AdminProductController@upload_image');

    Route::get('admin/product/delete/{id}', 'AdminProductController@delete');

    Route::get('admin/product/restore/{id}', 'AdminProductController@restore');

    Route::post('admin/product/action', 'AdminProductController@action');

    //AdminProductCatController
    Route::get('admin/product/cat/list', 'AdminProductCatController@list');

    Route::post('admin/product/cat/store', 'AdminProductCatController@store');

    Route::get('admin/product/cat/action/{id}', 'AdminProductCatController@action');

    Route::get('admin/product/cat/delete/{id}', 'AdminProductCatController@delete');

    //AdminPostCatController
    Route::get('admin/post/cat/list', 'AdminPostCatController@list');

    Route::post('admin/post/cat/store', 'AdminPostCatController@store');

    Route::get('admin/post/cat/action/{id}', 'AdminPostCatController@action');

    Route::get('admin/post/cat/delete/{id}', 'AdminPostCatController@delete');

    //AdminPostController
    Route::get('admin/post/list', 'AdminPostController@list');

    Route::get('admin/post/add', 'AdminPostController@add');

    Route::post('admin/post/store', 'AdminPostController@store');

    Route::get('admin/post/edit/{id}', 'AdminPostController@edit');

    Route::post('admin/post/upload_image', 'AdminPostController@upload_image');

    Route::post('admin/post/update/{id}', 'AdminPostController@update');

    Route::get('admin/post/delete/{id}', 'AdminPostController@delete');

    Route::get('admin/post/restore/{id}', 'AdminPostController@restore');

    Route::post('admin/post/action', 'AdminPostController@action');

    //AdminOrderController

    Route::get('admin/order/list', 'AdminOrderController@list');

    Route::get('admin/order/detail/{id}', 'AdminOrderController@detail');

    Route::post('admin/order/update/{id}', 'AdminOrderController@update');

    Route::get('admin/order/delete/{id}', 'AdminOrderController@delete');

    //AdminSliderController
    Route::get('admin/slider/list', 'AdminSliderController@list');

    Route::post('admin/slider/store', 'AdminSliderController@store');

    Route::get('admin/slider/action/{id}', 'AdminSliderController@action');

    Route::get('admin/slider/delete/{id}', 'AdminSliderController@delete');

    //AdminPageController
    Route::get('admin/page/list', 'AdminPageController@list');

    Route::get('admin/page/add', 'AdminPageController@add');

    Route::post('admin/page/store', 'AdminPageController@store');

    Route::get('admin/page/edit/{id}', 'AdminPageController@edit');

    Route::post('admin/page/update/{id}', 'AdminPageController@update');

    Route::get('admin/page/delete/{id}', 'AdminPageController@delete');

    Route::get('admin/page/restore/{id}', 'AdminPageController@restore');

    Route::post('admin/page/action', 'AdminPageController@action');
    //Manager File Laravel
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});


//===========ISMART===================//

//Error-404

Route::get('/error-404', function () {
    return view('ismart.error.404');
});


//IsmartCartController

Route::get('gio-hang', 'IsmartCartController@index');

Route::get('gio-hang/them-san-pham/{id}', 'IsmartCartController@add');

Route::get('gio-hang/xoa-san-pham/{rowId}', 'IsmartCartController@delete');

Route::get('gio-hang/xoa-tat-ca', 'IsmartCartController@destroy');

Route::post('gio-hang/cap-nhat-gio-hang', 'IsmartCartController@update');

Route::get('gio-hang/mua-ngay/{id}', 'IsmartCartController@buynow');

//IsmartHomeController
Route::get('trang-chu', 'IsmartHomeController@index');

//IsmartProductController

Route::get('{cat_id}-{slug}', 'IsmartProductController@index')->name('product.show');

Route::get('{cat_id}-{slug}/{product_id}-{product_slug}', 'IsmartProductController@detail')->name('product.detail');

Route::post('phan-trang-ajax', 'IsmartProductController@index_pagging');

Route::post('loc-ajax', 'IsmartProductController@filter_ajax');

Route::get('search', 'IsmartProductController@search');

Route::get('search_result', 'IsmartProductController@search_product');

//IsmartCheckOutController

Route::get('checkout', 'IsmartCheckOutController@checkout');

Route::post('checkout/store', 'IsmartCheckOutController@store');

Route::get('checkout/thong-bao', 'IsmartCheckOutController@message');

//IsmartPageController

Route::get('trang/{page_slug}', 'IsmartPageController@list');

//IsmartPostController

Route::get('post/danh-sach', 'IsmartPostController@index');

Route::get('post/danh-sach/{post_id}-{post_slug}', 'IsmartPostController@detail')->name('post.detail');
