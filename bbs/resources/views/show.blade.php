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
  <h1>mogura bbs</h1>
  <p>{{ $message }}</P>
  <p>{{ $article->content }}</P>
  <p>by {{ $article->user_name }}</P>

  <p>
    <a href={{ route('article.list') }}>一覧に戻る</a>
  </p>
</body>

</html>