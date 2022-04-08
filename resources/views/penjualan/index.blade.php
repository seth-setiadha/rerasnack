@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 mb-3 bg-{{ $colorTheme }} p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ ucwords(__($pageName)) }}</h3>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-{{ $colorTheme }}" href="{{ route($pageName . '.create') }}">{{ __('Tambah '. ucwords($pageName)) }}</a>
                </div>
            </div>
            
            <x-alert-component />
            
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <x-searchform url="{{ route($pageName . '.index') }}" :color="$colorTheme" :q="$q" />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama Barang</th>
                                    @if ($stock == "IN") <th scope="col">kg/bal</th> @endif
                                    <th scope="col">Qty</th>
                                    <th scope="col">Harga / Unit</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col">Sisa</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->tanggal }}</td>
                                    <td class="text-nowrap">{{ $row->item_name . ' (' . $row->item_code . ')' }}</td>
                                    @if ($stock == "IN") <td>{{ $row->bal_kg }}</td> @endif
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->unit_price . ' / ' . $row->unit }}</td>
                                    <td>{{ $row->sub_total }}</td>
                                    <td>{{ $row->sisa > 0 ? $row->sisa . '  kg' : 'habis' }}</td>
                                    <td class="text-end">
                                        
                                            <form method="POST" action="{{ route($pageName . '.destroy', [ $pageName => $row->id ]) }}">                        

                                            <a href="{{ route('stocks.show', ['stock' => $row->stock_id]) }}" class="btn btn-sm btn-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                            </svg></a>
                                            
                                            @if (($stock == "IN" && $row->nPenjualan < 1) || $stock == "OUT")    

                                            &nbsp;
                                            <a href="{{ route( $pageName . '.edit', [ $pageName => $row->id ]) }}" class="btn btn-sm btn-warning">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" title="Edit" viewBox="0 0 16 16">
                                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                                </svg> 
                                            </a>

                                            @csrf
                                            @method('DELETE')
                                                &nbsp;
                                                <button class="btn btn-sm btn-danger" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                        <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                                                    </svg>
                                                </button>
                                            @endif
                                            
                                            </form>
                                        
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
