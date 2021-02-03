<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <x-jet-application-mark class="block h-9 w-auto" />
                </a>
            </div>
            <div class="flex">
                

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
                    <x-jet-nav-link href="/" :active="request()->routeIs('home')">
                        {{ __('Inicio') }}
                    </x-jet-nav-link>

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
                    <x-jet-nav-link href="{{ $url }}" :active="request()->routeIs('products.index')">
                        {{ __('Productos') }}
                    </x-jet-nav-link>
                    @if (!Auth::check())
                        <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                            {{ __('Iniciar Sesión') }}
                        </x-jet-nav-link>
                        <x-jet-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
                            {{ __('Registrarme') }}
                        </x-jet-nav-link>
                    @endif
                </div>

                <!-- Settings Dropdown -->
                @if(Auth::check())
                    @if(Auth::user()->isAdmin() || Auth::user()->isEmployee())
                        <div class="hidden sm:flex sm:items-center sm:ml-5">
                            <x-jet-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-sm text-gray-500">
                                        Mantenimiento
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <!-- Product Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Administrar Productos') }}
                                    </div>
                                    <x-jet-dropdown-link href="{{ route('admin.products.create') }}">
                                        {{ __('Agregar producto') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="{{ route('categories.create') }}">
                                        {{ __('Agregar categoría') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="{{ route('options.create') }}">
                                        {{ __('Agregar caraterística') }}
                                    </x-jet-dropdown-link>
                                    <!-- <a href="products/create">Crear nuevo producto</a>
                                    {{ link_to(route('categories.create'), $title = 'Crear nueva categoría') }}
                                    {{ link_to(route('options.create'), $title = 'Crear nueva característica') }} -->
                                    
                                    <div class="border-t border-gray-100"></div>
                                    <!-- Order Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Administrar Pedidos') }}
                                    </div>
                                    <x-jet-dropdown-link href="{{ route('admin.orders.index') }}">
                                        {{ __('Ver pedidos') }}
                                    </x-jet-dropdown-link>

                                    <div class="border-t border-gray-100"></div>
                                    <!-- Users Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Administrar Usuarios') }}
                                    </div>
                                    <x-jet-dropdown-link href="{{ route('users.index') }}">
                                        {{ __('Ver usuarios') }}
                                    </x-jet-dropdown-link>
                                    <x-jet-dropdown-link href="{{ route('users.create') }}">
                                        {{ __('Agregar Usuario') }}
                                    </x-jet-dropdown-link>
                                </x-slot>
                            </x-jet-dropdown>
                        </div>
                    @endif
                    <div class="hidden sm:flex sm:items-center sm:ml-5">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                @endif
                            </x-slot>

                            <x-slot name="content">
                                <!-- Orders Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Administrar Pedidos') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('orders.index') }}">
                                    {{ __('Mis Pedidos') }}
                                </x-jet-dropdown-link>

                                <div class="border-t border-gray-100"></div>

                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Administrar Cuenta') }}
                                </div>

                                <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                    {{ __('Profile') }}
                                </x-jet-dropdown-link>

                                <!-- @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-jet-dropdown-link>
                                @endif -->

                                <div class="border-t border-gray-100"></div>

                                

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-jet-dropdown-link href="{{ route('logout') }}"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                        {{ __('Logout') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                        
                    </div>
                @endif
            </div>

            

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-jet-responsive-nav-link> -->
            <x-jet-responsive-nav-link href="/" :active="request()->routeIs('home')">
                {{ __('Inicio') }}
            </x-jet-responsive-nav-link>
            <x-jet-responsive-nav-link href="{{ route('products.index') }}" :active="request()->routeIs('products.index')">
                {{ __('Productos') }}
            </x-jet-responsive-nav-link>
            @if (!Auth::check())
                <x-jet-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-jet-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        @if(Auth::check())
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-jet-responsive-nav-link>
                </form>
            </div>
        </div>
        @endif
    </div>
</nav>
