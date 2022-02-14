<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Exports\PenjualanExport;
use App\Exports\RerasnackExport;
use App\Exports\SummaryExport;
use App\Models\ReportModal;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request) {
        return view('reports.index');
    }

    public function modal(Request $request) {
        $from = $request->input('from');
        $to = $request->input('to');
        if($request->input('action') == 'download') {
            return Excel::download(new InventoryExport($from, $to), 'modal-' . date('Y-m-d') . '.xlsx');
        } else {
            $data = ReportModal::select("item_code", "item_name", "bal_kg", "unit_price")
            ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total')                
            ->whereBetween('tanggal', [$from, $to])
            ->groupBy(["item_code", "item_name", "bal_kg", "unit_price"])
            ->orderBy("item_code", "ASC")
            ->orderBy("unit_price", "ASC")
            ->get();
            return view('reports.modal', [
                'data' => $data,
                'from' => $from, 
                'to' => $to
            ]);
        }           
    }

    public function penjualan(Request $request) {
        return Excel::download(new PenjualanExport($request->input('from'), $request->input('to')), 'penjualan-' . date('Y-m-d') . '.xlsx');
    }

    public function summary(Request $request) {
        return Excel::download(new SummaryExport, 'modals-' . date('Y-m-d') . '.xlsx');
    }

    public function rerasnack(Request $request) {
        return Excel::download(new RerasnackExport, 'modals-' . date('Y-m-d') . '.xlsx');
    }
}
