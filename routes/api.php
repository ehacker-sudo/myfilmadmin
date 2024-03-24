<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\DonThuoc;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\V1\ApiToken;

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

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    }); 
});

Route::get('v1/don-thuoc/tim-kiem',[DonThuoc::class,'tim_kiem'])->middleware('auth:sanctum');

Route::get('v1/api-token',[ApiToken::class,'api_token'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->controller(UserController::class)->group(function () {
    Route::get('/comment', 'comment');
    Route::get('user/comment', 'show_comment');
    Route::post('/comment/store', 'comment_store');
    Route::delete('/comment/destroy', 'comment_destroy');
});