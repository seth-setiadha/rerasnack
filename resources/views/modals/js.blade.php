
<script type="text/javascript">
    $('.saveButton').prop('disabled', true);
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
                            modal: parseInt(item.modal),
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
        checkSubTotal();
    });
    $('#stock_id').change(function() {
        checkSisa();
    });

    function checkSisa() {
        var qty = parseInt($('#qty').val());
        var stocksisa = parseInt($('#stocksisa').val());
        var unit_price = parseInt($('#unit_price').val());
        var unit = $('#unit option:selected').val();


        $('#sisa').val('');
        if(unit == 'bal') {
            unit = parseInt($('#balkg').val());
        } else if(unit == '1kg') { 
            unit = 1000;
        } else {
            unit = unit.replace(/[^.\d]/g, '');
        }
        $('#qty_gr').val(unit);

        if( qty > 0 && stocksisa > 0 && unit > 0) {
            var sisa = stocksisa - (qty * unit);
            if(sisa >= 0) {
                $('#sisa').val(sisa);
                $('.saveButton').prop('disabled', false);
            } else {
                $('.saveButton').prop('disabled', true);
            }
        }
    }        
</script>