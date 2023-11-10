<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\OrderController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// products 
Route::get('products', [ProductController::class, 'index']);
Route::post('products',[ProductController::class, 'store']);
Route::get('products/{id}',[ProductController::class, 'show']);
Route::put('products/{id}',[ProductController::class, 'edit']);
Route::delete('products/{id}',[ProductController::class, 'destroy']);

// orders
Route::get('orders/', [OrderController::class, 'index']);
Route::post('orders/', [OrderController::class, 'store']);
Route::get('orders/{id}', [OrderController::class, 'show']);
Route::put('orders/{id}', [OrderController::class, 'edit']);
Route::delete('orders/{id}', [OrderController::class, 'destroy']);
