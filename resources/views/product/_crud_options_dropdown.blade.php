<!-- Called in _product partial view -->
<div id="opts" class="col-span-2">
  {{ Form::select('colors', $colors->pluck('option', 'id'), $options->color != null ? $options->color->id : null, 
                  ['id'=>'Color', $options != null ? '' : 'hidden', 'class' => 'form-input w-full m-1']) }}
  {{ Form::select('sizes', $sizes->pluck('option', 'id'), $options->talla != null ? $options->talla->id : null, 
                  ['id'=>'Talla', $options != null ? '' : 'hidden', 'class' => 'form-input w-full m-1']) }}
  {{ Form::select('styles', $styles->pluck('option', 'id'), $options->estilo != null ? $options->estilo->id : null,
                  ['id'=>'Estilo', $options != null ? '' : 'hidden', 'class' => 'form-input w-full m-1']) }}
</div>
<div id="amounts" class="col-start-3 grid items-center place-items-center">
  {{ Form::selectRange('', 1, 50, $prod_options_amount != null ? $prod_options_amount[$k] : '1', 
                      ['id' => 'number_hid', 'class' => 'opt_amount form-input', $prod_options_amount != null ? '' : 'hidden']) }}
  {{ Form::button('X', ['id' => 'btn_remove_hid', 'class' => "btn_remove_options my-2 px-2 col-end-3 text-white bg-red-700 hover:bg-red-800 rounded", $prod_options_amount != null ? '' : 'hidden']) }}
</div>
<input type='text' id='contador' name='contador' value='0' hidden />
<hr class="col-span-3 m-3">