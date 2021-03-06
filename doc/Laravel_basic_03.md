## Laravel入門編3: Laravelのビューとフォームを理解しよう (全11回) 

### 目次
[3-1_投稿フォームを作成しよう](#3-1_投稿フォームを作成しよう)</br>
[3-2_テンプレートを共通化しよう](#3-2_テンプレートを共通化しよう)</br>
[3-3_掲示板にBootstrapを適用しよう](#3-3_掲示板にBootstrapを適用しよう)</br>
[3ｰ4_Bootstrapでページの見栄えを整えよう](#3ｰ4_Bootstrapでページの見栄えを整えよう)</br>
[3-5_検索フォームを設置しよう](#3-5_検索フォームを設置しよう)</br>
[3-6_フォームの値を取得しよう](#3-6_フォームの値を取得しよう)</br>
[3-7_掲示板のルーティングを設計しよう](#3-7_掲示板のルーティングを設計しよう)</br>
[3-8_新規投稿フォームを作成しよう](#3-8_新規投稿フォームを作成しよう)</br>
[3-9_記事の保存機能を完成させよう](#3-9_記事の保存機能を完成させよう)</br>
[3-10_編集フォームを追加しよう-その1](#3-10_編集フォームを追加しよう-その1)</br>
[3-11_編集フォームを追加しよう-その2](#3-11_編集フォームを追加しよう-その2)</br>

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

***
<br>

### 3-8_新規投稿フォームを作成しよう
前回のチャプターで新規投稿機能であるcreateメソッドを作成しているので、それに投稿フォームを組み合わせる。</br>
この投稿フォームのビューの作成は次のチャプターで行う。</br>
</br>

記事の新規投稿の流れ
1. ユーザー側のWebブラウザからリクエストが送信される。
2. サーバー側からWebフォーム(create())の情報を送信する。
3. ユーザー側からリクエストと値(フォームに記入した記事データ)が送信される。
4. サーバーは値をDBに格納(store())し、処理結果を送信する。
Laravel側の動きとしては、createメソッドによって投稿フォームを送信し、storeメソッドによって投稿内容をDBに保存する。</br>
</br>

それでは新規投稿のコードを作っていく。</br>
```php
// bbs/app/Http/Controllers/ArticleController.php
// createメソッドからstoreメソッドに貼り付け
public function store(Request $request)
{
    $article  = new Article();
    $article->content = 'Hello BBS by store()method';
    $article->user_name = 'moglin';
    $article->save();
    return redirect('/articles');
}
```
続いて投稿フォームを呼び出せるようにcreateメソッドを修正する。
```php
// bbs/app/Http/Controllers/ArticleController.php
public function create()
{
    $message = 'New article';
    return view('new',['message'=>$message]);
}
```
続きは次のチャプターで。</br>
</br>

***
</br>

### 3-9_記事の保存機能を完成させよう
前回の続きとして、createメソッドで呼び出すフォームのビューを作成して、新規投稿機能を完成させる。</br>
</br>
それでは早速ビュー(new.blade.php)を作成し、下記のように編集する。</br>
```php
// bbs/resources/views/new.blade.php
@extends('layout')

@section('content')
  <h1>mogura bbs</h1>
  <p>{{ $message}}</p>
  {{ Form::open(['route'=> 'article.store'])}}
    <div class='form-group'>
      {{ Form::label('content','Content')}}
      {{ Form::text('content',null)}}
    </div>
    <div class='form-group'>
      {{ Form::label('user_name','Name:')}}
      {{ Form::text('user_name',null)}}
    </div>
    <div class='form-group'>
      {{ Form::submit('作成する',['class'=> 'btn btn-primary'])}}
      <a href={{ route('article.list')}}>一覧に戻る</a>
    </div>
  {{ Form::close()}}
@endsection
```
ここで一旦ブラウザを確認する。一覧ページから新規作成ボタンからnewへのリンクと、newの作成するボタンから正しく記事が作成されているか確認。</br>
確認できたら次はstoreメソッドがnewのフォームの内容を正しく保存できるように修正する。

```php
// bbs/app/Http/Controllers/ArticleController.php
public function store(Request $request)
{
    $article  = new Article();
    $article->content = $request->content;
    $article->user_name = $request->user_name;
    $article->save();
    return redirect()->route('article.show',['id'=>$article->id]);
}
```
</br>

***
</br>

### 3-10_編集フォームを追加しよう-その1
ここでは掲示板アプリに編集フォームを追加する。</br>
すでにルーティングは設定済みなのでコントローラを編集する。</br>
```php
// ルーティング設定(設定済み) bbs/routes/web.php
// 記事の編集
Route::get('/article/edit/{id}', 'ArticleController@edit')->name('article.edit');
Route::post('/article/update/{id}', 'ArticleController@update')->name('article.update');

// コントローラ bbs/app/Http/Controllers/ArticleController.php
public function edit(Request $request, $id, Article $article)
{
    $message = 'Edit your article' . $id;
    $article = Article::find($id);
    // 下記をshowからeditに修正
    return view('edit', ['message' => $message, 'article' => $article]);
}
```
次に上記で指定したeditのビューを作っていく。</br>
new.blade.phpをコピーしてedit.blade.phpを作成</br>

```php
// bbs/resources/views/edit.blade.php
@extends('layout')

@section('content')
  <h1>mogura bbs</h1>
  <p>{{ $message}}</p>
  <!-- 下記を編集 -->
  <!-- {{ Form::open(['route'=> 'article.store'])}} -->
  {{ Form::model($article,['route'=> ['article.update',$article->id]])}}
    <div class='form-group'>
      {{ Form::label('content','Content')}}
      <div class='col-sm-8'>
      {{ Form::textarea('content',null,['rows'=>'3'])}}
      </div>
    </div>
    <div class='form-group'>
      {{ Form::label('user_name','Name:')}}
      {{ Form::text('user_name',null)}}
    </div>
    <div class='form-group'>
    <!-- 下記を編集 -->
      <!-- {{ Form::submit('作成する',['class'=> 'btn btn-primary'])}} -->
      <!-- <a href={{ route('article.list')}}>一覧に戻る</a> -->
      {{ Form::submit('保存する',['class'=> 'btn btn-primary'])}}
      <a href={{ route('article.show',['id'=> $article->id])}}>一覧に戻る</a>
    </div>
  {{ Form::close()}}
@endsection
```
ここでは`{{ Form::model($article,['route'=> ['article.update',$article->id]])}}`というように**model**というフォームファサードを用いている。</br>
これによって入力欄に自動的に取得したIDの値を表示する事ができる。</br>
</br>

いったんここで動作確認を行う。</br>
一覧ページからアドレスバーに`/article/edit/1`としてid=1の記事が入力欄に表示されていればOK。</br>
</br>

***
</br>

### 3-11_編集フォームを追加しよう-その2
前章で追加した編集ページで、修正した内容を保存できるようにupdateメソッドを編集する。</br>

```php
// bbs/app/Http/Controllers/ArticleController.php
public function update(Request $request,$id, Article $article)
{
    // 下記を追加
    $article  = Article::find($id);
    $article->content = $request->content;
    $article->user_name = $request->user_name;
    $article->save();
    return redirect()->route('article.show', ['id' => $article->id]);
}
```
基本的にはstoreメソッドからコードをコピーして編集する。</br>
storeメソッドでは、`$article = new Article();`のように新しい記事を作成するのに対し</br>
updateメソッドでは。`$article = Article::find($id);`というように指定のidの値を保存する。</br>
</br>

つぎに編集画面を開けるように詳細画面を編集する。</br>

```php
// bbs/resources/views/show.blade.php
<p>
  <a href={{ route('article.list') }} class='btn btn-outline-primary'>一覧に戻る</a>
  <!-- 下記を追加 -->
  <a href={{ route('article.edit',['id' => $article->id]) }} class='btn btn-outline-primary'>編集</a>
</p>
```
これで詳細ページに編集ボタンを追加できた。</br>
以上で掲示板アプリケーションの機能を全て追加できた。
