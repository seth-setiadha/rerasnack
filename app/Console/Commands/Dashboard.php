<?php

namespace App\Console\Commands;

use App\Models\Inventory;
use Illuminate\Console\Command;

class Dashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:daily';

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
        $from = date('Y-m-d', strtotime('yesterday'));
        $to = date('Y-m-d', strtotime('8 days ago'));
        $modal = Inventory::selectRaw('SUM(qty)')
                    ->where('stock', 'IN')
                    ->whereBetween('reservation_from', [$from, $to])
                    ->orderBy('total', 'DESC')
                    ->limit(3)
                    ->get();


        return 'OK';
    }
}
