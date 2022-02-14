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
        return ReportPenjualan::select("inventories.tanggal", "items.item_code", "items.item_name", "inventories.unit", "inventories.unit_price")
                ->selectRaw('SUM(inventories.qty) AS qty, SUM(inventories.sub_total) as sub_total')
                ->where("stock", "OUT")
                ->whereBetween('tanggal', [$this->from, $this->to])
                ->leftjoin("items", "inventories.item_id", "=", "items.id")
                ->groupBy(["inventories.tanggal", "items.item_code", "items.item_name", "inventories.unit", "inventories.unit_price"])
                ->orderBy("inventories.tanggal", "ASC")
                ->orderBy("items.item_code", "ASC")
                ->orderBy("inventories.unit_price", "ASC")
                ->get();
    }

    public function headings(): array
    {
        return [
           ['Tanggal', 'Kode Produk', 'Nama Produk', 'Unit', 'Harga Produk', 'Jumlah', 'Sum of Total'],           
        ];
    }
}
