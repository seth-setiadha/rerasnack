@extends('layouts.app')

@section('content')

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
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">{{ session('status') }}</div>
                @endif
                @error('tanggal') 
                    <div class="alert alert-success" role="alert">{{ $message }}</div>
                @enderror
                
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
                                <input type="text" class="form-control" name="item_id" id="item_id" value="" required>
                                <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
                                </script>
                                <script type="text/javascript">
                                    var route = "{{ route('items.autocomplete') }}";
                                    $('#item_id').typeahead({
                                        source: function (query, process) {
                                            return $.get(route, {
                                                query: query
                                            }, function (data) {
                                                return process(data);
                                            });
                                        }
                                    });
                                </script>
                            </div>
                            @elseif ($stock == "OUT")
                            <div class="col-md-4">
                                <label for="stock_id" class="form-label">Stock Barang</label>
                                <input type="text" class="form-control" name="stock_id" id="stock_id" value="" required>
                                
                                <!-- <div class="valid-feedback">Looks good!</div> -->
                            </div>
                            @endif
                            
                            <div class="col-md-1">
                                <label for="qty" class="form-label">Qty</label>
                                <!-- <div class="input-group has-validation">                                 -->
                                    <input type="text" class="form-control" id="qty" name="qty" required>
                                    <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                                    <!-- <div class="invalid-feedback">Please choose a username.</div> -->
                                <!-- </div> -->
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

<script language="">
    // Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()

</script>

@endsection
