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