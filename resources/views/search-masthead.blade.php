<div id="search-masthead">
    {{ Form::open(['route' => ('products.search'), 'method' => 'GET']) }}
        <!-- Search by name or keyword input -->
        <div class="flex flex-row py-4 px-5 w-full m-auto md:w-2/3 ">
            <input name="keyword_search" type="text" class="form-input w-full mx-1" placeholder="Buscar producto">
            <button type="submit" class="px-4 py-2 rounded bg-gray-700 text-white">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div x-data="{ show_detailed_search:false }">
        
            <a x-on:click.prevent="show_detailed_search=!show_detailed_search"
            class="text-gray-500 text-sm hover:underline cursor-pointer">
                Búsqueda Detallada ⯆
            </a>

            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 justify-items-center py-4 px-5 w-full m-auto md:w-2/3"
                x-show="show_detailed_search"
            >
                <!-- Dropdown of categories -->
                <div class="px-2 w-2/3 place-self-center">
                    <select name="category_search" class="form-input relative min-w-full md:w-16">
                        <option value="none">Categoría a buscar</option>
                        @foreach($search_categories as $categ) {
                            <option value="{{ $categ['id']}}">{{ $categ['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Slider -->
                <div class="px-2 w-full place-self-center">
                    <label for="price_search">Rango de precio:</label>
                        
                    <div id="slider-range"></div>
                    <div class="flex flex-row justify-between">
                        <input type="text" id="min_price_search" name="min_price_search" readonly 
                                class="w-1/2 bg-gray-200" value="₡{{ number_format($min_price, 0, '.', ' ') }}">
                        <input type="text" id="max_price_search" name="max_price_search" readonly 
                                class="w-1/2 bg-gray-200 text-right" value="₡{{ number_format($max_price, 0, '.', ' ') }}">
                        <label id="hidden_min_price" class="hidden">{{ $min_price }}</label>
                        <label id="hidden_max_price" class="hidden">{{ $max_price }}</label>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>