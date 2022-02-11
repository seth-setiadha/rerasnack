@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-warning p-2 text-dark bg-opacity-25 rounded shadow-sm">
            <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Daftar Adjusment') }}</h3>
                </div>
                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownStock" data-bs-toggle="dropdown" aria-expanded="false">
                            Stock/Adjustment
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownStock">
                            <li><a class="dropdown-item" href="{{ route('stocks.index') }}">{{ __('Stock Barang') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('stocks.habis') }}">{{ __('Stock Barang Habis') }}</a></li>                            
                            <li><a class="dropdown-item" href="{{ route('stocks.create') }}">{{ __('Buat Adjusment') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tgl. Adjusment</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Sisa</th>
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->tanggal }}</td>
                                    <td>{{ $row->item_name }}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->unit }}</td>
                                    <td>{{ $row->sisa }}</td>
                                    <!-- <td>&nbsp;</td> -->
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
