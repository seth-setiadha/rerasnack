<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ReportController;
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

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function() {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/stocks/adjustment', [StockController::class, 'adjustment'])->name('stocks.adjustment');
    Route::get('/stocks/habis', [StockController::class, 'habis'])->name('stocks.habis');
    Route::get('/stocks/autocomplete', [StockController::class, 'autocomplete'])->name('stocks.autocomplete');
    Route::get('/items/autocomplete', [ItemController::class, 'autocomplete'])->name('items.autocomplete');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('reports/modal', [ReportController::class, 'modal'])->name('reports.modal');
    Route::post('reports/penjualan', [ReportController::class, 'penjualan'])->name('reports.penjualan');
    Route::post('reports/summary', [ReportController::class, 'summary'])->name('reports.summary');
    Route::post('reports/rerasnack', [ReportController::class, 'rerasnack'])->name('reports.rerasnack');

    Route::resources([
        '/items' => ItemController::class,
        '/stocks' => StockController::class,
        '/modal' => InventoryController::class,
        '/penjualan' => PenjualanController::class,        
    ]);
});