@extends('layouts.application')

@section('content')
  <h2> Editar Producto </h2>
  {{ Form::model($product, ['route' => ['products.update', $product], 'method' => 'PUT', 'files' => true]) }}
    <!--@include('product._product_form', ['action' => 'products.update', 'method' => 'PUT'])-->
    @include('product._product')
  {{ Form::close() }}
@endsection