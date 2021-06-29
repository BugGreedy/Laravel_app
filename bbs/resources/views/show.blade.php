@extends('layout')

@section('content')
  <h1>mogura bbs</h1>
  <p>{{ $message }}</P>
  <p>ID:{{ $article->id }}</P>
  <p> {{ $article->content }}</P>
  <p>by {{ $article->user_name }}</P>

  <p>
    <a href={{ route('article.list') }} class='btn btn-outline-primary'>一覧に戻る</a>
    <!-- 下記を追加 -->
    <a href={{ route('article.edit',['id' => $article->id]) }} class='btn btn-outline-primary'>編集</a>
  </p>

  <div>
    {{ Form::open(['method' => 'delete', 'route' => ['article.delete', $article->id]]) }}
    {{ Form::submit('削除',['class'=>'btn btn-out-secondary']) }}
    {{ Form::close() }}
  </div>
@endsection