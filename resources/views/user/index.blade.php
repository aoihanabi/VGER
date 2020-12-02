@extends('layouts.application')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-10">
            <h2 class="text-xl">Usuarios</h2>
            @foreach($users as $user)
                <div class="py-5 "  x-data="{show{{$user->id}}:false}">
                    
                    <a x-on:click.prevent="show{{$user->id}}=!show{{$user->id}}" class="hover:bg-gray-100 cursor-pointer">
                        <div class="flex flex-row items-center">
                            <p class="flex-1 font-semibold">{{ $user->name}}</p>
                            <i class="p-3 justify-self-end rounded hover:bg-gray-200 cursor-pointer fas fa-plus"></i>
                        </div>
                    </a>
                    <div x-show="show{{$user->id}}" class="bg-gray-100 px-4 py-3 my-2 text-gray-700">
                        <div class="grid grid-cols-2 justify-between">
                            <p>Role: {{ $user->role }}</p>
                            <p>Email: {{ $user->email }}</p>
                            <p>Phone: {{ $user->phone }}</p>
                            <p>Address: {{ $user->address }}</p>
                        </div>
                        <br>
                        <div class="flex flex-row">
                            
                            <button class="px-2">
                                <a href="{{ route('users.edit', $user->id) }}"><i class="fas fa-edit"></i> Editar </a>
                            </button>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="px-2">
                                @method('DELETE')
                                @csrf
                                <button type="submit" name="delete" value="">
                                    <i class="fas fa-trash"></i>
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>  
    </div>
@endsection