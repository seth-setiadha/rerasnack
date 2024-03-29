<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Inventory;
use App\Models\Scale;
use App\Repositories\InventoryRepository;
use App\Repositories\StockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StockController extends Controller
{
    private $stockRepository;
    private $inventoryRepository;

    public function __construct()
    {
        $this->stockRepository = new StockRepository;
        $this->inventoryRepository = new InventoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $data = $this->stockRepository->index(">");
        $data['link'] = route('stocks.index');
        return view('stocks.index', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function habis()
    {
        $data = $this->stockRepository->index("<=");
                
        return view('stocks.habis', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function adjustment()
    {        
        $data = $this->inventoryRepository->index("ADJ");

        return view('stocks.adjustment', $data);
    }

    public function autocomplete(Request $request) {
        // $query = $request->get('query');
        $query = $request->get('term');
        $items = Stock::select('stocks.id', 'stocks.item_name', 'stocks.item_id', 'stocks.bal_kg', 'modal')->selectRaw('DATE_FORMAT(stocks.tanggal, "%e %b \'%y") AS tanggal, FORMAT(stocks.qty / 1000,2) AS sisa')
        ->where('stocks.qty', '>', 0)
        ->where('item_name', 'LIKE', '%'. $query. '%')->limit(10)->get();

        $arr = [];
        foreach($items as  $item) {
            $lastModal = Inventory::select('unit_price_gr')->where('item_id', '=', $item->item_id)->where('stock', '=', 'IN')->orderBy('created_at', 'DESC')->first();
            if($lastModal) {
                $latestModal = $lastModal->unit_price_gr;
            } else {
                $latestModal = 0;
            }
            $arr[] = [
                'id' => $item->id,
                'item_name' => $item->item_name,
                'bal_kg' => $item->bal_kg,
                'modal' => $item->modal,
                'tanggal' => $item->tanggal,
                'sisa' => $item->sisa,
                'latestModal' => $latestModal,
            ];
        }

        return response()->json($arr);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Stock();
        $scales = Scale::orderBy('pergram', 'DESC')->get();
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
    public function store(StoreStockRequest $request)
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
            return redirect()->back();
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        $data = $this->stockRepository->detailByStockID($stock);
        return view('stocks.show', [
            'data' => $data,
            "stock" => $stock,
            "labelX" => "item", 
            "label" => "stock"
        ]);
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
    public function destroy(Request $request, Inventory $stock)
    {
        if(! $stock->delete() ) {
            $request->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            $request->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        return redirect()->back(); 
    }
}
