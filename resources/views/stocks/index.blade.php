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
            
                <x-alert-component />

                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <x-searchform url="{{ route('stocks.index') }}" color="warning" :q="$q" />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col" rowspan="2" class="align-middle"><x-header-table text="Tgl. Masuk" field="tanggal" :sort="$sort" :sortBy="$sortBy" :link="$link"/></th>
                                    <th scope="col" rowspan="2" class="align-middle"><x-header-table text="Nama Barang" field="item_name" :sort="$sort" :sortBy="$sortBy" :link="$link"/></th>
                                    <th scope="col" rowspan="2" class="align-middle"><x-header-table text="bal/kg" field="bal_kg" :sort="$sort" :sortBy="$sortBy" :link="$link"/></th>
                                    <th colspan="2" class="text-center">Modal Awal</th>
                                    <th scope="col" rowspan="2" class="align-middle text-center"><x-header-table text="Sisa (kg)" field="qty_kg" :sort="$sort" :sortBy="$sortBy" :link="$link"/></th>
                                </tr>
                                <tr>                                   
                                    <th scope="col" class="text-center">Qty.</th>
                                    <th scope="col" class="text-center">&Sigma; kg </th>
                                    <th scope="col" class="text-center">&nbsp;</th>
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
                                    <td class="text-end"><a href="{{ route('stocks.show', ['stock' => $row->id]) }}" class="btn btn-sm btn-secondary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg></a>
                                    </td>
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
