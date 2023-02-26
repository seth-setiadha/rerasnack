
@csrf

<div class="col-md-2">
    <label for="name" class="form-label">Nama</label>
    <input type="text" class="form-control" name="name" id="name" value="{{ old('name') ?? $data->name }}" required>
</div>
<div class="col-md-4">
    <label for="email" class="form-label">Email</label>
    <input type="text" class="form-control" name="email" id="email" value="{{ old('email') ?? $data->email }}" required>                    
</div>
<div class="col-md-2">
    <label for="password" class="form-label">Password</label>    
    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') ?? '' }}" @if ($create) required @endif>
</div>
<div class="col-md-2">
    <label for="password_confirmation" class="form-label">Confirm Password</label>    
    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') ?? '' }}" @if ($create) required @endif>
</div>

<div class="col-12 d-flex">
    <div class="me-auto">
        <button name="action" value="save" class="btn btn-secondary" type="submit">Simpan</button>
    </div>    
    @if ($create)
    <div class="ms-auto">
        <button name="action" value="saveplus" class="btn btn-dark" type="submit">Simpan &amp; Tambah Lagi</button>
    </div>
    @else
    <div class="ms-auto px-3 fst-italic text-danger text-end">
        *tidak perlu mengisikan password jika tidak ingin mengubah password.
    </div>
    @endif
</div>