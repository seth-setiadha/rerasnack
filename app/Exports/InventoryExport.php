<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::select("items.item_code", "items.item_name", "items.bal_kg", "inventories.unit_price")
                ->selectRaw('SUM(inventories.qty) AS qty, SUM(inventories.sub_total) as sub_total')
                ->where("stock", "IN")
                ->leftjoin("items", "inventories.item_id", "=", "items.id")
                ->groupBy(["items.item_code", "items.item_name", "inventories.unit_price", "items.bal_kg"])
                ->orderBy("items.item_code", "ASC")
                ->orderBy("inventories.unit_price", "ASC")
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Kode Produk', 'Nama Produk', 'Isi Per Bal (KG)', 'Harga Produk (Per Bal)', 'Jumlah', 'Sum of Total'],           
        ];
    }

}
