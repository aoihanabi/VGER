<!-- Called in _product partial view -->
<div id="opts" class="col-span-2">
  @if ($options != null)
    {{ Form::select('color['.$k.']', $colors->pluck('option', 'id'), $options->color != null ? $options->color->id : null, 
                    ['id'=>'Color_'.$k, $options->color != null ? '' : 'hidden', 'class' => 'form-input w-full m-1']) }}
    {{ Form::select('talla['.$k.']', $sizes->pluck('option', 'id'), $options->talla != null ? $options->talla->id : null, 
                    ['id'=>'Talla_'.$k, $options->talla != null ? '' : 'hidden', 'class' => 'form-input w-full m-1']) }}
    {{ Form::select('estilo['.$k.']', $styles->pluck('option', 'id'), $options->estilo != null ? $options->estilo->id : null,
                  ['id'=>'Estilo_'.$k, $options->estilo != null ? '' : 'hidden', 'class' => 'form-input w-full m-1']) }}
  @else
    {{ Form::select('colors', $colors->pluck('option', 'id'), null, 
                    ['id'=>'Color', 'hidden', 'class' => 'form-input w-full m-1']) }}
    {{ Form::select('sizes', $sizes->pluck('option', 'id'), null, 
                    ['id'=>'Talla', 'hidden', 'class' => 'form-input w-full m-1']) }}
    {{ Form::select('styles', $styles->pluck('option', 'id'), null,
                  ['id'=>'Estilo', 'hidden', 'class' => 'form-input w-full m-1']) }}
  @endif
</div>
<div id="amounts" class="col-start-3 grid items-center place-items-center">
  {{ Form::selectRange('', 1, 50, $prod_options_amount != null ? $prod_options_amount[$k] : '1', 
                      ['id' => 'number_hid', 'class' => 'opt_amount form-input', $prod_options_amount != null ? '' : 'hidden']) }}
  {{ Form::button('X', ['id' => 'btn_remove_hid', 'class' => "btn_remove_options my-2 px-2 col-end-3 text-white bg-red-700 hover:bg-red-800 rounded", $prod_options_amount != null ? '' : 'hidden']) }}
</div>
<input type='text' id='contador' name='contador' value='0' hidden />
<hr class="col-span-3 m-3">