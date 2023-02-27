<?php

namespace App\Http\Controllers;

use App\Models\Tempnotes;
use App\Http\Requests\StoreTempnotesRequest;
use App\Http\Requests\UpdateTempnotesRequest;
use App\Repositories\TempnotesRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TempnotesController extends Controller
{
    private $repo;

    public function __construct(TempnotesRepository $repo)
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
        if (! Gate::allows('admin-access')) { abort(403); }
        $data['pageName'] = 'Pencatatan Penjualan Sementara';
        $data['colorTheme'] = 'primary';
        $data['link'] = route('tempnotes.index');
        // dd($data);
        return view('tempnotes.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        $data = new Tempnotes();

        return view('tempnotes.create', [
            'data' => $data,
            'pageName' => 'Pencatatan Penjualan Sementara',
            'colorTheme' => 'primary'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTempnotesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTempnotesRequest $request): RedirectResponse
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        $data = $request->validated();
     
        $tempnotes = Tempnotes::create($data);
        if(! $tempnotes) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('tempnotes.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        if($request->action == "saveplus") {
            return redirect( route('tempnotes.create') );
        }
        return redirect( route('tempnotes.index') );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tempnotes  $tempnotes
     * @return \Illuminate\Http\Response
     */
    public function show(Tempnotes $tempnotes)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        if(! $tempnotes) {
            return redirect( route('tempnotes.create') );
        }
        return view('tempnotes.edit', [
            'data' => $tempnotes,
            'pageName' => 'Pencatatan Penjualan Sementara',
            'colorTheme' => 'primary'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tempnotes  $tempnotes
     * @return \Illuminate\Http\Response
     */
    public function edit(Tempnotes $tempnotes)
    {        
        if (! Gate::allows('admin-access')) { abort(403); }
        if($tempnotes) {
            return view('tempnotes.edit', [
                'data' => $tempnotes,
                'pageName' => 'Pencatatan Penjualan Sementara',
                'colorTheme' => 'primary'
            ]);
        } else {
            return redirect( route('tempnotes.index') );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTempnotesRequest  $request
     * @param  \App\Models\Tempnotes  $tempnotes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTempnotesRequest $request, Tempnotes $tempnotes)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        $data = $request->validated();
        
        if(! $this->repo->update($tempnotes, $data ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('tempnotes.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('stocks.show', ['stock' => $tempnotes->stock_id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Http\Request $request
     * @param  \App\Models\Tempnotes  $tempnotes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tempnotes $tempnotes)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        if(! $tempnotes->delete() ) {
            $request->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            $request->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        // return redirect()->back(); 
        return redirect( route('tempnotes.index') );
    }
}
