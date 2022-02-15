<?php
 
$from
?>
<div class="col-sm-1 text-nowrap align-middle">
    Dari
</div>
<div class="col-sm mt-0 mt-sm-3">
    <select class="form-control" id="from" name="from">
        <option value="2022-02-01">Feb 2022</option>
        <option value="2022-01-01">Jan 2022</option>
        <option value="2021-12-01">Dec 2021</option>
        <option value="2021-11-01">Nov 2021</option>
        <option value="2021-10-01">Oct 2021</option>
    </select>                             
</div>
<div class="col-sm-1 text-start text-sm-center">
    s/d
</div>
<div class="col-sm mt-0 mt-sm-3">
    <select class="form-control" id="to" name="to">
        <option value="2022-02-31">Feb 2022</option>
        <option value="2022-01-31">Jan 2022</option>
        <option value="2021-12-31">Dec 2021</option>
        <option value="2021-11-31">Nov 2021</option>
        <option value="2021-10-31">Oct 2021</option>
    </select>                             
</div>
<div class="col-sm">
    <button name="action" value="show" class="btn btn-{{ $colorTheme }}" type="submit">Lihat</button> &nbsp;
    <button name="action" value="download" class="btn my-md-0 my-sm-2 btn-{{ $colorTheme }}" type="submit">Download</button>
</div>