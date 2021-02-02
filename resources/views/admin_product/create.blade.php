@extends('layouts.application')
<!--<link href="{{ asset('css/app.css') }}" rel="stylesheet">-->
@section('content')
  <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div>
        <h2 class="text-lg font-medium text-gray-900">Crear producto nuevo</h2>
        <p class="mt-1 text-sm text-gray-600">Agrega información del nuevo producto en inventario</p>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        {{ Form::open(['route' => 'admin.products.store', 'files' => true]) }}
          @include('admin_product._product')
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection