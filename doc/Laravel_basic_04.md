## Laravel入門編4: 実用的なLaravelアプリを作ろう (全13回)

### 目次
[4-1_アプリの概要を整理しよう](#4-1_アプリの概要を整理しよう)</br>
[4-2_アプリケーションディレクトリを用意しよう](#4-2_アプリケーションディレクトリを用意しよう)</br>
[4-3_モデルとコントローラを用意しよう](#4-3_モデルとコントローラを用意しよう)</br>


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

### 4-4_