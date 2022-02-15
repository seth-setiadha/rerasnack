@extends('layouts.app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-warning p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Buat Adjusment') }}</h3>
                </div>
                <div class="ms-auto">
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownStock" data-bs-toggle="dropdown" aria-expanded="false">
                            Stock/Adjustment
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownStock">
                            <li><a class="dropdown-item" href="{{ route('stocks.index') }}">{{ __('Stock Barang') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('stocks.habis') }}">{{ __('Stock Barang Habis') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('stocks.adjustment') }}">{{ __('Daftar Adjusment') }}</a></li>                            
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
                        
                        <form class="row g-3 needs-validation" autocomplete="off" novalidate method="POST" action="{{ route('stocks.store') }}">                        
                        @csrf
                        @method('POST')
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>                                
                            </div>
                            <div class="col-md-6">
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
                                                            text: item.item_name + ' ' + item.bal_kg + ' kg/bal. Masuk ' + item.tanggal + '. Sisa ' + item.sisa + ' kg',
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
                            
                            <div class="col-md-1">
                                <label for="qty" class="form-label">Qty</label>
                                    <input type="text" class="form-control" id="qty" name="qty" required>
                            </div>
                            <div class="col-md-2">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="bal">Bal</option>
                                    @foreach ($scales as $scale)
                                        <option value="{{ $scale->scalar }}">{{ $scale->scalar }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Submit form</button>
                            </div>
                        </form>

                </div>
            
            
        </div>
    </div>
</div>

@endsection
