<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\Sale;

class SalesController extends Controller

public function purchase(SaleRequest $request)
{
    $validatedData = $request->validated();

    $product = Product::findOrFail($validatedData['product_id']);

    // 在庫確認と更新
    if ($product->stock < $validatedData['quantity']) {
        return response()->json(['message' => '商品が在庫不足です'], 400);
    }
    $product->stock -= $validatedData['quantity'];
    $product->save();

    // Salesモデルに直接作成
    Sale::create([
        'product_id' => $validatedData['product_id'],
        // その他必要なカラムがあれば追加
    ]);

    return response()->json(['message' => '購入成功']);
}

}
