@extends('layouts.application')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-10 mx-20 grid grid-cols-2">
      
      <div id="images" class="mx-6">
        <div class="mb-2 p-0.5 box-border border-1 rounded shadow-md">
          <img src="{{ url($main_img->url) }}" class="object-cover h-96 w-full rounded" style=""></img>
        </div>

        <div class="grid grid-cols-4 gap-2">
          @foreach ($secondary_imgs as $img)
            <div class="p-0.5 box-border border-1 rounded shadow-md">
              <img src="{{ url($img->url) }}" class="object-cover h-28 w-full rounded" style=""></img>    
            </div>
          @endforeach
        </div>
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
  </div>
  
@endsection