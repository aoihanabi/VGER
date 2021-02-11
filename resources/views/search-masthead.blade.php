<div id="search-masthead">
    <!-- <form action="{{route('products.search')}}" method="GET"> -->
    {{ Form::open(['route' => ('products.search'), 'method' => 'GET']) }}
        <div class="py-4 px-5">
            <input name="keyword_search" type="text" class="form-input w-1/2" placeholder="Buscar producto">
            <button type="submit" class="px-4 py-2 rounded bg-gray-700 text-white">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div class="py-4 px-5">
            <input name="category_search" type="text" class="form-input">
            <input name="price_search" type="text" class="form-input">
        </div>
        
    {{ Form::close() }}
    <!-- </form> -->
</div>