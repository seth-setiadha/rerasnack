<?php

namespace App\Repositories;

use App\Models\Inventory;
use App\Models\ReportModal;
use App\Models\ReportPenjualan;
use App\Models\Stock;

class StockRepository
{
    public $model;

    public $q;
    public $perPage;

    public function __construct()
    {
        $this->model = new Stock;

        $this->q = request()->query('q');
        $this->perPage = intval(request()->query('perPage'));
        $this->perPage = $this->perPage > 0 && $this->perPage <= 100 ? $this->perPage : 15;
    }

    public function index($op=">") {

        $data = $this->model->where("stocks.qty", $op, 0)
                ->select("stocks.id", "stocks.item_name", "stocks.bal_kg", "inventories.tanggal", "inventories.qty")
                ->selectRaw("FORMAT((stocks.qty/1000), 2) AS qty_kg")
                ->leftjoin('inventories', function($query) {
                    $query->on("stocks.id", "=", "inventories.stock_id")
                    ->where("inventories.stock", "=", "IN");
                })
                ->orderBy("inventories.tanggal", "DESC")
                ->orderBy("stocks.qty", "DESC");
        if(! empty($this->q)) {
            $data->where(function($query)  {
                $query->where('stocks.item_name', 'LIKE', '%' . $this->q . '%')->orWhere('inventories.tanggal', 'LIKE', '%' . $this->q . '%');
            });                    
        }
        return ["data" => $data->paginate($this->perPage)->withQueryString(), "q" => $this->q];
    }

    public function detailByStockID($stockID) {
        $stockID = is_object($stockID) ? $stockID->id : $stockID;
        $dataModal = ReportModal::where('stock_id', '=', $stockID)->get();
        return $this->detail($dataModal);
    }

    public function detailByItemID($itemCode) {
        $itemCode = is_object($itemCode) ? $itemCode->item_code : $itemCode;
        $dataModal = ReportModal::where('item_code', '=', $itemCode)->orderBy('tanggal', 'DESC')->get();
        return $this->detail($dataModal);
    }

    public function detail($dataModal) {
        $data = [];
        foreach($dataModal as $value) {
            $dataPenjualan = ReportPenjualan::where('stock_id', '=', $value->stock_id)->orderBy('tanggal', 'DESC')->get();
            $dataAdj = Inventory::where('stock_id', '=', $value->stock_id)->orderBy('tanggal', 'DESC')->where('stock', '=', 'ADJ')->get();
            $dataStock = $this->model->where('id', $value->stock_id)->first();
            $value->penjualan = $dataPenjualan;
            $value->adjustment = $dataAdj;
            $value->stock = $dataStock;
            $data[] = $value;
        }
        return $data;
    }
}