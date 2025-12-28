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
use App\Http\Controllers\Client\CheckoutController;

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
        //COLLECTION
        Route::resource('collection', \App\Http\Controllers\Admin\CollectionController::class);

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

/*
|--------------------------------------------------------------------------
| CLIENT AUTH (LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/login', [\App\Http\Controllers\Client\AuthController::class, 'showLogin'])
    ->name('client.login');

/*
|--------------------------------------------------------------------------
| CLIENT CART & CHECKOUT
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

Route::post('/buy-now', [CartController::class, 'buyNow'])
    ->name('client.buy.now');

// ✅ CHECKOUT - ĐẶT TRƯỚC CÁC ROUTE CÓ {slug}
Route::get('/checkout', [CheckoutController::class, 'checkout'])
    ->name('client.checkout');

Route::post('/checkout', [CheckoutController::class, 'store'])
    ->name('client.checkout.store');

/*
|--------------------------------------------------------------------------
| CLIENT PAGES
|--------------------------------------------------------------------------
*/
Route::get('/he-thong-cua-hang', [PageController::class, 'storeSystem'])
    ->name('client.store-system');

Route::get('/chinh-sach-van-chuyen', [PageController::class, 'shippingPolicy'])
    ->name('client.shipping-policy');

/*
|--------------------------------------------------------------------------
| CLIENT DYNAMIC ROUTES (ĐẶT CUỐI CÙNG)
|--------------------------------------------------------------------------
*/
Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])
    ->name('client.category');

Route::get('/san-pham/{slug}', [ClientProductController::class, 'show'])
    ->name('client.product.show');

Route::post('/san-pham/{slug}', [ClientProductController::class, 'detail'])
    ->name('client.product.detail');

Route::get('/collection/{slug}', 
    [\App\Http\Controllers\Client\CollectionController::class, 'show']
)->name('client.collection.show');