<div id="footer" class=""> 
    <div class="relative w-full h-36 bg-gray-700">
        <a href="#">
            <!-- Up Arrow -->
            <div class="-mt-5 right-3 absolute rounded-full h-16 w-16 bg-gray-200 flex items-center justify-center">
                <i class="fas fa-caret-up text-gray-800 text-4xl"></i>
            </div>

            <!-- Nav-links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                
                <a href="/"> {{ __('Inicio') }} </a>

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
                <a href="{{ $url }}"> {{ __('Productos') }} </a>
                <!-- <x-jet-nav-link href="{{ $url }}" :active="request()->routeIs('products.index')">
                    {{ __('Productos') }}
                </x-jet-nav-link> -->
                @if (!Auth::check())
                    <!-- <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                        {{ __('Iniciar Sesión') }}
                    </x-jet-nav-link> -->
                    <a href="{{ route('login') }}"> {{ __('Iniciar Sesión') }} </a>
                    <!-- <x-jet-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                        {{ __('Registrarme') }}
                    </x-jet-nav-link> -->
                    <a href="{{ route('register') }}">{{ __('Registrarme') }}</a>
                @endif
            </div>
            <!-- Socials -->
            <div class="text-white text-3xl">
                <a href=""><i class="fab fa-whatsapp-square"></i></a>
                <a href=""><i class="fab fa-facebook-square"></i></a>
                <a href=""><i class="fab fa-instagram-square"></i></a>
            </div>
        </a>
    </div>
</div>