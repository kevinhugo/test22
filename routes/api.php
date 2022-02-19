<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('item')->group(function () {
    Route::post('save', 'App\Http\Controllers\ItemController@saveItem')->name('item.save');
    Route::get('detail', 'App\Http\Controllers\ItemController@getItemDetail')->name('item.detail');
    Route::prefix('get')->group(function () {
        Route::get('item-list', 'App\Http\Controllers\ItemController@getItemList')->name('item.get.item-list');
    });
    Route::prefix('update')->group(function () {
        Route::post('item', 'App\Http\Controllers\ItemController@updateItem')->name('item.update.item');
    });
    Route::prefix('delete')->group(function () {
        Route::post('item', 'App\Http\Controllers\ItemController@deleteItem')->name('item.delete.item');
    });
});