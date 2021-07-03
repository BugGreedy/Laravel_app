## Laravel入門編4: 実用的なLaravelアプリを作ろう (全13回)

### 目次
[4-1_アプリの概要を整理しよう](#4-1_アプリの概要を整理しよう)</br>
[4-2_アプリケーションディレクトリを用意しよう](#4-2_アプリケーションディレクトリを用意しよう)</br>
[4-3_モデルとコントローラを用意しよう](#4-3_モデルとコントローラを用意しよう)</br>
[4-4_お店とカテゴリのテーブルを関連付けよう](#4-4_お店とカテゴリのテーブルを関連付けよう)</br>
[※ エラー対処1_テーブルのリレーションについて、カリキュラムのまま記述するとつながらなかった件](#エラー対処1_テーブルのリレーションについて、カリキュラムのまま記述するとつながらなかった件)</br>
[4-5_お店一覧ページを作ろう](#4-5_お店一覧ページを作ろう)</br>
[4-6_共通テンプレートにBootstrapを導入しよう](#4-6_共通テンプレートにBootstrapを導入しよう)</br>
[4-7_お店の詳細ページを作ろう](#4-7_お店の詳細ページを作ろう)</br>
[4-8_新規投稿フォームを作ろう](#4-8_新規投稿フォームを作ろう)</br>
[エラー対処_2_フォームが見つからないエラー"Class_"Form"_not_found"](#エラー対処_2_フォームが見つからないエラー"Class_"Form"_not_found")</br>
[4-9_投稿フォームの内容を保存しよう](#4-9_投稿フォームの内容を保存しよう)</br>
[4-10_お店の編集フォームを作ろう](#4-10_お店の編集フォームを作ろう)</br>
[4-11_編集内容を更新しよう](#4-11_編集内容を更新しよう)</br>
[4-12_お店の情報を削除しよう](#4-12_お店の情報を削除しよう)</br>


</br>

***
</br>

### 4-1_アプリの概要を整理しよう
このレッスンではおすすめのお店を投稿できる「ランチマップ」アプリを開発する。</br>
今回はアプリの機能を整理する。</br>
</br>

* アプリ名：lunchmap</br>
  - 投稿をリストで表示</br>
  - 詳細ページにgoogle Mapで地図を表示</br>
</br>

* DB構成
  - shopsテーブル
    | id |  |
    | - | - |
    | 店名 | name |
    | 住所 | address |
    | カテゴリid | category_id |
    | 作成日時 | created_at |
    | 更新日時 | updated_at | 
    </br>

  - categoriesテーブル
    | id |  |
    | - | - |
    | カテゴリ名 | name |
    | 作成日時 | created_at |
    | 更新日時 | updates_at |
    </br>

  - リレーション
    shops.category_id = categories.id</br>
</br>

* 画面構成
  | 画面 | ビュー名 |
  | - | - |
  | 一覧画面 | index.blade.php |
  | 詳細画面 | show.blade.php |
  | 新規画面 | new.blade.php |
  | 更新画面 | edit.blade.php |
  </br>
</br>

* ルーティング
  | URL | HTTPメソッド | 呼び出す機能 | コントローラメソッド |
  | - | - | - | - |
  | /shops | GET | 一覧表示 | index() |
  | /shop/{id} | GET | 詳細表示 | show() |
  | /shop/new | GET | 新規作成 | create() |
  | /shop | POST | 保存 | store() |
  | /shop/edit/{id} | GET | 編集 | edit() |
  | /shop/update/{id} | POST | 更新 | update() |
  | /shop/{id} | DELETE | 削除 | destroy() |
  </br>
</br>

***
</br>

### 4-2_アプリケーションディレクトリを用意しよう
ここではアプリケーションのディレクトリとそのDBを用意する。</br>
</br>

それではアプリケーションを作成する。
```shell
$ composer create-project laravel/laravel lunchmap --prefer-dist
...
% cd lunchmap
lunchmap % php artisan -v
Laravel Framework 8.48.0
```
次にphpMyAdminでDBを作成する。
```
DB名：lunchmapdb
照合順序:utf8-general-ci
```
</br>

次にこのDBを使用できるように環境設定ファイルに記述を行う。</br>
```php
// lunchmap/.env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=lunchmapdb
DB_USERNAME=root
DB_PASSWORD=root
```
</br>

***
</br>

### 4-3_モデルとコントローラを用意しよう
前章で作成したDBに対して、モデルとコントローラを用意してマイグレーションを実行する。</br>
復習:Laravelではコントローラを作成する際に、モデルとマイグレーションファイルも同時に作成される。</br>
</br>
まずはCategoryのモデルを作成する。</br>
こちらはコントローラなしで、マイグレーションファイルのみを同時生成する。</br>

```shell
% php artisan make:model Category -m

Model created successfully.
Created Migration: 2021_06_25_002742_create_categories_table
```
続いてShopモデルを作る。</br>
こちらはコントローラとマイグレーションファイルを同時生成する。
```shell
% php artisan make:model Shop -m -c -r

Created Migration: 2021_06_25_003116_create_shops_table
Controller created successfully.
```
</br>
これでShop、Categoryの各モデルとマイグレーションファイル、Shopのコントローラーができた。</br>
</br>
**備考：モデル作成時のオプションについて**</br>
`% php artisan make:model -h`でモデル作成時のオプションを見る事ができる。</br>
[参考:モデル作成時のオプションについて](/doc/memo.md)</br>
</br>

それではマイグレーションファイルを編集して、必要なcolumnを追加していこう。</br>
```php
// Categoryのマイグレーションファイル
// lunchmap/database/migrations/2021_06_25_002742_create_categories_table.php

public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        // 下記のように編集
        $table->increments('id');
        $table->string('name');
        // ここまで
        $table->timestamps();
    });
}

// Shopのマイグレーションファイル
// lunchmap/database/migrations/2021_06_25_003116_create_shops_table.php
public function up()
{
    Schema::create('shops', function (Blueprint $table) {
        // 下記のように編集
        $table->increments('id');
        $table->string('name');
        $table->string('address');
        $table->integer('category_id');
        $table->timestamps();
    });
}
```
それではマイグレーションを実行しよう。
```shell
% php artisan migrate

Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (86.66ms)
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table (69.11ms)
Migrating: 2019_08_19_000000_create_failed_jobs_table
Migrated:  2019_08_19_000000_create_failed_jobs_table (67.71ms)
Migrating: 2021_06_25_002742_create_categories_table
Migrated:  2021_06_25_002742_create_categories_table (36.31ms)
Migrating: 2021_06_25_003116_create_shops_table
Migrated:  2021_06_25_003116_create_shops_table (34.96ms)
```
マイグレーションが実行できた。</br>
phpMyAdminで確認してみる。</br>
</br>

***
</br>

### 4-4_お店とカテゴリのテーブルを関連付けよう
前章で作成したテーブルのリレーション(関連付け)を行う。</br>

```php
// lunchmap/app/Models/Shop.php
class Shop extends Model
{
    use HasFactory;
    // 下記を追加
    public function category()
    {
        // return $this->belongsTo('App\Category'); カリキュラム内ではこの記述だったが、このままだとエラーになる。
         return $this->belongsTo('App\Models\Category'); //修正版
    }
}
```
* **belongsTO**について</br>
  今回のような関連付けにおいて、多対1の関係の1の方に記述を行う。</br>
  ニュアンスとしては`Shop(多)はCategory(1)に所属する(belongsTo)`。</br>
  → ●●飯店や〇〇茶房は'中華料理'というカテゴリに所属する。</br>
</br>

続いてphpMyAdminでサンプルデータを作っていく。</br>
備考：ここはLaravelのシーダーという機能でもできる。</br>
</br>
それでは各テーブルに追加していく。</br>

* categoriesテーブル
  ```
  INSERT INTO categories(name)
  VALUES
      ('イタリアン'),
      ('中華'),
      ('和食');
  ```
</br>

* shopsテーブル
  ```
  INSERT INTO shops(name,address,category_id)
  VALUES
      ('パイザ亭', '東京都港区南青山3丁目', 1),
      ('ラーメンLaravel', '東京都港区東青山', 2),
      ('そばの霧島', '東京都港区西青山', 3);
  ```
</br>

また、全体設定として下記を追加。
```php
// lunchmap/app/Providers/AppServiceProvider.php
public function boot()
{
    //下記を追加
    \URL::forceScheme('https');
}
```
</br>

***
</br>

### 4-5_お店一覧ページを作ろう
一覧ページを作成する。同時にドメイン名だけの時にここにリダイレクトするようにする。</br>
一覧ページのルーティングは次の通り。</br>
</br>

| URL | HTTPメソッド | 呼び出す機能 | コントローラメソッド |
| - | - | - | - |
| /shops | GET | 一覧表示 | index() |
</br>

それではまずルーティングから記述していく。
```php
// lunchmap/routes/web.php
// 下記を追加
Route::get('/shops','ShopController@index')->name('shop.list');

Route::get('/', function () {
    // 下記も変更する
    // return view('welcome');
    return redirect('/shops');
});
```
これで`/shops`にアクセスした際はShopコントローラのindexメソッドが呼び出されるようにできた。</br>
また`/`以降何も指定しない際は`/shop`にリダイレクトされるようになった。</br>
</br>

続いて先程ルーティングにて、呼び出すように設定したshopコントローラのindexメソッドを編集する。
```php
// lunchmap/app/Http/Controllers/ShopController.php
public function index()
{
    //下記を記述
    $shops = Shop::all();
    return view('index',['shops'=>$shops]);
}
```
</br>

次は一覧表示に使われるindexのビューを作成する。
```php
// lunchmap/resources/views/index.blade.php
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>lunchmap</title>
    <style>body {padding: 10px;}</style>
  </head>

  <body>
    <h1>お店一覧</h1>

    @foreach($shops as $shop)
      <p>
        {{ $shop->category->name}},
        {{ $shop->name}},
        {{ $shop->address}}
      </p>
    @endforeach
  </body>
</html>
```
ここで動作確認したところ,`Target class [ShopController] does not exist.`と表示され繋がらなかったので過去の学習を振り返った。</br>
[振り返り:エラー対処2_コントローラが見つからないエラー「Target class 〇〇〇Controller does not exist.」](/doc/Laravel_basic_01.md)</br>
`bbs/app/Providers/RouteServiceProvider.php`に`protected $namespace = 'App\Http\Controllers';`の一文を追加。</br>
</br>

### エラー対処1_テーブルのリレーションについて、カリキュラムのまま記述するとつながらなかった件
前章で作成したリレーションが呼び出せずエラーになる。</br>
`Class "App\Category" not found (View: /Applications/MAMP/htdocs/Laravel_app/lunchmap/resources/views/index.blade.php)`</br>
</br>

ここでpaiza本来のエディタで作成していたところ`appディレクトリ`直下に`Category.php`(モデル)がある事に気づいた。</br>
新しいバージョンのLaravelにおいては`app\Modelsディレクトリ`にモデルが配置されている。</br>
そのため上記のエラーが発生していた原因は、参照しているモデルの位置(パス)の指定間違いであった。</br>

```php
// lunchmap/app/Models/Shop.php
class Shop extends Model
{
    use HasFactory;
    // 下記を追加
    public function category()
    {
        // return $this->belongsTo('App\Category'); カリキュラム内ではこの記述だったが、このままだとエラーになる。
         return $this->belongsTo('App\Models\Category'); //修正版
    }
}
```
上記を修正した結果、正しくお店一覧ページが表示された。
以上。</br>
</br>

***
</br>

### 4-6_共通テンプレートにBootstrapを導入しよう
共通テンプレートにBootstrapを導入してナビゲーションバーを追加する。</br>
</br>
まず共通テンプレートを作成する。</br>
一覧表示のビューをコピーして共通テンプレートを作成。</br>

```shell
lunchmap % cp resources/views/index.blade.php resources/views/layout.blade.php 
```
</br>

続いてファイルの内容を下記のように編集。
```php
// lunchmap/resources/views/layout.blade.php
<!DOCTYPE html>
<html>

  <head>
    <meta charset='utf-8'>
    <title>Lunchmap</title>
    <style>
      body {
        padding: 10px;
      }
    </style>
  </head>

  <body>
    @yield('content')
  </body>

</html>
```
上記のようにページ各自の内容を`@yield('content')`という部分に割り当てるようにして、他の共通部分のみを残す。</br>
</br>

続いて一覧表示ページのテンプレートを編集する。
```php
// lunchmap/resources/views/index.blade.php
@extends('layout')

@section('content')
  <h1>お店一覧</h1>

  @foreach ($shops as $shop)
  <p>
    {{ $shop->category->name }},
    {{ $shop->name }},
    {{ $shop->address }}
  </p>
  @endforeach
@endsection
```
共通テンプレートを`@extends('layout')`で呼び出し、ページ独自の表示部分を`@section('content')~@endsection`で囲む。</br>
ここで一旦動作確認を行い、表示が問題なければBootstrapを導入する。</br>
共通テンプレートを編集する。

```php
// lunchmap/resources/views/layout.blade.php
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <!-- 下記を追加 -->
  <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <!-- 追加ここまで -->
  <title>Lunchmap</title>
  <style>
    body {
      padding-top: 80px;
    }
  </style>
</head>

<body>
  <!-- 下記にナビゲーションバーを追加 -->
  <nav class='navbar navbar-expand-md navbar-dark bg-dark fixed-top'>
    <a class='navbar-brand' href={{route('shop.list')}}>Lunchmap</a>
  </nav>
  <!-- コンテンツをcontainerタグで囲む -->
  <div class='container'>
    @yield('content')
  </div>
</body>

</html>
```
ナビゲーションバーにかぶらないようにbody要素の空白を`padding-top:80px;`に変更。</br>
</br>

***
</br>

### 4-7_お店の詳細ページを作ろう
ここではお店の詳細ページを作成する。</br>
* ルーティング
  | URL | HTTPメソッド | 呼び出す機能 | コントローラメソッド |
  | - | - | - | - |
  | /shops | GET | 一覧表示 | index() |
  | /shop/{id} | GET | 詳細表示 | show() |</br>
</br>

それではルーティングを設定していく
```php
// lunchmap/routes/web.php
Route::get('/shops', 'ShopController@index')->name('shop.list');
// 下記を追加【詳細ページ)
Route::show('/shop/{id}','ShopController@show')->name('shop.detail');

Route::get('/', function () {
    return redirect('/shops');
});
```
続いてコントローラのshowメソッドを記述する。
```php
// lunchmap/app/Http/Controllers/ShopController.php
public function show($id)
{
    $shop = Shop::find($id);
    return view('show',['shop'=>$shop]);
}
```
続いて詳細ページのビューを一覧ページのビューからコピーして作成する。
```php
// lunchmap/resources/views/show.blade.php
@extends('layout')

@section('content')
  <h1>{{ $shop->name }}</h1>

  <div>
    <p>{{ $shop->category->name }}</p>
    <p>{{ $shop->address }}</p>
  </div>
  <div>
    <a href={{ route('shop.list')}}>一覧に戻る</a>
  </div>
@endsection
```
ここで一度動作確認を行う。</br>
`/shop/1`などにアクセスしてそのidの詳細ページが表紙されればOK.</br>
</br>

つぎに一覧ページから詳細ページへのリンクを設置する。</br>
```php
// lunchmap/resources/views/index.blade.php
@extends('layout')

@section('content')
  <h1>お店一覧</h1>

  {{-- これまで箇条書きで表示されていた一覧にテーブルを割り当てる --}}
  <table class='table table-striped table-hover'>
    <tr>
      <th>カテゴリ</th><th>店名</th><th>住所</th>
    </tr>
    @foreach ($shops as $shop)
      <tr>
        <td>{{ $shop->category->name }}</td>,
        <td>
          <a href={{ route('shop.detail',['id' => $shop->id])}}>{{ $shop->name }}</a>
        </td>,
        <td>{{ $shop->address }}</td>
      </tr>
    @endforeach
  </table>
@endsection
```
これで一覧ページから詳細への各リンクができた。</br>
</br>

***
</br>

### 4-8_新規投稿フォームを作ろう
ここでは新規投稿フォームを追加する。</br>
ルーティングは下記の通り</br>

* ルーティング
  | URL | HTTPメソッド | 呼び出す機能 | コン
  | - | - | - | - |
  | /shops | GET | 一覧表示 | index() |
  | /shop/{id} | GET | 詳細表示 | show() |
  | /shop/new | GET | 新規作成 | create() |
  | /shop | POST | 保存 | store() |
</br>
</br>

それでは作っていく。</br>
まずルーティングを設定する。</br>

```php
// lunchmap/routes/web.php
Route::get('/shops', 'ShopController@index')->name('shop.list');
// 下記を追加 新規投稿
Route::get('/shop/new', 'ShopController@create')->name('shop.new');
Route::post('/shop', 'ShopController@store')->name('shop.store');
// 詳細
Route::get('/shop/{id}', 'ShopController@show')->name('shop.detail');

Route::get('/', function () {
    return redirect('/shops');
});
```
> **注意**</br>
> ここも前回同様に詳細ページの記述が先にあると、新規投稿の`new`が``{id}`に該当してしまいエラーになってしまう。</br>
> そのため詳細のルーティングより先に、新規投稿ページを記述する。</br>
</br>
次はコントローラにメソッドを追加する。</br>
まずはcreateメソッドを追加する。</br>

```php
// lunchmap/app/Http/Controllers/ShopController.php
// 頭の部分の箇所に下記を追記

use App\Models\Shop;
// 下記を追加
use App\Models\Category;
use Illuminate\Http\Request;

//省略
public function create()
{
    //下記を追記
    $categories = Category::all()->pluck('name','id');
    return view('new',['categories'=> $categories]);
}
```
`pluck('name','id')`：あるレコードから指定したカラムの値のみを取り出してくれる関数。</br>
</br>
次に新規投稿のビューを詳細ページのビューからコピーして作成する。</br>

```php
// lunchmap/resources/views/new.blade.php
@extends('layout')

@section('content')
  <h1>新しいお店</h1>
  {{ Form::open(['route' => 'shop.store']) }}
    <div class='form-group'>
      {{ Form::label('name','店名：')}}
      {{ Form::text('name',null)}}
    </div>
    <div class='form-group'>
      {{ Form::label('address','住所：')}}
      {{ Form::text('address',null)}}
    </div>
    <div class='form-group'>
      {{ Form::label('category_id','カテゴリ：')}}
      {{ Form::select('category_id',$categories)}}
    <div class='form-group'>
      {{ Form::submit('作成する',['class'=> 'btn btn-primary'])}}
    </div>
  {{ Form::close()}}

  <div>
    <a href={{ route('shop.list')}}>一覧に戻る</a>
  </div>
@endsection
```
ここで動作確認を行ったところ`Class "Form" not found`というエラーが出たので下記の対処を行った。</br> 
</br>

### エラー対処_2_フォームが見つからないエラー"Class_"Form"_not_found" 
>シンプルに`laravelcollective/html`を未導入だったためフォームファサードが使えなかった。</br>
>
>```shell
>lunchmap % composer require laravelcollective/html
>Using version ^6.2 for laravelcollective/html
>```
>以上。</br>
></br>

再度動作確認を行い`/shop/new`にアクセスし、新規投稿ページが表示できればOK。</br>
現状はまだstoreメソッドを定義していないためまだ投稿はできない。</br>
</br>

***
</br>

### 4-9_投稿フォームの内容を保存しよう
ここでは前章で作成した新規登録フォームで保存できる機能を追加する。</br>
投稿内容を保存するためのルートはすでに記述してあるので、コントローラのstoreメソッドを編集する。</br>

```php
//  lunchmap/routes/web.php 記述済みルーティング
// 新規投稿
Route::get('/shop/new', 'ShopController@create')->name('shop.new'
Route::post('/shop', 'ShopController@store')->name('shop.store');

// lunchmap/app/Http/Controllers/ShopController.php
public function store(Request $request)
{
    // 下記を追加
    $shop = new Shop();
    $shop->name = request('name');
    $shop->address = request('address');
    $shop->category_id = request('category_id'); 
    $shop->save();
    return redirect()->route('shop.detail',['id' => $shop->id]);
}
```
次にお店の一覧ページから新規の投稿フォームにリンクさせておく。
```php
// lunchmap/resources/views/index.blade.php
@extends('layout')

@section('content')
  <h1>お店一覧</h1>

  <table class='table table-striped table-hover'>
    <tr>
      <th>カテゴリ</th><th>店名</th><th>住所</th>
    </tr>
    @foreach ($shops as $shop)
      <tr>
        <td>{{ $shop->category->name }}</td>
        <td>
          <a href={{ route('shop.detail',['id' => $shop->id])}}>{{ $shop->name }}</a>
        </td>
        <td>{{ $shop->address }}</td>
      </tr>
    @endforeach
  </table>

  {{-- 下記を追加 --}}
  <div>
    <a href={{ route('shop.new')}} class='btn btn-outline-primary'>新しいお店</a>
  </div>
    
@endsection
```
これで新規投稿機能が追加できた。</br>
</br>

***
</br>

### 4-10_お店の編集フォームを作ろう
ここでは登録情報を編集するフォームを作成する。</br>
ルーティングは下記の編集と更新の箇所。</br>

* ルーティング
  | URL | HTTPメソッド | 呼び出す機能 | コントローラメソッド |
  | - | - | - | - |
  | /shops | GET | 一覧表示 | index() |
  | /shop/{id} | GET | 詳細表示 | show() |
  | /shop/new | GET | 新規作成 | create() |
  | /shop | POST | 保存 | store() |
  | /shop/edit/{id} | GET | *編集 | edit() |
  | /shop/update/{id} | POST | *更新 | update() |
  | /shop/{id} | DELETE | 削除 | destroy() |
  </br>
</br>

それではルーティングを設定する。</br>

```php
// lunchmap/routes/web.php
Route::get('/shops', 'ShopController@index')->name('shop.list');

// 新規投稿
Route::get('/shop/new', 'ShopController@create')->name('shop.new');
Route::post('/shop', 'ShopController@store')->name('shop.store');

// 下記を追加 編集と更新
Route::get('/shop/edit/{id}','ShopController@edit')->name('shop.edit');
Route::post('/shop/update/{id}','ShopController@update')->name('shop.update');

// 詳細
Route::get('/shop/{id}', 'ShopController@show')->name('shop.detail');

Route::get('/', function () {
    return redirect('/shops');
});
```
次はコントローラにメソッドを追加する。</br>
まずeditメソッドを編集する。
```php
// lunchmap/app/Http/Controllers/ShopController.php
// 下記を編集
public function edit(Shop $shop, $id)
{   
    $shop = Shop::find($id);
    $categories = Category::all()->pluck('name','id');
    return view('edit',['shop'=>$shop,'categories'=>$categories]);
}
```
続いてeditビューを`new.blade.phpか`らコピーして作成する。</br>

```php
// lunchmap/resources/views/edit.blade.php
@extends('layout')

@section('content')
  <h1>{{ $shop->name }}を編集する</h1>
  {{ Form::model($shop,['route' => ['shop.update',$shop->id]]) }}
    <div class='form-group'>
      {{ Form::label('name','店名：')}}
      {{ Form::text('name',null)}}
    </div>
    <div class='form-group'>
      {{ Form::label('address','住所：')}}
      {{ Form::text('address',null)}}
    </div>
    <div class='form-group'>
      {{ Form::label('category_id','カテゴリ：')}}
      {{ Form::select('category_id',$categories)}}
    <div class='form-group'>
      {{ Form::submit('更新する',['class'=> 'btn btn-primary'])}}
    </div>
  {{ Form::close()}}

  <div>
    <a href={{ route('shop.list')}}>一覧に戻る</a>
  </div>
@endsection
```
ここで動作確認を行う。</br>
`shop/edit/1`にアクセスして、入力欄に既存の値が表示されていればOK。</br>
</br>

***
</br>

### 4-11_編集内容を更新しよう
ここでは前章で作成した編集フォームを保存する機能(更新)を追加する。</br>
updateのルーティングは前章で記述したのでコントローラのupdateメソッドを編集する。</br>
基本的にはstoreメソッドからコピーして編集する。

```php
// lunchmap/app/Http/Controllers/ShopController.php
// 下記を編集
public function update(Request $request, $id, Shop $shop)
{
    $shop = Shop::find($id);
    $shop->name = request('name');
    $shop->address = request('address');
    $shop->category_id = request('category_id');
    $shop->save();
    return redirect()->route('shop.detail', ['id' => $shop->id]);
}
```
続いて詳細ページから編集ページへのリンクを設置する。
```php
// lunchmap/resources/views/show.blade.php
@extends('layout')

@section('content')
  <h1>{{ $shop->name }}</h1>
  
  <div>
    <p>{{ $shop->category->name }}</p>
    <p>{{ $shop->address }}</p>
  </div>
  <div>
    <a href={{ route('shop.list')}}>一覧に戻る</a>
    {{-- 下記を追加 --}}
    | <a href={{ route('shop.edit',['id' => $shop->id])}}>編集<a>

  </div>
@endsection
```
これで更新機能が追加できた。</br>
</br>

***
</br>

### 4-12_お店の情報を削除しよう
ここでは削除機能を追加する。ルーティングは下記の削除の行

* ルーティング
  | URL | HTTPメソッド | 呼び出す機能 | コントローラメソッド |
  | - | - | - | - |
  | /shops | GET | 一覧表示 | index() |
  | /shop/{id} | GET | 詳細表示 | show() |
  | /shop/new | GET | 新規作成 | create() |
  | /shop | POST | 保存 | store() |
  | /shop/edit/{id} | GET | 編集 | edit() |
  | /shop/update/{id} | POST | 更新 | update() |
  | /shop/{id} | DELETE | *削除 | destroy() |
  </br>
</br>

それではルーティングを設定する。</br>

```php
// lunchmap/routes/web.php
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
```
次にコントローラでdestroyメソッドを編集する。</br>

```php
// lunchmap/app/Http/Controllers/ShopController.php
// 下記を編集
public function destroy($id)
{
    $shop = Shop::find($id);
    $shop->delete();
    return redirect('/shops');
}
```
続いて詳細ページにこの機能を呼び出すボタンを追加する。</br>
DELETEメソッドはリンクとして呼び出せないのでフォームファサードでDELETEメソッドを指定する。</br>

```php
// lunchmap/resources/views/show.blade.php
@extends('layout')

@section('content')
  <h1>{{ $shop->name }}</h1>
  
  <div>
    <p>{{ $shop->category->name }}</p>
    <p>{{ $shop->address }}</p>
  </div>
  <div>
    <a href={{ route('shop.list')}}>一覧に戻る</a>
    | <a href={{ route('shop.edit',['id' => $shop->id])}}>編集<a>
    {{-- 下記を追加 --}}
    <p></p>
    {{ Form::open(['method'=>'delete','route'=>[ 'shop.destroy',$shop->id]])}}
      {{ Form::submit('削除',['class'=>'btn btn-outline-danger'])}}
    {{ Form::close()}}
  </div>
@endsection
```
これで削除機能が追加できた。</br>
</br>

***
</br>

### 4-13_Googleマップを表示しよう
アプリケーションにWeb地図サービスのGoogleマップを利用する。</br>
Googleマップを利用するためにAPIを用いる。</br>
</br>

- **APIとは**</br>
  Application Programming Interfaceの略で、プログラムから別のプログラムの機能を呼び出すために用意された命令や関数の事。</br>
  Googleマップを利用する際には**Google Maps API**を*APIキ*ーを取得して使用する。</br>
  今回はデモキーを使用して実装を行う。</br>
</br>

それでは導入していく。</br>
各記事の詳細ページに地図を表示できるようにする。</br>

```php
// lunchmap/resources/views/show.blade.php
@extends('layout')

@section('content')
  <h1>{{ $shop->name }}</h1>
  
  <div>
    <p>{{ $shop->category->name }}</p>
    <p>{{ $shop->address }}</p>
  </div>

  {{-- 下記を追加 --}}
  <iframe id='map' src='https://www.google.com/maps/embed/v1/place?key=(GoogleマップAPIキー)&q={{ $shop->address }}'
    width='100%'
    height='320'
    frameborder='0'>
    </iframe>


  <div>
    <a href={{ route('shop.list')}}>一覧に戻る</a>
    | <a href={{ route('shop.edit',['id' => $shop->id])}}>編集<a>
    {{-- 下記を追加 --}}
    <p></p>
    {{ Form::open(['method'=>'delete','route'=>[ 'shop.destroy',$shop->id]])}}
      {{ Form::submit('削除',['class'=>'btn btn-outline-danger'])}}
    {{ Form::close()}}
  </div>
@endsection
```
APIキーに制限があるためローカル環境で確認できないが、指定のコンテナ上ではGoogleマップの表示が確認できた。</br>
記述の内容は、APIキーを埋め込んだ後、データの住所を連結して表示する地図の位置を指定している。</br>

