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
            <select name="category_search" class="form-input w-1/3">
                <option value="none">Categoría a buscar</option>
                @foreach($search_categories as $categ) {
                    <option value="{{ $categ['id']}}">{{ $categ['name'] }}</option>
                @endforeach
            </select>
            <input name="price_search" type="text" class="form-input w-1/3">
        </div>
        
    {{ Form::close() }}
    <!-- </form> -->
</div>