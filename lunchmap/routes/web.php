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
// 下記を追加【詳細ページ)
Route::get('/shop/{id}','ShopController@show')->name('shop.detail');

Route::get('/', function () {
    return redirect('/shops');
});

