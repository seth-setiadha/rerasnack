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
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;
        $stock = "OUT";

        $data = Inventory::select("inventories.*", "items.item_name", "items.item_code", "stocks.bal_kg")
                        ->selectRaw("FORMAT(inventories.sub_total, 2) AS sub_total, FORMAT(inventories.unit_price, 2) AS unit_price")
                        ->selectRaw("FORMAT(stocks.qty / 1000,2) AS sisa")
                        ->where("stock", $stock)
                        ->leftjoin("items", "inventories.item_id", "=", "items.id")
                        ->leftjoin("stocks", "inventories.stock_id", "=", "stocks.id")
                        ->orderBy("inventories.tanggal", "DESC")
                        ->paginate($perPage);

        return view('modals.index', [
            'data' => $data,

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
        $penjualan = Inventory::create($data);
        if(! $penjualan) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('penjualan.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('penjualan.index') );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $penjualan)
    {
        if(! $penjualan) {
            return redirect( route('penjualan.create') );
        }
        return view('modals.edit', [
            'data' => $penjualan,
            'stock' => 'OUT',
            'pageName' => 'penjualan',
            'colorTheme' => 'primary'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $penjualan)
    {        
        if($penjualan) {
            return view('modals.edit', ['data' => $penjualan]);
        } else {
            return redirect( route('penjualan.index') );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $penjualan)
    {
        if(! $penjualan->update( $request->all() ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('penjualan.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('penjualan.show', ['penjualan' => $penjualan->id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Http\Request $request
     * @param  \App\Models\Inventory  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Inventory $penjualan)
    {
        if(! $penjualan->delete() ) {
            $request->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            $request->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        return redirect()->back(); 
    }
}
