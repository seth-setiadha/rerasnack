<?php

namespace App\Exports;

use App\Models\ReportModal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ReportModal::select("item_code", "item_name", "bal_kg", "unit_price")
                ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total')                
                ->whereBetween('tanggal', [$this->from, $this->to])
                ->groupBy(["item_code", "item_name", "bal_kg", "unit_price"])
                ->orderBy("item_code", "ASC")
                ->orderBy("unit_price", "ASC")
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Kode Produk', 'Nama Produk', 'Isi Per Bal (KG)', 'Harga Produk (Per Bal)', 'Jumlah', 'Sum of Total'],           
        ];
    }

}
