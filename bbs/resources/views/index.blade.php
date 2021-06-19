<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>mogura bbs</title>
    <style>body {padding: 10px;}</style>
  </head>
  <body>
    <h1>mogura bbs</h1>
    <p>{{ $message }}</P>
    <!-- 下記を追記 -->
    @foreach ($articles as $article)
      <p>
        <a href='{{ route("article.show",["id" => $article->id]) }}'>
        {{ $article->content}}</a>
        {{ $article->user_name}}</a>
      </p>
    @endforeach
  </body>
</html>

