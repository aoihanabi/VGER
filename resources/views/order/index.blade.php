@extends('layouts.application')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session()->has('order_notification'))
            <div class="p-3 m-3 bg-green-100 rounded-md border border-green-300">
                <label> {{ session()->get('order_notification') }} </label>
            </div>    
        @endif
        <div id="orders_masthead" class="py-5 text-center">
            <h2 class="text-xl">Mis pedidos</h2>
        </div>
        <div class="py-10">
            @foreach($p_orders as $order)
                <a href="{{ route('orders.show', ['order' => $order->id]) }}">
                <div class="py-5 grid grid-cols-3 content-center hover:bg-gray-100">
                    <div class="text-lg col-span-2 font-semibold"> Pedido #{{$order->id}} </div>
                    <div class="col-span-2 row-span-2">
                        <span class="font-semibold"> Estado: </span>
                        {{ ConstantsHelper::get_order_status_label($order->status) }}
                    </div>
                    <div class="text-lg font-semibold justify-self-end pr-4">₡{{number_format($order->total, 2, ".", " ")}}</div>
                </div>
                </a>
                <hr>
            @endforeach
            {{ $p_orders->onEachSide(1)->links() }}
        </div>
    </div>
@endsection