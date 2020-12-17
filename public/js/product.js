$(function() {
    // ********* Update product total quantity *********
    // in index.blade.php
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
    // ********* Add option dropdows dynamically *********
    // in _product.blade.php
    var cont = 0;
    $("#btn_add_options").on('click', function(){
        var selected_attributes = [];
        $('input[class="attributes form-checkbox"]').attr('onclick', 'return false'); //Avoid second guesses
        
        jQuery.each($('input[class="attributes form-checkbox"]:checked'), function(){
            selected_attributes.push($(this).siblings('#attribute_name').text());
        })
        for (var i = 0; i<selected_attributes.length; i++) {
            $("#"+selected_attributes[i]).clone().appendTo("#opts");
            $("#"+selected_attributes[i]).removeAttr("hidden");
            $("#"+selected_attributes[i]).attr("id", selected_attributes[i]+"_"+cont);
            $("#"+selected_attributes[i]+"_"+cont).attr("name", (selected_attributes[i].toLowerCase())+"["+cont+"]");
        }
        $("#number_hid").clone().appendTo("#amounts");
        $("#number_hid").removeAttr("hidden");
        $("#number_hid").attr("id", "number_"+cont);
        $("#number_"+cont).attr("name", "opt_amount["+cont+"]");

        $("#btn_remove_hid").clone().appendTo("#amounts");
        $("#btn_remove_hid").removeAttr("hidden");
        $("#btn_remove_hid").attr("id", cont);

        $("#contador").replaceWith("<input type='text' id='contador' name='contador' value="+cont+" hidden/>");
        get_total_amount();
        cont++;
    });
    $(document).on('click',"button.btn_remove_options", function(){
        var btn_id = $(this).attr("id");
        
        $("#Color_"+btn_id).remove();
        $("#Talla_"+btn_id).remove();
        $("#Estilo_"+btn_id).remove();
        $("#number_"+btn_id).remove();
        $(this).remove();
        get_total_amount();
        cont--;

        if(cont <=0){
            $('input[class="attributes form-checkbox"]').attr('onclick', 'return true'); //Avoid second guesses
        }
    });
    $(document).on('change', ".opt_amount", function() {
        get_total_amount();
    });
    function get_total_amount(){
        var addition = 0;
        $(".opt_amount").each(function() {
            addition += parseInt($(this).val());
            $("#quantity").val(addition-1);
        })
    }
});