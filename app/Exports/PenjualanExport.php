<?php

namespace App\Exports;

use App\Models\ReportPenjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PenjualanExport implements FromCollection, WithHeadings
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
        $summary = ReportPenjualan::selectRaw("'Grand Total' AS tanggal, '' AS item_code, '' AS item_name, '' AS unit, '' AS unit_price, SUM(qty) AS qty, SUM(sub_total) as sub_total, SUM(profit) as profit")
                    ->whereBetween('tanggal', [$this->from, $this->to]);
        return ReportPenjualan::select("tanggal", "item_code", "item_name", "unit", "unit_price")
                ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total, SUM(profit) as profit')                
                ->whereBetween('tanggal', [$this->from, $this->to])
                ->groupBy(["tanggal", "item_code", "item_name", "unit", "unit_price"])
                ->orderBy("tanggal", "ASC")
                ->orderBy("item_code", "ASC")
                ->orderBy("unit_price", "ASC")
                ->union($summary)
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Tanggal', 'Kode Produk', 'Nama Produk', 'Unit', 'Harga Produk', 'Jumlah', 'Sum of Total', 'Profit'],           
        ];
    }
}
