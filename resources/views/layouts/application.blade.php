<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!--Scripts-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/product.js') }}" defer></script>
  </head>
  <body>
    <div id="app">
      <div class="relative bg-white flex flex-row border-solid border-b border-gray-300">
        <div class="p-5 justify-start"><p class="text-xl">Logo</p></div>
        <div class="p-5 justify-end flex flex-row flex-auto ">
          
          <div class="mx-2 text-gray-800"><a href="/">Home</a></div>
          <div class="mx-2 text-gray-800"><a href="{{ route('products.index') }}">Products</a></div>
          <div class="mx-2 text-gray-800"><a href="{{ route('login') }}">Login</a></div>
        </div>
      </div>

      <div  class="">
        @yield('content')        
      </div>
      <div id="navbarExampleTransparentExample" class="navbar-menu"> 
        <div class="navbar-end">
          <order-component />
        </div>
      </div>
    </div>
  </body>
</html>