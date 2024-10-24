<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    use Sortable;

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

    public $sortable = [
        'id',
        'price',
        'stock'
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
    public function searchList($keyword, $searchCompany, $min_price, $max_price, $min_stock, $max_stock) {
        
        $products = DB::table('products')
        
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name as company_id');

        if($keyword) {
            $products->where('products.product_name', 'LIKE', "%".$keyword."%");
        }
        
        if($searchCompany) {
            $products->where('products.company_id', '=', $searchCompany);
            }

            //  価格下限〜上限
            if($min_price) {
                $products->where('products.price', '>=', $min_price);
            }
            if($max_price) {
                $products->where('products.price', '<=', $max_price);
            }
            // 在庫数下限〜上限
            if($min_stock) {
                $products->where('products.stock', '>=', $min_stock);
            }
            if($max_stock) {
                $products->where('products.stock', '<=', $max_stock);
            }
            // $products->orderBy($sortColumn, $sortOrder);

        return $products->get();
    }
    
    
}
