<?php


use App\Http\Controllers\Api\AdminApi\Admins\AdminController;
use App\Http\Controllers\Api\AdminApi\AuthAdmin;
use App\Http\Controllers\Api\AdminApi\Category\CategoryController;
use App\Http\Controllers\Api\AdminApi\DashboardController;
use App\Http\Controllers\Api\AdminApi\Orders\OrderController;
use App\Http\Controllers\Api\AdminApi\Partner\PartnerController;
use App\Http\Controllers\Api\AdminApi\Product\ProductController;
use App\Http\Controllers\Api\AdminApi\Testimonial\TestimonialController;
use App\Http\Controllers\Api\UserApi\Cart\CartController;
use App\Http\Controllers\Api\UserApi\HomeController;
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

    Route::group(['prefix' => 'admin'], function () {

        Route::post('login', [AuthAdmin::class, 'login']);
        Route::post('logout', [AuthAdmin::class, 'logout'])->middleware('auth.guard:apiAdmin');

    });


    Route::group(['middleware' => ['changelanguage','auth.guard:apiAdmin' ]], function () {



            ################### Start Admin Control Users #####################################
            Route::get('getAllAdmins', [AdminController::class, 'AllAdmins'])->name('admin.AllAdmins');
            Route::post('Admins/store', [AdminController::class, 'store'])->name('admin.admin.store');
            Route::get('Admins/edit/{id}', [AdminController::class, 'show'])->name('admin.show');
            Route::post('Admins/update/{id}', [AdminController::class, 'update'])->name('admin.update');
            Route::get('Admins/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
            Route::get('admin/changeStatus/{id}', [AdminController::class, 'changeStatus'])->name('admin.changeStatus');
            ################### End Admin Control Users #####################################
            ################### Start Category Control Dashboard #####################################
            Route::get('Admins/Category', [CategoryController::class, 'index']);
            Route::get('Admins/Category/show/{category_id}', [CategoryController::class, 'show']);
            Route::post('Admins/Category/store', [CategoryController::class, 'store'])->name('Category.store');
            Route::post('Admins/Category/update/{id}', [CategoryController::class, 'update'])->name('Category.update');
            Route::get('Admins/Category/destroy/{id}', [CategoryController::class, 'destroy'])->name('Category.destroy');
            ################### End Category Control Dashboard #####################################
            ################### Start Product Control Dashboard #####################################
            Route::resource('Admins/Product', ProductController::class);
            Route::post('Admins/Product/update/{id}', [ProductController::class, 'update'])->name('Product.update');
            Route::get('Admins/Product/destroy/{id}', [ProductController::class, 'destroy'])->name('Product.destroy');
            ################### End Product Control Dashboard #####################################
            ################### Start Partner Control Dashboard #####################################
            Route::resource('Admins/Partner', PartnerController::class);
            Route::post('Admins/Partner/update/{id}', [PartnerController::class, 'update'])->name('Partner.update');
            Route::get('Admins/Partner/destroy/{id}', [PartnerController::class, 'destroy'])->name('Partner.destroy');
            ################### End Partner Control Dashboard #####################################
            ################### Start Testimonial Control Dashboard #####################################
            Route::get('testimonial/showindex', [TestimonialController::class, 'ShowIndex'])->name('testimonial.showindex');
            Route::get('testimonial/{id}', [TestimonialController::class, 'destroy'])->name('testimonial.destroy');
            Route::get('changeStatus/{id}', [TestimonialController::class, 'changeStatus'])->name('testimonial.status');
            ################### End Testimonial Control Dashboard #####################################
            ################### Start Orders Control Dashboard #####################################
            Route::get('orders/showindex', [OrderController::class, 'ShowIndex'])->name('orders.showindex');
            Route::get('orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
            Route::get('showDetails/{id}', [OrderController::class, 'showDetails'])->name('orders.showDetails');
            Route::get('changeStatusToPay/{id}', [OrderController::class, 'changeStatusToPay'])->name('orders.changeStatusToPay');
            Route::get('changeStatusToDelivered/{id}', [OrderController::class, 'changeStatusToDelivered'])->name('orders.changeStatusToDelivered');
            ################### End Orders Control Dashboard #####################################



################################################## End Admin Api  ###############################################
///////////////////////////////////////////////////End Admin Api/////////////////////////////////////////////////

#################################################################################################################

        });
///////////////////////////////////////////////////Start User Api////////////////////////////////////////////////
################################################## Start User Api  ###############################################



        Route::get('/show_product/{id}', [CategoryController::class, 'show_product'])->middleware('auth');

############################# Start Cart ###################################
//Route::get('cart', [CartController::class, 'cartList'])->name('cart.list');
////Route::post('cart', [CartController::class, 'addToCart'])->name('cart.store');
//Route::post('cart', [CartController::class, 'addToMyCart'])->name('cart.storetocart');
        Route::post('update-cart', [CartController::class, 'updateCart'])->name('cart.update');
//Route::post('remove', [CartController::class, 'removeCart'])->name('cart.remove');
        Route::post('clear', [CartController::class, 'clearAllCart'])->name('cart.clear');


        Route::post('cart', [CartController::class, 'addToMyCart'])->name('cart.storetocart');
        Route::get('cartlist', [CartController::class, 'cartlist'])->name('cart.cartlist');
        Route::post('cartremove/{product_id}', [CartController::class, 'removeCart'])->name('cart.remove');
//Route::post('update-cart/{product_id}', [CartController::class, 'updateCart'])->name('cart.update');
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
