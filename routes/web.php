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
use App\Http\Controllers\Admin\CollectionController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\GoogleController;


/*
|--------------------------------------------------------------------------
| CLIENT CONTROLLERS
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ChatbotController;
use App\Http\Controllers\Client\EventClientController;
use App\Http\Controllers\Client\AuthController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\OrderController;
/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // COLLECTION
        Route::resource('collection', CollectionController::class);

        // CATEGORY
        Route::resource('category', AdminCategoryController::class);

        // LABEL
        Route::resource('label', LabelController::class);

        // PRODUCT
        Route::resource('product', AdminProductController::class);
        Route::get('product/image/delete/{id}', [AdminProductController::class, 'deleteImage'])
            ->name('product.image.delete');
Route::get('/event', [EventController::class, 'index'])
    ->name('event.index');

Route::get('/event/create', [EventController::class, 'create'])
    ->name('event.create');

Route::post('/event/store', [EventController::class, 'store'])
    ->name('event.store');

Route::get('/event/edit/{id}', [EventController::class, 'edit'])
    ->name('event.edit');

Route::post('/event/update/{id}', [EventController::class, 'update'])
    ->name('event.update');

Route::post('/event/toggle/{id}', [EventController::class, 'toggle'])
    ->name('event.toggle');


        /*
        |--------------------------------------------------------------------------
        | ORDER (Admin xác nhận)
        |--------------------------------------------------------------------------
        */
        Route::get('/order', [AdminOrderController::class, 'index'])->name('order.index');
        Route::get('/order/{id}', [AdminOrderController::class, 'show'])->name('order.show');

        // ✅ Nút "Xác nhận đơn" (0 -> 1) => đơn sẽ xuất hiện ở trang /admin/shipping
        Route::post('/order/{id}/confirm', [AdminOrderController::class, 'confirm'])->name('order.confirm');

        // Nếu bạn vẫn muốn giữ dropdown update status cũ thì giữ route này
        Route::put('/order/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('order.updateStatus');

        /*
        |--------------------------------------------------------------------------
        | SHIPPING (Vận chuyển xử lý)
        |--------------------------------------------------------------------------
        */
// SHIPPING (đúng controller)
Route::get('/shipping', [ShippingController::class, 'index'])->name('shipping.index');
Route::post('/shipping/{id}/pickup', [ShippingController::class, 'pickup'])->name('shipping.pickup');
Route::post('/shipping/{id}/delivered', [ShippingController::class, 'delivered'])->name('shipping.delivered');


        /*
        |--------------------------------------------------------------------------
        | BILL
        |--------------------------------------------------------------------------
        */
        Route::get('/bill', [BillController::class, 'index'])->name('bill.index');
        Route::get('/bill/{id}', [BillController::class, 'show'])->name('bill.show');
        Route::put('/bill/update/{id}', [BillController::class, 'update'])->name('bill.update');
    });

/*
|--------------------------------------------------------------------------
| CLIENT PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('client.search');
Route::get('/sale', [ClientCategoryController::class, 'sale'])->name('client.sale');

/*
|--------------------------------------------------------------------------
| CLIENT AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('auth:customer')->group(function () {
    Route::get('/tai-khoan', function () {
        return view('client.account.index');
    })->name('client.account');
});

// Hiển thị trang đăng nhập + đăng ký
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('client.login');

// Xử lý đăng nhập
Route::post('/login', [AuthController::class, 'login'])
    ->name('customer.login');

// Xử lý đăng ký (cùng trang)
Route::post('/register', [AuthController::class, 'register'])
    ->name('customer.register');

// Đăng xuất
Route::get('/logout', [AuthController::class, 'logout'])
    ->name('customer.logout');

/*
|--------------------------------------------------------------------------
| CLIENT CART & CHECKOUT
|--------------------------------------------------------------------------
*/
Route::get('/cart', [CartController::class, 'index'])->name('client.cart');
Route::post('/cart/add', [CartController::class, 'add'])->name('client.cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('client.cart.update');
Route::delete('/cart/delete/{variantId}', [CartController::class, 'delete'])->name('client.cart.delete');
Route::post('/buy-now', [CartController::class, 'buyNow'])->name('client.buy.now');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('client.checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('client.checkout.store');

/*
|--------------------------------------------------------------------------
| CLIENT PAGES
|--------------------------------------------------------------------------
*/
Route::get('/he-thong-cua-hang', [PageController::class, 'storeSystem'])->name('client.store-system');
Route::get('/chinh-sach-van-chuyen', [PageController::class, 'shippingPolicy'])->name('client.shipping-policy');

/*
|--------------------------------------------------------------------------
| CHATBOT
|--------------------------------------------------------------------------
*/
Route::post('/chatbot/suggest', [ChatbotController::class, 'suggest'])->name('chatbot.suggest');
Route::get('/chatbot/test-products', [ChatbotController::class, 'testProducts']);

/*
|--------------------------------------------------------------------------
| CLIENT DYNAMIC ROUTES (ĐẶT CUỐI)
|--------------------------------------------------------------------------
*/
Route::get('/danh-muc/{slug}', [ClientCategoryController::class, 'show'])->name('client.category');
Route::get('/san-pham/{slug}', [ClientProductController::class, 'show'])->name('client.product.show');
Route::post('/san-pham/{slug}', [ClientProductController::class, 'detail'])->name('client.product.detail');

Route::get('/collection/{slug}', [\App\Http\Controllers\Client\CollectionController::class, 'show'])
    ->name('client.collection.show');
Route::get('/event/{id}', [EventClientController::class, 'index'])
    ->name('client.event.index');
    Route::middleware('auth:customer')->group(function () {
    Route::get('/tai-khoan', [AccountController::class, 'index'])->name('client.account');
    Route::post('/tai-khoan', [AccountController::class, 'update'])->name('client.account.update');
});
Route::middleware('auth:customer')->group(function () {

    Route::get('/tai-khoan/dia-chi', [AddressController::class, 'index'])
        ->name('client.address');

    Route::post('/tai-khoan/dia-chi', [AddressController::class, 'store'])
        ->name('client.address.store');

    Route::post('/tai-khoan/dia-chi/{id}/default', [AddressController::class, 'setDefault'])
        ->name('client.address.default');

    Route::delete('/tai-khoan/dia-chi/{id}', [AddressController::class, 'destroy'])
        ->name('client.address.delete');
});
use App\Http\Controllers\Client\MomoController;

Route::get('/momo/return', [MomoController::class, 'return'])->name('momo.return');
Route::post('/momo/ipn', [MomoController::class, 'ipn'])->name('momo.ipn');

Route::prefix('momo')->group(function () {
    Route::get('/fake-success/{order}', [MomoController::class, 'fakeSuccess'])
        ->name('momo.fake.success');
});
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
Route::middleware('auth:customer')->group(function () {
    Route::get('/don-hang-cua-toi', [OrderController::class, 'myOrders'])
        ->name('client.order.my');
    Route::get('/don-hang-cua-toi/{id}', [OrderController::class, 'myOrderDetail'])
        ->name('client.order.detail');
});

