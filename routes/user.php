<?php


use App\Http\Controllers\Api\AdminApi\Category\CategoryController;
use App\Http\Controllers\Api\AdminApi\Product\ProductController;
use App\Http\Controllers\Api\UserApi\AuthUser\AuthUser;
use App\Http\Controllers\Api\UserApi\Cart\CartController;
use App\Http\Controllers\Api\UserApi\Order\OrderController;
use App\Http\Controllers\Api\UserApi\Testimonial\TestimonialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
################################################## Start Admin Api  ###############################################


Route::group(['prefix' => 'api'], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::post('login', [AuthUser::class, 'login']);
            Route::post('logout', [AuthUser::class, 'logout'])->middleware('auth.guard:user-api');

///////////////////////////////////////////////////Start User Api////////////////////////////////////////////////
################################################## Start User Api  ###############################################
        Route::get('/show_product/{id}', [CategoryController::class, 'show_product'])->middleware('auth.guard:user-api');
############################# Start Cart ###################################
        Route::post('cart', [CartController::class, 'addToMyCart']) ;
        Route::get('cartlist', [CartController::class, 'cartlist']) ;
        Route::post('update-cart', [CartController::class, 'updateCart']) ;
        Route::post('clear', [CartController::class, 'clearAllCart']) ;
        Route::post('cartremove/{product_id}', [CartController::class, 'removeCart']) ;
############################# End Cart ###################################
############################# Start Testimonial ###################################
//        Route::get('Testimonial', [TestimonialController::class, 'index'])->middleware('auth.guard:user-api');
        Route::post('Testimonial', [TestimonialController::class, 'create']) ->middleware('auth.guard:user-api');
############################# End Testimonial ###################################
        Route::get('/show_product_details/{id}', [ProductController::class, 'show_product_details'])->middleware('auth.guard:user-api');
        Route::post('/addOrder', [OrderController::class, 'addOrder'])->name('order.add')->middleware('auth.guard:user-api');
    });
});

################################################## End User Api    ###############################################
