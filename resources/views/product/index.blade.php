@extends('layouts.application')

@section('content')
  <h1>Productos Disponibles</h1>
  <hr>
  @can('create', App\Models\Product::class)
    <a href="products/create">Create a new product</a>
  @endcan

  @foreach($products as $key => $prod)
    <div>
      <img src="{{ asset($main_imgs[$key]) }}" style="width: 300px; height: 200px;"></img>
      <br>
      {{ link_to("products/$prod->id", $prod->name, $attributes = [], $secure = null) }}
      @can('create', App\Models\Product::class)
        <div>
          {{ Form::label('quantity', 'Disponible') }}
          {{ Form::number('quantity', "$prod->quantity", ['min' => '0']) }}
          {{ Form::label('price', 'Precio') }}
          {{ Form::number('price', "$prod->price", ['min' => '0']) }}
        </div>
      @endcan
    </div>
    <hr>
  @endforeach
  <br>
@endsection