<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;


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
    return view('home');
})->name('home');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('products', ProductController::class)->only([
    'index', 'show'
]);
Route::resource('admin/products', AdminProductController::class, ['as' => 'admin'])->middleware('auth.vip');
// Route::post('update-quantity', [ProductController::class, 'update_quantity_only']);

Route::resource('admin/categories', CategoryController::class)->except('show')->middleware('auth.vip');
Route::resource('admin/options', OptionController::class)->except('show')->middleware('auth.vip');
Route::resource('admin/users', UserController::class)->except('show')->middleware('auth.vip');

Route::resource('orders', OrderController::class)->except(['create', 'edit', 'update', 'destroy'])->middleware('auth');
Route::group(['prefix' => 'admin', 'middleware' => 'auth.vip'], function() 
{
    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('orders/sort', [AdminOrderController::class, 'sort_orders']);//add params
    Route::get('orders-search', [AdminOrderController::class, 'search_orders'])->name('orders.search');
    Route::post('orders/status-update', [AdminOrderController::class, 'order_update_status'])->name('admin.orders.status-update');
});

Route::get('products-search', [ProductController::class, 'search_products'])->name('products.search');


// Route::group(['prefix' => 'general',  'middleware' => ['jwt.verify','admin']], function()
// {
//     Route::get('eav_dropdowns', 'GeneralController@eavDropdowns');
//     Route::get('account_dropdowns', 'GeneralController@accountDropdowns');

//     Route::get('equipment_form_dropdowns', 'GeneralController@equipmentFormDropdowns');

//     Route::get('equipment_dropdowns', 'GeneralController@equipmentDropdowns');

//     Route::get('units_dropdowns', 'GeneralController@unitsDropdowns');
// });