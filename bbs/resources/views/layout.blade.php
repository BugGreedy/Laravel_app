<!DOCTYPE html>
<html>

<head>
  <meta charset='utf-8'>
  <title>mogura bbs</title>
  <!-- <style>タグの部分を削除 -->
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
