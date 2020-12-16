$(function() {
    
    $(".quantity-modifier").on('click', function(){
        var orig_value = $(this).attr("id");

        if (orig_value != $(this).val()) {
            $(this).siblings('button').show();
        } else {
            $(this).siblings('button').hide();
        }
    });
    $(".save-quantity-changes").on('click', function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var sibling_quantity = $(this).siblings('input[name="quantity"]').val();
        var prod_id = $(this).siblings('input[name="prod_id"]').attr('id');

        $.ajax({
            url: "/update-quantity",
            type:'POST',
            data: {
                _token: CSRF_TOKEN, 
                new_quantity: sibling_quantity,
                id: prod_id
            },
            dataType: 'JSON',
            success: function(data){
                alert(data.message);
            }
        });
    });
    var cont = 0;
    $("#btn_add_options").on('click', function(){
        var selected_attributes = [];
        $('input[class="attributes form-checkbox"]').attr('disabled', true); //Avoid second guesses
        
        jQuery.each($('input[class="attributes form-checkbox"]:checked'), function(){
            selected_attributes.push($(this).siblings('#attribute_name').text());
        })
        for (var i = 0; i<selected_attributes.length; i++) {
            $("#"+selected_attributes[i]).clone().appendTo("#opts");
            $("#"+selected_attributes[i]).removeAttr("hidden");
            $("#"+selected_attributes[i]).attr("id", selected_attributes[i]+"_"+cont);
        }
        $("#number_hid").clone().appendTo("#amounts");
        $("#number_hid").removeAttr("hidden");
        $("#number_hid").attr("id", "number_"+cont);
        $("#btn_remove_hid").clone().appendTo("#amounts");
        $("#btn_remove_hid").removeAttr("hidden");
        $("#btn_remove_hid").attr("id", cont);
        cont++;
    });
    $(document).on('click',"button.btn_remove_options", function(){
        var btn_id = $(this).attr("id");
        
        $("#Color_"+btn_id).remove();
        $("#Talla_"+btn_id).remove();
        $("#Estilo_"+btn_id).remove();
        $("#number_"+btn_id).remove();
        $(this).remove();
    });
});