<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthAdmin;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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




Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'guest:admin'], function () {
        Route::get('login', [AuthAdmin::class, 'login'])->name('admin.login');
        Route::post('login', [AuthAdmin::class, 'dologin'])->name('admin.dologin');

    });

    Route::group(['middleware' => 'auth:admin'], function () {
        Route::get('getAllAdmins',[AdminController::class, 'AllAdmins'])->name('admin.AllAdmins');
        Route::get('create',[AdminController::class, 'create'])->name('admin.create');
        Route::post('store',[AdminController::class, 'store'])->name('admin.admin.store');
        Route::get('/',[DashboardController::class, 'index'])->name('admin.dashboard');

    });
});
Route::get('logout', [AuthAdmin::class, 'logout'])->name('admin.logout');
//
//
//Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
//
//    Route::group(['middleware' => 'guest:admin'], function () {
//        Route::get('login', [AuthAdmin::class, 'login'])->name('admin.login');
//        Route::post('dologin', [AuthAdmin::class, 'dologin'])->name('admin.dologin');
//    });
//});
//Route::group(['middleware' => 'auth:admin'], function () {
//    Route::prefix('admin')->group(function(){
//        Route::get('/',[DashboardController::class, 'index'])->name('admin.dashboard');
//    });
//
//});
//
//
