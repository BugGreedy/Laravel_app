@extends('layout')

@section('content')
<h1>mogura bbs</h1>
<p>{{ $message }}</P>
<!-- 下記を追記 -->
@include('search')

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
<div><a href={{ route('article.new') }} class='btn btn-outline-primary'>新規投稿</a></div>
@endsection