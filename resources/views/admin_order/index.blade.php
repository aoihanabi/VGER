
@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-xl">Órdenes en proceso</h2>
    <div class="py-10">
        @foreach($orders as $order)
            <a href="">
                <div class="py-5 flex flex-row content-center hover:bg-gray-100">
                    <div class="text-lg font-semibold flex-1">Pedido #{{$order->id}}</div>
                    <div class="text-lg font-semibold">{{$order->total}}</div>
                </div>
            </a>
            <hr>
        @endforeach
    </div>
</div>
@endsection