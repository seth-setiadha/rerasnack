<?php

namespace App\Repositories;

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
}