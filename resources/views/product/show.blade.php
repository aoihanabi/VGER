@extends('layouts.application')

@section('content')
  <div>
    <h1>{{ $product->name }}</h1>
    <li>{{ $product->description }}</li>
    <li>{{ $product->quantity }}</li>
    <li>{{ $product->price }}</li>  
  </div>

  <div>
    @foreach ($imgs as $m)
      @if ($m->type == 'MN')
        <img src="{{ url($m->url) }}" style="width: 400px; height: 300px;"></img><br>
      @else 
        <img src="{{ url($m->url) }}" style="width: 150px; height: 150px;"></img>
      @endif
    @endforeach
  </div>

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
@endsection