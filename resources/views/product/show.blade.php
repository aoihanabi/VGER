@extends('layouts.application')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-10 mx-auto grid grid-cols-1 md:grid-cols-2">
      <!-- Images -->
      <div id="images" class="md:mx-6 mx-auto">
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

        <product-images-component />
      </div>
      <!-- Product Information -->
      <div class="px-5">
        <div class="">
          <label for="code" class="flex-1"> # {{ $product->code }} </label>
          <h1 class="align-center text-4xl font-semibold">{{ $product->name }}</h1>
        </div>
        <div>
          <p class="py-2 px-1 text-lg">{{ $product->description }}</p>
          <div class="my-3 grid grid-cols-3 gap-4">
            <label class="text-lg font-semibold">Precio:</label>
            <p class="col-start-2 col-span-2 text-lg">₡{{ number_format($product->price, 2, ".", " ") }}</p>
            
            <!-- Product characteristics selection area -->
            <label class="col-span-3 text-lg font-semibold">Opciones: </label>
            @include('product._options_dropdown', ['attr' => $attrs])
            
            <!-- Product amount (to purchase) selection area -->
            <div class="custom-number-input col-span-3">
              <label class="col-span-3 text-lg font-semibold">Cantidad: </label>
              
              <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent mt-1">
                <button data-action="decrement" class=" bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none">
                  <span class="fas fa-minus mx-5"></span>
                </button>

                <input type="number" id="purchase_quantity" min="1" 
                  class="styled_input outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black  md:text-basecursor-default flex items-center text-gray-700  outline-none"
                  value="1">
                
                <button data-action="increment" class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer">
                  <span class="fas fa-plus mx-5"></span>
                </button>
              </div>
            </div>
            
            <!-- To take attributes names and send them to VueJS -->
            <div id="options_json" data-product-options='@json($options_db)' hidden></div>
          </div>
          
          <!-- Process Order button -->
          <div>
            @auth
              @if(Auth::user()->isUser())
                <purchase-button :product="{{ $product }}" :attributes="{{ $attrs }}" /><!-- attr_names -->
              @endif
            @else
              <purchase-button :product="{{ $product }}" :attributes="{{ $attrs }}" /><!-- attr_names -->
            @endauth
          </div>

        </div>
      </div>

    </div>
  </div>
  
@endsection