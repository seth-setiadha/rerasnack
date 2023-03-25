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
                    <h3 class="mb-0 lh-1">{{ __('Tambah Pencatatan') }}</h3>
                </div>
                <div class="ms-auto">
                    <a class="btn btn-{{ $colorTheme }}" href="{{ route($pageName . '.index') }}">{{ __('kembali') }}</a>
                </div>
            </div>
            
            <x-alert-component />
                
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                        <form class="row g-3 needs-validation" autocomplete="off" novalidate method="POST" action="{{ route($pageName . '.update', ['tempnote' => $data->id ]) }}">                        
                        @csrf
                        @method('PUT')
                       
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" >
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-4">
                                <label for="item_id" class="form-label">Nama Barang</label><br />{{ $data->item->item_name . " (" . $data->item->item_code. ")" }}
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

                                    var studentSelect = $('#item_id');
                                    $.ajax({
                                        type: 'GET',
                                        url: "{{ route('items.autocomplete') }}/?term={{ $data->item->item_name }}",
                                    }).then(function (data) {
                                        // create the option and append to Select2
                                        var option = new $.map(data, function (item) {
                                                return {
                                                    text: item.item_name + ' (' + item.item_code + ') ' + item.bal_kg + ' kg/bal',
                                                    id: item.id
                                                } 
                                            });
                                        console.log("option:" + option);
                                        studentSelect.append(option).trigger('change');

                                        // manually trigger the `select2:select` event
                                        studentSelect.trigger({
                                            type: 'select2:select',
                                            params: function (data) {
                                                return {
                                                    results: $.map(data, function (item) {
                                                        return {
                                                            text: item.item_name + ' (' + item.item_code + ') ' + item.bal_kg + ' kg/bal',
                                                            id: item.id
                                                        }
                                                    })
                                                };
                                            },
                                        });
                                    });
                                </script>
                            </div>
                            
                            <div class="col-md-2">
                                <label for="harga" class="form-label">Harga &amp; Qty</label>
                                    <input type="text" class="form-control" id="harga" name="harga" value="{{ $data->harga }}" >
                            </div>
                            <div class="col-md-4">
                                <label for="note" class="form-label">Catatan</label>
                                <input type="text" class="form-control" value="{{ $data->note; }}" id="note" name="note" max=200>
                            </div>
                            <div class="col-12 d-flex">
                                <div class="me-auto">
                                    <button name="action" value="save" class="saveButton btn btn-{{ $colorTheme }}" type="submit">Simpan</button>
                                </div>    
                            </div>
                        </form>

                </div>
            
            
        </div>
    </div>
</div>

<script type="text/javascript">    
    // $("#item_id").select2().select2("val", null);
    // $("#item_id").select2().select2("val", {{ $data->item_id }});
</script>

@endsection
