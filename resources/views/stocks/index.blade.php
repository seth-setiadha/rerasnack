@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-warning p-2 text-dark bg-opacity-25 rounded shadow-sm">
            <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Stock Barang') }}</h3>
                </div>
                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownStock" data-bs-toggle="dropdown" aria-expanded="false">
                            Stock/Adjustment
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownStock">
                            <li><a class="dropdown-item" href="{{ route('stocks.habis') }}">{{ __('Stock Barang Habis') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('stocks.adjustment') }}">{{ __('Daftar Adjusment') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('stocks.create') }}">{{ __('Buat Adjusment') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" rowspan="2" class="align-middle">Tgl. Masuk</th>
                                    <th scope="col" rowspan="2" class="align-middle">Nama Barang</th>
                                    <th scope="col" rowspan="2" class="align-middle">bal/kg</th>
                                    <th colspan="2" class="text-center">Modal Awal</th>
                                    <th scope="col" rowspan="2" class="align-middle text-center">Sisa (kg)</th>
                                </tr>
                                <tr>                                   
                                    <th scope="col" class="text-center">Qty.</th>
                                    <th scope="col" class="text-center">kg </th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->tanggal }}</td>
                                    <td>{{ $row->item_name }}</td>
                                    <td>{{ $row->bal_kg }}</td>
                                    <td class="text-center">{{ $row->qty }}</td>
                                    <td class="text-center">{{ ($row->qty * $row->bal_kg) }}</td>
                                    <td class="text-center">{{ $row->qty_kg }}</td>                                    
                                </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>
                    <x-pagination :links="$data" />
                </div>
            
            
        </div>
    </div>
</div>
@endsection
