<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'product_name',
        'company_id',
        'price',
        'stock',
        'comment',
        'img_path'
    ];

    // public function getCompanyNameById() {
    //     $products= DB::table('products')
    //         ->join('companies', 'products.company_id', '=', 'companies.id')
    //         ->get();

    //     return $products;
    // }

    public function getList() {
        // productsテーブルからデータを取得
        $products = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name as company_id')
        ->get();

        return $products;
    }
       
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Productモデルがcompanysテーブルとリレーション関係を結ぶ為のメソッドです
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function registProduct($data, $image_path) {
        // 登録処理
            DB::table('products')->insert([
                'img_path' => $image_path,
                'product_name' => $data->product_name,
                'price' => $data->price,
                'stock' => $data->stock,
                'company_id' => $data->company_id,
                'comment' => $data->comment,
            ]);
        }

        // 更新処理
        public function updateProduct($request, $id, $image_path) {
            
            DB::table('products')->where('id', $id)->update([
            // Product::where('id', $id)->update([
    
                'product_name' => $request->product_name,
                'img_path' => $image_path,
                'price' => $request->price,
                'stock' => $request->stock,
                'company_id' => $request->company_id,
                'comment' => $request->comment
    
            ]);
            
        }

        // 検索機能
    public function searchList($keyword) {
        
        $products=DB::table('products')
        
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name as company_id')
        ->where('product_name', 'like', "%$keyword%")
        ->get();
        
        return $products;
    }
    
    
}
