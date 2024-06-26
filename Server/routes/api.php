<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;

// Handling unauthenticated routes
Route::get( '/unauthenticated', [AuthController::class, 'unauthenticated'])->name('login');

// Unauthenticated routes
Route::post("register-normal-user", [AuthController::class, "registerNormalUser"]);
Route::post("login", [AuthController::class, "login"]);
Route::get( 'search', [SearchController::class, 'searchAllModels']);
Route::get( 'search-products', [SearchController::class, 'searchProducts']);

// Products
Route::get('/products', [ProductController::class, 'getProducts']);
Route::get('/products/{id}', [ProductController::class, 'singleProduct']);

Route::group([
    "middleware" => ["auth:api", "role:normal_user"]
], function(){
    // User data
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refresh", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);

    // Mpesa
    Route::post('/mpesa/stk-push', [MpesaController::class, 'stkPush']);
});

// Super_Admin Routes
Route::group([
    "middleware" => ["auth:api", "role:super_admin"]
], function(){
    // Register admin and check users
    Route::post("register-admin", [AuthController::class, "registerAdmin"]);
    Route::get("users", [AuthController::class, "indexUsers"]);

    // Super_Admin data
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refresh", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);

    // Mpesa
    Route::get('/mpesa/access-token', [MpesaController::class, 'getAccessToken']);

    // Whitelist Ip
    Route::post("register-super-admin", [AuthController::class, "registerSuperAdmin"]);
});

Route::group([
    "middleware" => ["auth:api", "role:admin"]
], function(){
    // Admin data
    Route::get("profile", [AuthController::class, "profile"]);
    Route::get("refresh", [AuthController::class, "refreshToken"]);
    Route::get("logout", [AuthController::class, "logout"]);

    // Products
});


// Category 
Route::get('/categories', [CategoryController::class, 'indexCategories']);
Route::get('/categories/{id}', [CategoryController::class, 'singleCategory']);
Route::post('/categories', [CategoryController::class, 'storeCategory']);
Route::put('/categories/{id}', [CategoryController::class, 'updateCategory']);

// Check on it later 
Route::delete('/categories/{id}', [CategoryController::class, 'destroyCategory']);


// Cart
Route::get('/carts', [CartController::class, 'indexCarts']);
Route::get('/carts/{id}', [CartController::class, 'showCart']);
Route::post('/carts', [CartController::class, 'storeCart']);
Route::put('/carts/{id}', [CartController::class, 'updateCart']);
Route::delete('/carts/{id}', [CartController::class, 'destroyCart']);

// Order
Route::get('/orders', [OrderController::class, 'indexOrders']);
Route::get('/orders/{id}', [OrderController::class, 'showOrder']);
Route::post('/orders', [OrderController::class, 'storeOrder']);
Route::delete('/orders/{id}', [OrderController::class, 'destroyOrder']);

// OrderItem
Route::get('/order-items', [OrderItemController::class, 'indexOrderItems']);
Route::get('/order-items/{id}', [OrderItemController::class, 'showOrderItem']);
Route::post('/order-items', [OrderItemController::class, 'storeOrderItem']);
Route::put('/order-items/{id}', [OrderItemController::class, 'updateOrderItem']);
Route::delete('/orders/{id}', [OrderItemController::class, 'destroyOrderItem']);

// Payment
Route::get('/payments', [PaymentController::class, 'indexPayments']);
Route::get('/payments/{id}', [PaymentController::class, 'showPayment']);
Route::post('/payments', [PaymentController::class, 'storePayments']);
Route::put('/payments/{id}', [PaymentController::class, 'updatePayment']);
Route::delete('/payments/{id}', [PaymentController::class, 'destroyPayment']);

