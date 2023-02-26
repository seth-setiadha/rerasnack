<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Repositories\StockRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        if (! Gate::allows('admin-access')) { abort(403); }
        $q = $request->query('q');
        $perPage = intval($request->query('perPage'));
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $data = Item::select('id', 'item_code', 'item_name', 'bal_kg')
                ->selectRaw("(SELECT COUNT(inventories.id) FROM `inventories` WHERE inventories.item_id = items.id)  AS nInventories")
                ->orderBy('item_code', 'ASC');
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
        if (! Gate::allows('admin-access')) { abort(403); }
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
        if (! Gate::allows('admin-access')) { abort(403); }
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
        if (! Gate::allows('admin-access')) { abort(403); }
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
        if (! Gate::allows('admin-access')) { abort(403); }
        if($item) {
            $nCount = DB::table('inventories')->selectRaw("count(item_id) AS nCount")->where('item_id', '=', $item->id)->first('nCount')->nCount;
            return view('items.edit', ['data' => $item, 'nCount' => $nCount]);
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
        if (! Gate::allows('admin-access')) { abort(403); }
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
        if (! Gate::allows('admin-access')) { abort(403); }
        if(! $item->delete() ) {
            request()->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            request()->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        return redirect()->back(); 
    }
}
