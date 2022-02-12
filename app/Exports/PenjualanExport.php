<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;

class PenjualanExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::select("inventories.tanggal", "items.item_code", "items.item_name", "inventories.unit", "inventories.unit_price")
                ->selectRaw('SUM(inventories.qty) AS qty, SUM(inventories.sub_total) as sub_total')
                ->where("stock", "OUT")
                ->leftjoin("items", "inventories.item_id", "=", "items.id")
                ->groupBy(["inventories.tanggal", "items.item_code", "items.item_name", "inventories.unit_price", "items.bal_kg"])
                ->orderBy("inventories.tanggal", "ASC")
                ->orderBy("items.item_code", "ASC")
                ->orderBy("inventories.unit_price", "ASC")
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Tanggal', 'Kode Produk', 'Nama Produk', 'Unit', 'Harga Produk (Per Bal)', 'Jumlah', 'Sum of Total'],           
        ];
    }
}
