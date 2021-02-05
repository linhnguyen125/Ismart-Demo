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
});

Route::middleware(['auth', 'verified', 'checkRole:21'])->group(function () {


    //=================================================
    //================ DASHBOARD ======================
    //=================================================

    Route::get('dashboard', 'DashboardController@show');
    Route::get('admin', 'DashboardController@show');

    Route::middleware(['checkRole:18'])->group(function () { // thêm user
        Route::get('admin/user/list', 'AdminUserController@list');
        Route::get('admin/user/add', 'AdminUserController@add');
        Route::post('admin/user/store', 'AdminUserController@store');
    });
    Route::middleware(['checkRole:20'])->group(function () { // xóa user
        Route::get('admin/user/list', 'AdminUserController@list');
        Route::post('admin/user/action', 'AdminUserController@action');
        Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('delete_user');
        Route::get('admin/user/forceDelete/{id}', 'AdminUserController@forceDelete')->name('forceDelete_user');
    });
    Route::middleware(['checkRole:22'])->group(function () { // Sửa user
        Route::get('admin/user/list', 'AdminUserController@list');
        Route::get('admin/user/edit/{id}', 'AdminUserController@edit')->name('edit_user');
        Route::post('admin/user/update/{id}', 'AdminUserController@update')->name('update_user');
    });
    Route::middleware(['checkRole:19'])->group(function () { // xem user
        Route::get('admin/user/list', 'AdminUserController@list');
    });



    Route::middleware(['checkRole:5'])->group(function () { // thêm bài viết
        Route::get('admin/post/list', 'AdminPostController@list');
        Route::get('admin/post/add', 'AdminPostController@add');
        Route::post('admin/post/store', 'AdminPostController@store');
        Route::post('admin/post/cat/store', 'AdminPostController@catStore');
    });
    Route::middleware(['checkRole:6'])->group(function () { // sửa bài viết
        Route::get('admin/post/list', 'AdminPostController@list');
        Route::get('admin/post/edit/{id}', 'AdminPostController@edit')->name('edit_post');
        Route::post('admin/post/update/{id}', 'AdminPostController@update')->name('update_post');
        Route::get('admin/post/cat/edit/{id}', 'AdminPostController@editCat')->name('edit_post_cat');
        Route::post('admin/post/cat/update/{id}', 'AdminPostController@updateCat')->name('update_post_cat');
    });
    Route::middleware(['checkRole:7'])->group(function () { // xóa bài viết
        Route::get('admin/post/list', 'AdminPostController@list');
        Route::get('admin/post/delete/{id}', 'AdminPostController@delete')->name('delete_post');
        Route::get('admin/post/forceDelete/{id}', 'AdminPostController@forceDelete')->name('forceDelete_post');
        Route::post('admin/post/action', 'AdminPostController@action');
        Route::get('admin/post/cat/delete/{id}', 'AdminPostController@deleteCat')->name('delete_post_cat');
    });
    Route::middleware(['checkRole:8'])->group(function () { // xem bài viết
        Route::get('admin/post/list', 'AdminPostController@list');
        Route::get('admin/post/cat/list', 'AdminPostController@listCat');
    });
    Route::middleware(['checkRole:1'])->group(function () {  // thêm sản phẩm
        Route::get('admin/product/list', 'AdminProductController@list');
        Route::get('admin/product/add/thumbnail/{id}', 'AdminProductController@addThumbnail')->name('add_thumbnail');
        Route::post('admin/product/storeThumbnail/{id}', 'AdminProductController@storeThumbnail')->name('storeThumbnail');
        Route::get('admin/product/add', 'AdminProductController@add');
        Route::post('admin/product/store', 'AdminProductController@store');
        Route::post('admin/product/cat/store', 'AdminProductController@catStore');
        Route::get('admin/product/cat/list', 'AdminProductController@listCat');
    });
    Route::middleware(['checkRole:2'])->group(function () { // sửa sản phẩm
        Route::get('admin/product/list', 'AdminProductController@list');
        Route::get('admin/product/edit/thumbnail/{id}', 'AdminProductController@editThumbnail')->name('edit_thumbnail');
        Route::post('admin/product/update/thumbnail/{id}', 'AdminProductController@updateThumbnail')->name('update_thumbnail');
        Route::get('admin/product/edit/{id}', 'AdminProductController@edit')->name('edit_product');
        Route::post('admin/product/update/{id}', 'AdminProductController@update')->name('update_product');
        Route::get('admin/product/cat/edit/{id}', 'AdminProductController@editCat')->name('edit_product_cat');
        Route::post('admin/product/cat/update/{id}', 'AdminProductController@updateCat')->name('update_product_cat');
    });
    Route::middleware(['checkRole:3'])->group(function () { // xóa sản phẩm
        Route::get('admin/product/list', 'AdminProductController@list');
        Route::post('admin/product/action', 'AdminProductController@action');
        Route::get('admin/product/delete/thumbnail/{id}', 'AdminProductController@deleteThumbnail')->name('delete_thumbnail');
        Route::get('admin/product/delete/{id}', 'AdminProductController@delete')->name('delete_product');
        Route::get('admin/product/forceDelete/{id}', 'AdminProductController@forceDelete')->name('forceDelete_product');
        Route::get('admin/product/cat/delete/{id}', 'AdminProductController@deleteCat')->name('delete_product_cat');
    });
    Route::middleware(['checkRole:4'])->group(function () { // xem sản phẩm
        Route::get('admin/product/list', 'AdminProductController@list');
    });


    Route::middleware(['checkRole:9'])->group(function () { // xem đơn hàng
        Route::get('admin/order/list', 'AdminOrderController@list');
        Route::get('admin/order/detail/{id}', 'AdminOrderController@detail')->name('detail_order');
    });
    Route::middleware(['checkRole:10'])->group(function () { // cập nhật trạng thái
        Route::get('admin/order/list', 'AdminOrderController@list');
        Route::post('admin/order/store/{id}', 'AdminOrderController@store')->name('order_store');
    });
    Route::middleware(['checkRole:11'])->group(function () { // hủy đơn hàng
        Route::get('admin/order/list', 'AdminOrderController@list');
        Route::get('admin/order/forceDelete/{id}', 'AdminOrderController@forceDelete')->name('forceDelete_order');
        Route::get('admin/order/delete/{id}', 'AdminOrderController@delete')->name('delete_order');
        Route::post('admin/order/action', 'AdminOrderController@action');
    });


    Route::middleware(['checkRole:12'])->group(function () { // thêm banner
        Route::get('admin/banner/list', 'AdminBannerController@list');
        Route::post('admin/banner/store', 'AdminBannerController@store');
    });
    Route::middleware(['checkRole:13'])->group(function () { // sửa banner
        Route::get('admin/banner/list', 'AdminBannerController@list');
        Route::get('admin/banner/edit/{id}', 'AdminBannerController@edit')->name('edit_banner');
        Route::post('admin/banner/update/{id}', 'AdminBannerController@update')->name('update_banner');
    });
    Route::middleware(['checkRole:14'])->group(function () { // xóa banner
        Route::get('admin/banner/list', 'AdminBannerController@list');
        Route::get('admin/banner/delete/{id}', 'AdminBannerController@delete')->name('delete_banner');
    });
    Route::middleware(['checkRole:15'])->group(function () { // xem banner
        Route::get('admin/banner/list', 'AdminBannerController@list');
    });


    Route::middleware(['adminStator:1'])->group(function () { // AdminStator
        Route::get('admin/role/list', 'AdminRoleController@list');
        Route::post('admin/role/store', 'AdminRoleController@store')->name('storeRole');
        Route::get('admin/role/updatePermission', 'AdminRoleController@updatePermission');
        Route::get('admin/role/updatePermission', 'AdminRoleController@updatePermission');
        Route::get('admin/role/delete/{id}', 'AdminRoleController@delete')->name('delete_role');
        Route::get('admin/role/edit/{id}', 'AdminRoleController@edit')->name('edit_role');
        Route::post('admin/role/update/{id}', 'AdminRoleController@update')->name('updateRole');
    });
});



