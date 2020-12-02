@extends('layouts.application')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl">Usuarios</h2>
        <div class="py-10">
            @foreach($users as $user)
                <div class="py-5 grid grid-cols-3 justify-between hover:bg-gray-100">
                    <div class="text-lg font-semibold">{{$user->name}}</div>
                    <div class="text-lg font-semibold">{{$user->role}}</div>
                    <div class="text-lg font-semibold">{{$user->email}}</div>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
@endsection