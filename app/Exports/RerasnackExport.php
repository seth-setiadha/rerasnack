<?php

namespace App\Exports;

use App\Models\Misc;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
use App\Models\ReportRerasnack;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class RerasnackExport implements FromCollection, WithHeadings, WithEvents
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
        // DB::transaction(function () {
            ReportRerasnack::truncate();
            $modals = ReportModal::selectRaw('item_code, item_name, bal_kg, unit_price, SUM(qty) AS qty, SUM(sub_total) AS sub_total, GROUP_CONCAT(stock_id) AS stock_ids')
                        ->groupBy(['item_code', 'item_name', 'bal_kg', 'unit_price'])
                        ->whereBetween('tanggal', [$this->from, $this->to])
                        ->orderBy('item_code', 'ASC')
                        ->get();
            
            foreach($modals AS $modal) {
                $data = [];
                $data['item_code'] = $modal->item_code;
                $data['item_name'] = $modal->item_name;
                $data['bal_kg'] = $modal->bal_kg;
                $data['unit_price'] = $modal->unit_price;
                $data['qty'] = $modal->qty;
                $data['sub_total'] = $modal->sub_total;
                $price_gr = $modal->unit_price / ($modal->bal_kg * 1000);

                $stock_ids = explode(',', $modal->stock_ids);
                $penjualans = ReportPenjualan::selectRaw('unit, SUM(qty) AS qty, SUM(sub_total) AS sub_total')
                                ->whereIn('stock_id', $stock_ids)
                                ->groupBy(['unit'])
                                ->get();

                $totalQty = $totalProfit = $totalOmset = $totalGram = 0; 
                foreach($penjualans AS $penjualan) {
                    if($penjualan->unit == "bal") {
                        $unit_gram = $penjualan->qty * $modal->bal_kg * 1000;
                    } else if($penjualan->unit == "1kg") {
                        $unit_gram = $penjualan->qty * 1000;
                    } else {
                        $unit_gram = preg_replace("/[^0-9]/", "", $penjualan->unit) * $penjualan->qty;
                    }
                    
                    $profit = $penjualan->sub_total - ($price_gr * $unit_gram);
                    $data['qty_' . $penjualan->unit] = $penjualan->qty;
                    $data['profit_' . $penjualan->unit] = $profit;
                    $data['omset_' . $penjualan->unit] = $penjualan->sub_total;
                    $totalProfit += $profit;
                    $totalOmset += $penjualan->sub_total;
                    $totalQty += $penjualan->qty;
                    $totalGram += $unit_gram;
                }
                $data['qty_total'] = $totalQty;
                $data['omset_total'] = $totalOmset;
                $data['profit_total'] = $totalProfit;
                $data['sisa'] = (($modal->qty * $modal->bal_kg * 1000) - $totalGram) / 1000;
                
                ReportRerasnack::create($data);
            }            
        $modalLains = Misc::selectRaw('misc_name, unit_price, SUM(qty) AS qty, SUM(sub_total) AS sub_total')
            ->groupBy(['misc_name', 'unit_price'])
            ->whereBetween('tanggal', [$this->from, $this->to])
            ->orderBy('misc_name', 'ASC')
            ->get();
        foreach($modalLains as $row) {
            $data = [];
            $data['item_name'] = $row->misc_name;
            $data['qty'] = $row->qty;
            $data['sub_total'] = $row->sub_total;
            ReportRerasnack::create($data);
        }

        return ReportRerasnack::selectRaw('item_code, item_name, bal_kg, unit_price, qty, (bal_kg * qty) AS qty_kg, sub_total, qty_bal, qty_1kg, qty_500gr, qty_300gr, qty_250gr, qty_200gr, qty_150gr, qty_100gr, qty_total, profit_bal, profit_1kg, profit_500gr, profit_300gr, profit_250gr, profit_200gr, profit_150gr, profit_100gr, profit_total, omset_bal, omset_1kg, omset_500gr, omset_300gr, omset_250gr, omset_200gr, omset_150gr, omset_100gr, omset_total, sisa')
                ->orderBy('id', 'ASC')
                ->get();
    }

    public function headings(): array
    {
        return [
            [
                'LAPORAN PENJUALAN PRODUK RERA SNACK'
            ],
            [
                'PERIODE ' . date('j F Y', strtotime($this->from)) . " s/d " . date('j F Y', strtotime($this->to))
            ],
            [
                'KODE PRODUK', 'NAMA PRODUK', 'ISI per bal (kg)', 'HARGA (per bal)', 'Jlh PEMBELIAN (bal)', 'JLH PEMBELIAN (kg)', 'TOTAL HARGA',
                'bal', '1kg', '500gr', '300gr', '250gr', '200gr', '150gr', '100gr', 'TOTAL PENJUALAN',
                'bal', '1kg', '500gr', '300gr', '250gr', '200gr', '150gr', '100gr', 'TOTAL PROFIT',
                'bal', '1kg', '500gr', '300gr', '250gr', '200gr', '150gr', '100gr', 'TOTAL OMSET',
                'SISA (kg)'
            ],
        ];    
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:W2'; 
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle("A3:W3")->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A3:G3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFFFF00');                
                $event->sheet->getDelegate()->getStyle('H3:P3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF00FFCC');
                $event->sheet->getDelegate()->getStyle('Q3:Y3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFFF9999');
                $event->sheet->getDelegate()->getStyle('Z3:AH3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FF00FF00');
                $event->sheet->getDelegate()->getStyle('AI3')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF8CBAD');
                
                // for($i=5;$i<50;$i=+2) {
                    $event->sheet->getDelegate()->getStyle('A5:AI5')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A7:AI7')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A9:AI9')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A11:AI11')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A13:AI13')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A15:AI15')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A17:AI17')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A19:AI19')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A21:AI21')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A23:AI23')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A25:AI25')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A27:AI27')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A29:AI29')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A31:AI31')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A33:AI33')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');
                    $event->sheet->getDelegate()->getStyle('A35:AI35')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A37:AI37')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A39:AI39')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A41:AI41')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A43:AI43')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A45:AI45')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A47:AI47')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A49:AI49')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A51:AI51')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A53:AI53')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A55:AI55')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A57:AI57')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A59:AI59')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A61:AI61')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A63:AI63')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A65:AI65')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A67:AI67')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A69:AI69')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A71:AI71')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A73:AI73')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A75:AI75')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A77:AI77')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A79:AI79')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A81:AI81')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A83:AI83')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A85:AI85')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A87:AI87')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A89:AI89')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2');  
                    $event->sheet->getDelegate()->getStyle('A91:AI91')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A93:AI93')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A95:AI95')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A97:AI97')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                    $event->sheet->getDelegate()->getStyle('A99:AI99')->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('FFF2F2F2'); 
                // }
                
            },
        ];

        /***
         * $spreadsheet->getActiveSheet()->getStyle('B3:B7')->getFill()
    ->setFillType(Fill::FILL_SOLID)
    ->getStartColor()->setARGB('FFFF0000');
         */
    }

}
