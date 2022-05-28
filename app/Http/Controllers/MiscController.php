<?php

namespace App\Http\Controllers;

use App\Models\Misc;
use App\Http\Requests\StoreMiscRequest;
use App\Http\Requests\UpdateMiscRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MiscController extends Controller
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
        $sort = $request->query('sort');
        $sortBy = $request->query('sortBy');

        $perPage = intval($request->query('perPage'));
        $perPage = $perPage > 0 && $perPage <= 100 ? $perPage : 15;

        $data = Misc::select('*');
        if(! empty($q)) {
            $data->where(function($query) use ($q) {
                $query->where('misc_name', 'LIKE', '%' . $q . '%')->orWhere('tanggal', 'LIKE', '%' . $q . '%');
            });                    
        }

        if(! empty($sortBy)) { 
            if(empty($sort) && ! in_array($sort, ['ASC', 'DESC'])) {
                $sort = 'DESC';
            }
            $data->orderBy($sortBy, $sort);
        } else {
            $data->orderBy("tanggal", "DESC");
        }
        
        $data = $data->paginate($perPage)->withQueryString();
        return view('miscs.index', [
            'data' => $data,

            'colorTheme' => 'secondary',
            'q' => $q,
            "sortBy" => $sortBy, 
            "sort" => $sort,
            'link' => route('misc.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = new Misc();

        return view('miscs.create', [
            'data' => $data,
            'colorTheme' => 'secondary'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMiscRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMiscRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $data = Misc::create($validatedData);
        if(! $data) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('misc.create') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        
        if($request->input('action') == "saveplus") {
            return redirect( route('misc.create') );
        }
        return redirect( route('misc.show', ['misc' => $data->id ]) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Misc  $misc
     * @return \Illuminate\Http\Response
     */
    public function show(Misc $misc)
    {
        if(! $misc) {
            return redirect( route('misc.create') );
        }
        return view('miscs.edit', ['data' => $misc]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Misc  $misc
     * @return \Illuminate\Http\Response
     */
    public function edit(Misc $misc)
    {
        if($misc) {
            return view('misc.edit', ['data' => $misc]);
        } else {
            return redirect( route('misc.index') );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMiscRequest  $request
     * @param  \App\Models\Misc  $misc
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMiscRequest $request, Misc $misc)
    {
        $validatedData = $request->validated();
        if(! $misc->update( $validatedData ) ) {
            $request->session()->flash('error', 'Data belum berhasil disimpan');
            return redirect( route('misc.edit') );
        }
        $request->session()->flash('status', 'Data sudah berhasil disimpan');
        return redirect( route('misc.show', ['misc' => $misc->id ]) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Misc  $misc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Misc $misc)
    {
        if(! $misc->delete() ) {
            $request->session()->flash('error', 'Data belum berhasil dihapus');
            
        } else {
            $request->session()->flash('status', 'Data sudah berhasil dihapus');
        }        

        return redirect()->back(); 
    }
}
