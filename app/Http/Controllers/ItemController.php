<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Repositories\StockRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
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

        $data = Item::select('id', 'item_code', 'item_name', 'bal_kg')->orderBy('item_code', 'ASC');
        if(! empty($q)) {
            $data->where('item_code', 'LIKE', '%' . $q . '%')->orWhere('item_name', 'LIKE', '%' . $q . '%');                    
        }
        $data = $data->paginate($perPage)->withQueryString();

        return view('items.index', [
            'data' => $data,
            'q' => $q
        ]);
    }

    public function autocomplete(Request $request) {
        // $query = $request->get('query');
        $query = $request->get('term');
        $items = Item::select('id', 'item_name', 'bal_kg', 'item_code')->where('item_name', 'LIKE', '%'. $query. '%')->orWhere('item_code', 'LIKE', '%' . $query . '%')->limit(10)->get();   
        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = new Item();

        return view('items.create', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $validatedData["user_id"] = Auth::user()->id;

        $item = Item::create($validatedData);
        if(! $item) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('items.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        
        if($request->input('action') == "saveplus") {
            return redirect( route('items.create') );
        }
        return redirect( route('items.show', ['item' => $item->id ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        if(! $item) {
            return 404;
        }
        $stockRepo = new StockRepository();
        $data = $stockRepo->detailByItemID($item);
        return view('stocks.show', ['data' => $data, "stock" => $item, "label" => "item", "labelX" => "stock"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        if($item) {
            return view('items.edit', ['data' => $item]);
        } else {
            return redirect( route('items.index') );
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item): RedirectResponse
    {
        $validatedData = $request->validated();
        if(! $item->update( $validatedData ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('items.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('items.show', ['item' => $item->id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
