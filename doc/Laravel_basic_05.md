## Laravel入門編5: Laravelでユーザー管理しよう (全9回)

### 目次
[5-1_ユーザー管理機能を理解しよう](#5-1_ユーザー管理機能を理解しよう)</br>
[5-2_ユーザー管理機能を追加しよう](#5-2_ユーザー管理機能を追加しよう)</br>
[*_エラー対処1_make:authができないため代わりの方法で対処](#エラー対処1_makeauthができないため代わりの方法で対処)</br>
[5-3_ユーザー管理用のテーブルを用意しよう](#5-3_ユーザー管理用のテーブルを用意しよう)</br>
[*_エラー対処2_ログイン画面にCSSが適用されない件](#エラー対処2_ログイン画面にCSSが適用されない件)</br>
[5-4_ログインフォームの動作確認をしよう](#5-4_ログインフォームの動作確認をしよう)</br>
[5-5_ログイン機能を追加しよう](#5-5_ログイン機能を追加しよう)</br>


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

### エラー対処1_makeauthができないため代わりの方法で対処
>調べてみるとLaravel6.0以降、`make auth`コマンドは廃止されたらしい。</br>
>そこで下記の所作を行った。</br>
>参考：
>- [Laravel 6.0 で「make:auth」が利用できなくなったので、対応方法記載します。｜Koushi Kagawa｜note](https://note.com/koushikagawa/n/n1b5bb4a69514)</br>
>- [認証-Laravel-Web職人のためのPHPフレームワーク](https://laravel.com/docs/6.x/authentication#included-views)</br>
>
>1. `Laravel/ui`をインストール
>
>   ```shell
>   composer require laravel/ui
>   ```
>   </br>
> 
>2. 認証関連のビューファイルの作成
>
>   ```shell
>   php artisan ui vue --auth
>   
>   Vue scaffolding installed successfully.
>   Please run "npm install && npm run dev" to compile your fresh scaffolding.
>   Authentication scaffolding generated successfully.
>   ```
>   </br>
>
>3. メッセージにあった`"npm install && npm run dev"`を実行。
>
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
次にマイグレートを実行。</br>

```shell
% php artisan migrate
```
これでDB`myauth`にアプリケーション内で設定していた`users,password_resets,migration`(あと`failed_jobs`)が追加できた。</br>
</br>

次にアプリケーション全体の設定として`http(本来はhttps)`で行うように設定を行う。</br>
```php
// test_auth/app/Providers/AppServiceProvider.php
/**
 * Bootstrap any application services.
 *
 * @return void
 */
public function boot()
{   
    // 下記を追加
    \URL::forcScheme('http');
}
```

### エラー対処2_ログイン画面にCSSが適用されない件
>ここでログイン画面がプレーンなHTMLなままなので理由と対策を調査。</br>
>(カリキュラムや`laravle/ui`だと何かのCSSが適用されている。)</br>
>参考：
>[[Laravel 6.0+] ログイン・登録画面を用意する - Larapet]https://larapet.hinaloe.net/2019/09/11/scaffold-auth-screen/</br>
></br>
>どうやらLaravel_6以降のバージョンではそれまで同梱されていたBootstrapのJS/CSSがなくなった事でこうなっているらしい。</br>
>(ui:auth だけではスタイルの適用されていない中途半端な画面になる)</br>
>なのでこれを時前で用意する必要がある。</br>
>
>```shell
># VueやReactを利用しない、Bootstrap(+jQuery)のみのプリセット 
>$ artisan ui bootstrap --auth 
># Bootstrapに加えてVue.jsを利用する 
>$ artisan ui vue --auth 
># Vue.jsではなくReactを利用する 
>$ artisan ui react --auth
>```
>これらで生成したプリセットはコンパイル前の sass, js のみなのでwebpack(laravel-mix)でコンパイルする必要がある。</br>
>なおこれにはnode.jsが必要。</br>
>`laravel/ui`導入時に一緒にインストールした`npm`を用いて
>```shell
># with npm
>$ npm i
># 開発用ビルド
>$ npm run dev
># 本番用ビルド【実行していない)
>$ npm run prod
>
>  Laravel Mix v6.0.25   
>                         
>
>✔ Compiled Successfully in 5673ms
>┌───────────────────────────────────────────────────────────┬─────────┐
>│                                                      File │ Size    │
>├───────────────────────────────────────────────────────────┼─────────┤
>│                                                /js/app.js │ 1.4 MiB │
>│                                               css/app.css │ 178 KiB │
>└───────────────────────────────────────────────────────────┴─────────┘
>webpack compiled successfully
>```
>ここでブラウザを確認(http://localhost:8000/register)
>したらCSSが反映されいたのでOK。
</br>

***
</br>

### 5-4_ログインフォームの動作確認をしよう
ここではhttp://localhost:8000/register
にアクセスしてユーザー登録を行ってみた。</br>
```
username:
mogura
email:
mogura@mogura.com
pass:
mogumogu
```
</br>

***
</br>

### 5-5_ログイン機能を追加しよう
ここではLunchmapアプリにユーザー機能を追加する。</br>
前々章でやった[authを作成するコマンド](#エラー対処1_makeauthができないため代わりの方法で対処)を行う。</br>

```shell
% composer require lalavel/ui
% npm install
% npm run dev
```
routeを確認するとユーザー管理用のrouteを追加している。</br>
```php
//lunchmap/routes/web.php
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
```
またビューにはauthというビューが追加されている。</br>
</br>

それではlunchmapアプリでユーザー登録とログイン機能を利用できるようにする。</br>
共通テンプレートに下記の記述を記載する。</br>
```php
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>

    <!-- 下記を追加 -->
    <meta name='csrf-token' content='{{ csrf_token() }}'>

    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <title>Lunchmap</title>
    
    <!-- 下記を追加 -->
    <script src='{{ asset("js/app.js") }}'defer></script>

    <style>
        body {
            padding-top: 80px;
        }

    </style>
</head>
```
>* `<meta name='csrf-token' content='{{ csrf_token() }}'>`について</br>
>`csrf_token()`とは**Cross Site Request Forgery(リクエスト強要)**と呼ばれる攻撃手法に対策するものです。</br>
>CSRFはWebアプリケーションへのリクエストを記述した命令を不本意に実行させて、その人の権限でリクエストを実行させるという攻撃です。</br>
>例えば本講座ではPOSTメソッドを使ってLunchmapアプリにお店を追加しますが、</br>
>1. お店を追加するPOSTリクエストを記述したボタンのある偽のサイトを用意する
>2. 攻撃対象のユーザーに偽のサイトへアクセスさせる
>3. 攻撃対象のユーザーが(1)のボタンをクリックしてしまう
>4. 攻撃対象のユーザーがLunchmapアプリにログイン中だった場合、クリックしたボタンのPOSTメソッドが受理されてしまい、意図せずお店が追加されてしま>う
></br>
>という流れで攻撃が成立してしまいます。</br>
>実際に存在するSNSで、CSRFを利用してユーザーの知らないところで不本意な投稿を大量に繰り返されてしまうという事件がありました。</br>
>このことの対策として、一回使い切りの認証情報を作ることで毎回「本当に本人が要求したリクエストなのか？」ということを確認する方法があります。</br>
>この認証情報は毎回変わりますので事前に偽のリクエストを作ることが難しくなりますし、最悪認証情報を盗まれてしまったとして使い捨てなのでその時点では>もう使用済みで破棄されているから大丈夫、ということになります。</br>
></br>
>Laravelではこの「一回使い切りの認証情報」を簡単に利用できるようになっています。一回使い切りの認証情報を自動で作成し、その認証情報が正しいかの照>合まで行ってくれるのが「csrf_token()」という機能なのです。</br>
></br>

>* `<script src='{{ asset("js/app.js") }}' defer></script>`という記述について</br>
>ここでapp.jsを読み込んでいるのですが、読み込まれているapp.jsはpublic/js/app.jsにあります。</br>
>しかし、このapp.jsは別のスクリプトをコンパイルしてブラウザで表示するように圧縮されたものであり、その圧縮する前の本体であるスクリプトはresources/js/app.jsとなります。</br>
>本体のapp.jsの8行目で同じディレクトリにあるbootstrap.jsが呼び出されていますが、このbootstrap.jsの中に上の項で解説したcsrf_tokenの認証に関わる処理が記述されており(27-39行目)、csrf_tokenを利用するために読み込む必要のあるスクリプトなのです。</br>
</br>

次にナビゲーターバーにログイン機能の表示を追加する。</br>
ログイン機能用の共通テンプレートから下記を抜粋し、共通テンプレートに貼り付ける。</br>

```php
//lunchmap/resources/views/layouts/app.blade.php
<button class="navbar-toggler" type="button" data-toggle="collapse"
    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
    aria-label="{{ __('Toggle navigation') }}">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <!-- Left Side Of Navbar -->
    <ul class="navbar-nav mr-auto">

    </ul>

    <!-- Right Side Of Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
            @endif

            @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @endif
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</div>
```
をコピーし、下記の箇所にペースト
```php
//lunchmap/resources/views/layout.blade.php
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name='csrf-token' content='{{ csrf_token() }}'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
    <title>Lunchmap</title>
    <script src='{{ asset("js/app.js") }}'difer></script>

    <style>
        body {
            padding-top: 80px;
        }

    </style>
</head>

<body>
    <nav class='navbar navbar-expand-md navbar-dark bg-dark fixed-top'>
        <a class='navbar-brand' href={{ route('shop.list') }}>Lunchmap</a>
        // ここに挿入
    </nav>
    <div class='container'>
        @yield('content')
    </div>
</body>

</html>
```
これでlunchmapアプリのナビゲーションバーに前章で追加したような`Login`と`Reguster`が表示されるようになった。
ユーザーを2つ追加してDBにて追加されているか確認して終了する。
```
ユーザー1：
name:mogura
mail:mogura@mogura.com
pass:mogumogu

ユーザー2：
name:mogura2
mail:mogura2@mogura.com
pass:mogumogu
```
</br>

***
</br>

sss



