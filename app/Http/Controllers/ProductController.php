<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller

{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showList(Request $request) {

        $product = new Product();
        $company = new Company();

        $products = $product->getList();
        $companies = $company->getListcompany();

        $products = Product::sortable()->get();
        // return view('product_list', compact('products','companies','posts'));
        return view('product_list', compact('products','companies'));

    }


    public function showRegistForm() {
        $companies = Company::all();
        return view('product_regist', ['companies' => $companies]);
    }

    // 新規登録
    public function registSubmit(ProductRequest $request) {

        //①画像ファイルの取得
	    $image = $request->file('image');

        //②画像ファイルのファイル名を取得
        $file_name = $image->getClientOriginalName();

        //③storage/app/public/imagesフォルダ内に、取得したファイル名で保存
        $image->storeAs('public/images', $file_name);

        //④データベース登録用に、ファイルパスを作成
        $image_path = 'storage/images/' . $file_name;

        $model = new Product();

        // トランザクション開始
        DB::beginTransaction();

        try {
            // 登録処理呼び出し
            $model->registProduct($request, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        // 処理が完了したらregistにリダイレクト
        return redirect(route('products.regist'));
    }

    // 詳細ボタン押下時
    public function show($id) {
        $product = Product::find($id);

        $companies = Company::all();

        return view('product_show', compact('product','companies'));
    }

    // 編集ボタン押下時
    public function edit($id) {
        $product = Product::find($id);

        $companies = Company::all();

        return view('product_edit', compact('product', 'companies'));
    }


        // 更新
        public function update($id, ProductRequest $request){
        $companies = Company::all();

        $product = Product::find($id);

        $image = $request->file('image');

        $file_name = $image->getClientOriginalName();

        $image->storeAs('public/images', $file_name);

        $image_path = 'storage/images/' . $file_name;

        $model = new Product();


        DB::beginTransaction();

        try {
        $model->updateProduct($request, $id, $image_path);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

            return view('product_edit', compact('product', 'companies'));

    }

        // 検索機能

        public function search(Request $request) {
            \Log::info($request);

            $companies = Company::all();

            $keyword = $request->input('keyword');

            $searchCompany = $request->input('search_company');

            $min_price = $request->input('min_price');
            $max_price = $request->input('max_price');

            $min_stock = $request->input('min_stock');
            $max_stock = $request->input('max_stock');

            // ソート情報取得
            $allowedSortColumns = ['id', 'price', 'stock'];
            $sortColumn = $request->input('sort_column', 'id');
            $sortColumn = in_array($sortColumn, $allowedSortColumns) ? $sortColumn : 'id';
            $sortOrder = $request->input('sort_order', 'asc');

            $product = new Product();

            $products = $product->searchList($keyword, $searchCompany, $min_price, $max_price, $min_stock, $max_stock, $sortColumn, $sortOrder);

            // return view('product_list', compact('products', 'companies'));
            return response()->json(['products' => $products]);

        }

        // 削除機能
        public function destroy(Product $product) {

            try {
                $product->delete();
                return response()->json(['message' => '削除しました'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => '削除に失敗しました'], 500);
            }
        }

}
