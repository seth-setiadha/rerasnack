<?php

namespace App\Http\Controllers;

use App\Exports\InventoryExport;
use App\Exports\PenjualanExport;
use App\Exports\RerasnackExport;
use App\Exports\SummaryExport;
use App\Jobs\ReportDetail;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request) {
        $from = $request->input('from');
        $to = $request->input('to');
        $laporan = $request->input('laporan') ?? "index";
        $data = [];

        if($request->input('action') == 'download') {
            if($laporan == "modal") {
                return Excel::download(new InventoryExport($from, $to), 'modal-' . date('Y-m-d') . '.xlsx');
            } else if($laporan == "penjualan") {
                return Excel::download(new PenjualanExport($from, $to), 'penjualan-' . date('Y-m-d') . '.xlsx');
            } else if($laporan == "detail") {
                $reportSaved = Excel::store(new RerasnackExport($from, $to), '/reports/detail-from-' . date('d', strtotime($from)) . "-sd-" . date('d-m-Y', strtotime($to)) . '.xlsx');
                // ReportDetail::dispatch($from, $to);
                if ($reportSaved) {
                    $request->session()->flash('status', 'Laporan sudah berhasil digenerate');
                } else {
                    $request->session()->flash('error', 'Laporan belum berhasil digenerate. Coba lagi!');
                }
            } else {
                $laporan = "index";
            }
        } else if($request->input('action') == 'show') {            
            if($laporan == "modal") {
                $data = ReportModal::select("tanggal", "item_code", "item_name", "bal_kg", "unit_price")
                        ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total')                
                        ->whereBetween('tanggal', [$from, $to])
                        ->groupBy(["tanggal", "item_code", "item_name", "bal_kg", "unit_price"])
                        ->orderBy("tanggal", "ASC")
                        ->orderBy("item_code", "ASC")
                        ->orderBy("unit_price", "ASC")
                        ->get();
            } else if($laporan == "penjualan") {
                $data = ReportPenjualan::select("tanggal", "item_code", "item_name", "unit", "unit_price")
                        ->selectRaw('SUM(qty) AS qty, SUM(sub_total) as sub_total')                
                        ->whereBetween('tanggal', [$from, $to])
                        ->groupBy(["tanggal", "item_code", "item_name", "unit", "unit_price"])
                        ->orderBy("tanggal", "ASC")
                        ->orderBy("item_code", "ASC")
                        ->orderBy("unit_price", "ASC")
                        ->get();            
            } else {
                $laporan = "index";
            }
        } 

        $files = Storage::files('/reports');        

        return view('reports.' . $laporan, [
            'data' => $data,
            'files' => $files,
            'from' => $from, 
            'laporan' => $laporan,
            'to' => $to
        ]);
        
    }

    public function download(Request $request)
    {
        $file = $request->query('file');        
        if (Storage::exists($file)) {
            return Storage::download($file);
        } else {
            echo "File doesn't exist " . $file;
        }
    }
}
