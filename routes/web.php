<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::group(['middleware' => ['auth']], function() {
//     // your routes
//   });

Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\ProductController::class, 'showList'])->name('products.list');
Route::get('/', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');

Route::get('/product_show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/product_edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('/product_edit/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');

Route::get('/product_regist', [App\Http\Controllers\ProductController::class, 'showRegistForm'])->name('products.regist');
Route::post('/product_regist', [App\Http\Controllers\ProductController::class, 'registSubmit'])->name('products.submit');


Route::delete('/home/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');