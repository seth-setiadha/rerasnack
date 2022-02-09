<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/stocks/adjustment', [StockController::class, 'adjustment'])->name('stocks.adjustment');
    Route::get('/stocks/autocomplete', [StockController::class, 'autocomplete'])->name('stocks.autocomplete');
    Route::get('/items/autocomplete', [ItemController::class, 'autocomplete'])->name('items.autocomplete');

    Route::resources([
        '/items' => ItemController::class,
        '/stocks' => StockController::class,
        '/pembelian' => InventoryController::class,
        '/penjualan' => PenjualanController::class,        
    ]);
});