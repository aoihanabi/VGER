@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Editar característica</h2>
            <p class="mt-1 text-sm text-gray-600">Actualizar la información de la característica</p>

            <div class="flex text-center pr-6 py-6">
                <a href="/options" class='flex-1 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold 
                                            text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                            focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150'> 
                Ver todas</a>    
            </div>
        </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            {{ Form::model($option, ['route' => ['options.update', $option], 'method' => 'PUT']) }}
                @include('option._option')
            {{ Form::close() }}
        </div>
        
    </div>
</div>
@endsection