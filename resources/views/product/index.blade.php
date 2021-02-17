@extends('layouts.application')

@section('content')

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <div id="product_masthead" class="py-5 text-center bg-gray-200">
      <h1 class="m-5 text-xl"></h1>
      @include ('search-masthead')

      <h1 class="m-5 text-xl">Productos Disponibles</h1>
    </div>
    
    <div class="py-10 grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      @foreach($products as $key => $prod)
        <div class="border-solid border border-gray-300 rounded shadow-md">
          <div class="m-5">
            <a href="{{ route('products.show', ['product' => $prod->id]) }}">
              
              <img src="{{ asset($main_imgs[$key]) }}" style="width: 300px; height: 200px;"></img>
              
              <label class="hover:underline text-blue-700 text-lg">
                {{ $prod->name }}
              </label>
            </a>
            <!-- <product-list :product="{{ $prod }}"/> -->
          </div>
        </div>
      @endforeach
    </div>
  </div>
  
  
@endsection