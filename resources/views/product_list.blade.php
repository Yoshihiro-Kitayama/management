@extends('layouts.app')

@section('title', '商品画面一覧')

@section('content')

<div class="container">
<h1 class="info">商品画像一覧</h1>
</div>

<form action="{{ route('products.search') }}" method="GET" id="search_form">
    @csrf
<div class="search1">

    <!-- 商品名検索 -->
    <div class="search_product">
        <input type="text" class="search_box" id="search_name" name="keyword" placeholder="検索キーワード">
    </div>


    <div class="search_company">
        <select name="search_company" class="search_box">
        <option value=""></option>
        @foreach($companies as $company)
            <option value="{{ $company->id }}">
                {{ $company->company_name }}
            </option>
            @endforeach
        </select>
    </div>

</div>

    <div class="search2">

        <!-- 価格（下限〜上限）検索用の入力欄 -->
        <div class="search_price">
            <input type="number" name="min_price" class="search_box" placeholder="最小価格" value="">
        </div>
        <div class="search_price">
                <input type="number" name="max_price" class="search_box" placeholder="最大価格" value="">
            </div>

            <!-- 在庫数（下限〜上限）検索用の入力欄 -->
            <div class="search_stock">
                <input type="text" name="min_stock" class="search_box" placeholder="最小在庫数" value="{{ request('min_stock') }}">
            </div>
            <div class="search_stock">
                <input type="text" name="max_stock" class="search_box" placeholder="最大在庫数" value="{{ request('max_stock') }}">
            </div>

            <div>
                <input type="submit" id="search_btn" value="検索">
            </div>
        </div>

    </form>

    <div id="search-results" class="mt-5">

        <div id="productTable">
            <table class="table table-striped tablesorter" id="tableView">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>商品画像</th>
                        <th>商品名</th>
                        <th>価格</th>
                        <th>在庫数</th>
                        <th >メーカー名</th>
                        <th></th>
                        <th><a href="{{ route('products.regist') }}" class="btn btn-warning">新規登録</a></th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td><img src="{{ asset($product->img_path) }}"></td>

                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->company->company_name }}</td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('products.show' , $product->id) }}">詳細</a>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="delBtn" class="btn btn-sm btn-danger delete-product" data-product-id="{{ $product->id }}">
                                    削除
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>

        </div>

        @endsection
        