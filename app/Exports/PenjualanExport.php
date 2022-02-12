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
        return Inventory::all();
    }

    public function headings(): array
    {
        return [
           ['Kode Produk', 'Nama Produk', 'Isi Per Bal (KG)', 'Harga Produk (Per Bal)', 'Jumlah', 'Sum of Total'],           
        ];
    }
}
