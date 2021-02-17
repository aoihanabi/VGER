<div id="search-masthead">
    <!-- <form action="{{route('products.search')}}" method="GET"> -->
    {{ Form::open(['route' => ('products.search'), 'method' => 'GET']) }}
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
                <div class="px-2 w-2/3 place-self-center">
                    <select name="category_search" class="form-input relative min-w-full md:w-16">
                        <option value="none">Categoría a buscar</option>
                        @foreach($search_categories as $categ) {
                            <option value="{{ $categ['id']}}">{{ $categ['name'] }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- <input name="price_search" type="text" class="form-input w-1/3"> -->
                <div class="px-2 w-2/3 place-self-center">
                    <label class="">Precio:</label>
                    <div class="flex h-16 w-full m-auto items-center justify-center">
                        <div class="py-1 relative min-w-full">
                            <div class="h-2 bg-gray-200 rounded-full">
                                <div class="absolute h-2 rounded-full bg-teal-600 w-0" style="width: 58.5714%;"></div>
                                <div class="absolute h-4 flex items-center justify-center w-4 rounded-full bg-white shadow border border-gray-300 -ml-2 top-0 cursor-pointer" unselectable="on" onselectstart="return false;" style="left: 58.5714%;">
                                    <div class="relative -mt-2 w-1">
                                        <div class="absolute z-40 opacity-100 bottom-100 mb-2 left-0 min-w-full" style="margin-left: -20.5px;">
                                            <div class="relative shadow-md">
                                                <div class="bg-black -mt-8 text-white truncate text-xs rounded py-1 px-4">92</div>
                                                <svg class="absolute text-black w-full h-2 left-0 top-100" x="0px" y="0px" viewBox="0 0 255 255" xml:space="preserve">
                                                    <polygon class="fill-current" points="0,0 127.5,127.5 255,0"></polygon>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="absolute text-gray-800 -ml-1 bottom-0 left-0 -mb-6">10</div>
                                <div class="absolute text-gray-800 -mr-1 bottom-0 right-0 -mb-6">150</div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
    {{ Form::close() }}
    <!-- </form> -->
</div>