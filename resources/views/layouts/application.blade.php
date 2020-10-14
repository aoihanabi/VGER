<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!--Styles-->
    <!--Scripts-->
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="">Home</a></li>
        <li><a href="">Products</a></li>
        <li><a href="">Profile</a></li>
      </ul>
    </nav>
    <div>
      @yield('content')
    </div>
  </body>
</html>