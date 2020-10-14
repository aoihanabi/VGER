@extends('layouts.application')

@section('content')
  <h2> Editar Producto </h2>
  @include('product._product_form', ['action' => 'products.update', 'method' => 'PUT'])
@endsection