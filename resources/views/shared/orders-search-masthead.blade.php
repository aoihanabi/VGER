<div id="search-masthead">
    {{ Form::open(['route' => ('products.search'), 'method' => 'GET']) }}
        
        <div x-data="{ show_order_search:false }">
        
            <a x-on:click.prevent="show_order_search=!show_order_search"
            class="text-gray-500 text-sm hover:underline cursor-pointer">
                Buscar Pedido ⯆
            </a>
            
            <!-- Search by name or keyword input -->
            <div class="grid grid-cols-2 py-4 px-5 w-full m-auto md:w-2/3 " x-show="show_order_search">
                <label class="col-span-2 text-sm text-gray-700 justify-self-start">Buscar por usuario: </label>
                <div class="row-start-2 col-span-2 flex flex-row">
                    <select name="category_search" class="form-input relative min-w-full md:w-16">
                        <option value="none">Nombre de usuario</option>
                    </select>
                    <!-- <input name="keyword_search" type="text" class="form-input w-full mx-1" placeholder="Buscar por usuario"> -->
                    <button type="submit" class="px-4 py-2 rounded bg-gray-700 text-white">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                
            </div>

            <div class="grid grid-cols-2 gap-3 py-4 px-5 w-full m-auto md:w-2/3 " x-show="show_order_search">
                <label class="col-span-2 text-sm text-gray-700 justify-self-start">Buscar por fecha/s: </label>
                <div class="col-span-2 grid grid-cols-2 gap-3">
                    <label class="text-gray-700 justify-self-start">Fecha de inicio</label>
                    <label class="text-gray-700 justify-self-start">Fecha de final</label>
                    <input type="date" class="py-2">
                    <input type="date" class="py-2">
                </div>
            </div>
            
            
        </div>
    {{ Form::close() }}
</div>