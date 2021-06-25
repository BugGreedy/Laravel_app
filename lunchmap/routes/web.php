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
// 下記を追加
Route::get('/shops', 'ShopController@index')->name('shop.list');

Route::get('/', function () {
    // 下記も変更する
    // return view('welcome');
    return redirect('/shops');
});
