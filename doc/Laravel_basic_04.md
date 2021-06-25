## Laravel入門編4: 実用的なLaravelアプリを作ろう (全13回)

### 目次
[4-1_アプリの概要を整理しよう](#4-1_アプリの概要を整理しよう)</br>
[アプリケーションディレクトリを用意しよう](#アプリケーションディレクトリを用意しよう)</br>


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

### アプリケーションディレクトリを用意しよう
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

