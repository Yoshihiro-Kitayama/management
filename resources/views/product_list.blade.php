@extends('layouts.app')

@section('title', '商品画面一覧')

@section('content')

<div class="container">
     <h1 class="info">商品画像一覧</h1>
</div>

<form action="{{ route('products.search') }}" method="GET">
    @csrf
<div class="search">

    <!-- 商品名検索 -->
    <div class="search_product">
        <input type="text" class="search_box" name="keyword" placeholder="検索キーワード">
    </div>

    <!-- メーカー名検索 -->
        <!-- <input type="text" name="sort" list="company_id" placeholder="メーカー名">
        <datalist id="company_id">
        <option value="Coka-cola"></option>
        <option value="サントリー"></option>
        <option value="キリン"></option>
        </datalist> -->

    <div class="search_company">
        <select name="company_id" class="search_box">
        <option value=""></option>
        @foreach($companies as $company)
            <option value="{{ $company->id }}">
                {{ $company->company_name }}
            </option>
        @endforeach
        </select>
    </div>

    <div>
        <input type="submit" value="検索">
    </div>
    
</div>
    </form>

<div class="links">
  <table class="table table-striped">
     <thead>
        <tr>
            <th>ID</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th></th>
            <th><a href="{{ route('products.regist') }}" class="btn btn-warning">新規登録</a></th>
        </tr>
    </thead>
     <tbody>
     @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            
            <td><img src="{{ asset($product->img_path) }}"></td>

            <td>{{ $product->product_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->company_id }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('products.show' , $product->id) }}">詳細</a>
            </td>
            <td>
                <form action="{{ route('products.destroy', $product->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？")'>
                        削除
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
  </table>
  
@endsection
