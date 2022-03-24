@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-light p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __( ucfirst($label) . ' Detail') . ': ' . $stock->item_name }} </h3>
                </div>
                <div class="ms-auto">
                    @if ($label == 'stock')                        
                    <a class="btn btn-secondary" href="{{ route( $labelX . 's.show', [ $labelX => $stock->item_id ?? $stock->id ]) }}">{{ __( ucfirst($labelX) . ' Detail') }}</a>
                    @else
                    <a class="btn btn-secondary" href="{{ url()->previous() }}">Back</a>
                    @endif
                </div>
            </div>
            
            <x-alert-component />

                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">    
                    @forelse ($data as $modal)
                    <ul>                        
                        <li><span class="fw-bold">Modal Tgl. Masuk: {{ date("d F Y", strtotime($modal->tanggal) ) }}</span>
                            <ul>
                                <li>Kilo / Bal: {{ $modal->bal_kg }} kg</li>
                                <li>Qty @ Harga: {{ $modal->qty }} @ Rp.  {{ number_format($modal->unit_price) }} per bal</li>
                                <li>Stock Awal: {{ ($modal->bal_kg * $modal->qty) }} kg</li>
                                <li>Sub Total: Rp. {{ number_format($modal->sub_total) }}</li>
                                <li><span class="fw-bold">Stock Sisa: {{ ($modal->stock->qty / 1000) }} kg</span> 
                                    dgn hitungan modal: Rp. {{ number_format($modal->stock->modal,2) }} / gram
                                </li>
                                <li> Penjualan: 
                                    <ul>
                                @forelse ($modal->penjualan as $penjualan)
                                    <li>Tgl. Penjualan: {{ $penjualan->tanggal }} <br />
                                        Qty @ Unit @ Harga: {{ $penjualan->qty . ' buah @ ' . $penjualan->unit . ' @ ' . number_format($penjualan->unit_price) }} = Rp. {{ number_format($penjualan->sub_total) }}
                                </li>
                                @empty
                                    Belum ada penjualan
                                @endforelse
                                    </ul>
                                </li>                                                    
                            </ul>
                        </li>
                    </ul>
                    @empty
                        Belum ada data di system
                    @endforelse
                </div>
        </div>
    </div>
</div>
@include('modals.js')

@endsection
