## Laravel入門編1: Laravelの基本を理解しよう(全9回)

### 目次
[1-1_Laravelの基本を理解しよう](#1-1_Laravelの基本を理解しよう)</br>
[1-2_アプリケーションを用意しよう](#1-2_アプリケーションを用意しよう)</br>
[1-3_LaravelでHelloWorld](#1-3_LaravelでHelloWorld)</br>
[1-4_1行掲示板を作ろう](#1-4_1行掲示板を作ろう)</br>
[1-5_モデルとコントローラを用意する](#1-5_モデルとコントローラを用意する)</br>
[1-6_ルーティングを定義しよう](#1-6_ルーティングを定義しよう)</br>
[1-7_コントローラとビューを作成しよう](#1-7_コントローラとビューを作成しよう)</br>

</br>

***

</br>

###  1-1_Laravelの基本を理解しよう
Web掲示板を作成する中で、Webアプリケーションの基本的な動作を学習する。</br>
主目的はLaravelの基本的な機能を学習すること。</br>
</br>

* Laravelとは
  - Webアプリケーションフレームワークの一つ
  - Webアプリを開発するための必要・便利なツールをひとまとめにしたもの
  - Webアプリを効率よく短期的に開発するために用いる</br>
</br>

* Laravelの基本的な機能
  - テンプレートエンジン(Blade)
  - データベース(ORマッパー/Eloquent)
  - コマンドラインインターフェース(Artisan)
  - ユーザー認証</br>
</br>

* この講座で作るもの
  - 簡単な一行掲示板
    - 一覧表示
    - 記事の作成・編集・削除
    - フォームによる記事の編集
  - 実用的なアプリケーション
    - ランチマップ
    - ユーザー管理機能</br>
      ログイン時だけ投稿</br>
      自分の記事だけ編集・削除</br>
</br>

* 作業の流れ
  - Laravelでアプリケーション用ディレクトリを作る
  - LaravelでHelloWorld
  - 1行掲示板の構成を確認する
  - モデルとコントローラーを用意する
  - ルーティングを定義する
  - コントローラーとビューを作成する
  - 記事一覧を作成する
  - 詳細画面を作成する</br>
</br>

***
</br>

### 1-2_アプリケーションを用意しよう
任意のディレクトリ内に`bbs`というプロジェクト(ディレクトリ)を作成する。</br>
Laravelのインストールについては[こちら](/doc/Laravel_install_00.md)を参照。</br>
```shell
$ laravel new bbs
# 今回は学習もかねてcomposerコマンドの方で実行した。
# $ composer create-project laravel/laravel プロジェクト名 --prefer-dist

# プロジェクトが作成できたら
$ cd bbs
$ php artisan -v
# 下記のように出てきたらOK
Laravel Framework 8.46.0
以下略
```
</br>

それでは動作確認を行う。</br>
Laravelの管理コマンドを呼び出してサーバーを起動する。</br>

```shell
$ php artisan serve
# 下記のように表示される
Starting Laravel development server: http://127.0.0.1:8000
[Tue Jun 15 13:01:49 2021] PHP 8.0.6 Development Server (http://127.0.0.1:8000) started
```
サーバー起動後、
(http://localhost:8000/)
にアクセスして下記の画面が表示されていれば正しく起動している。</br>
![on_Laravel](/img/Laravel.png)
</br>

また、サーバーを停止する際はターミナル上で`ctrl + c`で停止する。</br>
</br>

* **artisan**とは</br>
  ターミナルで「artisan」(アーティサン)コマンドを使ってLaravelの機能を呼び出すことができる。</br>
  LaravelでWebアプリケーションを開発するときに役に立つ、数多くのコマンドを提供している。</br>
</br>

* 参考にディレクトリ作成(`laravel new ~`)を早くする方法</br>
  ```bash
  $ composer config -g repositories.packagist composer 'https://packagist.jp'
  $ composer global require hirak/prestissimo
  ```
  今回はローカル環境では実行していない。</br>
</br>

***
</br>

### 1-3_LaravelでHelloWorld
備考：(localhost:8000/)
に接続して出てくるLaravelの画面(下記参照)はデフォルトで用意されている画像である。</br>
![on_Laravel](/img/Laravel.png)</br>
場所は`/bbs/resources/views/welcome.blade.php/`である。</br>
それではこのWelcomeページを編集してみる。</br>

```html
<p><?= date('y,m,d'); ?></p>
```
借りに上記のようなタグを挿入する事でPHPプログラムを挿入する事が可能。</br>
</br>

***
</br>

### 1-4_1行掲示板を作ろう
ページの構成は下記のとおり。</br>
* 記事一覧ページ(index.blade.php)</br>
  - 詳細ページ(show.blade.php)
  - 新規画面(new.blade.php)
  - 編集画面(edit.blade.php)</br>
  </br>

  **備考:Blade**[(参考:【Laravel入門】ビューとBladeと継承)](https://qiita.com/yukibe/items/86ccd3f72ecf943825a6)</br>
  BladeはシンプルながらパワフルなLaravelのテンプレートエンジンです。他の人気のあるPHPテンプレートエンジンとは異なり、ビューの中にPHPを直接記述することを許しています。全BladeビューはPHPへコンパイルされ、変更があるまでキャッシュされます。つまりアプリケーションのオーバーヘッドは基本的に０です。Bladeビューには.blade.phpファイル拡張子を付け、通常はresources/viewsディレクトリの中に設置します。</br>
  つまり</br>
  - Laravelのビュー作成にはBladeテンプレートエンジンが使われ、結果Bladeビューとなる。
  - **ビューの中にPHPが直接記述できる。**
  - Laravelのビューはresources/viewsディレクトリにある。
  - 拡張子は.blade.phpとなる。</br>
</br>

* ページ遷移図</br>
  ![](/img/1phraseBBS_page.png)</br>
</br>

* ルーティング</br>
  ![](/img/1phraseBBS_rooting.png)</br>
</br>

* DBの構成
  - データベース：mybbs
  - テーブル：articles
  - カラム：id,content,created_at,updated_at</br>
</br>

それではDBを作成していく。</br>
phpMyAdminにて`mybbs`という名前のDBを作成。照合順序はいつもどおり`utf8_general_ci`。(DBで日本語を扱うため)</br>
とりあえず作成だけで良い。テーブルかカラムは次のチャプターで設定。</br>
</br>

次にアプリケーションがこのDBを読み込むようにLaravelで設定する。</br>
これは隠しファイルになっている`.env`という環境設定ファイルにて設定する。</br>
bbsディレクトリ内の`.env`を開く。</br>
```s
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mybbs # 自分の使用するDB名にする
DB_USERNAME=root # rootになってない場合はrootにする。
# 下記をコメントアウトする
# DB_PASSWORD=
略
```
</br>

***
</br>

### 1-5_モデルとコントローラを用意する
PHPオブジェクトとしてDBのレコードを操作するためにモデルを作成する。</br>
Laravelではモデルを自動生成できる。</br>
モデルの作成と同時にその設定である**マイグレーションファイル**と**コントローラー**も作成される。</br>
テーブル名は`Articles`と複数形で表すが、モデルは`Article`と単数形で表す。</br>
```shell
$ php artisan make:model Article -m -c -r
Model created successfully.
Created Migration: 2021_06_16_021409_create_articles_table
Controller created successfully.
```
実行後、`/bbs/app/Models`内に`Article.php`というファイルが作成されている。これがArticleモデルである。</br>
```php
// Article.php
<?php

namespace App\Models;

// 作成段階でEloquent(ORマッパー)を読み込んでいる。
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
}
```
</br>

また、`/bbs/Http/Controllers`に`ArticleController.php`というコントローラーが作成されている。</br>
ここにアプリケーションの動作に合わせて記述を行う。</br>
```php
// ArticleController.php
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
```
</br>

また、`/bbs/database/migrations`内に`2021_06_16_021409_create_articles_table.php`というマイグレーションファイルが作成されている。</br>
こちらに今回使用するテーブルの情報を追加する。
```php
// 2021_06_16_021409_create_articles_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            // $table->id(); 下記に変更
            $table->increments('id');
            // 下記を追記
            $table->string('content');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

```
それでは編集したマイグレーションファイルを実行しよう。
```shell
$ php artisan migrate
# しかし、エラーで正常に実行できず
 Illuminate\Database\QueryException 

  SQLSTATE[HY000] [1049] Unknown database 'mybbs' (SQL: select * from information_schema.tables where table_schema = mybbs and table_name = migrations and table_type = 'BASE TABLE')

  at vendor/laravel/framework/src/Illuminate/Database/Connection.php:692
    688▕         // If an exception occurs when attempting to run a query, we'll format the error
    689▕         // message to include the bindings with SQL, which will make this exception a
    690▕         // lot more helpful to the developer instead of just the database's errors.
    691▕         catch (Exception $e) {
  ➜ 692▕             throw new QueryException(
    693▕                 $query, $this->prepareBindings($bindings), $e
    694▕             );
    695▕         }
    696▕ 

      +33 vendor frames 
  34  artisan:37
      Illuminate\Foundation\Console\Kernel::handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
```
</br>

エラーが発生したため`.env`の内容を下記に訂正。
```s
// .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mydbs
DB_USERNAME=root
# DB_PASSWORD=

↓

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=mybbs
DB_USERNAME=root
DB_PASSWORD=root
```
書き換え後に実行
```shell
# 一度キャッシュをクリア
% php artisan config:cache

Configuration cache cleared!
Configuration cached successfully!

# 再度マイグレーションを実行
% php artisan migrate

Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table (75.91ms)
Migrating: 2014_10_12_100000_create_password_resets_table
Migrated:  2014_10_12_100000_create_password_resets_table (63.72ms)
Migrating: 2019_08_19_000000_create_failed_jobs_table
Migrated:  2019_08_19_000000_create_failed_jobs_table (68.31ms)
Migrating: 2021_06_16_021409_create_articles_table
Migrated:  2021_06_16_021409_create_articles_table (32.20ms)
```
今度は正常にマイグレーションを行えた。</br>
*このエラーの内容はqiita(https://qiita.com/BugGreedy/items/f7e1743a26e9465b7350) にて記載。</br>
</br>

あらためてphpMyAdminの`mybbs`テーブルを確認したところ、migrationに設定した`artilesテーブル`と各カラム(id,content,created_at,updated_at)ができている。</br>
ここでサンプルデータを登録する。</br>
`挿入`タブを選択し、`3行ずつ挿入する`を選択。各contentsカラムにメッセージを記入し実行。</br>
`表示`タブをクリックし、今挿入したレコードが登録されていればOK。</br>
</br>

***
</br>

### 1-6_ルーティングを定義しよう
* **ルーティングとは**</br>
  特定のアドレスにアクセスした時、どの機能を呼び出すか設定するもの。</br>


* 一行掲示板のルーティング
  | ルート | メソッド | 関数 | 表示するページ |
  | - | - | - | - |
  | `/` | GET | - | BBS-mogura |
  | `/articles` | GET | index() | 一覧画面 |
  | `/article/<id>` | GET | show() | 詳細画面 |
</br>


まず現在のルーティングを確認する。</br>
`/bbs/routes/web.php`を確認。
その下部に追加するルート(ルーティングの定義)を記述する。
```php
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
// 下記は記事詳細のルート
Route::get('/article/id','ArticleController@show')->name('article.show');
```
</br>

**ルーティングの記述について</br>
**`Route::get('ルート','コントローラー@メソッド')->name('リンク');`**</br>
例：①記事一覧のルートについて</br>
`Route::get('/articles','ArticleController@index')->name('article.list');`</br>
`/articles`にアクセスしたとき、ArticleControllerのindexメソッドを呼び出す。</br>
また`->name('article.list')`とname付けしているのでP¥`article.list`というリンクを貼る事ができるようになる。</br>
</br>

次に当環境でhttpsを使うようにアプリケーションの全体設定を編集する。</br>
`/bbs/app/Providers/AppServiceProvider.php`を開き、下記の記述を追加する。</br>
```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 下記を追記
        \URL::forceScheme('https');
    }
}
```
</br>

***
</br>

### 1-7_コントローラとビューを作成しよう
前回はルーティングの設定を行った。ここにコントローラーとビューを追加すればブラウザからのアクセスでページを表示できるようになる。</br>
</br>
まずコントローラ(`/bbs/app/Http/Controllers/ArticleController.php)に記述を追加する。</br>

```php
// 一部抜粋 
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 下記を追加
        return view('index');
    }
```
これでコントローラーのindexメソッドが追加できた。</br>
ここでは`index`という名前のビューを呼び出すだけの仕組みになっている。</br>
続いてビューを作成する。</br>
</br>

**ビューとは**</br>
- アプリケーションの見た目を設定する機能。
- LaravelではBladeというテンプレートエンジンを用いている。[Bladeについては以前の章を参照](#1-4_1行掲示板を作ろう)</br>

ではビューを作成していこう。</br>
`bbs/resources/views`に`index.blade.php`というファイルを作成し、次のように記述する。

```php
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>mogura bbs</title>
    <style>body {padding: 10px;}</style>
  </head>
  <body>
    <h1>mogura bbs</h1>
  </body>
</html>
```
ここで動作確認のため(http://localhost:8000/articles)にアクセスしてみたところ</br>
`Target class [ArticleController] does not exist.`




