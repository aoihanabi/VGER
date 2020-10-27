@section('options_field')
  @foreach($attrs as $attr)    
    <div class="{{$attr->name}}-attributes">
      {{ Form::label("$attr->name") }}
      <br>
      @foreach ($options as $k => $opt)        
        @if ($attr->id == $opt->attribute_id)
          {{ Form::checkbox("opt_checks[$k]", "$opt->attribute_id,$opt->id", $prod_options==null ? '' : in_array($opt->id, $prod_options)) }}
          {{ Form::label("opt_checks[$k]","$opt->option") }}
        @endif
      @endforeach  
    </div>
  @endforeach
@endsection

<div>
    <div id="product_fields">
        {{ Form::text('name', null, ['placeholder' => 'Nombre del producto']) }}
        <br><br>
        {{ Form::textarea('description', null, ['placeholder' => 'Descripción del producto', 'rows' => 3]) }}
        <br><br>
        {{ Form::text('quantity', null, ['placeholder' => 'Cantidad disponible']) }}
        <br><br>
        {{ Form::text('price', null, ['placeholder' => 'Precio']) }}
        <br><br>
    </div>
    <div id="product_attributes">
        @if($product == null )
            @yield('options_field')
        @elseif(Auth::user()->role === 'admin')
            @yield('options_field')
        @endif
    
    </div>
    <div id="product_images">
        {{ Form::label("Main Image:") }}<br>
        {{ Form::file('main_image') }}
        <br><br>
        {{ Form::label("Secondary Images:") }} <br>
        {{ Form::file('sec_images[]', ['multiple' => 'multiple']) }}
    </div>
    <br><br>
    {{ Form::submit('Guardar cambios') }}
</div>