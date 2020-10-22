@extends('layouts.application')
<!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
@section('content')
  <h2>Create a Product</h2>
  @include('product._product_form', ['action' => 'products.store', 'method' => null])
@endsection