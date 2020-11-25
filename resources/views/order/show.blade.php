@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="p-5 border-solid border border-gray-300 rounded shadow-md">
        <div class="grid grid-cols-2">
            <div class="col-span-1">
                <h1 class="text-xl">Pedido #{{ $order->id }}</h1>
                <label>FECHA: {{ $order->date }}</label>
            </div>
            <label class="col-span-1 justify-self-end self-center text-2xl">{{ $order->total }}</label>
        </div>
        <br>
        <div class="grid grid-cols-3">
            <h2 class="justify-self-stretch font-semibold">Artículo</h2>
            <h2 class="justify-self-end font-semibold">Cantidad</h2>
            <h2 class="justify-self-end font-semibold">Subtotal</h2>
            <hr class="col-span-3">
            @foreach ($details as $prod)
                <p class="py-2 justify-self-stretch">{{$prod->name}}</p>
                <p class="py-2 justify-self-end">0</p>
                <p class="py-2 justify-self-end">{{$prod->subtotal}}</p>
                <hr class="col-span-3">
            @endforeach
        </div>
        
    </div>

</div>
@endsection