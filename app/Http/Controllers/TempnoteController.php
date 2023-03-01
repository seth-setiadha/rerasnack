<?php

namespace App\Http\Controllers;

use App\Models\Tempnotes;
use App\Http\Requests\StoreTempnotesRequest;
use App\Http\Requests\UpdateTempnotesRequest;
use App\Repositories\TempnotesRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TempnoteController extends Controller
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
        $data = $this->repo->index();
        $data['pageName'] = 'tempnotes';
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
            'pageName' => 'tempnotes',
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
    public function show(Tempnotes $tempnote)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        if(! $tempnote) {
            return redirect( route('tempnotes.create') );
        }
        return view('tempnotes.edit', [
            'data' => $tempnote,
            'pageName' => 'tempnotes',
            'colorTheme' => 'primary'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tempnotes  $tempnotes
     * @return \Illuminate\Http\Response
     */
    public function edit(Tempnotes $tempnote)
    {        
        if (! Gate::allows('admin-access')) { abort(403); }
        if($tempnote) {
            return view('tempnotes.edit', [
                'data' => $tempnote,
                'pageName' => 'tempnotes',
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
    public function update(UpdateTempnotesRequest $request, Tempnotes $tempnote)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        $data = $request->validated();

        if(! $this->repo->update($tempnote, $data ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('tempnotes.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('stocks.show', ['stock' => $tempnote->stock_id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Illuminate\Http\Request $request
     * @param  \App\Models\Tempnotes  $tempnotes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Tempnotes $tempnote)
    {
        if (! Gate::allows('admin-access')) { abort(403); }
        if(! $tempnote->delete() ) {
            $request->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            $request->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        // return redirect()->back(); 
        return redirect( route('tempnotes.index') );
    }
}
