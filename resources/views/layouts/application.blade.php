<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--Scripts-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/product.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.0/dist/alpine.js" defer></script>
  </head>
  <body class="relative">
    @livewire('navigation-dropdown')
    <div id="app">
      

      <div  class="">
        @if($errors->any())
          @include('error-message')
        @endif
        
        @yield('content')        
      </div>
      
      <div class=""> 
        
        <!-- Show cart modal button -->
        <button  
          class="rounded-full border-2 h-24 w-24 flex items-center justify-center"
          @click="modal_showing = true"
        >
          <order-counter />
        </button>

        <div class="">
          <order-component :showing="modal_showing" @close="modal_showing = false"/>
        </div>
        
      </div>
    </div>
    
    @livewireScripts
  </body>
</html>