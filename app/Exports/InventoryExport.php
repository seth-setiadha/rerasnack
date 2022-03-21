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
        $summary = ReportModal::selectRaw("'Grand Total' AS tanggal, '' AS item_code, '' AS item_name, '' AS bal_kg, '' AS unit_price, SUM(qty) AS qty, SUM(sub_total) as sub_total")
                    ->whereBetween('tanggal', [$this->from, $this->to]);

        return ReportModal::select("tanggal", "item_code", "item_name", "bal_kg", "unit_price")
                ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total')                
                ->whereBetween('tanggal', [$this->from, $this->to])
                ->groupBy(["tanggal","item_code", "item_name", "bal_kg", "unit_price"])
                ->orderBy("tanggal", "ASC")
                ->orderBy("item_code", "ASC")
                ->orderBy("unit_price", "ASC")
                ->union($summary)
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Tanggal Masuk', 'Kode Produk', 'Nama Produk', 'Isi Per Bal (KG)', 'Harga Produk (Per Bal)', 'Jumlah', 'Sum of Total'],           
        ];
    }

}
