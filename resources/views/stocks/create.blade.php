@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            
        
            <div class="d-flex align-items-center p-3 my-3 bg-warning p-2 text-dark bg-opacity-25 rounded shadow-sm">
                <div class="me-auto">
                    <h3 class="mb-0 lh-1">{{ __('Buat Stock Adjusment') }}</h3>
                </div>
                <div class="ms-auto">
                <a class="btn btn-warning" href="{{ route('stocks.adjustment') }}">{{ __('Stock Adjustment') }}</a>
                <a class="btn btn-warning" href="{{ route('stocks.index') }}">{{ __('kembali') }}</a>
                </div>
            </div>
            
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="p-3 my-3 bg-white p-2 text-dark bg-opacity-50 rounded shadow-sm">
                        
                        <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('stocks.store') }}">                        
                        @csrf
                        @method('POST')
                            <div class="col-md-2">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>                                
                            </div>
                            <div class="col-md-4">
                                <label for="stock_id" class="form-label">Stock Barang</label>
                                <input type="text" class="form-control" name="stock_id" id="stock_id" value="" required>                                
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
