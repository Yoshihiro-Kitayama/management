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
