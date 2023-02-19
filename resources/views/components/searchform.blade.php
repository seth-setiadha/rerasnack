<form class="row g-3 needs-validation" autocomplete="off" novalidate method="GET" action="{{ $url }}">  

    <!-- @if (isset($tglTransaksi))
    <div class="col-md-2 my-3 order-2">
        <input type="text" name="tanggal" class="form-control datepicker" value="{{ $tanggal }}" id="q" placeholder="Tgl. Transaksi">
    </div>
    @endif  -->
    <div class="ms-auto col-md-5 my-3 order-2">        
        <div class="input-group">
        @if (isset($tglTransaksi))
            <input type="text" name="tanggal" class="form-control datepicker" value="{{ $tanggal }}" id="q" placeholder="Tgl. Transaksi">
        @endif 
            <input type="text" name="q" class="form-control" value="{{ $q }}" id="q" placeholder="Keyword">
            
            <button type="submit" class="btn btn-{{ $color }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg>
        </button>
        </div>                            
    </div>
</form>