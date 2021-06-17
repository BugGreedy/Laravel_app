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

Route::get('/', function () {
    return view('welcome');
});

// 下記を追記
// 下記は①記事一覧のルート
Route::get('/articles','ArticleController@index')->name('article.list');
// 下記を試してみたけどできなかった。
// Route::get('/articles', 'app\Http\Controllers\articleController@index')->name('article.list');


// 下記は記事詳細のルート
Route::get('/article/{id}','ArticleController@show')->name('article.show');
