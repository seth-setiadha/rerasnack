<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
use App\Models\Stock;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $from30 = date('Y-m-d', strtotime('30 days ago'));
        $from = date('Y-m-d', strtotime('10 days ago'));
        $to = date('Y-m-d', strtotime('1 days ago'));
        $indexes = $modals = $penjualans = [];
        for($i=10; $i >= 1; $i--) {
            $index =  date('Y-m-d', strtotime( $i .' days ago'));
            $indexes[] = "'" . date('M j', strtotime($index)) . "'";
            $modals['qty'][$index] = $modals['sub_total'][$index] = $penjualans['sub_total'][$index] = $penjualans['qty'][$index] = 0;
        }

        $modalWeekly = ReportModal::selectRaw("tanggal, SUM(qty) as qty, SUM(sub_total) as sub_total")
                        ->groupBy(['tanggal'])
                        ->whereBetween('tanggal', [$from, $to])
                        ->orderBy('tanggal', 'ASC')
                        ->get();

        $penjualanWeekly = ReportPenjualan::selectRaw("tanggal, SUM(qty) as qty, SUM(sub_total) as sub_total")
                        ->groupBy(['tanggal'])
                        ->whereBetween('tanggal', [$from, $to])
                        ->orderBy('tanggal', 'ASC')
                        ->get();

        $top3['penjualan'] = ReportPenjualan::selectRaw("item_code, item_name, SUM(qty) as qty, SUM(sub_total) as sub_total")
                        ->groupBy(['item_code', 'item_name'])
                        ->whereBetween('tanggal', [$from30, $to])
                        ->orderBy('qty', 'DESC')
                        ->limit(3)
                        ->get();

        $top3['modal'] = ReportModal::selectRaw("item_code, item_name, SUM(qty) as qty, SUM(sub_total) as sub_total")
                        ->groupBy(['item_code', 'item_name'])
                        ->whereBetween('tanggal', [$from30, $to])
                        ->orderBy('qty', 'DESC')
                        ->limit(3)
                        ->get();

        $top3['stock'] = Stock::selectRaw("item_name, FORMAT(SUM(qty) / 1000,2) AS qty")
                        ->groupBy(['item_name'])
                        ->where('qty', '>', 0)
                        ->orderBy('qty', 'ASC')
                        ->limit(5)
                        ->get();

        
        foreach($modalWeekly as $row) {
            $modals['qty'][$row->tanggal] = $row->qty;
            $modals['sub_total'][$row->tanggal] = $row->sub_total;
        }

        foreach($penjualanWeekly as $row) {
            $penjualans['qty'][$row->tanggal] = $row->qty;
            $penjualans['sub_total'][$row->tanggal] = $row->sub_total;
        }

        return view('home', [
            'indexes' => $indexes,
            'modals' => $modals,
            'top3' => $top3,
            'penjualans' => $penjualans
        ]);
    }
}
