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
