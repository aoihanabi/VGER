$(function() {
    
    $(".quantity-modifier").on('click', function(){
        var orig_quantity = $(this).attr("id");

        if (orig_quantity != $(this).val()) {
            $(this).siblings('button').show();
        }
    });
});