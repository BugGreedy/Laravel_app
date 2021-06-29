@extends('layout')

@section('content')
  <h1>お店一覧</h1>

  {{-- これまで箇条書きで表示されていた一覧にテーブルを割り当てる --}}
  <table class='table table-striped table-hover'>
    <tr>
      <th>カテゴリ</th><th>店名</th><th>住所</th>
    </tr>
    @foreach ($shops as $shop)
      <tr>
        <td>{{ $shop->category->name }}</td>
        <td>
          <a href={{ route('shop.detail',['id' => $shop->id])}}>{{ $shop->name }}</a>
        </td>
        <td>{{ $shop->address }}</td>
      </tr>
    @endforeach
  </table>

    
@endsection