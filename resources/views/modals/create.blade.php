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
                        
                        <form class="row g-3 needs-validation" autocomplete="off" novalidate method="POST" action="{{ route($pageName . '.store') }}">                        
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
                                <input type="hidden" id="modal" value="" />
                                <input type="hidden" id="qty_gr" value="" />
                                <input type="hidden" id="stocksisa" value="" />
                                <input type="hidden" id="balkg" value="" />
                                <input type="hidden" id="sisa" class="form-control" value="" required />
                                <select class="form-control" id="stock_id" name="stock_id" required></select>
                                
                            </div>
                            @endif
                            
                            
                            <div class="col-md-2">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select" id="unit" name="unit" required>
                                    <option value="bal">Bal</option>
                                    @if ($stock == "OUT")
                                        @foreach ($scales as $scale)
                                            
                                            @if (old('unit') == $scale->scalar)
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
                                    <input type="number" class="form-control" min="1" id="qty" name="qty" value="{{ old('qty') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="unit_price" class="form-label">Harga</label>
                                <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ old('unit_price') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label for="sub_total" class="form-label">Subtotal</label>
                                <input type="text" class="form-control" id="sub_total" name="sub_total" readonly>
                            </div>
                            @if ($stock == "OUT")
                            <div class="col-md-2">
                                <label for="profit" class="form-label">Profit</label>
                                <input type="text" class="form-control" id="profit" name="profit" readonly>
                            </div>
                            @endif
                            <div class="col-12 d-flex">
                                <div class="me-auto">
                                    <button name="action" value="save" class="saveButton btn btn-{{ $colorTheme }}" type="submit">Simpan</button>
                                </div>    
                                <div class="ms-auto">
                                    <button name="action" value="saveplus" class="saveButton btn btn-dark" type="submit">Simpan &amp; Tambah Lagi</button>
                                </div>    
                            </div>
                        </form>

                </div>
            
            
        </div>
    </div>
</div>

@if ($stock == "OUT")
@include('modals.js') 
@endif

<script type="text/javascript">    
    $('#qty').focusout(function() {
        checkSubTotal();
    });
    $('#unit').change(function() {
        
    });
    $('#unit_price').focusout(function() {
        checkSubTotal();
    });

    function checkSubTotal() {
        $('#sub_total').val(0);
        var qty = parseInt($('#qty').val());
        var unit_price = parseInt($('#unit_price').val());
        
        if( qty > 0 && unit_price > 0) {
            $('#sub_total').val( qty * unit_price );
        } else {
            // console.log('masuk else');
        }

        if( $("#profit").length > 0 && $("#modal").length > 0 ) {
            var modal = parseFloat( $('#modal').val() );
            var qty_gr = parseInt( $('#qty_gr').val() );
            var sub_total = parseInt( $('#sub_total').val() );

            if(sub_total > 0) {
                let profit = sub_total - (qty * qty_gr * modal);
                if(profit >= 0) { } else {
                    alert('Profit minus!');
                }
                $("#profit").val(profit);
                $('.saveButton').prop('disabled', false);
            } else {
                $('.saveButton').prop('disabled', true);
            }
        }
    }    
</script>

@endsection
