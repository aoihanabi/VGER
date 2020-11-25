@extends('layouts.application')

@section('content')
  <div class="my-10 mx-20 grid grid-cols-2">
    
    <div id="images">
      
      @foreach ($imgs as $m)
        @if ($m->type == 'MN')
          <div class="box-border h-300 w-400 border-4">
            <img src="{{ url($m->url) }}" style="width: 400px; height: 300px;"></img>
          </div>
        @endif

        @if ($m->type == 'SC') 
          <img src="{{ url($m->url) }}" style="width: 150px; height: 150px;"></img>
        @endif
      @endforeach
    </div>
    
    <div class="p-5">
      <div class="grid grid-cols-3 items-start">
        <h1 class="col-span-2 align-center text-4xl font-semibold">{{ $product->name }}</h1>
        
        <div class="flex justify-end">
          @can('update', $product)
            <button class="px-2">
              <a href="{{ route('products.edit', $product->id) }}"><i class="fas fa-edit"></i></a>
            </button>
          @endcan
          @can('delete', $product)
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="px-2">
              @method('DELETE')
              @csrf
              <button type="submit" name="delete" value="">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          @endcan
        </div>
      </div>
      <div>
        <h2 class="my-3 text-lg font-semibold">Descripción</h2>
        <p class="">{{ $product->description }}</p>
        <div class="my-3 grid grid-cols-3 gap-4">
          <label class="text-lg font-semibold">Cantidad:</label>
          <p class="col-start-2 col-span-2 text-lg">{{ $product->quantity }}</p>
          <label class="text-lg font-semibold">Precio:</label>
          <p class="col-start-2 col-span-2 text-lg">₡{{ $product->price }}</p>
          <label class="col-span-3 text-lg font-semibold">Características: </label>
          @foreach ($attrs as $attr)
            <label class="col-span-3">{{ $attr->name }}</label>
            @foreach ($opts as $opt) 
              @if ($opt->attribute_id == $attr->id)
                <label class="py-2 px-4 border-2 border-gray-600 rounded-full text-center">{{ $opt->option }}</label>
              @endif
            @endforeach
          @endforeach
        </div>
        <product-list :product="{{ $product }}"/>
      </div>
    </div>

  </div>
@endsection