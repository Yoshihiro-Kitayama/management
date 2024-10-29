<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
//     public function purchase(Request $request)
// {
//     // リクエストから必要なデータを取得する
//     $productId = $request->input('product_id');
//     $quantity = $request->input('quantity', 1);

//     // データベースから対象の商品を検索・取得
//     $product = Product::find($productId);

//     // 商品が存在しない、または在庫が不足している場合のバリデーションを行う
//     if (!$product) {
//         return response()->json(['message' => '商品が存在しません'], 404);
//     }
//     if ($product->stock < $quantity) {
//         return response()->json(['message' => '商品が在庫不足です'], 400);
//     }

//     // 在庫を減少させる
//     $product->stock -= $quantity;
//     $product->save();


//     // Salesテーブルに商品IDと購入日時を記録する
//     $sale = new Sale([
//         'product_id' => $productId,

//     ]);

//     $sale->save();

//     // レスポンスを返す
//     return response()->json(['message' => '購入成功']);
// }


    public function purchase(SaleRequest $request)
    {

        $validatedData = $request->validated();

        DB::beginTransaction();

        try {

        $product = Product::findOrFail($validatedData['product_id']);


        if ($product->stock < $validatedData['quantity'])
        {
            return response()->json(['message' => '商品が在庫不足です'], 400);
        }

        $product->stock -= $validatedData['quantity'];
        $product->save();

        Sale::create([
            'product_id' => $validatedData['product_id'],

        ]);

        DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('購入処理中にエラーが発生しました:', ['exception' => $e]);
            return response()->json(['message' => '購入処理中にエラーが発生しました'], 500);
        }

        return response()->json(['message' => '購入成功']);
    }

}