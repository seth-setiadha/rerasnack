<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\UpdateInventoryRequest;
use App\Repositories\InventoryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    private $inventoryRepository;
    
    public function __construct(InventoryRepository $inventoryRepository)
    {
        $this->inventoryRepository = $inventoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $data = $this->inventoryRepository->index($stock="IN");
        $data['stock'] = $stock;
        $data['pageName'] = 'modal';
        $data['colorTheme'] = 'success';
        
        return view('modals.index', $data);
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
    public function store(StoreInventoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data["stock"] = "IN";
        
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
