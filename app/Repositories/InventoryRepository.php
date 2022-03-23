<?php

namespace App\Repositories;

use App\Models\Inventory;

class InventoryRepository
{
    public $model;

    public $q;
    public $perPage;

    public function __construct()
    {     
        $this->model = new Inventory;

        $this->q = request()->query('q');
        $this->perPage = intval(request()->query('perPage'));
        $this->perPage = $this->perPage > 0 && $this->perPage <= 100 ? $this->perPage : 15;
    }

    public function index($stock = "IN") {
        $data = $this->model->select("inventories.*", "items.item_name", "items.item_code", "stocks.bal_kg")
                        ->selectRaw("FORMAT(inventories.sub_total, 2) AS sub_total, FORMAT(inventories.unit_price, 2) AS unit_price")
                        ->selectRaw("FORMAT(stocks.qty / 1000,2) AS sisa");
        if($stock == "IN") {
            $data->selectRaw("(SELECT COUNT(penjualan.id) FROM `inventories` as `penjualan` WHERE (penjualan.stock = 'OUT' OR penjualan.stock = 'ADJ') AND penjualan.stock_id = inventories.stock_id ) AS nPenjualan");
        }
                        $data->where("stock", $stock)
                        ->leftjoin("items", "inventories.item_id", "=", "items.id")
                        ->leftjoin("stocks", "inventories.stock_id", "=", "stocks.id")
                        ->orderBy("inventories.tanggal", "DESC");
        if(! empty($this->q)) {
            $data->where(function($query) {
                $query->where('items.item_name', 'LIKE', '%' . $this->q . '%')->orWhere('inventories.tanggal', 'LIKE', '%' . $this->q . '%')->orWhere('items.item_code', 'LIKE', '%' . $this->q . '%');
            });                    
        }
        return ["data" => $data->paginate($this->perPage)->withQueryString(), "q" => $this->q];
    }
}