@extends('layouts.application')

@section('content')
  
  <h1>Productos Disponibles</h1>
  <hr>
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  @can('create', App\Models\Product::class)
    <a href="products/create">Create a new product</a>
  @endcan

  @foreach($products as $key => $prod)
    <div>
      <img src="{{ asset($main_imgs[$key]) }}" style="width: 300px; height: 200px;"></img>
      <br>
      {{ link_to("products/$prod->id", $prod->name, $attributes = [], $secure = null) }}
      @can('create', App\Models\Product::class)
        <div class="prod_quantity_update">
          {{ Form::label('quantity', 'Disponible') }}
          {{ Form::number('quantity', "$prod->quantity", ['class' => 'quantity-modifier', 'id' => "$prod->quantity", 'min' => '0']) }}
          {{ Form::button('Save', ['class' => 'save-quantity-changes', 'hidden']) }}
          {{ Form::hidden('prod_id', null, ['id' => "$prod->id"])}}
        </div>
      @endcan
    </div>
    <hr>
  @endforeach
  <br>
@endsection