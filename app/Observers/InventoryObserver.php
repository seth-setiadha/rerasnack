<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Models\Item;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
use App\Models\Stock;
use Illuminate\Http\Request;

class InventoryObserver
{
    /**
     * Handle the Inventory "created" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function created(Inventory $inventory)
    {
        if($inventory->stock == "IN") {
            $item = Item::find($inventory->item_id);
            ReportModal::create([

                'modal_id' => $inventory->id,
                'tanggal' => $inventory->tanggal,
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,
                'bal_kg' => $item->bal_kg,
                'unit_price' => $inventory->unit_price,
                'qty' => $inventory->qty,
                'sub_total' => $inventory->sub_total,
                'stock_id' => $inventory->stock_id,
            ]);
        } else if($inventory->stock == "OUT") {
            $item = Item::find($inventory->item_id);
            ReportPenjualan::create([
                'modal_id' => $inventory->id,
                'tanggal' => $inventory->tanggal,
                'item_code' => $item->item_code,
                'item_name' => $item->item_name,       
                'unit' => $inventory->unit,         
                'unit_price' => $inventory->unit_price,
                'qty' => $inventory->qty,
                'sub_total' => $inventory->sub_total,
                'profit' => request()->profit,
                'stock_id' => $inventory->stock_id,
            ]);
        }
    }

    /**
     * Handle the Inventory "updated" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function updated(Inventory $inventory)
    {
        if($inventory->stock == "IN") {
            $modal = ReportModal::where('modal_id', $inventory->id);
            $modal->update([
                'tanggal' => $inventory->tanggal,  
                'unit_price' => $inventory->unit_price,
                'qty' => $inventory->qty,
                'sub_total' => $inventory->sub_total
            ]);
        } else if($inventory->stock == "OUT") {
            $penjualan = ReportPenjualan::where('modal_id', $inventory->id);
            $penjualan->update([
                'tanggal' => $inventory->tanggal,  
                'unit' => $inventory->unit,         
                'unit_price' => $inventory->unit_price,
                'qty' => $inventory->qty,
                'profit' => request()->profit,
                'sub_total' => $inventory->sub_total
            ]);
        }
    }

    /**
     * Handle the Inventory "deleted" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function deleted(Inventory $inventory)
    {
        if($inventory->stock == "IN") {
            ReportModal::where('modal_id', $inventory->id)->delete();
            Stock::destroy($inventory->stock_id);
            // Stock::where("id", "=", $inventory->stock_id)->delete();
        }
        
        if($inventory->stock == "OUT") {
            ReportPenjualan::where('modal_id', $inventory->id)->delete();
        }

        if($inventory->stock == "ADJ" || $inventory->stock == "OUT") {
            $stock = Stock::where("id", "=", $inventory->stock_id)->first();
            $stock->qty += $inventory->qty_gr;
            $stock->save();
        }
    }

    /**
     * Handle the Inventory "restored" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function restored(Inventory $inventory)
    {
        //
    }

    /**
     * Handle the Inventory "force deleted" event.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return void
     */
    public function forceDeleted(Inventory $inventory)
    {
        //
    }
}
