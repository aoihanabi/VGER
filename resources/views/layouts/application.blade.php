<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--Styles-->
    
    <!--Scripts-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/product.js') }}" defer></script>
  </head>
  <body>
    <div id="app">
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="{{ route('products.index') }}">Products</a></li>
          <li><a href="">Profile</a></li>
        </ul>
      </nav>

      <div id="navbarExampleTransparentExample" class="navbar-menu"> 
        <div class="navbar-end">
          <order-component />
        </div>
      </div>

      <div>
        @yield('content')
        <product-list />
      </div>
    </div>
  </body>
</html>