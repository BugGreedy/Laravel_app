## Laravel入門編2:Laravelの動作を理解しよう (全7回)

### 目次
[2-1_データベースとルーティングを理解しよう](#2-1_データベースとルーティングを理解しよう)</br>
[2-2_artisan_tinkerでデータベースを確認しよう](#2-2_artisan_tinkerでデータベースを確認しよう)</br>
[2-3_マイグレーションでカラムを追加しよう](#2-3_マイグレーションでカラムを追加しよう)</br>
[2-4_モデルに追加したカラムをビューで表示しよう](#2-4_モデルに追加したカラムをビューで表示しよう)</br>
[2-5_Laravelのルーティングを理解しよう](#2-5_Laravelのルーティングを理解しよう)</br>
</br>

***
</br>

### 2-1_データベースとルーティングを理解しよう
ここでは前回に引き続き一行掲示板を用いてLaravelの機能について理解を深める。</br>
具体的にはLaravelのMVCについて、またLaravelでDBにデータを追加する事について等である。</br>
</br>

* Laravelの各機能のおさらい
  | 名称 | 機能 |
  | - | - |
  | モデル | アプリで扱うデータを保持し、操作する |
  | ビュー | データの表示形式を記述する |
  | コントローラー | ユーザーからのリクエストに応じて、モデル・ビューを呼び出す |
  | ルーティング | リクエストを振り分ける |
 </br>

* Laravelの動作イメージ</br>
  ![](/img/Laravel_MVC.png)</br>
</br>

* DBを操作する機能
  | 名称 | 機能 |
  | - | - |
  | artisan tinker | Laravelアプリの環境を有効にしたまま、コマンドで操作 |
  | Eloquent | DBのレコードをモデルクラスで処理するORマッパー |
  | マイグレーション | データベースの操作を一括実行・取り消し |
  - artisan tinkerはDBのデータをチェックしたり、PHPプログラムがどのような結果を出すか調べたりできる。</br>
</br>

* このカリキュラムの学習の流れ
  - artisan tinkerで動作を確認
  - マイグレーションでカラムを追加
  - 追加したカラムをビューに表示
  - Webアプリのデータの流れを理解しよう
  - DBに記事を書き込んでみよう
  - DBから記事を削除しよう</br>
</br>

***
</br>

### 2-2_artisan_tinkerでデータベースを確認しよう
**artisan tinkerとは**</br>
- 対話型コンソール。Laravelに含まれているコマンドラインインターフェイス。
- Laravelアプリの環境を有効にしたまま、Laravelの機能をコマンドで操作できる
- `irb`や`php -a`のLaravel版。</br>
</br>

それではartisan tinkerを実行してみる。
```shell
% php artisan tinker

Psy Shell v0.10.8 (PHP 8.0.6 — cli) by Justin Hileman
>>> 
```
これでartisan tinkerが起動できる。</br>
機能の例は下記。
```shell
>>> echo 'hello tinker';
hello tinker⏎
>>> exit
Exit:  Goodbye
```
</br>

またDBの操作も可能。
```shell
# テーブルの全てのレコードを取り出してみる
>>> Article::all();
[!] Aliasing 'Article' to 'App\Models\Article' for this Tinker session.
=> Illuminate\Database\Eloquent\Collection {#4102
     all: [
       App\Models\Article {#4101
         id: 1,
         content: "hello world",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#3695
         id: 2,
         content: "hello Laravel",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4063
         id: 3,
         content: "世界の皆さん こんにちは",
         created_at: null,
         updated_at: null,
       },
     ],
   }

# ひとつのidのレコードのみ取り出す
>>> $article = Article::find(1);
[!] Aliasing 'Article' to 'App\Models\Article' for this Tinker session.
=> App\Models\Article {#4167
     id: 1,
     content: "hello world",
     created_at: null,
     updated_at: null,
   }
# 一回変数に代入すれば次も同じレコードを取り出せる
>>> $article
=> App\Models\Article {#4167
     id: 1,
     content: "hello world",
     created_at: null,
     updated_at: null,
   }
# 特定のカラムを取得する
>>> $article->content
=> "hello world"
```
</br>

次にテーブルにレコードを追加してみる。
```shell
# レコードを新規で追加
>>> $article = new Article()
=> App\Models\Article {#4257}

# 続いてカラムに値を代入する
>>> $article->content = 'hello tinker'
=> "hello tinker"

# saveメソッドで保存
>>>  $article->save()
=> true

# テーブルを全て表示して追加されたか確認
>>> Article::all()
=> Illuminate\Database\Eloquent\Collection {#4256
     all: [
       App\Models\Article {#4313
         id: 1,
         content: "hello world",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4314
         id: 2,
         content: "hello Laravel",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4315
         id: 3,
         content: "世界の皆さん こんにちは",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4316
         id: 4,
         content: "hello tinker",
         created_at: "2021-06-18 01:44:09",
         updated_at: "2021-06-18 01:44:09",
       },
     ],
   }
# id:4が追加されている事が確認できた。
# 次にレコードを削除してみる。
>>> $article->delete(4)
=> true

# 再度確認
>>> Article::all()
=> Illuminate\Database\Eloquent\Collection {#4325
     all: [
       App\Models\Article {#3378
         id: 1,
         content: "hello world",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4312
         id: 2,
         content: "hello Laravel",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4323
         id: 3,
         content: "世界の皆さん こんにちは",
         created_at: null,
         updated_at: null,
       },
       App\Models\Article {#4315
         id: 5,
         content: "mogura",
         created_at: "2021-06-18 01:49:25",
         updated_at: "2021-06-18 01:49:25",
       },
     ],
   }
# id=4が削除されている。
```
</br>

***
</br>

### 2-3_マイグレーションでカラムを追加しよう
**モデル**：レコードをオブジェクトに割り当てる。</br>
↓</br>

articlesテーブル</br>
| id | content | name |
| - | - | - |
| 1 | hello world | mogura |
| 2 | hello Laravel | moguti |
| 3 | こんにちはLaravel | moggu |
</br>

**ORマッパー**：レコードをPHPオブジェクトとして操作する。</br>
例：id=1のレコード
```php
id = 1
content = 'hello world'
name = 'mogura'
```
のような感じのPHPオブジェクトとして操作できるのが**ORマッパー**。</br>
</br>

**マイグレーションとは**</br>
- DBの中身を一括して移行・変更する作業。
- LaravelではDB設定ファイルを自動生成する。
- Laravelでは自動生成でマイグレーションファイルを作成、それを編集してマイグレーション実行という流れでDBへの変更を適用する。</br>
</br>

それではマイグレーションを行ってみよう。</br>
今回はArticlesテーブルにuser_nameカラムを追加する。</br>
</br>

Laravelでカラムを変更するには、**doctrine/dbal**というライブラリが必要。</br>
以下はdoctrine/dbalを追加するコマンド。</br>
備考：dbal = database abstraction layer(データベース抽象化レイヤー)
```shell
$ composer require doctrine/dbal
```
上記を実行してdoctrine/dbalを導入。</br>
</br>

ではuser_nameカラムを追加してみよう。</br>
```shell
% php artisan make:migration add_column_username --table=articles
Created Migration: 2021_06_18_081113_add_column_username
```
これで`bbs/database/migrations/2021_06_18_081113_add_column_username.php`が作成された。</br>
</br>

**マイグレーションファイル作成について**</br>
`% php artisan make:migration マイグレーションファイル名 --table=編集したいテーブル名`</br>
</br>

マイグレーションファイルについて</br>
```php
// bbs/database/migrations/2021_06_18_081113_add_column_username.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUsername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()  // upメソッド
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()  // downメソッド
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
}
```
**upメソッドとdownメソッド**</br>
upメソッドはDBに追加する項目を指定し、downメソッドは削除する項目を指定する。</br>
今回は項目を追加するのでupメソッドの箇所に記述を行う。</br>
```php
// bbs/database/migrations/2021_06_18_081113_add_column_username.php
// 前後は略
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            //下記を追記
            $table->string('user_name');
        });
    }
```
ここを追記したらマイグレーションを実行する。
```shell
% php artisan migrate
Migrating: 2021_06_18_081113_add_column_username
Migrated:  2021_06_18_081113_add_column_username (196.06ms)
```
ではtinkerを使ってテーブルの中身を確認してみよう。
```shell
% php artisan tinker
Psy Shell v0.10.8 (PHP 8.0.6 — cli) by Justin Hileman
>>> Article::all()
[!] Aliasing 'Article' to 'App\Models\Article' for this Tinker session.
=> Illuminate\Database\Eloquent\Collection {#4101
     all: [
       App\Models\Article {#3695
         id: 1,
         content: "hello world",
         created_at: null,
         updated_at: null,
         user_name: "",
       },
       App\Models\Article {#4063
         id: 2,
         content: "hello Laravel",
         created_at: null,
         updated_at: null,
         user_name: "",
       },
       App\Models\Article {#4310
         id: 3,
         content: "世界の皆さん こんにちは",
         created_at: null,
         updated_at: null,
         user_name: "",
       },
       App\Models\Article {#4311
         id: 5,
         content: "mogura",
         created_at: "2021-06-18 01:49:25",
         updated_at: "2021-06-18 01:49:25",
         user_name: "",
       },
     ],
   }
```
カラムにuser_nameが追加されていることが確認できた。</br>
</br>

ここでuser_nameにもサンプルデータを追加しておく。
```shell
>>> $article = Article::find(1)
=> App\Models\Article {#3375
     id: 1,
     content: "hello world",
     created_at: null,
     updated_at: null,
     user_name: "",
   }
>>> $article->user_name = 'mogura'
=> "mogura"
>>> $article->save()
=> true
=> App\Models\Article {#3375
     id: 1,
     content: "hello world",
     created_at: null,
     updated_at: "2021-06-18 08:28:30",
     user_name: "mogura",
   }
```
これでid=1のuser_nameにサンプルデータを登録できた。</br>
</br>

***
</br>

### 2-4_モデルに追加したカラムをビューで表示しよう
ここでは前章で追加したuser_nameを表示してみる。</br>
本来はコントローラーから編集を行うが、今回は下記のように`$article = Article::all();`と全ての要素を取り出しているから編集は必要ない。</br>
```php
// ArticleController.php
    public function index()
    {
        $message = 'Welcome to My BBS';
        // 下記を追記
        $articles = Article::all();
        return view('index',['message' => $message], ['articles' => $articles]);
    }
```
よって、ビューのみ編集する事で表示が可能。
```php
// index.blade.php
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>mogura bbs</title>
    <style>body {padding: 10px;}</style>
  </head>
  <body>
    <h1>mogura bbs</h1>
    <p>{{ $message }}</P>
    <!-- 下記を追記 -->
    @foreach ($articles as $article)
      <p>
        <a href='{{ route("article.show",["id" => $article->id]) }}'>
        {{ $article->content}}</a>
        // 下記を追加
        {{ $article->user_name}}</a>
      </p>
    @endforeach
  </body>
</html>
```
これで一覧ページにユーザーネームを追加できる。
詳細ページにも同様の追記を行う。</br>
</br>

***
</br>

### 2-5_Laravelのルーティングを理解しよう
ここではLaravelのルーティングに新しいルートを追加する。</br>
* これまでに設定したルーティング</br>
  | URL | メソッド | 呼び出す機能 | コントローラのメソッド |
  | - | - | - | - |
  | / | GET | Welcomeページ |  |
  | /articles | GET | 記事の一覧表示 | index() |
  | /article/`<id>` | GET | 記事の個別表示 | show() |
</br>

* 今後追加するルーティング</br>
  | URL | メソッド | 呼び出す機能 | コントローラのメソッド |
  | - | - | - | - |
  | /article/new | GET | 記事の新規作成 | create() |
  | /article/ | POST | 記事の投稿 | store() |
  | /article/edit/`<id>` | GET | 記事の編集 | edit() |
  | /article/update/`<id>` | POST | 記事の更新 | update() |
  | /article/`<id>` | DELETE | 記事の削除 | destroy() |

  要は、情報を表示するだけなら**GET**、何か情報を追加する際は**POST**を用いる。</br>
</br>

* CRUDのHTTPメソッドについてのおさらい</br>
  | CRUD | 意味 | メソッド |
  | - | - | - |
  | Create | 作成 | POST/PUT |
  | Read | 読み込み | GET |
  | Update | 更新 | PUT |
  | Delete | 削除 | DELETE |</br>
  
  - HTTPメソッドは全部で8つ。(GET/POST/PUT/DELETE/HEAD/OPTIONS/TRACE/CONNECT)</br>
  - GET：リソースの取得
  - POST：リソースの追加
  - PUT：リソースの更新
  - DELETE：リソースの削除</br>
</br>

それではLaravelのルートを編集しよう。</br>
</br>

- **リダイレクト**の設定</br>
  リダイレクトとはアクセス先を自動的に切り替える事。</br>
  今回は`http://localhost:8000/`以降何も指定しない時に自動的に一覧ページへリダイレクトさせる記述を行う。
  ```php
  // bbs/routes/web.php
  Route::get('/', function () {
      // return view('welcome');  下記に編集
      return redirect('/articles');
  });
  ```
  これでhttp://localhost:8000/ にアクセスした際Welcomeページでなく一覧ページ(`/articles`)にリダイレクトされる。</br>
</br>

***
</br>

### 2-6_



