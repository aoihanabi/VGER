@extends('layouts.application')

@section('content')
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-10 mx-auto grid grid-cols-1 md:grid-cols-2">
      
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
      
      <div class="px-5">
        <div class="flex flex-row justify-end">
          <label for="code" class="flex-1"> # {{ $product->code }} </label>
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
        <div class="">
          <h1 class="align-center text-4xl font-semibold">{{ $product->name }}</h1>
        </div>
        <div>
          <p class="py-2 px-1 text-lg">{{ $product->description }}</p>
          <div class="my-3 grid grid-cols-3 gap-4">
            <!-- <label class="text-lg font-semibold">Disponibles:</label>
            <p class="col-start-2 col-span-2 text-lg">{{ $product->quantity }}</p> -->
            <label class="text-lg font-semibold">Precio:</label>
            <p class="col-start-2 col-span-2 text-lg">₡{{ number_format($product->price, 2, ".", " ") }}</p>
            <label class="col-span-3 text-lg font-semibold">Opciones: </label>
            
              @auth
                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'employee')
                  <!-- Show options as as simple labels for admins and employees-->
                  
                  <table class="col-span-3">
                    <thead class="bg-gray-600 text-sm text-white font-bold">
                      <tr class="border-2 border-gray-400">
                        <th class="p-2 col-span-2 border-r-2 border-white">Descripción</th>
                        <th class="">Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($options_db as $detail)
                        
                        <tr class="border-2 border-gray-400">
                          <td for="" class="p-2 col-span-2 border-r-2 border-gray-400">
                            @foreach((array)json_decode($detail->options_ids) as $key => $opt)
                              @if($opt != null)
                                {{$opt->option}}
                              @endif
                              
                            @endforeach
                            
                          </td>
                          <td class="inline-grid justify-self-center p-2">{{ $detail->amount }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                @else
                  
                  @include('product._options_dropdown', ['attr' => $attrs])
                  
                @endif
              @else
                
                @include('product._options_dropdown', ['attr' => $attrs])
                
              @endauth
              <!-- Agarrar los nombres de atributo y enviarlos en un array al vue -->
            
            <label class="col-span-3 text-lg font-semibold">Cantidad: </label>
            <input type="number" id="purchase_quantity" min="1" class="col-span-3 form-input rounded-md shadow-sm mt-1 block w-full">
            <div id="options_json" data-product-options='@json($options_db)' hidden></div>
          </div>
          <div>
            
            @auth
              @if(Auth::user()->role === 'user')
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