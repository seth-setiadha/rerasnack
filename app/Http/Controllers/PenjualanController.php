<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Models\Scale;
use App\Repositories\InventoryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    private $repo;

    public function __construct(InventoryRepository $repo)
    {
        $this->repo = $repo;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->repo->index($stock="OUT");
        $data['stock'] = $stock;
        $data['pageName'] = 'penjualan';
        $data['colorTheme'] = 'primary';
        $data['link'] = route('penjualan.index');
        // dd($data);
        return view('penjualan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Inventory();
        $scales = Scale::orderBy('pergram', 'DESC')->get();

        return view('penjualan.create', [
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
    public function store(StoreInventoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data["stock"] = "OUT";

        $penjualan = Inventory::create($data);
        if(! $penjualan) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('penjualan.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        if($request->action == "saveplus") {
            return redirect( route('penjualan.create') );
        }
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
        return view('penjualan.edit', [
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
            $penjualan->persediaan;
            $penjualan->unit_gr = $this->repo->toGram($penjualan->unit, $penjualan->persediaan->bal_kg);        
            $penjualan->profit = floor($penjualan->sub_total - ($penjualan->qty_gr * $penjualan->persediaan->modal));

            $scales = Scale::orderBy('pergram', 'DESC')->get();            
            return view('penjualan.edit', [
                'data' => $penjualan,
                'scales' => $scales,
                'stock' => 'OUT',
                'pageName' => 'penjualan',
                'colorTheme' => 'primary'
            ]);
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
        $data = $request->validated();
        

        if(! $this->repo->update($penjualan, $data ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('penjualan.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('stocks.show', ['stock' => $penjualan->stock_id ]) );
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

        // return redirect()->back(); 
        return redirect( route('penjualan.index') );
    }
}
