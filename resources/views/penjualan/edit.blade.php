@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 mb-3 bg-{{ $colorTheme }} p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Ubah ' . ucwords($pageName)) }}</h3>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-{{ $colorTheme }}" href="{{ route($pageName . '.index') }}">{{ __('kembali') }}</a>
                </div>
            </div>
            
            <x-alert-component />
                @if ($tempNotes)
                    <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                        <div class="col-12 d-flex">
                            <div class="me-auto pb-2">
                                <h4 class="mb-0 lh-1">{{ __('Pencatatan Sementara') }}</h4>
                            </div>    
                        </div>
                        <div class="row">
                            <input type="hidden" name="temp_id" value="{{  $tempNotes->id }}" />
                            <div class="col-md-2">Tanggal:</div>
                            <div class="col-md-3">{{ $tempNotes->tanggal }}</div>
                            <div class="col-md-2">Nama Barang:</div>
                            <div class="col-md-5">{{ $tempNotes->item->item_name . " (" . $tempNotes->item->item_code . ")" }}</div>
                            
                            <div class="col-md-2">Harga &amp; Qty:</div>
                            <div class="col-md-3">{{ $tempNotes->harga }}</div>
                            <div class="col-md-2">Catatan:</div>
                            <div class="col-md-5">{{ $tempNotes->note }}</div>
                        </div>
                    </div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                        <form class="row g-3 needs-validation" autocomplete="off" novalidate method="POST" action="{{ route($pageName . '.update', ['penjualan' => $data->id]) }}">                        
                        @csrf
                        @method('PUT')
                        @if ($tempNotes)<input type="hidden" name="temp_id" value="{{  $tempNotes->id }}" />@endif
                        <input type="hidden" name="stock" value="{{ $stock }}" />
                        <input type="hidden" name="item_id" value="{{ $data->item_id }}" />
                        <input type="hidden" name="stock_id" value="{{ $data->stock_id }}" />
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            @if ($stock == "IN")
                            <div class="col-md-4">
                                <label for="item_id" class="form-label">Nama Barang</label>    
                                <select class="form-control" id="item_id" name="item_id" required></select>                                
                                <script type="text/javascript">
                                    $('#item_id').select2({
                                        placeholder: 'Pilih barang',
                                        ajax: {
                                            url: "{{ route('items.autocomplete') }}",
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.item_name + ' (' + item.item_code + ') ' + item.bal_kg + ' kg/bal',
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                            cache: true
                                        }
                                    });
                                </script>
                            </div>
                            @elseif ($stock == "OUT")
                            <div class="col-md-6">
                                <label for="stock_id" class="form-label">Stock Barang</label>                          
                                <input type="hidden" id="modal" value="{{ $data->persediaan->modal }}" /> <!-- STOCKS.MODAL  -->
                                <input type="hidden" id="qty_gr" value="{{  $data->unit_gr }}" />  <!-- QTY GRAM SUATU UNIT  --> 
                                <input type="hidden" id="stocksisa" value="{{ $data->persediaan->qty + $data->qty_gr }}" />
                                <input type="hidden" id="balkg" name="balkg" value="{{ ($data->persediaan->bal_kg * 1000) }}" /> <!-- STOCKS.BAL_KG -->
                                <input type="hidden" id="sisa" value="{{ $data->persediaan->qty }}" required /> <!-- STOCKS.QTY -->
                                <input type="text" class="form-control" readonly value="{{ $data->persediaan->item_name }}" required>
                                
                            </div>
                            @endif
                            
                            
                            <div class="col-md-2">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="bal">Bal</option>
                                    @if ($stock == "OUT")
                                        @foreach ($scales as $scale)                                            
                                            @if ($data->unit == $scale->scalar)
                                                <option value="{{ $scale->scalar }}" selected>{{ $scale->scalar }}</option>
                                            @else
                                                <option value="{{ $scale->scalar }}">{{ $scale->scalar }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label for="qty" class="form-label">Qty</label>
                                    <input type="number" class="form-control" min="1" id="qty" name="qty" value="{{ $data->qty }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="unit_price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ $data->unit_price }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="sub_total" class="form-label">Subtotal</label>
                                <input type="text" class="form-control" id="sub_total" name="sub_total" value="{{ ( $data->qty *  $data->unit_price ) }}" readonly>
                            </div>
                            @if ($stock == "OUT")
                            <div class="col-md-2">
                                <label for="profit" class="form-label">Profit</label>
                                <input type="text" class="form-control" id="profit" name="profit" value="{{ $data->profit }}" readonly>
                            </div>
                            @endif
                            <div class="col-12 d-flex">                                
                                <div class="me-auto">
                                    <button name="action" value="save" class="saveButton btn btn-{{ $colorTheme }}" type="submit">Simpan</button>
                                </div>    
                                <div class="ms-auto">
                                    <a class="btn btn-danger" href="#"
                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-form').submit();">
                                        {{ __('Delete') }}
                                    </a>                                    
                                </div>    
                            </div>
                        </form>                        
                        <form id="delete-form" method="POST" action="{{ route($pageName . '.destroy', [ $pageName => $data->id ]) }}" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>

                </div>
            
            
        </div>
    </div>
</div>


@include('penjualan.jsedit') 

@endsection
