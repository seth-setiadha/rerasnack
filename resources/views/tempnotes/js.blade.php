
<script type="text/javascript">    

    $('#qty').focusout(function() {
        checkSisa();
    });

    $('#unit').change(function() {        
        checkSisa();    
    });

    $('#unit_price').focusout(function() {
        checkSisa();
    });

    function checkSisa() {
        var qty = parseInt($('#qty').val());
        var unit_price = parseInt($('#unit_price').val());                
                
        if( qty > 0 && unit_price > 0) {            
            sub_total = qty * unit_price;
            $('#sub_total').val( sub_total );
        }
    }    
    
    
</script>