<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SelectedProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




Route::get('/products', [ProductController::class, 'getProduct']);
Route::get('/products/{id}', [ProductController::class, 'singleProduct']);

Route::post('/register', [UserController::class, 'createUser']);
Route::post('/login', [UserController::class, 'login']);



Route::group([
    "middleware" => ["auth:api"]
], function(){
    Route::get('/profile/{id}', [UserController::class, 'profile']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/forgot', [UserController::class, 'forgotPassword']);
    Route::post('/order', [OrderController::class, 'createOrder']);
    Route::post('/addcart', [SelectedProductsController::class, 'create']);
    
    
    
});


Route::group([
    "middleware" => ["auth:api", "admin"]
], function(){
    Route::get('/admin/products', [ProductController::class, 'getproduct']);
    Route::post('/admin/addproduct', [ProductController::class, 'addProduct']);
    Route::get('/admin/users', [UserController::class,'allUser']);
    Route::get('/admin/singlecustomer/{id}', [UserController::class, 'singleCustomer']);
    Route::put('admin/updateuser', [UserController::class, 'editUser']);
    Route::delete('/admin/deleteuser/{id}', [UserController::class, 'deleteUser']);
    Route::delete('/admin/deleteproduct/{id}', [ProductController::class, 'deleteProduct']);
    Route::put('/admin/updateproduct', [ProductController::class,'editProduct']);

    //orders
    Route::get('/number', [OrderController::class, 'numberOfOrders']);
});

// Mpesa
Route::get('/mpesa/access-token', [MpesaController::class, 'getAccessToken']);
Route::post('/mpesa/stk-push', [MpesaController::class, 'stkPush']);

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




