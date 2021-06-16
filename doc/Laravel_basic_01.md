## Laravel入門編1: Laravelの基本を理解しよう

### 目次
[1-1_Laravelの基本を理解しよう](#1-1_Laravelの基本を理解しよう)</br>
[1-2_アプリケーションを用意しよう](#1-2_アプリケーションを用意しよう)</br>
[1-3_LaravelでHelloWorld](#1-3_LaravelでHelloWorld)</br>
[1-4_1行掲示板を作ろう](#1行掲示板を作ろう)</br>

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
ターミナルで`public_html`というディレクトリを作成後、`bbs`というプロジェクト(ディレクトリ)を作成する。</br>
Laravelのインストールについては[こちら](/doc/Laravel_install_00.md)を参照。</br>
```bash
$ mkdir public_html
$ cd public_html
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

```bash
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
場所は`/resources/views/welcome.blade.php/`である。</br>
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
  **備考:Blade**</br>
  - BladeはシンプルながらパワフルなLaravelのテンプレートエンジンです。他の人気のあるPHPテンプレートエンジンとは異なり、ビューの中にPHPを直接記述することを許しています。全BladeビューはPHPへコンパイルされ、変更があるまでキャッシュされます。つまりアプリケーションのオーバーヘッドは基本的に０です。Bladeビューには.blade.phpファイル拡張子を付け、通常はresources/viewsディレクトリの中に設置します。
</br>




