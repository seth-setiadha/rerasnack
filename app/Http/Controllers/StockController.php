<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
      * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = intval($request->query('perPage'));
        $page = intval($request->query('page'));
        $page = $page > 0 ? $page : 1;
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;
        $offset = ($page - 1) * $perPage;

        $data = Stock::where("stocks.qty", ">", 0)
                ->select("stocks.id", "stocks.item_name", "stocks.qty", "stocks.bal_kg", "inventories.tanggal")
                ->selectRaw("FORMAT((stocks.qty/1000), 2) AS qty_kg")
                ->leftjoin('inventories', function($query) {
                    $query->on("stocks.id", "=", "inventories.stock_id")
                    ->where("inventories.stock", "=", "IN");
                })
                ->orderBy("inventories.tanggal", "ASC")
                ->orderBy("stocks.qty", "DESC")
                ->offset($offset)->limit($perPage)->get();

        $count = Stock::where("stocks.qty", ">", 0)->count();

        return view('stocks.index', [
            'data' => $data,
            'count' => $count,
            'page' => $page,
            'nPage' => ceil($count / $perPage)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStockRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStockRequest  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStockRequest $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }
}
