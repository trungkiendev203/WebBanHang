<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\LabelController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\PageController;

/*
|--------------------------------------------------------------------------
| CLIENT CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.post');

Route::get('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // CATEGORY
        Route::resource('category', AdminCategoryController::class);

        // LABEL
        Route::resource('label', LabelController::class);

        // PRODUCT
        Route::resource('product', AdminProductController::class);
        Route::get('product/image/delete/{id}',
            [AdminProductController::class, 'deleteImage']
        )->name('product.image.delete');

        // ORDER
        Route::get('/order', [AdminOrderController::class, 'index'])
            ->name('order.index');

        Route::get('/order/{id}', [AdminOrderController::class, 'show'])
            ->name('order.show');

        Route::put('/order/update-status/{id}',
            [AdminOrderController::class, 'updateStatus']
        )->name('order.updateStatus');

        // BILL
        Route::get('/bill', [BillController::class, 'index'])
            ->name('bill.index');

        Route::get('/bill/{id}', [BillController::class, 'show'])
            ->name('bill.show');

        Route::put('/bill/update/{id}', [BillController::class, 'update'])
            ->name('bill.update');
    });

/*
|--------------------------------------------------------------------------
| CLIENT PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/search', [HomeController::class, 'search'])
    ->name('client.search');

Route::get('/sale', [ClientCategoryController::class, 'sale'])
    ->name('client.sale');

Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])
    ->name('client.category');

Route::get('/san-pham/{slug}', [ClientProductController::class, 'show'])
    ->name('client.product.show');

/*
|--------------------------------------------------------------------------
| CLIENT AUTH (LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('client.auth.login');
})->name('client.login');

/*
|--------------------------------------------------------------------------
| CLIENT CART & CHECKOUT (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/


// CART
Route::get('/cart', [CartController::class, 'index'])
    ->name('client.cart');

Route::post('/cart/add', [CartController::class, 'add'])
    ->name('client.cart.add');

Route::post('/cart/update', [CartController::class, 'update'])
    ->name('client.cart.update');

Route::delete('/cart/delete/{variantId}', [CartController::class, 'delete'])
    ->name('client.cart.delete');
    

// HIỂN THỊ TRANG THANH TOÁN
Route::get('/cart/checkout', [OrderController::class, 'showCheckout'])
    ->name('client.checkout');

// XỬ LÝ ĐẶT HÀNG
Route::post('/cart/checkout', [OrderController::class, 'checkout'])
    ->name('checkout');

Route::post('/san-pham/{slug}', [ClientProductController::class, 'detail'])
    ->name('client.product.detail');
Route::get('/he-thong-cua-hang', [App\Http\Controllers\Client\PageController::class, 'storeSystem'])
    ->name('client.store-system');
Route::get('/chinh-sach-van-chuyen', [App\Http\Controllers\Client\PageController::class, 'shippingPolicy'])
    ->name('client.shipping-policy');

