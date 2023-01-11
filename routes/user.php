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

        });


///////////////////////////////////////////////////Start User Api////////////////////////////////////////////////
################################################## Start User Api  ###############################################



        Route::get('/show_product/{id}', [CategoryController::class, 'show_product'])->middleware('auth');

############################# Start Cart ###################################
        Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
        Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
        Route::post('cart', [CartController::class, 'addToMyCart'])->name('cart.storetocart');
        Route::get('cartlist', [CartController::class, 'cartlist'])->name('cart.cartlist');
        Route::post('cartremove/{product_id}', [CartController::class, 'removeCart'])->name('cart.remove');
############################# End Cart ###################################

############################## Start Testimonial ###################################
        Route::get('Testimonial', [TestimonialController::class, 'index'])->name('Testimonial')->middleware('auth');
        Route::post('Testimonial', [TestimonialController::class, 'create'])->name('create.Testimonial')->middleware('auth');

############################# End Testimonial ###################################

        Route::get('/show_product_details/{id}', [ProductController::class, 'show_product_details'])->middleware('auth');
        Route::post('/addOrder', [OrderController::class, 'addOrder'])->name('order.add')->middleware('auth');
        Route::get('product-Order', [OrderController::class, 'getOrderById']);

    });


################################################## End User Api    ###############################################
