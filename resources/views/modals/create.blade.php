@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-{{ $colorTheme }} p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Tambah ' . ucwords($pageName)) }}</h3>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-{{ $colorTheme }}" href="{{ route($pageName . '.index') }}">{{ __('kembali') }}</a>
                </div>
            </div>
            
            <x-alert-component />
                
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                    <!-- <div class="me-auto">
                        <h3 class="mb-0 lh-1">{{ __('Tambah ' . ucwords($pageName)) }}</h3>
                    </div>
                    <div class="ms-auto"> -->
                        
                        <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route($pageName . '.store') }}">                        
                        @csrf
                        @method('POST')
                        <input type="hidden" name="stock" value="{{ $stock }}" />
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            @if ($stock == "IN")
                            <div class="col-md-4">
                                <label for="item_id" class="form-label">Nama Barang</label>                             
                                
                                <select class="form-control" id="item_id" name="item_id"></select>
                                
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
                            <div class="col-md-4">
                                <label for="stock_id" class="form-label">Stock Barang</label>
                                <select class="form-control" id="stock_id" name="stock_id"></select>
                                <script type="text/javascript">
                                    $('#stock_id').select2({
                                        placeholder: 'Pilih barang',
                                        ajax: {
                                            url: "{{ route('stocks.autocomplete') }}",
                                            dataType: 'json',
                                            delay: 250,
                                            processResults: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.item_name + '. Sisa: ' + item.sisa + ' kg',
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
                            @endif
                            
                            <div class="col-md-1">
                                <label for="qty" class="form-label">Qty</label>
                                    <input type="text" class="form-control" id="qty" name="qty" required>
                            </div>
                            <div class="col-md-2">
                                <label for="unit" class="form-label">Unit</label>
                                <!-- <input type="text" class="form-control" id="unit" required> -->
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="bal">Bal</option>
                                    @if ($stock == "OUT")
                                        @foreach ($scales as $scale)
                                            <option value="{{ $scale->scalar }}">{{ $scale->scalar }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <!-- <div class="invalid-feedback">Please provide a valid city.</div> -->
                            </div>
                            <div class="col-md-2">
                                <label for="unit_price" class="form-label">Harga</label>
                                <input type="text" class="form-control" id="unit_price" name="unit_price" required>
                                <!-- <div class="invalid-feedback">Please select a valid state.</div> -->
                            </div>
                            <div class="col-md-2">
                                <label for="sub_total" class="form-label">Subtotal</label>
                                <input type="text" class="form-control" id="sub_total" name="sub_total" readonly>
                                <!-- <div class="invalid-feedback">Please provide a valid zip.</div> -->
                            </div>
                            <!-- <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                    <label class="form-check-label" for="invalidCheck">Data sudah benar semua!</label>
                                    <div class="invalid-feedback">You must agree before submitting.</div>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>
                    <!-- </div> -->

                </div>
            
            
        </div>
    </div>
</div>

@endsection
