@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-{{ $colorTheme }} p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ ucwords(__($pageName)) }}</h3>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-{{ $colorTheme }}" href="{{ route($pageName . '.create') }}">{{ __('Tambah '. ucwords($pageName)) }}</a>
                </div>
            </div>
            
            <x-alert-component />
            
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama Barang</th>
                                    @if ($stock == "IN") <th scope="col">Bal/kg</th> @endif
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
                                    <td>{{ $row->sisa }} kg</td>
                                    <td>
                                        <form method="POST" action="{{ route($pageName . '.destroy', [ $pageName => $row->id ]) }}">                        
                                        @csrf
                                        @method('DELETE')
                                            <button class="btn btn-sm btn-danger" type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eraser-fill" viewBox="0 0 16 16">
                                                    <path d="M8.086 2.207a2 2 0 0 1 2.828 0l3.879 3.879a2 2 0 0 1 0 2.828l-5.5 5.5A2 2 0 0 1 7.879 15H5.12a2 2 0 0 1-1.414-.586l-2.5-2.5a2 2 0 0 1 0-2.828l6.879-6.879zm.66 11.34L3.453 8.254 1.914 9.793a1 1 0 0 0 0 1.414l2.5 2.5a1 1 0 0 0 .707.293H7.88a1 1 0 0 0 .707-.293l.16-.16z"/>
                                                </svg>
                                            </button>
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
