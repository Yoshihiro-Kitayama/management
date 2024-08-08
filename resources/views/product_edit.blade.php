@extends('layouts.app')

@section('title', '編集')

@section('content')

<h1  class="info2">商品情報編集画面</h1>
<br>
<div class="container" id="product">
        <div class="col-md-8">

<form action="{{ route('products.update' , $product->id) }}" method="post"  enctype='multipart/form-data'>
    @method('put')

    @csrf
            <div class="form-group">
                <label for="id">ID</label>
                {{ $product->id }}
            </div>
            <br>
            <div class="form-group">
                <label for="product_name">商品名<span>*</span></label>
                <input type="text" id="product_name" name="product_name" value="{{ old('product_name') }}">
                @if($errors->has('product_name'))
                        <p>{{ $errors->first('product_name') }}</p>
                    @endif
            </div>
            <br>
            <div class="form-group">
                <label for="company_id">メーカー名<span>*</span></label>
                <select name="company_id" id="company_id" value="{{ old('company_id') }}">
                    <option value=""></option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">
                        {{ $company->company_name }}
                    </option>
                @endforeach
                </select>
                @if($errors->has('company_id'))
                        <p>{{ $errors->first('company_id') }}</p>
                    @endif
            </div>
            <br>
            <div class="form-group">
                <label for="price">価格<span>*</span></label>
                <input type="text" id="price" name="price" value="{{ old('price') }}">
                @if($errors->has('price'))
                        <p>{{ $errors->first('price') }}</p>
                    @endif
            </div>
                <br>
                <div class="form-group">
                    <label for="stock">在庫数<span>*</span></label>
                    <input type="text" id="stock" name="stock" value="{{ old('stock') }}">
                    @if($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>
                <br>
                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea id="coment" name="comment" value="{{ old('coment') }}" rows="2"></textarea>
                    @if($errors->has('comment'))
                        <p>{{ $errors->first('comment') }}</p>
                    @endif
                </div>
                <br>

                <div class="form-group">
                    商品画像
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>

                <br><br>
           
            <button type="submit" class="btn btn-warning">更新</button>
            
        </from>
        <a href="#" onclick="history.back()" class="btn btn-primary" id="back">戻る</a>

    </div>
</div>

    @endsection