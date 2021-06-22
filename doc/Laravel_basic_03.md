## Laravel入門編3: Laravelのビューとフォームを理解しよう (全11回) 

### 目次
[3-1_投稿フォームを作成しよう](#3-1_投稿フォームを作成しよう)</br>
[3-2_テンプレートを共通化しよう](#3-2_テンプレートを共通化しよう)</br>
[3-3_掲示板にBootstrapを適用しよう](#3-3_掲示板にBootstrapを適用しよう)</br>
[3ｰ4_Bootstrapでページの見栄えを整えよう](#3ｰ4_Bootstrapでページの見栄えを整えよう)</br>
[3-5_検索フォームを設置しよう](#3-5_検索フォームを設置しよう)</br>
[3-6_フォームの値を取得しよう](#3-6_フォームの値を取得しよう)</br>

</br>

***
</br>

### 3-1_投稿フォームを作成しよう
このカリキュラムでは掲示板を題材に、ビューとフォームを学習
- テンプレートの共通化
- Bootstrapを読み込む
  - 掲示板にBootstrapを適用しよう
  - Bootstrapで見栄えを整えよう
- 検索フォーム
- 投稿フォーム(新規、作成、編集、更新)</br>
</br>

***
</br>

### 3-2_テンプレートを共通化しよう
画面の共通部分を共通テンプレートとしてまとめる。</br>
index.blade.phpからlayout.blade.phpを作成。
```html
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <title>mogura bbs</title>
  <style>
    body {
      padding: 10px;
    }
  </style>
</head>

<body>
<!--  個別ベージ部分 -->
  @yield('content')     
</body>

</html>
```
このように共通の部分のみのファイルを作成する。</br>
各ページの個別部分は`@yield('content')`という箇所に埋め込む。</br>
</br>

それでは各ページのビューを修正していく。
```html
<!-- 一覧ページ bbs/resources/views/index.blade.php -->
<!-- 先程取り出した部分(共通部分)を削除して下記を追記 -->
@extends('layout')

@section('content')
  <h1>mogura bbs</h1>
  <p>{{ $message }}</P>
  @foreach ($articles as $article)
  <p>
    <a href='{{ route("article.show",["id" => $article->id]) }}'>
      ID:{{ $article->id}},
      {{ $article->content}}, by
    {{ $article->user_name}}</a>
  </p>
  @endforeach
  <!-- 下記を追記 -->
  <div><a href={{ route('article.new') }}>●新規投稿●</a></div>
<!-- 個別の終わりに下記も追記 -->
@endsection
```
詳細ページも同様に編集
```html
<!-- 詳細ページ bbs/resources/views/show.blade.php -->
@extends('layout')

@section('content')
  <h1>mogura bbs</h1>
  <p>{{ $message }}</P>
  <p>ID:{{ $article->id }}</P>
  <p> {{ $article->content }}</P>
  <p>by {{ $article->user_name }}</P>

  <p>
    <a href={{ route('article.list') }}>一覧に戻る</a>
  </p>

  <div>
    {{ Form::open(['method' => 'delete', 'route' => ['article.delete', $article->id]]) }}
    {{ Form::submit('削除') }}
    {{ Form::close() }}
  </div>
@endsection
```
</br>

***
</br>

### 3-3_掲示板にBootstrapを適用しよう
今回はLaravelに標準で備わっているBootstrapテンプレートを使わずにWebでダウンロードしたものを用いる。</br>
それではBootstrapを導入する。これは共通テンプレートの追加部分として記述する。</br>
まず、追加用のテンプレートファイルを用意する。(style-sheet.blade.php)
```html
<!-- bbs/resources/views/style-sheet.blade.php -->

<meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
<style>body {padding-top: 80px;}</style>
```
次にこの追加テンプレートを読み込むように共通テンプレートを編集する。</br>
ついでに表示サイズによってレイアウトが崩れないように`<body>タグ`も修正する
```html
<!-- bbs/resources/views/layout.blade.php -->

<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <title>mogura bbs</title>
  <!-- <style>タグの部分を削除 -->
  @include('style-sheet')
</head>

<!-- <body>タグを編集 <div class='container'>~</div>を追加-->
<body>
  <div class='container'>
    @yield('content')
  </div>
</body>

</html>
```
ここで動作を確認すると、追加したテンプレートが反映されている事が分かる。</br>
</br>

それでは次に、ナビゲーションバーを追加してみよう。</br>
導入用にテンプレートファイルを作成(nav.blade.php)して下記を記述する。</br>
```php
// bbs/resources/views/nav.blade.php
<nav class='navbar navbar-expand-md navbar-dark bg-dark fixed-top'>
  <a class='navbar-brand' href={{ route('article.list') }}>mogura bbs</a>
</nav>
```
次にこのナビゲーションバーを共通テンプレートに追加する。
```php
// bbs/resources/views/layout.blade.php
<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <title>mogura bbs</title>
  @include('style-sheet')
</head>

<body>
  <!-- 下記を追記 -->
  @include('nav')

  <div class='container'>
    @yield('content')
  </div>
</body>

</html>
```
これで各ページにナビゲーションバーを追加する事ができた。</br>
</br>

***
</br>

### 3ｰ4_Bootstrapでページの見栄えを整えよう
まず記事一覧にテーブルのスタイルを割り当てる。</br>
のちに投稿ボタンにもデザインを割り当てる。</br>
</br>

それではまずindexにテーブルタグを追加していく。</br>
テーブルタグを追加してループで表示している箇所をテーブルに置き換える。</br>
具体的にはこれまで<p>タグで表示していた箇所を<tr><td>のテーブル表示に切り替える。
```php
// bbs/resources/views/index.blade.php
@extends('layout')

@section('content')
<h1>mogura bbs</h1>
<p>{{ $message }}</P>

<!-- 下記を追記 -->
<table class='table table-striped table-hover'>
  @foreach ($articles as $article)
  <tr>
    <td><a href='{{ route("article.show",["id" => $article->id]) }}'>
      ID:{{ $article->id}}
    </td>
    <td>
      {{ $article->content}}
    </td>
    <td>
      {{ $article->user_name}}</a>
    </td>
  </tr>
  @endforeach
</table>
<div><a href={{ route('article.new') }}>●新規投稿●</a></div>
@endsection
```
次にボタンにデザインを割り当てる。</br>
```php
// bbs/resources/views/index.blade.php

//下記のリンクにclass属性を追加
略
</table>
<div><a href={{ route('article.new') }} class='btn btn-outline-primary'>新規投稿</a></div>
@endsection
```
次に詳細ページにおいてもボタンにデザインを追加する。</br>
```php
// bbs/resources/views/show.blade.php

// class属性を追加
略
  <p>
    <a href={{ route('article.list') }} class='btn btn-outline-primary'>一覧に戻る</a>
  </p>

  <div>
    {{ Form::open(['method' => 'delete', 'route' => ['article.delete', $article->id]]) }}
    {{ Form::submit('削除',['class'=>'btn btn-out-secondary']) }}
    {{ Form::close() }}
  </div>
@endsection
```
これで一覧・詳細ページにデザインを追加する事ができた。</br>
このように各要素にclass属性を追加する事でWeb上のBootstrapテンプレートを使用する事ができる。</br>
</br>

***
</br>

### 3-5_検索フォームを設置しよう
ここでは記事検索機能を追加する。そのため一覧表示画面に検索フォームを追加する。</br>
Laravelにおける基本的なフォームの使い方を理解する。</br>
</br>

Laravelでフォームを使うために**laravelcollective/html**というライブラリを用いる。
```shell
% composer require "laravelcollective/html":"^5.4.0"
# 最新版を入れる際は
% composer require "laravelcollective/html" -w
# "-w"は"to allow upgrades"というオプション

# 導入されたライブラリを確認する
%composer info
```
</br>

それでは検索フォームを作成していく。</br>
検索フォーム用のテンプレート(search.blade.php)を作成して、下記のように編集する。
```php
// bbs/resources/views/seaech.blade.php
{{Form::open(['method'=>'get'])}}
  {{csrf_field()}}
  <div class='form-group'>
    {{ Form::label('keyword','キーワード:')}}
    {{ Form::text('keyword',null,['class'=>'form-control'])}}
  </div>
  <div class='form-group'>
    {{ Form::submit('検索',['class'=>'btn btn-outline-primary'])}}
    <a href={{ route('article.list')}}>クリア</a>
  </div>
{{ Form::close()}}
```
</br>

**ファサード(facade)について**
ファサードとはLaravelにおいてフォームを利用するために記述する**2重のブラケット{{ ~ }}**の事である。</br>
このような部品を**Formファサード**という。</br>
Laravelのファサードは、アプリケーションのサービスコンテナに登録したクラスに対するインターフェースを提供する。</br>
</br>

続いて、記事一覧のビューに検索フォームのテンプレートを追加する。</br>
```php
// bbs/resources/views/index.blade.php
@extends('layout')

@section('content')
<h1>mogura bbs</h1>
<p>{{ $message }}</P>
<!-- 下記を追記 -->
@include('search')

略
```
これで一覧ページにアクセスすると検索フォームが表示される。</br>
</br>

***
</br>

### 3-6_フォームの値を取得しよう
検索機能が正しく作動するようにファイルを編集する。</br>
具体的には、検索フォームからGETメソッドでキーワードを受け取ったら、該当の記事を表示するよう`ArticleController.php`を修正する。

```php
// bbs/app/Http/Controllers/ArticleController.php
    public function index(Request $request)
    {
        // 下記を追記
        if($request->filled('keyword')){
            $keyword = $request->input('keyword');
            $message = 'Welcome to my BBS:'.$keyword;
            $article = Article::where('content','like','%'.$keyword.'%')->get();
        }else{
            $message = 'Welcome to My BBS';    
             $articles = Article::all();        
        }
       
        return view('index',['message' => $message], ['articles' => $articles]);
    }
```

- `if($request->filled('keyword')){`</br>
  indexメソッドの引数にリクエストを追加し、そのリクエストの変数に値がある場合という指定を行っている。</br>
</br>

- `$article = Article::where('content','%'.'$keyword'.'%')->get();`
  SQLの項目でやったようにデータの中から曖昧検索を行い、GETメソッドで該当の記事を取得する。</br>
</br>
これで検索機能が追加できた。</br>
</br>

***
</br>

### 3-7_掲示板のルーティングを設計しよう
ここからは投稿機能を作成していく。</br>
前回の固定記事の新規投稿のリンクと、編集と更新のルーティングを追加する。</br>
```php
// bbs/routes/web.php
Route::get('/', function () {
    // return view('welcome');  下記に編集
    return redirect('/articles');
});

// 一覧表示
Route::get('/articles','ArticleController@index')->name('article.list');
// 新規作成
Route::get('/article/new','ArticleController@create')->name('article.new');
// 記事の投稿
Route::post('/article','ArticleController@store')->name('article.store');

// 記事の編集
Route::get('/article/edit/{id}','ArticleController@edit')->name('article.edit');
Route::post('/article/update/{id}','ArticleController@update')->name('article.update');

// 詳細表示
Route::get('/article/{id}','ArticleController@show')->name('article.show');
// 記事の削除
Route::delete('/article/{id}','ArticleController@destroy')->name('article.delete');
```
</br>

次にコントローラーのeditメソッドを修正する。</br>
```php
// bbs/app/Http/Controllers/ArticleController.php

// 同コントローラー内のshowメソッドから引数とコードの中身を貼り付ける。
    public function edit(Request $request, $id, Article $article)
    {
        $message = 'Edit your article ' . $id;
        $article = Article::find($id);
        return view('show', ['message' => $message, 'article' => $article]);
    }
```
ここでいったんアドレスに(http://localhost:8000/article/edit/1)
など打って詳細ページ同様に表示されるか確認。 
</br>
