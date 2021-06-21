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