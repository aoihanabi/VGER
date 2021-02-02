@extends('layouts.application')

@section('content')
  <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div>
        <h2 class="text-lg font-medium text-gray-900"> Editar producto </h2>
        <p class="mt-1 text-sm text-gray-600">Edita la información del producto</p>
      </div>
      
      <div class="mt-5 md:mt-0 md:col-span-2">
        {{ Form::model($product, ['route' => ['admin.products.update', $product], 'method' => 'PUT', 'files' => true]) }}
          @include('admin_product._product')
        {{ Form::close() }}
      </div>
    </div>
  </div>
  
  
@endsection