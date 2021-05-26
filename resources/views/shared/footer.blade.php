<div id="footer" class=""> 
    <div class="relative w-full h-36 bg-gray-700">
        <a href="#">
            <!-- Up Arrow -->
            <div class="-mt-5 right-3 absolute rounded-full h-16 w-16 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-caret-up text-gray-800 text-4xl"></i>
            </div>
        </a>
        <div class="grid grid-cols-2 items-center h-full px-2 md:px-8">
            <!-- Nav-links -->
            <div class="my-3 col-start-1 col-span-2 text-sm md:text-base text-white font-title 
                        flex md:space-x-4 flex-col md:flex-row">
                
                <a href="{{ route('home') }}" class="hover:underline"> {{ __('Inicio') }} </a>
                <a href="{{ route('about-us') }}" class="hover:underline"> {{ __('Sobre nosotros') }} </a>
                @php
                    if (Auth::check()) {
                        $url = route('products.index');
                        if(Auth::user()->isAdmin() || Auth::user()->isEmployee()) {
                            $url = route('admin.products.index');
                        }
                    } else {
                        $url = route('products.index');
                    }
                @endphp
                <a href="{{ $url }}" class="hover:underline"> {{ __('Productos') }} </a>
                <!-- <x-jet-nav-link href="{{ $url }}" :active="request()->routeIs('products.index')">
                    {{ __('Productos') }}
                </x-jet-nav-link> -->
                @if (!Auth::check())
                    <!-- <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                        {{ __('Iniciar Sesión') }}
                    </x-jet-nav-link> -->
                    <a href="{{ route('login') }}" class="hover:underline"> {{ __('Iniciar Sesión') }} </a>
                    <!-- <x-jet-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                        {{ __('Registrarme') }}
                    </x-jet-nav-link> -->
                    <a href="{{ route('register') }}" class="hover:underline">{{ __('Registrarme') }}</a>
                @endif
            </div>
            <!-- Socials -->
            <div class="col-start-1 row-start-2 text-white text-3xl flex space-x-6 place-self-start">
                <a href=""><i class="fab fa-whatsapp-square"></i></a>
                <a href=""><i class="fab fa-facebook-square"></i></a>
                <a href=""><i class="fab fa-instagram-square"></i></a>
            </div>
            <div class="px-10 py-5 row-span-2 justify-self-end place-self-end">logo</div>
        </div>
        
    
    </div>
</div>