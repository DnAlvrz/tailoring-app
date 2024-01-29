<?php
namespace App\Http\Controllers\API;
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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// Test
// Route::middleware('auth:api')->get('/test', function(Request $request) {
//     return 'hello';
// });

// Images
Route::post('images/products', [ImageController::class, 'store']);

// Products
Route::get('products', [ProductController::class, 'index']);
Route::middleware('auth:api')->post('products',[ProductController::class, 'store']);
Route::get('products/{id}',[ProductController::class, 'show']);
Route::middleware('auth:api')->put('products/{id}',[ProductController::class, 'edit']);
Route::middleware('auth:api')->delete('products/{id}',[ProductController::class, 'destroy']);
Route::get('products/category/{category}',[ProductController::class, 'category']);

// Orders
Route::get('orders/', [OrderController::class, 'index']);
Route::middleware('auth:api')->post('orders/', [OrderController::class, 'store']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::put('orders/{id}', [OrderController::class, 'edit']);
Route::delete('orders/{id}', [OrderController::class, 'destroy']);
Route::middleware('auth:api')->put('orders/{id}/status', [OrderController::class, 'updateStatus']);
Route::middleware('auth:api')->put('orders/{userId}/', [OrderController::class, 'userOrders']);

// Product orders
Route::get('product-orders/', [ProductOrderController::class, 'index']);
Route::middleware('auth:api')->post('product-orders/', [ProductOrderController::class, 'store']);
Route::get('product-orders/{id}', [ProductOrderController::class, 'show']);
Route::middleware('auth:api')->put('product-orders/{id}', [ProductOrderController::class, 'edit']);
Route::middleware('auth:api')->delete('product-orders/{id}', [ProductOrderController::class, 'destroy']);

Route::get('rating/', [RatingController::class, 'index']);
Route::middleware('auth:api')->post('rating/', [RatingController::class, 'store']);
Route::get('rating/{id}', [RatingController::class, 'show']);
Route::middleware('auth:api')->put('rating/{id}', [RatingController::class, 'edit']);
Route::middleware('auth:api')->delete('rating/{id}', [RatingController::class, 'destroy']);

//User
Route::middleware('auth:api')->get('user/{id}/orders', [UserController::class, 'userOrders']);
Route::middleware('auth:api')->get('user/list', [UserController::class, 'index']);
