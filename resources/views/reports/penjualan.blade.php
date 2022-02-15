@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-light p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div>
                    <h3 class="mb-0 lh-1 text-primary">{{ __('Reports: Laporan Penjualan') }}</h3>
                </div>                
            </div>
            
            <x-alert-component />

            <div class="card border-0 rounded shadow-sm my-3">
                <div class="card-body">
                    <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('reports.index') }}">
                        @method('POST')
                        @csrf
                        @include('reports.form', ['colorTheme' => 'primary'])
                    </form> 
                </div>
            </div>
                
            <div class="p-3 my-3 bg-white p-2 text-dark bg-rounded shadow-sm">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Unit</th>
                                <th scope="col">Harga Jual Per Unit</th>
                                <th scope="col">Qty</th>
                                <th scope="col">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                            <tr>
                                <td>{{ $row->tanggal }}</td>
                                <td>{{ $row->item_code }}</td>
                                <td>{{ $row->item_name }}</td>
                                <td>{{ $row->unit }}</td>
                                <td>{{ $row->unit_price }}</td>
                                <td>{{ $row->qty }}</td>
                                <td>{{ $row->sub_total }}</td>
                            </tr>
                            @endforeach                                
                        </tbody>
                    </table>
                </div>                    
            </div>
            
            
        </div>
    </div>
</div>
@endsection
