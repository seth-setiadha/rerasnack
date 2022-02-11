<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Exports\PenjualanExport;
use App\Exports\RerasnackExport;
use App\Exports\SummaryExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request) {
        return view('reports.index');
    }

    public function pembelian(Request $request) {
        return Excel::download(new InventoryExport, 'modals-' . date('Y-m-d') . '.xlsx');
    }

    public function penjualan(Request $request) {
        return Excel::download(new PenjualanExport, 'modals-' . date('Y-m-d') . '.xlsx');
    }

    public function summary(Request $request) {
        return Excel::download(new SummaryExport, 'modals-' . date('Y-m-d') . '.xlsx');
    }

    public function rerasnack(Request $request) {
        return Excel::download(new RerasnackExport, 'modals-' . date('Y-m-d') . '.xlsx');
    }
}
