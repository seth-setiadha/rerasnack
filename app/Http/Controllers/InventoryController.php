<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->query('q');
        $perPage = intval($request->query('perPage'));
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;
        $stock = "IN";

        $data = Inventory::select("inventories.*", "items.item_name", "items.item_code", "stocks.bal_kg")
                        ->selectRaw("FORMAT(inventories.sub_total, 2) AS sub_total, FORMAT(inventories.unit_price, 2) AS unit_price")
                        ->selectRaw("FORMAT(stocks.qty / 1000,2) AS sisa, (SELECT COUNT(penjualan.id) FROM `inventories` as `penjualan` WHERE (penjualan.stock = 'OUT' OR penjualan.stock = 'ADJ') AND penjualan.stock_id = inventories.stock_id ) AS nPenjualan")
                        ->where("stock", $stock)
                        ->leftjoin("items", "inventories.item_id", "=", "items.id")
                        ->leftjoin("stocks", "inventories.stock_id", "=", "stocks.id")
                        ->orderBy("inventories.tanggal", "DESC");
        if(! empty($q)) {
            $data->where(function($query) use ($q) {
                $query->where('items.item_name', 'LIKE', '%' . $q . '%')->orWhere('inventories.tanggal', 'LIKE', '%' . $q . '%')->orWhere('items.item_code', 'LIKE', '%' . $q . '%');
            });                    
        }
        $data = $data->paginate($perPage)->withQueryString();
        return view('modals.index', [
            'data' => $data,

            'stock' => $stock,
            'pageName' => 'modal',
            'colorTheme' => 'success',
            'q' => $q
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

        return view('modals.create', [
            'data' => $data,
            'stock' => 'IN',
            'pageName' => 'modal',
            'colorTheme' => 'success'
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
            "stock" => "IN",
        ];
        $inventory = Inventory::create($data);
        if(! $inventory) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('modal.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        if($request->action == "saveplus") {
            return redirect( route('modal.create') );
        }
        return redirect( route('modal.index') );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $modal
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $modal)
    {
        if(! $modal) {
            return redirect( route('modal.create') );
        }
        return view('modals.edit', ['data' => $modal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $modal
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $modal)
    {
        if($modal) {
            return view('modals.edit', ['data' => $modal]);
        } else {
            return redirect( route('modal.index') );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $modal
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInventoryRequest $request, Inventory $modal)
    {
        if(! $modal->update( $request->all() ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('modal.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('modal.show', ['inventory' => $modal->id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $modal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Inventory $modal)
    {
        if(! $modal->delete() ) {
            $request->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            $request->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        return redirect()->back(); 
    }
}
