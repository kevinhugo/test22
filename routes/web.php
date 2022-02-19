<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', 'App\Http\Controllers\ItemController@index')->name('/');

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
        Route::post('delete', 'App\Http\Controllers\ItemController@deleteItem')->name('item.delete.item');
    });
});
