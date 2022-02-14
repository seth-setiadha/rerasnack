<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
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
        $from = date('Y-m-d', strtotime('8 days ago'));
        $to = date('Y-m-d');
        $modalWeekly = ReportModal::selectRaw("tanggal, SUM(qty) as qty")
                        ->groupBy(['tanggal'])
                        ->whereBetween('tanggal', [$from, $to])
                        ->orderBy('tanggal', 'ASC')
                        ->get();

        $penjualanWeekly = ReportPenjualan::selectRaw("tanggal, SUM(qty) as qty")
                        ->groupBy(['tanggal'])
                        ->whereBetween('tanggal', [$from, $to])
                        ->orderBy('tanggal', 'ASC')
                        ->get();

        return view('home', [
            'modalWeekly' => $modalWeekly,
            'penjualanWeekly' => $penjualanWeekly
        ]);
    }
}
