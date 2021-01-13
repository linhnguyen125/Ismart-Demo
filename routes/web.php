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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    //=================================================
    //================ DASHBOARD ======================
    //=================================================

    Route::get('dashboard', 'DashboardController@show');
    Route::get('admin', 'DashboardController@show');

    //================= USER =========================

    Route::get('admin/user/list', 'AdminUserController@list');
    Route::get('admin/user/add', 'AdminUserController@add');
    Route::post('admin/user/store', 'AdminUserController@store');
    Route::post('admin/user/action', 'AdminUserController@action');
    Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('delete_user');
    Route::get('admin/user/edit/{id}', 'AdminUserController@edit')->name('edit_user');
    Route::post('admin/user/update/{id}', 'AdminUserController@update')->name('update_user');

    //=================== POST =========================

    Route::get('admin/post/list', 'AdminPostController@list');
    Route::get('admin/post/add', 'AdminPostController@add');
    Route::post('admin/post/store', 'AdminPostController@store');
    Route::get('admin/post/delete/{id}', 'AdminPostController@delete')->name('delete_post');
    Route::get('admin/post/edit/{id}', 'AdminPostController@edit')->name('edit_post');
    Route::post('admin/post/update/{id}', 'AdminPostController@update')->name('update_post');
    Route::get('admin/post/forceDelete/{id}', 'AdminPostController@forceDelete')->name('forceDelete_post');
    Route::post('admin/post/action', 'AdminPostController@action');

    Route::get('admin/post/cat/list', 'AdminPostController@listCat');
    Route::get('admin/post/cat/edit/{id}', 'AdminPostController@editCat')->name('edit_post_cat');
    Route::get('admin/post/cat/delete/{id}', 'AdminPostController@deleteCat')->name('delete_post_cat');
    Route::post('admin/post/cat/update/{id}', 'AdminPostController@updateCat')->name('update_post_cat');
    Route::post('admin/post/cat/store', 'AdminPostController@catStore');

    //==================== PRODUCT ===========================

    Route::get('admin/product/list', 'AdminProductController@list');
    Route::get('admin/product/add', 'AdminProductController@add');
    Route::post('admin/product/action', 'AdminProductController@action');
    Route::post('admin/product/store', 'AdminProductController@store');
    Route::get('admin/product/edit/{id}', 'AdminProductController@edit')->name('edit_product');
    Route::get('admin/product/add/thumbnail/{id}', 'AdminProductController@addThumbnail')->name('add_thumbnail');
    Route::post('admin/product/storeThumbnail/{id}', 'AdminProductController@storeThumbnail')->name('storeThumbnail');
    Route::get('admin/product/edit/thumbnail/{id}', 'AdminProductController@editThumbnail')->name('edit_thumbnail');
    Route::post('admin/product/update/thumbnail/{id}', 'AdminProductController@updateThumbnail')->name('update_thumbnail');
    Route::get('admin/product/delete/thumbnail/{id}', 'AdminProductController@deleteThumbnail')->name('delete_thumbnail');
    Route::get('admin/product/delete/{id}', 'AdminProductController@delete')->name('delete_product');
    Route::post('admin/product/update/{id}', 'AdminProductController@update')->name('update_product');
    Route::get('admin/product/forceDelete/{id}', 'AdminProductController@forceDelete')->name('forceDelete_product');

    Route::get('admin/product/cat/list', 'AdminProductController@listCat');
    Route::post('admin/product/cat/store', 'AdminProductController@catStore');
    Route::get('admin/product/cat/delete/{id}', 'AdminProductController@deleteCat')->name('delete_product_cat');
    Route::get('admin/product/cat/edit/{id}', 'AdminProductController@editCat')->name('edit_product_cat');
    Route::post('admin/product/cat/update/{id}', 'AdminProductController@updateCat')->name('update_product_cat');

    //==================== ORDER ===========================

    Route::get('admin/order/list', 'AdminOrderController@list');
    Route::get('admin/order/detail/{id}', 'AdminOrderController@detail')->name('detail_order');
    Route::get('admin/order/delete/{id}', 'AdminOrderController@delete')->name('delete_order');
    Route::post('admin/order/action', 'AdminOrderController@action');

    //==================== BANNERS =========================

    Route::get('admin/banner/list', 'AdminBannerController@list');
    Route::get('admin/banner/add', 'AdminBannerController@add');

});

//==================================================
//===================== USER =======================
//==================================================



//=================== PAGE =======================

Route::get('page/blog', 'UserPageController@blog');
Route::get('page/blog/detail', 'UserPageController@detail_blog');

//==================== HOME ======================

Route::get('/', 'UserHomeController@home');

//==================== PRODUCT ====================

Route::get('product/detail/{id}', 'UserProductController@detail')->name('detail_product');

//==================== CAT PRODUCT ====================
Route::get('cat/product/{id}', 'UserCatProductController@show')->name('cat_product');
Route::post('cat/product/action', 'UserCatProductController@action');
Route::get('cat/product/{id}/{status_id}', 'UserCatProductController@getProductFilterStatus')->name('filter');

//==================== CART ===========================
Route::get('cart/show', 'UserCartController@show')->name('cart_show');
Route::get('cart/add/{id}', 'UserCartController@add')->name('cart_add');
Route::get('cart/remove/{rowId}', 'UserCartController@remove')->name('cart_remove');
Route::get('cart/destroy', 'UserCartController@destroy')->name('cart_destroy');
Route::get('cart/update', 'UserCartController@update');

//=================== FILE MANAGER ======================
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
}); 


