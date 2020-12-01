<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\OrderController;

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
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('products', ProductController::class);
Route::post('update-quantity', [ProductController::class, 'update_quantity_only']);
Route::resource('categories', CategoryController::class)->except('show');
Route::resource('options', OptionController::class)->except('show');
Route::get('/orders/all', [OrderController::class, 'all_orders']);
Route::post('/orders/sort', [OrderController::class, 'sort_orders']);//add params
Route::resource('orders', OrderController::class);


// Route::group(['prefix' => 'general',  'middleware' => ['jwt.verify','admin']], function()
// {
//     Route::get('eav_dropdowns', 'GeneralController@eavDropdowns');
//     Route::get('account_dropdowns', 'GeneralController@accountDropdowns');

//     Route::get('equipment_form_dropdowns', 'GeneralController@equipmentFormDropdowns');

//     Route::get('equipment_dropdowns', 'GeneralController@equipmentDropdowns');

//     Route::get('units_dropdowns', 'GeneralController@unitsDropdowns');
// });