@extends('layouts.application')
<!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
@section('content')
  <h2>Create a Product</h2>
  {{ Form::open(['route' => 'products.store', 'files' => true]) }}
    @include('product._product')
  {{ Form::close() }}
  <!--@include('product._product_form', ['action' => 'products.store', 'method' => null])-->
@endsection