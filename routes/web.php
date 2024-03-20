<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

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

Route::prefix('management')->controller(UserController::class)->group(function () {

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
