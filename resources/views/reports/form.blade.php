<?php
 
$from
?>
<div class="col-sm-2">
    <select class="form-select" id="laporan" name="laporan" required>
        <option value="modal" @if ($laporan == 'modal') {{ 'selected' }} @endif>Modal</option>
        <option value="penjualan" @if ($laporan == 'penjualan') {{ 'selected' }} @endif>Penjualan</option>
        <option value="modallain" @if ($laporan == 'modallain') {{ 'selected' }} @endif>Modal Lain</option>
        <option value="detail" @if ($laporan == 'detail') {{ 'selected' }} @endif>Detail</option>
        <option value="summary" @if ($laporan == 'summary') {{ 'selected' }} @endif>Summary</option>
    </select>
</div>
<div class="col-sm-1 text-nowrap align-middle pt-2">
    Dari
</div>
<div class="col-sm-2 mt-0 mt-sm-3">
    <input class="form-control" type="text" id="from" value="{{ $from }}" name="from" required>                           
</div>
<div class="col-sm-1 text-start text-sm-center pt-2">
    s/d
</div>
<div class="col-sm-2 mt-0 mt-sm-3">
    <input class="form-control" type="text" id="to" value="{{ $to }}" name="to" required>
</div>
<div class="col-sm">
    <button name="action" value="show" class="btn btn-{{ $colorTheme }}" type="submit">Lihat</button> &nbsp;
    <button name="action" value="download" class="btn my-md-0 my-sm-2 btn-{{ $colorTheme }}" type="submit">Download</button>
</div>