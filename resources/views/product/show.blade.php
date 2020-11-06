@extends('layouts.application')

@section('content')
  <div class="my-10 mx-20 grid grid-cols-2">
    
    <div>
      @foreach ($imgs as $m)
        @if ($m->type == 'MN')
          <img src="{{ url($m->url) }}" style="width: 400px; height: 300px;"></img><br>
        @else 
          <img src="{{ url($m->url) }}" style="width: 150px; height: 150px;"></img>
        @endif
      @endforeach
    </div>
    
    <div class="p-5">
      <div class="grid grid-cols-2">
        <h1 class="pb-5 text-4xl font-semibold">{{ $product->name }}</h1>
        <div class="col-end-3 items-end">
          @can('update', $product)
            <button>
              <a href="{{ route('products.edit', $product->id) }}">Editar producto</a>
            </button>
          @endcan
          @can('delete', $product)
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
              @method('DELETE')
              @csrf
              <input type="submit" name="delete" value="Eliminar producto">
            </form>
          @endcan
        </div>
      </div>
      
      <h2 class=" text-md font-semibold">Descripción</h2>
      <p class="mb-3">{{ $product->description }}</p>
      @foreach ($attrs as $attr)
        <li>{{$attr->name}}: {{$attr->pivot->value}} Cantidad: {{$attr->pivot->quantity}}</li>
        <li>{{ $attr->pivot->price }}</li>  
      @endforeach

      
      
    </div>

  </div>
@endsection