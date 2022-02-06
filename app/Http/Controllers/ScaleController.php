<?php

namespace App\Http\Controllers;

use App\Models\Scale;
use App\Http\Requests\StoreScaleRequest;
use App\Http\Requests\UpdateScaleRequest;

class ScaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScaleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScaleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function show(Scale $scale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function edit(Scale $scale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScaleRequest  $request
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScaleRequest $request, Scale $scale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Scale  $scale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scale $scale)
    {
        //
    }
}
