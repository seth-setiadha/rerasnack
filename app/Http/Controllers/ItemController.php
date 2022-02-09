<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
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
        $perPage = intval($request->query('perPage'));
        $page = intval($request->query('page'));
        $page = $page > 0 ? $page : 1;
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;
        $offset = ($page - 1) * $perPage;

        $data = Item::select('id', 'item_code', 'item_name', 'bal_kg')->offset($offset)->limit($perPage)->get();
        $count = Item::count();

        return view('items.index', [
            'data' => $data,
            'count' => $count,
            'page' => $page,
            'nPage' => ceil($count / $perPage)
        ]);
    }

    public function autocomplete(Request $request) {
        // $query = $request->get('query');
        $query = $request->get('term');
        $items = Item::select('id', 'item_name')->where('item_name', 'LIKE', '%'. $query. '%')->orWhere('item_code', 'LIKE', '%' . $query . '%')->limit(10)->get();
        $itemsArr = [];
        foreach($items as $item) {
            $itemsArr[$item->id] = $item->item_name;
        }
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
    public function store(StoreItemRequest $request)
    {
        $data = [
            "item_code" => $request->item_code,
            "item_name" => $request->item_name,
            "item_description" => $request->item_description,
            "bal_kg" => $request->bal_kg,
            "user_id" => Auth::user()->id,
        ];
        $item = Item::create($data);
        if(! $item) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            // return response()->json(["message" => "Data belum berhasil ditambahkan", "data" => $data ], 400);    
            return redirect( route('items.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
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
            // return response()->json(["message" => "Data belum berhasil ditambahkan", "data" => $data ], 400);    
            return redirect( route('items.create') );
        }
        return view('items.edit', ['data' => $item]);
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
    public function update(UpdateItemRequest $request, Item $item)
    {
        if(! $item->update( $request->all() ) ) {
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
