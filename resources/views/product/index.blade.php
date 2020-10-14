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
      <a href="products/{{ $prod->id }}"><b>{{ $prod->name }}</b> <br></a>
    </div>
    <hr>
  @endforeach
  <br>
@endsection