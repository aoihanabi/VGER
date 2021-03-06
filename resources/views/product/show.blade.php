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
            <label class="col-span-3 text-lg font-semibold">Cantidad: </label>
            <input type="number" id="purchase_quantity" min="1" class="col-span-3 form-input rounded-md shadow-sm mt-1 block w-full">
            
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