//==================================================
//===================== USER =======================
//==================================================



//=================== PAGE =======================

Route::get('page/blog', 'UserPageController@blog');
Route::get('page/blog/detail/{id}', 'UserPageController@detail_blog')->name('detail_blog');

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
Route::get('cart/update', 'UserCartController@update')->name('cart_update');;
Route::get('cart/checkout/{productId}', 'UserCartController@buyNow')->name('buy_now');

//==================== INTRODUCE =====================
Route::get('introduce', 'UserIntroduceController@introduce');

//==================== CONTACT =====================
Route::get('contact', 'UserContactController@contact');

//==================== CHECKOUT =====================
Route::get('checkout/show', 'UserCheckoutController@show');
Route::get('checkout/updateDistrict', 'UserCheckoutController@updateDistrict')->name('update_District');
Route::get('checkout/updateWard', 'UserCheckoutController@updateWard')->name('update_Ward');
Route::get('checkout/order', 'UserCheckoutController@order');
Route::post('checkout/store', 'UserCheckoutController@store')->name('store_checkout');
Route::get('mail/orderInfo', 'SendMailController@sendMail');

//=================== SEARCH ========================

Route::get('autocomplete-ajax', 'UserHomeController@autocomplete')->name('autocomplete-ajax');
Route::post('search', 'UserHomeController@search');

//=================== FILE MANAGER ======================
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
