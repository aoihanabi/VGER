<div id="home-categories" class="h-4/5 py-2 bg-white grid grid-cols-2 gap-2">
    <!-- Category: Hogar -->
    <div class="row-span-2 bg-cover bg-center bg-no-repeat" style="background-image: url(images/page/hogar-bg.jpg);">
        <a href="{{ route('products.search', ['keyword_search' => '', 'category_search' => 1, 'min_price_search' => 0, 'max_price_search' => 1000000]) }}">
            <div class="relative h-full w-full bg-gray-200 bg-opacity-25">
                <h1 class="absolute top-0 left-0 m-5 font-title text-3xl text-gray-800">Artículos para el Hogar</h1>
            </div>
        </a>
    </div>
    <!-- Category: Libreria -->
    <div class="h-full bg-cover bg-no-repeat bg-left-bottom" style="background-image: url(images/page/libreria-bg.jpg);">
        <a href="{{ route('products.search', ['keyword_search' => '', 'category_search' => 2, 'min_price_search' => 0, 'max_price_search' => 1000000]) }}">
            <div class="relative h-full w-full bg-gray-200 bg-opacity-25">
                <h1 class="absolute bottom-0 left-0 m-5 font-title text-3xl text-gray-800">Artículos de Librería</h1>
            </div>
        </a>
    </div>
    <!-- Category: Ferreteria -->
    <div class="h-full bg-cover bg-right-bottom" style="background-image: url(images/page/ferreteria-bg.jpg);">
        <a href="{{ route('products.search', ['keyword_search' => '', 'category_search' => 5, 'min_price_search' => 0, 'max_price_search' => 1000000]) }}">
            <div class="relative h-full w-full bg-gray-200 bg-opacity-25">
                <h1 class="absolute bottom-0 left-0 m-5 font-title text-3xl text-gray-800">Artículos de Ferretería</h1>
            </div>
        </a>
    </div>
</div>