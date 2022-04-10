
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

    $('#unit_price').focusout(function() {
        checkSisa();
    });

    function checkSisa() {
        var qty = parseInt($('#qty').val());
        var stocksisa = parseInt($('#stocksisa').val());
        var unit_price = parseInt($('#unit_price').val());
        var unit = $('#unit option:selected').val();     
        var modal = parseFloat( $('#modal').val() );
        var sub_total = parseInt( $('#sub_total').val() );
        var balkg = parseFloat($('#balkg').val());
        var sisa = -1;         
        var profit = -1;  
        if(unit == 'bal') {
            unit = balkg;
        } else if(unit == '1kg') { 
            unit = 1000;
        } else {
            unit = unit.replace(/[^.\d]/g, '');
        }
        $('#qty_gr').val(unit);
        // $('#sub_total').val(0);
        $('#sisa').val(''); 
        $('.saveButton').prop('disabled', true);

        // console.log('qty: ', qty);
        // console.log('qty_gr: ', qty_gr);
        // console.log('unit: ', unit);
        // console.log('stocksisa: ', stocksisa);
        if( qty > 0 && stocksisa > 0 && unit > 0) {
            sisa = stocksisa - (qty * unit);            
            $('#sisa').val(sisa);
            if(sisa < 0) {
                functionAlertPlaceholder('Penjualan ' + (qty * unit / 1000) + ' kg, melebihi stock sisa! Sisa ' + (stocksisa/1000) + ' kg', 'danger', 'idStocksisa');
            }
        }              
                
        if( qty > 0 && unit_price > 0) {            
            sub_total = qty * unit_price;
            $('#sub_total').val( sub_total );
        } else {
        }

        if( $("#profit").length > 0 && $("#modal").length > 0 ) {            
            console.log('modal: ', modal);
            if(sub_total > 0) {
                profit = (sub_total - (qty * unit * modal)).toFixed(0);
                if(profit == -0) {
                    profit = 0;
                }
                $("#profit").val(profit);
                // console.log('qty: ', qty);
                // console.log('unit: ', unit);
                // console.log('sub_total: ', sub_total);
                // console.log('profit: ', profit);
                if(profit >= 0) { } else {
                    functionAlertPlaceholder('Profit minus!', 'danger', 'idProfit');
                }
                
                // $('.saveButton').prop('disabled', false);
            }
        }

        if(sisa >= 0 && profit >= 0) {
            $('.saveButton').prop('disabled', false);
        }
    }    
    
    
</script>