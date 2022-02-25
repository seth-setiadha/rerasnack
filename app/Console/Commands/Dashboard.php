<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
use App\Models\ReportRerasnack;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Dashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reportdetail:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Repopulate data for dashboard daily';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        $stocks = Stock::selectRaw('GROUP_CONCAT(id) AS ids')
                    ->where('qty', '<', 1)->groupBy(['item_name', 'bal_kg', 'modal'])
                    ->get();
        if($stocks) {            
            foreach($stocks as $stock) {
                DB::transaction(function () use($stock) {
                    $ids = explode(',', $stock->ids);
                    $modal = ReportModal::selectRaw('item_code, item_name, bal_kg, unit_price, SUM(qty) AS qty, SUM(sub_total) AS sub_total')
                            ->groupBy(['item_code', 'item_name', 'unit_price'])
                            ->whereIn('stock_id', $ids)                            
                            ->first()->toArray();
                            
                    $penjualans = ReportPenjualan::selectRaw('SUM(qty) AS qty, SUM(sub_total) AS sub_total, unit, unit_price')
                            ->groupBy(['unit', 'unit_price'])
                            ->whereIn('stock_id', $ids)
                            ->get();

                    foreach($penjualans as $penjualan) {
                        ReportRerasnack::create();
                    }                    
                });
            }    
        }

        return 'OK';
    }
}
