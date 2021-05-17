$(function() {
    // ********* Update product total quantity *********
    // in index.blade.php
    // $(".quantity-modifier").on('click', function(){
    //     var orig_value = $(this).attr("id");

    //     if (orig_value != $(this).val()) {
    //         $(this).siblings('button').show();
    //     } else {
    //         $(this).siblings('button').hide();
    //     }
    // });
    // $(".save-quantity-changes").on('click', function(){
    //     var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    //     var sibling_quantity = $(this).siblings('input[name="quantity"]').val();
    //     var prod_id = $(this).siblings('input[name="prod_id"]').attr('id');

    //     $.ajax({
    //         url: "/update-quantity",
    //         type:'POST',
    //         data: {
    //             _token: CSRF_TOKEN, 
    //             new_quantity: sibling_quantity,
    //             id: prod_id
    //         },
    //         dataType: 'JSON',
    //         success: function(data){
    //             alert(data.message);
    //         }
    //     });
    // });

    // ******************************* Add option dropdows dynamically *************************************
    // in _product.blade.php for product CREATE & EDIT
    var cont = $("#contador").val();//0;
    $("#btn_add_options").on('click', function(){

        var selected_attributes = [];
        
        jQuery.each($('input[class="attributes form-checkbox"]:checked'), function() {
            selected_attributes.push($(this).siblings('#attribute_name').text());
        })

        if(selected_attributes.length > 0) {
            //When editing an existing product options, add/remove/change to the old dropdonws
            manage_existing_dropdowns(selected_attributes);
            //-----------------------------------------------

            //Duplicate and rename #opts element and its childs
            $("#opts").clone().appendTo("#option_dropdowns");
            $("#opts").attr("id", cont);
            $("#" + cont).removeAttr("hidden");
            for (var i = 0; i<selected_attributes.length; i++) {
                $("#"+cont).children("#"+selected_attributes[i]).attr("id", selected_attributes[i]+"_"+cont);
                $("#"+selected_attributes[i]+"_"+cont).removeAttr("hidden");
                $("#"+selected_attributes[i]+"_"+cont).attr("name", (selected_attributes[i].toLowerCase())+"["+cont+"]");
            }

            //Duplicate and rename #amounts elem and its childs
            $("#amounts").clone().appendTo("#option_dropdowns");
            $("#amounts").attr("id", "amounts_"+cont);
            $("#amounts_"+cont).removeAttr("hidden");

            $("#amounts_"+cont).children("#number_hid").attr("id", "number_"+cont); // option amount dropdown 
            $("#number_"+cont).removeAttr("hidden");
            $("#number_"+cont).attr("name", "opt_amount["+cont+"]");

            $("#amounts_"+cont).children("#btn_remove_hid").attr("remove_counter", cont); //remove option button
            $("#amounts_"+cont).children("#btn_remove_hid").removeAttr("hidden");

            $("#divider").clone().appendTo("#option_dropdowns"); //divider
            $("#divider").attr("id", "divider_"+cont);
            $("#divider_"+cont).removeAttr("hidden");

            $("#contador").replaceWith("<input type='text' id='contador' name='contador' value="+cont+" hidden/>");
            calc_product_amount();
            cont++;
        } else {
            alert("Seleccione al menos un atributo a agregar");
        }
    });

    //REMOVE PRODUCT OPTION
    $(document).on('click',"button.btn_remove_options", function() {
        var elem_count = $(this).attr("remove_counter");
        
        $("#"+elem_count).remove();
        $("#amounts_"+elem_count).remove();
        $("#divider_"+elem_count).remove();
        calc_product_amount();
        
        rename_dropdown_elements(cont)
        cont--;
    });
    //SUM OF TOTAL PRODUCT'S QUANTITY
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

    //Add or remove dropdowns to existing .opt_class div elements according to the attribute checkbox selected
    function manage_existing_dropdowns(selected_attributes){
        jQuery.each($(".opts_class:visible"), function() {
            
            var total_dropdowns = $(this).children('select:visible').length;
            var opts_id = $(this).attr('id');

            if (total_dropdowns != 0) {
                //Check if total visible dropdowns correspond to the total attributes selected, to either add needed dropdowns or hide them
                if(total_dropdowns < selected_attributes.length) {
                    
                    var hidden_select = $(this).children('select:hidden');
                    jQuery.each(hidden_select, function(){
                        
                        var hidden_select_id = $(this).attr('id');
                        var simpler_name = hidden_select_id != undefined ? hidden_select_id.slice(0, -2) : '';//remove index in the name of existing selects
                        
                        //when it's CREATE form
                        //if select id IS in selected_attributes array
                        console.log(hidden_select_id + " - " +selected_attributes);
                        if (jQuery.inArray(hidden_select_id, selected_attributes) !== -1) {
                            var temp_id = $(this).attr('id');
                            var temp_name = $(this).attr('name');
                            
                            $(this).attr("id", temp_id+"_"+opts_id);
                            $(this).attr("name", temp_name+"["+opts_id+"]");
                            $(this).removeAttr("hidden");
                            //duplicar num_hid
                        }
                        //when it's EDIT form
                        //if select IS in selected_attributes array
                        else if(jQuery.inArray(simpler_name, selected_attributes) !== -1){ 
                            
                            var temp_id = ($(this).attr('id')).slice(0,-2);
                            $(this).attr("name", (temp_id.toLowerCase())+"["+opts_id+"]");
                            $(this).removeAttr("hidden");
                        }
                    })
                }
                if (total_dropdowns > selected_attributes.length) {
                    var visible_select = $(this).children('select:visible');
                    jQuery.each(visible_select, function(){
                        
                        var visible_select_id = $(this).attr('id');
                        var simpler_name = visible_select_id != undefined ? visible_select_id.slice(0, -2) : '';
                        
                        // console.log(visible_select_id + "  " + selected_attributes);
                        // console.log(simpler_name + "  " + selected_attributes);
                        
                        //if select id IS NOT in selected_attributes, hide it
                        if(jQuery.inArray(simpler_name, selected_attributes) === -1){ //for edit
                            $(this).attr("name", ""); //erase its name to avoid the controller catching it
                            $(this).attr("hidden", true);
                        }
                    })
                }
                //Check if the dropdowns showing are according to the attributes selected
                if(total_dropdowns == selected_attributes.length) {
                    var vis_select = $(this).children('select');
                    
                    jQuery.each(vis_select, function(){
                        //console.log($(this).attr("id"));
                        var vis_select_id = $(this).attr('id');
                        var simpler_name = vis_select_id != undefined ? vis_select_id.slice(0, -2) : '';

                        //console.log(simpler_name +" in "+ selected_attributes);
                        if(jQuery.inArray(simpler_name, selected_attributes) === -1){
                            console.log("hide "+vis_select_id);
                            //alert("1"+simpler_name + " is not in " + selected_attributes)
                            $(this).attr("name", "");
                            $(this).attr("hidden", true);
                        }
                         console.log(vis_select_id + " " + selected_attributes);
                         console.log((jQuery.inArray(vis_select_id, selected_attributes) !== -1));
                        // console.log(($(this).attr("hidden") == "hidden"));
                        
                        if((jQuery.inArray(vis_select_id, selected_attributes) !== -1)){
                            //alert("2"+vis_select_id + " is in " + selected_attributes)
                            if($(this).attr("hidden") == "hidden"){
                                var temp_id = $(this).attr('id');
                                //var temp_name = $(this).attr('name');

                                $(this).attr("id", temp_id+"_"+opts_id);
                                $(this).attr("name", (temp_id.toLowerCase())+"["+opts_id+"]");
                                // $(this).attr("id", temp_id+"_"+cont);
                                // $(this).attr("name", temp_name+"["+cont+"]");
                                $(this).removeAttr("hidden");
                                //console.log($(this).attr("id") +" make visible");
                            }
                        }
                        // alert(simpler_name+"? in "+selected_attributes);
                        // console.log((jQuery.inArray(simpler_name, selected_attributes) !== -1));
                        if((jQuery.inArray(simpler_name, selected_attributes) !== -1)){
                            //alert("3"+simpler_name + " is in " + selected_attributes)
                            if($(this).attr("hidden") == "hidden"){
                                var temp_id = ($(this).attr('id')).slice(0,-2);;
                                $(this).attr("name", (temp_id.toLowerCase())+"["+opts_id+"]");
                                $(this).removeAttr("hidden");
                            }
                        }
                    })
                }
                
            }

        })
    }

    // Re calcula y asigna los indices en orden incremental para los
    // dropdown que contienen las opciones. 
    //(Para que puedan ser captados sin problemas por el controlador)
    function rename_dropdown_elements(cont) {
       
        var new_count = 0;
        //For each div .opts_class
        jQuery.each($(".opts_class:visible"), function() {
            $(this).attr("id", new_count);
            var visible_select = $(this).children('select:visible');

            //For each select inside that div
            jQuery.each(visible_select, function() {
                
                var select_id = $(this).attr("id");
                var select_name = $(this).attr("name");
                
                if(new_count < cont) {
                    var temp_id = select_id.slice(0,-1);
                    $(this).attr("id", temp_id + new_count);
                    
                    var temp_name = select_name.slice(0,-2);
                    $(this).attr("name", temp_name + new_count+"]");
                }
            });
            new_count++;
        })

        new_count = 0;
        //For each div .amounts_class
        jQuery.each($(".amounts_class:visible"), function() {
            $(this).attr("id", "amounts_"+new_count);     
            $(this).children("#btn_remove_hid").attr("remove_counter", new_count);

            var number_select = $(this).children('select');
            //For each select inside that div
            jQuery.each(number_select, function() {
                
                //opt_amount
                if(new_count < cont) {
                    //var temp_id = select_id.slice(0,-1);
                    $(this).attr("id", "number_" + new_count);
                    
                    //var temp_name = select_name.slice(0,-2);
                    $(this).attr("name", "opt_amount["+new_count+"]");
                    
                }
            });
            new_count++;
        })

        new_count = 0;
        jQuery.each($(".divider:visible"), function(){
            $(this).attr("id", "divider_"+new_count);
            new_count++;
        })
    }

    function test(val) {
        $("#option_dropdowns").append('<input type="text" value='+val+'>');
    }

    // ***************************** Dynamic product options restriction *******************************
    // in _options_dropdown.blade.php for product SHOW when a user is making an order
    $(document).on('change', ".buy_dropdown", function() {
        
        if ($(this).children("option:selected").val() == "none" ){
            reset_dropdowns();
        } else {
            //Resetear todas las opciones deshabilitadas
            jQuery.each($(this).children("option"), function() {
                $(this).attr("disabled", false);
            });

            var product_options = parse_options_json(); //JSON with all options (related with each other especifically) available for the product
            var selected_ids = get_selected_options();
            //console.log(selected_ids);
            var similar_details_found = [];
            
            for(var i = 0; i< product_options.length; i++) {
                var comparison_ids = [];
                
                //Recorrer los detalles del producto (colores, tallas, etc)
                for (var details in product_options[i].options_ids) {
                    
                    //Crear un array con los id de cada opcion para compararlos con las opciones que hayan sido seleccionadas
                    if(product_options[i].options_ids[details] != null) {
                        comparison_ids.push(product_options[i].options_ids[details].id);
                    }
                }
                // Check if selected options ids are similar/compatible with the the comparison options array
                if(is_similar(selected_ids, comparison_ids)) {
                    similar_details_found.push(product_options[i]);
                }
            }
            console.log(similar_details_found);
            
            if(similar_details_found.length <= 0) 
            {
                alert("Las características especificadas no están disponibles");
                reset_dropdowns();
            } else {
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
                                if($(this).val() != "none") {
                                    $(this).attr("disabled", true);
                                }
                            }

                            //Evitar que se mantengan seleccionadas opciones desabilitadas
                            // if($(this).is(':selected')){
                            //     if($(this).attr('disabled') == 'disabled') {
                            //         $(this).prop("selected", false);
                            //     }
                            // } 
                            // else {
                            //     if($(this).attr('disabled') != 'disabled') {
                            //         $(this).prop("selected", true);
                            //     }
                            // }
                    
                    });
                });
            }
        }
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
    //Comparar cada id seleccionado con el correspondiente en los id para comparar y 
    //retornar true si la combinacion de esas opciones existe.
    function is_similar(selectedIDS, comparisonIDS) {
        for (var i in comparisonIDS) { 
            if(selectedIDS[i] != "none") {
                //si no coinciden
                if(comparisonIDS[i] !== selectedIDS[i]) {
                    return false;
                }
            }
        }
        return true;
    }

    function get_selected_options() {
        var dropdowns = $('select');
        ids = [];
        jQuery.each(dropdowns, function(){
            
            var val = $(this).children("option:selected").val();
            ids.push(val)
            
        });
        return ids;
    }

    function reset_dropdowns() {
        var dropdowns = $('select');
        jQuery.each(dropdowns, function(){
            
            jQuery.each($(this).children("option"), function() {
                $(this).attr("disabled", false);
                
                if($(this).val() == "none") {
                    $(this).prop("selected", true);
                }   
            });
        });
    }

    // ******************* Decrement/Increment number input in product show page **********************
    function decrement(e) {
        const btn = e.target.parentNode.parentElement.querySelector(
          'button[data-action="decrement"]'
        );
        const target = btn.nextElementSibling;
        let value = Number(target.value);
        value--;
        target.value = value;
      }
    
    function increment(e) {
    const btn = e.target.parentNode.parentElement.querySelector(
        'button[data-action="decrement"]'
    );
    const target = btn.nextElementSibling;
    let value = Number(target.value);
    value++;
    target.value = value;
    }

    const decrementButtons = document.querySelectorAll(
    `button[data-action="decrement"]`
    );

    const incrementButtons = document.querySelectorAll(
    `button[data-action="increment"]`
    );

    decrementButtons.forEach(btn => {
        btn.addEventListener("click", decrement);
    });

    incrementButtons.forEach(btn => {
        btn.addEventListener("click", increment);
    });

    // ******************* Range Slider functionality for prices search **********************
    $( function() {
        var formatter = new Intl.NumberFormat(undefined, {
            style: 'currency',
            currency: 'CRC',
            // These options are needed to round to whole numbers if that's what you want.
            minimumFractionDigits: 0, // (this suffices for whole numbers, but will print 2500.10 as $2,500.1)
            maximumFractionDigits: 0, // (causes 2500.99 to be printed as $2,501)
        });

        var hiddenMin = parseInt($("#hidden_min_price").text());
        var hiddenMax = parseInt($("#hidden_max_price").text());

        $( "#slider-range" ).slider({
            range: true,
            min: hiddenMin,
            max: hiddenMax,
            values: [ hiddenMin, hiddenMax ],
            step: 100,
            slide: function( event, ui ) {
                $( "#min_price_search" ).val( formatter.format(ui.values[ 0 ]) );
                $( "#max_price_search" ).val( formatter.format(ui.values[ 1 ]) );
            }
        });
        // $( "#price_search" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
        //     " - $" + $( "#slider-range" ).slider( "values", 1 ) );
    });

    
    // ******************* Confirm box for image deletion **********************
    var imgsToDelete = [];
    $(".deletable_image").on('click', function() {
        var deletable_image = $(this).children('img');
        var img_type = $(this).attr('data-image-type');
        
        $( "#dialog-confirm" ).dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Si": function() {
                    
                    if (img_type === 'MN') {
                        deletable_image.parent("div").remove();
                        $('#main_image_present').attr('value', "");
                        
                    } else if (img_type === 'SC') {
                        var imgToDelete_id = deletable_image.attr('id').slice(4);
                        imgsToDelete.push(imgToDelete_id); 
                        
                        $("#sec_images_to_delete").attr('value', imgsToDelete.toString());
                        deletable_image.parent("div").remove();
                    }
                    
                    $( this ).dialog( "close" );
                },
                "No": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
    // ******************* Button to fire order status changes **********************
    
    var order_current_status = ($('#order_status_changer').attr("data-status") == 'true');
    style_order_status(order_current_status);
    
    $('#order_status_changer').on('click', function() {
        
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var current_status = ($(this).attr("data-status") == 'true');
        var id = $(this).attr("order-id");
        
        current_status = !current_status;
        
        jQuery.post("status-update", 
        {
            _token: CSRF_TOKEN,
            new_status: current_status,
            order_id: id
        })
            .done(function(data) {
                alert(data.message);
            })
            .fail(function(data, XMLHttpRequest, textStatus, errorThrown) {
                alert(data.message + "\n" + errorThrown);
            });
        style_order_status(current_status);
    });

    function style_order_status( status ) {
        if(status) {
            $('#order_status_changer').attr('class', 'bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded');
            $('#order_status_changer').text('Completado');
        } else {
            $('#order_status_changer').attr('class', 'bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded');
            $('#order_status_changer').text('En Proceso');
        }
        $('#order_status_changer').attr("data-status", status)
    }
});