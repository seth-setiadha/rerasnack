<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Scale;
use Illuminate\Http\Request;

class PenjualanController extends Controller
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
        $stock = "OUT";

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
        return view('modals.index', [
            'data' => $data,
            'count' => $count,
            'page' => $page,
            'nPage' => ceil($count / $perPage),

            'stock' => $stock,
            'pageName' => 'penjualan',
            'colorTheme' => 'primary'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Inventory();
        $scales = Scale::all();

        return view('modals.create', [
            'data' => $data,
            'scales' => $scales,
            'stock' => 'OUT',
            'pageName' => 'penjualan',
            'colorTheme' => 'primary'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInventoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInventoryRequest $request)
    {
        $data = [
            "item_id" => $request->item_id,
            "stock_id" => $request->stock_id,
            "tanggal" => $request->tanggal,
            "qty" => $request->qty,
            "unit" => $request->unit,
            "unit_price" => $request->unit_price,
            "stock" => "OUT",
        ];
        $inventory = Inventory::create($data);
        if(! $inventory) {
            return response()->json(["message" => "Data belum berhasil ditambahkan", "data" => $data ], 400);    
        }
        return response()->json(["message" => "Data berhasil ditambahkan", "data" => $inventory]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
