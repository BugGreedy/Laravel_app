## Laravel入門編2:Laravelの動作を理解しよう (全7回)

### 目次
[2-1_データベースとルーティングを理解しよう](#2-1_データベースとルーティングを理解しよう)</br>
[2-2_artisan_tinkerでデータベースを確認しよう](#2-2_artisan_tinkerでデータベースを確認しよう)</br>
[2-3_マイグレーションでカラムを追加しよう](#2-3_マイグレーションでカラムを追加しよう)</br>
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
