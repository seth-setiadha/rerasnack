
<script type="text/javascript">
    
    $('#stock_id').select2({
        placeholder: 'Pilih barang',
        ajax: {
            url: "{{ route('stocks.autocomplete') }}",
            dataType: 'json',
            delay: 500,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {                                                        
                        return {
                            modal: parseFloat(item.modal),
                            sisa: parseInt(1000 * item.sisa),
                            balkg: parseInt(1000 * item.bal_kg),
                            text: item.item_name + ' ' + item.bal_kg + ' kg/bal. Masuk ' + item.tanggal + '. Sisa ' + item.sisa + ' kg',
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    })
    $('#stock_id').on('select2:select', function (e) {
        $('#stocksisa').val(e.params.data.sisa);
        $('#modal').val(e.params.data.modal);
        $('#balkg').val(e.params.data.balkg);
        checkSisa();
    });

    $('#qty').focusout(function() {
        checkSisa();
    });
    $('#unit').change(function() {        
        checkSisa();    
    });
    $('#stock_id').change(function() {
        checkSisa();
    });



    function checkSisa() {
        var qty = parseInt($('#qty').val());
        var stocksisa = parseInt($('#stocksisa').val());
        var unit = $('#unit option:selected').val();     
        var modal = parseFloat( $('#modal').val() );
        var balkg = parseFloat($('#balkg').val());
        var sisa = -1;         
        if(unit == 'bal') {
            unit = balkg;
        } else if(unit == '1kg') { 
            unit = 1000;
        } else {
            unit = unit.replace(/[^.\d]/g, '');
        }
        $('#qty_gr').val(unit);
        $('#sisa').val(''); 
        $('.saveButton').prop('disabled', true);

        if( qty > 0 && stocksisa > 0 && unit > 0) {
            sisa = stocksisa - (qty * unit);            
            $('#sisa').val(sisa);
            if(sisa < 0) {
                functionAlertPlaceholder('Penjualan ' + (qty * unit / 1000) + ' kg, melebihi stock sisa! Sisa ' + (stocksisa/1000) + ' kg', 'danger', 'idStocksisa');
            }
        } 
        
        if(sisa >= 0) {
            $('.saveButton').prop('disabled', false);
        }
         
    }    
    
    
</script>