<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('products/getAll', [ProductController::class,'getAllProducts']);
Route::get('products/getProduct/{id}', [ProductController::class,'getProductForId']);
Route::post('products/insert', [ProductController::class,'insertProduct']);
Route::post('products/searchProduct', [ProductController::class,'searchProductForName']);
Route::put('products/update/{id}', [ProductController::class,'updateProduct']);
Route::delete('products/delete/{id}', [ProductController::class,'deleteProduct']);
