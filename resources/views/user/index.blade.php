@extends('layouts.application')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-10">
            <div class="inline-grid w-full">
                <h2 class="justify-self-center text-lg font-medium text-gray-900">Usuarios</h2>

                <div class="flex items-center justify-end py-3">
                    {{ link_to(route('users.create'), $title = 'Crear nuevo usuario',
                        ['class' => 'items-center px-4 py-2 pt-2 bg-gray-800 border border-transparent rounded-md font-semibold 
                                    text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                    focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}
                </div>
            </div>
            
            @foreach($users as $user)
                <div class="py-5 "  x-data="{ show{{$user->id}}:false }">
                    
                    <a x-on:click.prevent="show{{$user->id}}=!show{{$user->id}}" class="hover:bg-gray-100 cursor-pointer">
                        <div class="flex flex-row items-center">
                            <p class="flex-1 font-semibold">{{ $user->name}}
                            @if ($user->isAdmin() || $user->isEmployee())
                                <i class="fas fa-star"></i>
                            @endif
                            </p>
                            <i class="p-3 justify-self-end rounded hover:bg-gray-200 cursor-pointer fas fa-angle-down"></i>
                        </div>
                    </a>
                    <div x-show="show{{$user->id}}" class="bg-gray-100 px-4 pt-3 my-2 text-gray-700">
                        @if (Auth::user()->isAdmin())
                            @if (!$user->isUser())
                                <div class="flex flex-row justify-end">
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
                        <div class="grid grid-cols-2 justify-between">
                            <div class="my-4">
                                <label class="block font-bold text-gray-700">Rol</label>
                                <p>{{ ConstantsHelper::get_user_role_label($user->role) }}</p>
                            </div>
                            <div class="my-4">
                                <label class="block font-bold text-gray-700">Correo</label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="my-4">
                                <label class="block font-bold text-gray-700">Teléfono</label>
                                <p>{{ $user->phone }}</p>
                            </div>
                            <div class="my-4">
                                <label class="block font-bold text-gray-700">Dirección</label>
                                <p>{{ $user->address }}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <hr>
            @endforeach
        </div>  
    </div>
@endsection