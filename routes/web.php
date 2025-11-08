<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

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
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin.auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});
Route::post('/api/admin/product', [ProductController::class, 'store']);
Route::get('/', function () {
    return view('welcome');
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('category', CategoryController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('label', App\Http\Controllers\Admin\LabelController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('product', App\Http\Controllers\Admin\ProductController::class);
    Route::get('product/image/delete/{id}', [App\Http\Controllers\Admin\ProductController::class, 'deleteImage'])
        ->name('product.image.delete');
});
// ===================== HÓA ĐƠN =====================
use App\Http\Controllers\Admin\OrderController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
});

