
@csrf
<div class="col-md-2">
    <label for="item_code" class="form-label">Kode Barang</label>
    <input type="text" class="form-control" name="item_code" id="item_code" value="{{ old('item_code') ?? $data->item_code }}" required>                                
</div>
<div class="col-md-4">
    <label for="item_name" class="form-label">Nama Barang</label>
    <input type="text" class="form-control" name="item_name" id="item_name" value="{{ old('item_name') ?? $data->item_name }}" required>                                
</div>

<div class="col-md-1">
    <label for="bal_kg" class="form-label">bal/kg</label>
        <input type="text" class="form-control" id="bal_kg" name="bal_kg" value="{{ old('bal_kg') ?? $data->bal_kg }}" required>
</div>

<div class="col-12">
    <button class="btn btn-primary" type="submit">Submit form</button>
</div>