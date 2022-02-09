<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Inventory;
use App\Models\Scale;
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
                ->orderBy("inventories.tanggal", "DESC")
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
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function adjustment(Request $request)
    {
        // dd("masuk");
        $perPage = intval($request->query('perPage'));
        $page = intval($request->query('page'));
        $page = $page > 0 ? $page : 1;
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;
        $offset = ($page - 1) * $perPage;
        $stock = "ADJ";

        $data = Inventory::select("inventories.*", "items.item_name", "items.item_code", "stocks.bal_kg")
                        ->selectRaw("FORMAT(inventories.sub_total, 2) AS sub_total, FORMAT(inventories.unit_price, 2) AS unit_price")
                        ->selectRaw("FORMAT(stocks.qty / 1000,2) AS sisa")
                        ->where("stock", $stock)
                        ->leftjoin("items", "inventories.item_id", "=", "items.id")
                        ->leftjoin("stocks", "inventories.stock_id", "=", "stocks.id")
                        ->offset($offset)
                        ->orderBy("inventories.tanggal", "DESC")
                        ->limit($perPage)->get();

        $count = Inventory::where("stock", $stock)->count();
        // dd('inside')
        return view('stocks.adjustment', [
            'data' => $data,
            'count' => $count,
            'page' => $page,
            'nPage' => ceil($count / $perPage),
        ]);
    }

    public function autocomplete(Request $request) {
        // $query = $request->get('query');
        $query = $request->get('term');
        $items = Stock::select('stocks.id', 'stocks.item_name')->selectRaw('FORMAT(stocks.qty / 1000,2) AS sisa')
        ->where('stocks.qty', '>', 0)
        ->where('item_name', 'LIKE', '%'. $query. '%')->limit(10)->get();
        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Stock();
        $scales = Scale::all();
        return view('stocks.create', [
            'data' => $data,
            'scales' => $scales
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStockRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request, Stock $stock)
    {
        $data = [
            "item_id" => 0,
            "stock_id" => $request->stock_id,
            "tanggal" => $request->tanggal,
            "qty" => $request->qty,
            "unit" => $request->unit,
            "unit_price" => 0,
            "stock" => "ADJ",
        ];
        $stock = Inventory::create($data);
        if(! $stock) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('stocks.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('stocks.adjustment') );
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
