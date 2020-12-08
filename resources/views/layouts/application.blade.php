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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
  </head>
  <body>
    @livewire('navigation-dropdown')
    <div id="app">
      

      <div  class="">
        @yield('content')        
      </div>
      
      <div id="navbarExampleTransparentExample" class="navbar-menu"> 
        <!-- <div class="navbar-end">
          <order-component />
        </div> -->
        <div class="rounded-full border-2 h-24 w-24 flex items-center justify-center">
          <order-counter />
        </div>
      </div>
    </div>
    
    @livewireScripts
  </body>
</html>