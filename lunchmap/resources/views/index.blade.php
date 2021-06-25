<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <title>lunchmap</title>
    <style>body {padding: 10px;}</style>
  </head>

  <body>
    <h1>お店一覧</h1>

    @foreach($shops as $shop)
      <p>
        {{ $shop->category->name}},
        {{ $shop->name}},
        {{ $shop->address}}
      </p>
    @endforeach
  </body>
</html>