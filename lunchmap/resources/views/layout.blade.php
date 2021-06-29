<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <!-- 下記を追加 -->
  <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'>
  <!-- 追加ここまで -->
  <title>Lunchmap</title>
  <style>
    body {
      padding-top: 80px;
    }
  </style>
</head>

<body>
  <!-- 下記にナビゲーションバーを追加 -->
  <nav class='navbar navbar-expand-md navbar-dark bg-dark fixed-top'>
    <a class='navbar-brand' href={{route('shop.list')}}>Lunchmap</a>
  </nav>
  <!-- コンテンツをcontainerタグで囲む -->
  <div class='container'>
    @yield('content')
  </div>
</body>

</html>