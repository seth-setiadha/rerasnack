@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-light p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div>
                    <h3 class="mb-0 lh-1 text-success">{{ __('Reports: Laporan Modal') }}</h3>
                </div>                
            </div>
            
            <x-alert-component />

            <div class="card border-0 rounded shadow-sm my-3">
                <div class="card-body">
                    <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('reports.index') }}">
                        @method('POST')
                        @csrf
                        @include('reports.form', ['colorTheme' => 'success'])
                    </form> 
                </div>
            </div>
                
                <div class="p-3 my-3 bg-white p-2 text-dark rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Kode Barang</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col" class="text-center">Isi Per Bal (kg)</th>
                                    <th scope="col" class="text-center">Harga Produk (Per Bal)</th>
                                    <th scope="col" class="text-center">Jumlah Pembelian (Bal)</th>
                                    <th scope="col" class="text-center">Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sumQty = $sumTotal = 0; ?>
                                @foreach ($data as $row) 
                                <?php $sumQty += $row->qty; $sumTotal += $row->sub_total; ?>
                                <tr>
                                    <td>{{ $row->tanggal }}</td>
                                    <td>{{ $row->item_code }}</td>
                                    <td>{{ $row->item_name }}</td>
                                    <td class="text-center">{{ $row->bal_kg }}</td>
                                    <td class="text-end pe-2">{{ number_format($row->unit_price) }}</td>
                                    <td class="text-center">{{ $row->qty }}</td>
                                    <td class="text-end">{{ number_format($row->sub_total) }}</td>
                                </tr>                                
                                @endforeach    
                                <tr class="bg-success bg-opacity-25 fw-bold">
                                    <td colspan="5">Grand Total</td>
                                    
                                    <td class="text-center">{{ $sumQty }}</td>
                                    <td class="text-end">{{ number_format($sumTotal) }}</td>
                                </tr>                            
                            </tbody>
                        </table>
                    </div>                    
                </div>
            
            
        </div>
    </div>
</div>
@endsection
