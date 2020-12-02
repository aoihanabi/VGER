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
                            <div class="mb-2">
                                <label class="block font-medium text-sm text-gray-700">Rol</label>
                                <p>{{ $user->role }}</p>
                            </div>
                            <div class="mb-2">
                                <label class="block font-medium text-sm text-gray-700">Correo</label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="mb-2">
                                <label class="block font-medium text-sm text-gray-700">Teléfono</label>
                                <p>{{ $user->phone }}</p>
                            </div>
                            <div class="mb-2">
                                <label class="block font-medium text-sm text-gray-700">Dirección</label>
                                <p>{{ $user->address }}</p>
                            </div>
                        </div>
                        <br>
                        @if (Auth::user()->isAdmin())
                            @if (!$user->isUser())
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
                            @endif
                            
                        @endif
                    </div>
                </div>
                <hr>
            @endforeach
        </div>  
    </div>
@endsection