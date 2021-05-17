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
        <div id="app" class="w-full h-screen bg-cover bg-fixed" style="background-image: url(images/page/masthead-bg.jpg);">
        
            @if($errors->any())
                @include('error-message')
            @endif
        
            @yield('content')    
            
            <!-- Show cart modal button -->
            <button  
                class="rounded-full bg-white border-2 h-24 w-24 flex items-center justify-center"
                @click="modal_showing = true"
            >
                <order-counter />
            </button>
            <div class="">
                <order-component :showing="modal_showing" @close="modal_showing = false"/>
            </div>


            <div class="rounded-full fixed right-6 bottom-6 z-10 inline-flex items-center justify-center p-2     h-16 w-16 bg-gray-800 shadow-md text-2xl text-white 
                        hover:bg-gray-600 hover:border-gray-300 
                        focus:outline-none focus:text-gray-700 focus:border-gray-300 
                        transition duration-150 ease-in-out" 
                    @click="modal_showing = true">
                <!-- <li class="font-sans block align-middle text-black hover:text-gray-700"> -->
                    <a role="button" class="relative flex">
                        <!-- <svg class="flex-1 w-8 h-8 fill-current" viewbox="0 0 24 24">
                            <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5.5C20.95,5.34 21,5.17 21,5A1,1 0 0,0 20,4H5.21L4.27,2M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                        </svg> -->
                        <i class="fas fa-shopping-cart flex-1 w-8 h-8 fill-current mt-2"></i>
                        <span class="absolute right-0 top-0 rounded-full bg-red-600 w-4 h-4 top right p-0 m-0 text-white font-mono text-sm  leading-tight text-center">
                            5
                        </span>
                    </a>
                <!-- </li> -->
            </div>

            <footer class="">
                @include ('shared.footer')
            </footer>
        </div>
    
        @livewireScripts
    </body>
</html>