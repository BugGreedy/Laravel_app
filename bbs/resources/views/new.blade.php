@extends('layout')

@section('content')
  <h1>mogura bbs</h1>
  <p>{{ $message}}</p>
  {{ Form::open(['route'=> 'article.store'])}}
    <div class='form-group'>
      {{ Form::label('content','Content')}}
      <div class='col-sm-8'>
      {{ Form::textarea('content','記事を入力してください',['rows'=>'3'])}}
      </div>
    </div>
    <div class='form-group'>
      {{ Form::label('user_name','Name:')}}
      {{ Form::text('user_name','ユーザー名を入力してください')}}
    </div>
    <div class='form-group'>
      {{ Form::submit('作成する',['class'=> 'btn btn-primary'])}}
      <a href={{ route('article.list')}}>一覧に戻る</a>
    </div>
  {{ Form::close()}}
@endsection