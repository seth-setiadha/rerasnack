@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-secondary p-2 text-dark bg-opacity-25 rounded shadow-sm">                
                <h3 class="mb-0 lh-1">{{ __('Reports') }}</h3>                
            </div>
            
            <x-alert-component />

            <div class="card border-0 rounded shadow-sm my-3">
                <div class="card-header bg-success bg-opacity-25" role="button" data-bs-toggle="collapse" data-bs-target="#collapseModal" aria-expanded="true" aria-controls="collapseModal">                    
                    <h5 class="mb-0">{{ __('Modal') }}</h5>
                </div>
                <div class="collapse" id="collapseModal">
                    <div class="card-body">
                        <form class="row g-3 needs-validation" target="_blank" novalidate method="POST" action="{{ route('reports.modal') }}">
                            @method('POST')
                            @csrf
                            <div class="col-sm-1 align-middle">
                                Dari
                            </div>
                            <div class="col-sm mt-0 mt-sm-3">
                                <select class="form-control" id="from" name="from">
                                    <option>Jan 2022</option>
                                    <option>Dec 2021</option>
                                    <option>Nov 2021</option>
                                    <option>Oct 2021</option>
                                </select>                             
                            </div>
                            <div class="col-sm-1 text-start text-sm-center">
                                s/d
                            </div>
                            <div class="col-sm mt-0 mt-sm-3">
                                <select class="form-control" id="to" name="to">
                                    <option>Jan 2022</option>
                                    <option>Dec 2021</option>
                                    <option>Nov 2021</option>
                                    <option>Oct 2021</option>
                                </select>                             
                            </div>
                            <div class="col-sm">
                                <button class="btn btn-success" type="submit">Download</button>
                            </div>
                        </form>                        
                    </div>
                </div>
            </div>
            
            <div class="card border-0 rounded shadow-sm my-3">
                <div class="card-header bg-primary bg-opacity-25 "  data-bs-toggle="collapse" data-bs-target="#collapsePenjualan" aria-expanded="false" aria-controls="collapsePenjualan" role="button">
                    <h5 class="mb-0">{{ __('Penjualan') }}</h5>
                </div>
                <div class="collapse" id="collapsePenjualan">
                    <div class="card-body">
                    <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('reports.penjualan') }}">
                            @method('POST')
                            @csrf
                            <div class="col-sm-1">
                                Dari Bulan
                            </div>
                            <div class="col-sm mt-0 mt-sm-3">
                                <select class="form-control" id="from" name="from">
                                    <option>Jan 2022</option>
                                    <option>Dec 2021</option>
                                    <option>Nov 2021</option>
                                    <option>Oct 2021</option>
                                </select>                             
                            </div>
                            <div class="col-sm-1 text-start text-sm-center">
                                s/d
                            </div>
                            <div class="col-sm mt-0 mt-sm-3">
                                <select class="form-control" id="from" name="from">
                                    <option>Jan 2022</option>
                                    <option>Dec 2021</option>
                                    <option>Nov 2021</option>
                                    <option>Oct 2021</option>
                                </select>                             
                            </div>
                            <div class="col-sm">
                                <button class="btn btn-primary" type="submit">Download</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card border-0 rounded shadow-sm my-3">
                <div class="card-header bg-secondary bg-opacity-25 "  data-bs-toggle="collapse" data-bs-target="#collapseDetail" aria-expanded="false" aria-controls="collapseDetail" role="button">
                    <h5 class="mb-0">{{ __('Detail Report') }}</h5>
                </div>
                <div class="collapse" id="collapseDetail">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-secondary">Download</a>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 rounded shadow-sm ">
                <div class="card-header bg-warning bg-opacity-25 "  data-bs-toggle="collapse" data-bs-target="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary" role="button">
                    <h5 class="mb-0">{{ __('Summary') }}</h5>
                </div>
                <div class="collapse" id="collapseSummary">
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-warning">Download</a>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
@endsection
