<div id="{{ $opts_div_id }}" class="opts_class col-span-2"  {{ $opts_div_hidden }}>
    <!-- Form::select('NAME', ARRAY-OF-OPTIONS, SELECTED-OPTION, 
                    ['id'=>'ID', HIDDEN-ATTRIBUTE, 'class' => 'CLASS']) -->
    
    <!--opts_div_id, color_name, talla_name, estilo_name, $colors, $sizes, $styles, selected_option, option_select_id, option_select_hidden?, 
    amount_div_id, selected_amount, amount_select_id, amount_select_name, amount_select_hidden?, remove_btn_hidden?, divider_id-->
    <label>{{ $all_colors }}</label>
    {{ Form::select($color_name, 
                    $all_colors->pluck('option', 'id'), 
                    $color_selected, 
                    [
                        'id'=>$color_id, 
                        $color_hidden, 
                        'class' => 'form-input w-full m-1'
                    ]) }}

    {{ Form::select($talla_name,
                    $all_tallas->pluck('option', 'id'), 
                    $talla_selected, 
                    [
                        'id'=>$talla_id, 
                        $talla_hidden,
                        'class' => 'form-input w-full m-1'
                    ]) }}

    {{ Form::select($estilo_name,
                    $all_estilos->pluck('option', 'id'), 
                    $estilo_selected,
                    [
                    'id'=>$estilo_id, 
                    $estilo_hidden, 
                    'class' => 'form-input w-full m-1'
                    ]) }}
</div>
<div id="{{ $amount_div_id }}" class="amounts_class col-start-3 my-1 mx-5">
{{ Form::selectRange($amount_name, 1, 50, $amount_selected, 
                    ['id' => $amount_id, 
                    $amount_hidden,
                    'class' => 'opt_amount mr-1 form-input']) }}
{{ Form::button('X', ['id' => 'btn_remove_hid', 'class' => "btn_remove_options my-2 px-2 col-end-3 text-white bg-red-700 hover:bg-red-800 rounded", 
    $remove_btn_hidden, 'remove_counter' => $remove_counter]) }}
</div>
<hr id="{{ $divider_id }}" class="col-span-3 m-3 divider" {{ $divider_hidden }}>