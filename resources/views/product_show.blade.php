@extends('layouts.app')

@section('title', '詳細')

@section('content')



<h1 class="info2">商品情報詳細画面</h1>
<br>
<div class="container" id="product">
        <div class="col-md-8">

            <div class="form-group">
                <label for="id">ID</label>
                {{ $product->id }}
            </div>
            <br>
            <div class="form-group">
                <label for="image">商品画像</label>
                <img src="{{ asset($product->img_path) }}">
            </div>
            <br>
            <div class="form-group">
                <label for="name">商品名</label>
                {{ $product->product_name }}
            </div>
            <br>
            <div class="form-group">
                <label for="makername">メーカー名</label>
                {{ $product->company->company_name }}
            </div>
            <br>
            <div class="form-group">
                <label for="price">価格</label>
                {{ $product->price }}
            </div>
                <br>
                <div class="form-group">
                    <label for="stocks">在庫数</label>
                    {{ $product->stock }}
                </div>
                <br>
                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea readonly rows="2">{{ $product->comment }}</textarea>
                </div>
                <br>
            <br>
            <div>

            <a href="{{ route('products.edit' , ['id'=>$product->id]) }}" class="btn btn-warning" id="edit">編集</a>
            <a href="#" onclick="history.back()" class="btn btn-primary" id="back">戻る</a>
            </div>


    </div>
</div>

    @endsection
