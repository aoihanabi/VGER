
@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div id="orders_admin_masthead" class="py-5 text-center">
        <h2 class="text-xl">Órdenes</h2>
    </div>
    <div class="py-10">
        <div x-data="{show_{{ConstantsHelper::ORDER_STATUS_IN_PROCESS}}:false}" class="py-2">
            <a x-on:click.prevent="show_{{ConstantsHelper::ORDER_STATUS_IN_PROCESS}}=!show_{{ConstantsHelper::ORDER_STATUS_IN_PROCESS}}" class="hover:bg-gray-100 cursor-pointer">
                <div class="flex flex-row items-center">
                    <p class="flex-1 font-semibold"> Pedidos en proceso </p>
                    <i class="p-3 justify-self-end rounded hover:bg-gray-200 cursor-pointer fas fa-angle-down"></i>
                </div>
            </a>
            @foreach($orders as $order)
                @if ($order->status ==  ConstantsHelper::ORDER_STATUS_IN_PROCESS)
                    <div x-show="show_{{$order->status}}" class="bg-gray-100 px-4 py-3 my-2 text-gray-700">
                        <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="">
                            <div class="py-5 grid grid-cols-3 content-center hover:bg-gray-100">
                                <div class="text-lg font-semibold col-span-2">Pedido #{{$order->id}}</div>
                                <div class="text-md font-semibold row-start-2">Usuario: {{ $order->name }} </div>
                                <div class="text-lg font-semibold justify-self-end pr-4">₡{{number_format($order->total, 2, ".", " ")}}</div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
        <hr>
        <div x-data="{show_{{ConstantsHelper::ORDER_STATUS_READY}}:false}" class="py-2">
            <a x-on:click.prevent="show_{{ConstantsHelper::ORDER_STATUS_READY}}=!show_{{ConstantsHelper::ORDER_STATUS_READY}}" class="hover:bg-gray-100 cursor-pointer">
                <div class="flex flex-row items-center">
                    <p class="flex-1 font-semibold"> Pedidos listos para entrega </p>
                    <i class="p-3 justify-self-end rounded hover:bg-gray-200 cursor-pointer fas fa-angle-down"></i>
                </div>
            </a>
            @foreach($orders as $order)
                @if ($order->status ==  ConstantsHelper::ORDER_STATUS_READY)
                    <div x-show="show_{{$order->status}}" class="bg-gray-100 px-4 py-3 my-2 text-gray-700">
                        <a href="{{ route('admin.orders.show', ['order' => $order->id]) }}" class="">
                            <div class="py-5 grid grid-cols-3 content-center hover:bg-gray-100">
                                <div class="text-lg font-semibold col-span-2">Pedido #{{$order->id}}</div>
                                <div class="text-md font-semibold row-start-2">Usuario: {{ $order->name }} </div>
                                <div class="text-lg font-semibold justify-self-end pr-4">₡{{number_format($order->total, 2, ".", " ")}}</div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection