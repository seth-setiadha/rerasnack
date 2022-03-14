
@csrf

<div class="col-md-2">
    <label for="item_code" class="form-label">Kode Barang</label>
    <input type="text" class="form-control" @if (! $create) readonly @endif name="item_code" id="item_code" value="{{ old('item_code') ?? $data->item_code }}" required>
</div>
<div class="col-md-4">
    <label for="item_name" class="form-label">Nama Barang</label>
    <input type="text" class="form-control" name="item_name" id="item_name" value="{{ old('item_name') ?? $data->item_name }}" required>                                
</div>

<div class="col-md-2">
    <label for="bal_kg" class="form-label">bal/kg</label>
    <div class="input-group">
        <input type="number" step="0.01" class="form-control" id="bal_kg" min="0.5" name="bal_kg" value="{{ old('bal_kg') ?? $data->bal_kg }}" required>
        <div class="input-group-text">kg</div>
    </div>
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