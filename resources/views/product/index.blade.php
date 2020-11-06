@extends('layouts.application')

@section('content')
  <div class="my-10 mx-20">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div id="product_masthead" class="py-5 text-center">
      <h1 class="m-5 text-xl">Productos Disponibles</h1>
    </div>
    
    @can('create', App\Models\Product::class)
      <a href="products/create">Crear nuevo producto</a>
      {{ link_to(route('categories.create'), $title = 'Crear nueva categoría') }}
      {{ link_to(route('options.create'), $title = 'Crear nueva característica') }}
    @endcan
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      @foreach($products as $key => $prod)
        <div class="border-solid border border-gray-300 rounded shadow-md">
          <div class="m-5">
            <img src="{{ asset($main_imgs[$key]) }}" style="width: 300px; height: 200px;"></img>
            {{ link_to("products/$prod->id", $prod->name, $attributes = ['class' => 'hover:underline text-blue-700 text-lg '], $secure = null) }}
            @can('create', App\Models\Product::class)
              <div class="prod_quantity_update py-2 grid grid-cols-2">
                {{ Form::label('quantity', 'Disponible', ['class' => 'col-span-1']) }}
                {{ Form::number('quantity', "$prod->quantity", ['class' => 'quantity-modifier py-1 border-solid border border-gray-500 rounded', 'id' => "$prod->quantity", 'min' => '0']) }}
                {{ Form::button('Guardar', ['class' => 'save-quantity-changes my-2 p-2 col-end-3 text-white bg-blue-700 hover:bg-blue-800 rounded', 'hidden']) }}
                {{ Form::hidden('prod_id', null, ['id' => "$prod->id"])}}
              </div>
            @endcan
            <product-list :product="{{ $prod }}"/>
          </div>
          
        </div>
      @endforeach
    </div>
  </div>
  
  
@endsection