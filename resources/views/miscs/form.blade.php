
@csrf
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="col-md-2">
    <label for="tanggal" class="form-label">Tanggal</label>
    <input type="text" class="form-control datepicker" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
    <div class="valid-feedback">Looks good!</div>
</div>
<div class="col-md-4">
    <label for="misc_name" class="form-label">Nama Modal</label>
    <input type="text" class="form-control" name="misc_name" id="misc_name" value="{{ old('misc_name') ?? $data->misc_name }}" required>                                
</div>
<div class="col-md-2">
    <label for="qty" class="form-label">Qty</label>
    <input type="number" class="form-control" name="qty" id="qty" min="1" value="{{ old('qty') ?? $data->qty }}" required>
</div>
<div class="col-md-2">
    <label for="unit_price" class="form-label">Harga Satuan</label>
    <input type="number" class="form-control" name="unit_price" id="unit_price" value="{{ old('unit_price') ?? $data->unit_price }}" required>
</div>
<div class="col-md-2">
    <label for="sub_total" class="form-label">Sub Total</label>
    <input type="text" class="form-control" readonly name="sub_total" id="sub_total" value="{{ old('sub_total') ?? $data->sub_total }}" required>
</div>

<div class="col-12 d-flex">
    <div class="me-auto">
        <button name="action" value="save" class="btn btn-info" type="submit">Simpan</button>
    </div>    
    @if ($create)
    <div class="ms-auto">
        <button name="action" value="saveplus" class="btn btn-dark" type="submit">Simpan &amp; Tambah Lagi</button>
    </div>
    @endif
</div>

<script type="text/javascript">    
    function checkSubTotal() {
        $('#sub_total').val(0);
        var qty = parseInt($('#qty').val());
        var unit_price = parseInt($('#unit_price').val());

        if( qty > 0 && unit_price > 0) {
            $('#sub_total').val( qty * unit_price );
        } else {
            console.log('masuk else');
        }
    } 
    $('#qty').focusout(function() {
        checkSubTotal();
    });
    $('#unit_price').focusout(function() {
        checkSubTotal();
    });

       
</script>