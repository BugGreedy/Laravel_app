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
    // return view('welcome');  下記に編集
    return redirect('/articles');
});

// 一覧表示
Route::get('/articles', 'ArticleController@index')->name('article.list');
// 新規作成
Route::get('/article/new', 'ArticleController@create')->name('article.new');
// 記事の投稿
Route::post('/article', 'ArticleController@store')->name('article.store');

// 記事の編集
Route::get('/article/edit/{id}', 'ArticleController@edit')->name('article.edit');
Route::post('/article/update/{id}', 'ArticleController@update')->name('article.update');

// 詳細表示
Route::get('/article/{id}', 'ArticleController@show')->name('article.show');
// 記事の削除
Route::delete('/article/{id}', 'ArticleController@destroy')->name('article.delete');
