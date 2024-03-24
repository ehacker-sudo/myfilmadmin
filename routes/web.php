<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RateController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', "login");
Route::redirect('/home', 'ytebox/table/search');
Auth::routes();

Route::controller(HomeController::class)->middleware('admin')->group(function () {
    Route::prefix('/ytebox')->group(function () {
        Route::prefix('/table')->group(function () {
            Route::get('/list', 'basic_table')->name('table.basic');
            Route::get('/search', 'data_table')->name('table.data');
            Route::get('/render', 'getApi')->name('render');
            Route::get('/details/{id?}', 'details')->name('table.detail');
            Route::get('/search/address', 'address')->name('table.search');  
            Route::post('ajax/address/district', 'renderDitrict')->name('table.render.district');    
            Route::post('ajax/address/ward', 'renderWard')->name('table.render.ward');      
        });
    });
});

Route::prefix('management')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::prefix('staff')->group(function () {
            Route::get('list', 'user_list')->name('manager.user');    
            Route::post('/create', 'create_user')->name('manager.create.user');
            Route::post('/validate/user/request', 'create_user_request')->name('manager.create.user.request');
            Route::post('edit/{user}', 'edit_user')->name('manager.edit.user');
            Route::post('/get/user/id', 'select_user_id')->name('manager.user.id');
            Route::get('/delete/{user}', 'delete_user')->name('manager.delete.user');
        });
    
        Route::prefix('api-token')->group(function () {
            Route::get('/list', 'apiKey')->name('manager.api.key');     
            Route::post('/create/info', 'create_token')->name('manager.create.token');
            Route::post('/validate/token/request', 'create_token_request')->name('manager.create.token.request');
            Route::post('/create/plain-text-token', 'create_personal_access_token')->name('manager.create.access.token');
            Route::post('/get/key-api/id', 'select_key_id')->name('manager.key.api.id');
            Route::post('/edit/{token}', 'edit_token')->name('manager.edit.token');
            Route::get('/delete/{token}', 'delete_token')->name('manager.delete.token'); 
        });
    });

    Route::controller(RateController::class)->group(function () {
        Route::prefix('rate')->group(function () {
            Route::get('/list', 'index')->name('manager.rate.index');     
            Route::post('/store/rate', 'store')->name('manager.rate.store');
            Route::post('/validate/rate/request', 'create_rate_request')->name('manager.create.rate.request');
            Route::post('/get/rate/id', 'show')->name('manager.rate.id');
            Route::post('/edit/{rate}', 'update')->name('manager.edit.rate');
            Route::get('/delete/{rate}', 'destroy')->name('manager.delete.rate'); 
        });
    });

    Route::controller(HistoryController::class)->group(function () {
        Route::prefix('history')->group(function () {
            Route::get('/list', 'index')->name('manager.history.index');     
            Route::post('/store/history', 'store')->name('manager.history.store');
            Route::post('/validate/history/request', 'create_history_request')->name('manager.create.history.request');
            Route::post('/get/history/id', 'show')->name('manager.history.id');
            Route::post('/edit/{history}', 'update')->name('manager.edit.history');
            Route::get('/delete/{history}', 'destroy')->name('manager.delete.history'); 
        });
    });

    Route::controller(WatchListController::class)->group(function () {
        Route::prefix('watchlist')->group(function () {
            Route::get('/list', 'index')->name('manager.watchlist.index');     
            Route::post('/store/watchlist', 'store')->name('manager.watchlist.store');
            Route::post('/validate/watchlist/request', 'create_watchlist_request')->name('manager.create.watchlist.request');
            Route::post('/get/watchlist/id', 'show')->name('manager.watchlist.id');
            Route::post('/edit/{watchlist}', 'update')->name('manager.edit.watchlist');
            Route::get('/delete/{watchlist}', 'destroy')->name('manager.delete.watchlist'); 
        });
    });

    Route::controller(CommentController::class)->group(function () {
        Route::prefix('comment')->group(function () {
            Route::get('/list', 'index')->name('manager.comment.index');     
            Route::post('/store/comment', 'store')->name('manager.comment.store');
            Route::post('/validate/comment/request', 'create_comment_request')->name('manager.create.comment.request');
            Route::post('/get/comment/id', 'show')->name('manager.comment.id');
            Route::post('/edit/{comment}', 'update')->name('manager.edit.comment');
            Route::get('/delete/{comment}', 'destroy')->name('manager.delete.comment'); 
        });
    });
});
