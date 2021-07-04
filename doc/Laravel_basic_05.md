## Laravel入門編5: Laravelでユーザー管理しよう (全9回)

### 目次
[5-1_ユーザー管理機能を理解しよう](#5-1_ユーザー管理機能を理解しよう)</br>
[5-2_ユーザー管理機能を追加しよう](#5-2_ユーザー管理機能を追加しよう)</br>
[* エラー対処1_make:authができないため、代わりの方法で対処](#エラー対処1_make:authができないため、代わりの方法で対処)</br>
[5-3_ユーザー管理用のテーブルを用意しよう](#5-3_ユーザー管理用のテーブルを用意しよう)</br>


</br>

***
</br>

### 5-1_ユーザー管理機能を理解しよう
ここではLaravelのユーザー管理機能について理解すると共に、Lunchmapアプリの追加機能について確認する。</br>
</br>

- **ユーザー管理機能**</br>
  まず、ユーザー管理機能を使うためには、**ユーザー情報**というデータを所持している状態で**ユーザー認証**を行う必要がある。</br>
  ユーザー認証をもとに、投稿・編集・削除ができるユーザーと閲覧のみできるユーザーの判断、また登録していないユーザーはアクセスを拒否するなどのの**アクセス許可**を行う。</br>
</br>

- **Laravelのユーザー管理機能(もともともっている機能)**</br>
  - ユーザー情報：Userモデル、マイグレーションファイル
  - ユーザー認証：ログイン・ログアウト・パスワード変更などのコントローラとビューを標準装備
  - アクセスの許可：アクセス盛業に利用できるヘルパー関数やクラス</br>
</br>

### 5-2_ユーザー管理機能を追加しよう
ここではユーザー管理機能を追加する。</br>
これまで作成していたアプリケーションだとどこからが元からある機能かが不明のため、新規にディレクトリを作成して確認しながら実装する。</br>
</br>

**アプリケーション作成手順**</br>
1. アプリ用ディレクトリを用意
2. ユーザー管理ようのコントローラーとマイグレーションファイルを用意
3. ユーザー管理用のルートとビューを追加
4. データベースを作成する
5. モデルとコントローラを生成
6. マイグレーション
7. アプリの機能に合わせてコントローラとビュー作成</br>
</br>

まず、新規プロジェクトディレクトリ`(test_auth)`を作成
```shell
% composer create-project laravel/laravel test_auth --prefer-dist
```
ここでできたばかりのアプリケーションディレクトリを確認してみると、モデルの中にはすでにUserモデルがあり、DBディレクトリにはUserとパスワードリセットのマイグレーションファイルがある事が分かる。</br>
ここではまたユーザー管理機能用のルートとビューが設定されていないので下記を実行して追加する。</br>
```shell
% php artisan make:auth
```
ここで下記のようなエラーが発生したため調査を行った。</br>
```shell
test_auth % php artisan make:auth

                                       
  Command "make:auth" is not defined.  
                                       
  Did you mean one of these?           
      make:cast                        
      make:channel                     
      make:command                     
      make:component                   
      make:controller                  
      make:event                       
      make:exception                   
      make:factory                     
      make:job                         
      make:listener                    
      make:mail                        
      make:middleware                  
      make:migration                   
      make:model                       
      make:notification                
      make:observer                    
      make:policy                      
      make:provider                    
      make:request                     
      make:resource                    
      make:rule                        
      make:seeder                      
      make:test                        
                                       
```
</br>

### エラー対処1_make:authができないため、代わりの方法で対処
>調べてみるとLaravel6.0以降、`make auth`コマンドは廃止されたらしい。</br>
>そこで下記の所作を行った。</br>
>参考：
>- [Laravel 6.0 で「make:auth」が利用できなくなったので、対応方法記載します。｜Koushi Kagawa｜note](https://note.com/koushikagawa/n/n1b5bb4a69514)</br>
>- [認証-Laravel-Web職人のためのPHPフレームワーク]https://laravel.com/docs/6.x/authentication#included-views</br>
>
>1. `Laravel/ui`をインストール
>   ```shell
>   composer require laravel/ui
>   ```
>   </br>
>2. 認証関連のビューファイルの作成
>   ```shell
>   php artisan ui vue --auth
>
>   Vue scaffolding installed successfully.
>   Please run "npm install && npm run dev" to compile your fresh scaffolding.
>   Authentication scaffolding generated successfully.
>   ```
>   </br>
>3. メッセージにあった`"npm install && npm run dev"`を実行。
>   ```shell
>   test_auth % npm install
>   npm WARN deprecated urix@0.1.0: Please see https://github.com/lydell/urix#deprecated
>   npm WARN deprecated resolve-url@0.2.1: https://github.com/lydell/resolve-url#deprecated
>   npm WARN deprecated uuid@3.4.0: Please upgrade  to version 7 or higher.  Older versions may use Math.random() in certain circumstances, which is known to be problematic.  See https://v8.dev/blog/math-random for details.
>   npm WARN deprecated querystring@0.2.0: The
>   npm WARN deprecated popper.js@1.16.1: You can find the new Popper v2 at @popperjs/core, this package is dedicated to the legacy v1
>   
>   added 816 packages, and audited 817 packages in 32s
>   
>   84 packages are looking for funding
>     run `npm fund` for details
>   
>   found 0 vulnerabilities
>   npm notice 
>   npm notice New minor version of npm available! 7.10.0 -> 7.19.1
>   npm notice Changelog: https://github.com/npm/cli/releases/tag/v7.19.1
>   npm notice Run npm install -g npm@7.19.1 to update!
>   npm notice 
>   ```
>   </br>
>
>   ```shell
>   test_auth % npm run dev
>   
>   > dev
>   > npm run development
>   
>   
>   > development
>   > mix
>   
>    	Additional dependencies must be installed. This will only take a moment.
>   
>    	Running: npm install vue-loader@^15.9.7 --save-dev --legacy-peer-deps
>   
>    	Finished. Please run Mix again.
>   ```
></br>
>エラー対処はここまで</br>
</br>

これでユーザー管理機能のルートとビューが追加できた。</br>
ただし、まだマイグレートしていないのでユーザー登録やログインはできない。</br>
</br>

### 5-3_ユーザー管理用のテーブルを用意しよう
ここではユーザー管理用のDBを作成して、使用できるように設定していく。</br>
基本的にはこれまでやってきた手順と同じだが復習として再度記述する。</br>
</br>

まず、このアプリケーション用にphpMyAdminでDBを作成する。</br>

```
DB名：myauth
照合順序:utf8_general_ci → 日本語を扱うため
```
続いてこのDBを扱えるように`.env`という隠しファイルを設定する。</br>

```php
// test_auth/.env
// 下記の箇所だけ編集

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=myauth
DB_USERNAME=root
DB_PASSWORD=root
```

