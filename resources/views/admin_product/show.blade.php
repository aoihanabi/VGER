@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-10 mx-auto">
        
        <!-- Product Information -->
        <div class="px-5">
            <div class="flex flex-row justify-end">
                <label for="code" class="flex-1"> # {{ $product->code }} </label>
                <button class="px-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}"><i class="fas fa-edit"></i></a>
                </button>
                @can('delete', $product)
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="px-2">
                        @method('DELETE')
                        @csrf
                        <button type="submit" name="delete" value="">
                        <i class="fas fa-trash"></i>
                        </button>
                    </form>
                @endcan
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <div>
                    <h1 class="align-center text-4xl font-semibold">{{ $product->name }}</h1>
                    <p class="py-2 px-1 text-lg">{{ $product->description }}</p>
                    
                    
                </div>

                
                <div class="my-3 grid grid-cols-3 gap-4">
                    <label class="text-lg font-semibold">Inventario:</label>
                    <p class="col-start-2 col-span-2 text-lg">{{ $product->quantity }}</p>
                    <label class="text-lg font-semibold">Precio:</label>
                    <p class="col-start-2 col-span-2 text-lg">₡{{ number_format($product->price, 2, ".", " ") }}</p>
                </div>
                
            </div>

            <div>
                <label class="text-lg font-semibold">Características: </label>
                <!-- Show options as as simple labels for admins and employees-->
                <table class="mt-2 w-full">
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
                            <td class="inline-grid p-2 w-full">
                                <p class="justify-self-center">{{ $detail->amount }}</p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Images -->
            <div id="images" class="mx-auto my-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 w-full">
                <div class="my-1 p-0.5 box-border border-1 rounded shadow-md">
                    <img src="{{ url($main_img->url) }}" class="object-cover h-full w-full rounded" style=""></img>
                </div>
                @foreach ($secondary_imgs as $img)
                    <div class="my-1 p-0.5 box-border border-1 rounded shadow-md">
                        <img src="{{ url($img->url) }}" class="object-cover h-full w-full rounded" style=""></img>    
                    </div>
                @endforeach
            </div>
        </div>

        
        
        
    </div>
</div>
  
@endsection