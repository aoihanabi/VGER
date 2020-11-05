<div id="option_fields">
    {{ Form::text('option', null, ['placeholder' => 'Característica']) }}
    {{ Form::select('attribute_id', $attributes, $option != null ? $option->attribute_id : '1') }}
    {{ Form::submit('Guardar') }}
</div>