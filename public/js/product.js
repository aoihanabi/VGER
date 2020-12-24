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
    // in _product.blade.php for product CREATE & EDIT
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
        calc_product_amount();
        cont++;
    });
    $(document).on('click',"button.btn_remove_options", function(){
        var btn_id = $(this).attr("id");
        
        $("#Color_"+btn_id).remove();
        $("#Talla_"+btn_id).remove();
        $("#Estilo_"+btn_id).remove();
        $("#number_"+btn_id).remove();
        $(this).remove();
        calc_product_amount();
        cont--;

        if(cont <=0){
            $('input[class="attributes form-checkbox"]').attr('onclick', 'return true'); //Avoid second guesses
        }
    });
    $(document).on('change', ".opt_amount", function() {
        calc_product_amount();
    });
    function calc_product_amount(){
        var addition = 0;
        $(".opt_amount").each(function() {
            addition += parseInt($(this).val());
            $("#quantity").val(addition-1);
        })
    }

    // ********* Dynamic product options restriction *********
    // in _options_dropdown.blade.php for product SHOW
    $(document).on('change', ".buy_dropdown", function() {
        
        var selected_id = $(this).children("option:selected").val();
        var product_options = parse_options_json(); //JSON with all options (related with each other especifically) available for the product
        var similar_details_found = [];
        
        for(var i = 0; i< product_options.length; i++) {
            
            //Recorrer los detalles del producto (colores, tallas, etc)
            for (var details in product_options[i].options_ids) {
                
                //Tomar cada id de las opciones (que no estén null)
                var comparison_id = "";
                if(product_options[i].options_ids[details] != null) {
                    comparison_id = product_options[i].options_ids[details].id;
                }

                //Comparar el id seleccionado por el usuario con el resto de ids de opcion.
                //Y añadir a un array los detalles que incluyan la opcion seleccionada
                if(selected_id == comparison_id) {
                    similar_details_found.push(product_options[i]);
                }
            }
        }

        //Resetear todas las opciones deshabilitadas
        jQuery.each($(this).children("option"), function() {
            $(this).attr("disabled", false);
        });
        
        //Recorrer los selects que sean sibling de este (onchange)
        var sibling_dropdowns = $(this).siblings('select');
        jQuery.each(sibling_dropdowns, function(){
            
            jQuery.each($(this).children("option"), function(){
                                
                $(this).attr("disabled", false); //resetear opciones deshabilitas
                var available_optionIds = [];
                for (var index in similar_details_found) {
                    var found_amount = similar_details_found[index].amount;
                    var found_options = similar_details_found[index].options_ids;
                    
                    //Recorrer las opciones para chequear si están disponibles Get options ids to disable?
                    for (var type in found_options) {
                        
                        if(found_options[type] != null) {
                            //Chequear si la opcion por la que va tiene la cantidad en 0 para deshabilitarla
                            if(found_options[type].id == $(this).val() && found_amount == 0) {
                                $(this).attr("disabled", true);
                            } else 
                            //Chequear si la opción NO está en el array para agregarla
                            if((jQuery.inArray(found_options[type].id, available_optionIds)) === -1) {
                                available_optionIds.push(found_options[type].id);
                            }
                        }
                    }
                }

                //Si la opción NO está en el array de ids disponibles
                if((jQuery.inArray($(this).val(), available_optionIds)) === -1) {
                    
                    $(this).attr("disabled", true);
                }

                //Evitar que se mantengan seleccionadas opciones desabilitadas
                if($(this).is(':selected')){
                    if($(this).attr('disabled') == 'disabled') {
                        $(this).prop("selected", false);
                    }
                } 
                // else {
                //     if($(this).attr('disabled') != 'disabled') {
                //         $(this).prop("selected", true);
                //     }
                // }
                
            });
        });
    });

    function parse_options_json() {
        let div = document.getElementById("options_json");
        let options_json = div.getAttribute('data-product-options');

        options_json = JSON.parse(options_json);
        for(var i = 0; i < options_json.length; i++) {
            options_json[i].options_ids = JSON.parse(options_json[i].options_ids);
        }
        return options_json;
    }
});