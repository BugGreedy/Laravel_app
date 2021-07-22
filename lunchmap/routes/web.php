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
Route::get('/shops', 'ShopController@index')->name('shop.list');

// 新規投稿
Route::get('/shop/new', 'ShopController@create')->name('shop.new');
Route::post('/shop', 'ShopController@store')->name('shop.store');

// 編集と更新
Route::get('/shop/edit/{id}','ShopController@edit')->name('shop.edit');
Route::post('/shop/update/{id}','ShopController@update')->name('shop.update');

// 詳細
Route::get('/shop/{id}', 'ShopController@show')->name('shop.detail');

// 下記を追加 削除
Route::delete('/shop/{id}','ShopController@destroy')->name('shop.destroy');

Route::get('/', function () {
    return redirect('/shops');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
