@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="my-15">
        <div class="p-5 border-solid border border-gray-300 rounded shadow-md">
            <div class="grid grid-cols-2">
                <div class="col-span-1">
                    <h1 class="text-2xl font-bold">Pedido #{{ $order->id }}</h1>
                    <label class="font-semibold">Fecha:  </label>
                    <label>{{date("d/m/Y", strtotime($order->date))  }}</label>
                    <br>
                    <label class="font-semibold mr-2">Estado:  </label>
                    <!-- <label>{{ ConstantsHelper::get_order_status_label($order->status)}}</label> -->
                    <button id="order_status_changer"
                            order-id = "{{ $order->id }}"
                            data-status = "{{ ConstantsHelper::get_order_status_label($order->status) == 'En Proceso' ? 'false' : 'true'  }}"
                            class="">
                        Estado Desconocido
                    </button>
                </div>
                <label class="col-span-1 justify-self-end self-center text-2xl">₡{{ number_format($order->total, 2, ".", " ") }}</label>
            </div>
            <br>
            <div class="grid grid-cols-4 justify-items-stretch">
                <h2 class="p-3 font-semibold bg-gray-200">Artículo</h2>
                <h2 class="p-3 font-semibold bg-gray-200">Detalle</h2>
                <h2 class="p-3 inline-grid justify-items-end font-semibold bg-gray-200">Cantidad</h2>
                <h2 class="p-3 inline-grid justify-items-end font-semibold bg-gray-200">Subtotal</h2>
                <hr class="col-span-4">
                @foreach ($details as $prod)
                    <p class="p-3 justify-self-stretch">{{ $prod->name }}</p>
                    <p class="p-3">{{ $prod->description }}</p>
                    <p class="p-3 justify-self-end">{{ $prod->purchased_quantity }}</p>
                    <p class="p-3 justify-self-end">₡{{ number_format($prod->subtotal, 2, ".", " ") }}</p>
                    
                    <hr class="col-span-4">
                @endforeach
            </div>
            
        </div>
    </div>
</div>
@endsection