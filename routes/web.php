<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;     // Admin category
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BillController;

/*
|--------------------------------------------------------------------------
| CLIENT CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;   // ⭐ KHÔNG TRÙNG


/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (prefix + middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CATEGORY
        Route::resource('category', CategoryController::class);

        // LABEL
        Route::resource('label', LabelController::class);

        // PRODUCT
        Route::resource('product', ProductController::class);
        Route::get('product/image/delete/{id}', [ProductController::class, 'deleteImage'])
            ->name('product.image.delete');

        // ORDER
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
        Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
        Route::put('/order/update-status/{id}', [OrderController::class, 'updateStatus'])->name('order.updateStatus');

        // BILL
        Route::get('/bill', [BillController::class, 'index'])->name('bill.index');
        Route::get('/bill/{id}', [BillController::class, 'show'])->name('bill.show');
        Route::put('/bill/update/{id}', [BillController::class, 'update'])->name('bill.update');
    });


/*
|--------------------------------------------------------------------------
| CLIENT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('client.search');

// ⭐ DANH MỤC CLIENT — KHÔNG ẢNH HƯỞNG ADMIN
Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])
    ->name('client.category');
    Route::get('/san-pham/{slug}', [ProductController::class, 'detail'])
    ->name('product.detail');
Route::get('/sale', [ClientCategoryController::class, 'sale'])->name('client.sale');

