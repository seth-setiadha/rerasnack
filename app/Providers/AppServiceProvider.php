<?php

namespace App\Providers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\Scale;
use App\Models\Stock;
use App\Observers\InventoryObserver;
use App\Observers\ItemObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }    
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Inventory::observe(InventoryObserver::class);

        Item::observe(ItemObserver::class);

        Inventory::creating(function ($inventory) {
            // DI PEMBELIAN DROPDOWN MENGGUNAKAN TABLE ITEM, DI PENJUALAN MENGGUNAKNA STOCK
            if($inventory->stock == "IN") {
                $dataItem = Item::where("id", "=", $inventory->item_id)->first();
            } else if($inventory->stock == "OUT" || $inventory->stock == "ADJ") {
                $dataItem = Stock::where("id", "=", $inventory->stock_id)->first();
                $inventory->item_id = $dataItem->item_id;
            }

            // $inventory->bal_kg = $dataItem->bal_kg;
            if($inventory->unit == "bal") {
                $inventory->qty_kg = $inventory->qty * $dataItem->bal_kg;
                $inventory->qty_gr = $inventory->qty_kg * 1000;                
            } else {
                $koef = Scale::where('scalar', '=', $inventory->unit)->first()->pergram;
                $inventory->qty_gr = $inventory->qty * $koef;
                $inventory->qty_kg = round($inventory->qty_gr / 1000, 2);
            }

            $inventory->sub_total = $inventory->qty * $inventory->unit_price;
            $inventory->unit_price_gr = round($inventory->sub_total / $inventory->qty_gr, 4);
            
            if($inventory->stock == "IN") {
                $stock = Stock::create([
                    'tanggal' => $inventory->tanggal,
                    'item_id' => $inventory->item_id,
                    'item_name' => $dataItem->item_name . " (" . $dataItem->item_code . ")",
                    'bal_kg' => $dataItem->bal_kg,
                    'qty' => $inventory->qty_gr,
                    'modal' => $inventory->unit_price_gr
                ]);
                $inventory->stock_id = $stock->id;
            } else if($inventory->stock == "OUT" || $inventory->stock == "ADJ") {
                $dataItem->qty -= $inventory->qty_gr;
                $dataItem->save();
            }
        });      
        
    }
}
