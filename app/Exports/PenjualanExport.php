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
        return ReportPenjualan::select("tanggal", "item_code", "item_name", "unit", "unit_price")
                ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total')                
                ->whereBetween('tanggal', [$this->from, $this->to])
                ->groupBy(["tanggal", "item_code", "item_name", "unit", "unit_price"])
                ->orderBy("tanggal", "ASC")
                ->orderBy("item_code", "ASC")
                ->orderBy("unit_price", "ASC")
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Tanggal', 'Kode Produk', 'Nama Produk', 'Unit', 'Harga Produk', 'Jumlah', 'Sum of Total'],           
        ];
    }
}
