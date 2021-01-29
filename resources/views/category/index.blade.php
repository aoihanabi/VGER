@extends('layouts.application')

@section('content')
<div class="max-w-7xl mx-auto my-10 px-10 sm:px-6 lg:px-15">
    <div class="md:grid md:grid-cols-2 md:gap-6">
      <div class="inline-grid mt-5 md:mt-0 md:col-span-2">
        <h2 class="justify-self-center text-lg font-medium text-gray-900">Categorías de Producto</h2>
      </div>

        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                
                    <div class="flex col-start-2 items-center justify-end py-3">
                        {{ link_to(route('categories.create'), $title = 'Crear nueva categoría',
                            ['class' => 'items-center px-4 py-2 pt-2 bg-gray-800 border border-transparent rounded-md font-semibold 
                                        text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                        focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}
                    </div>
                    <div class="grid grid-cols-2 gap-x-15 gap-y-6">
                        
                        <!-- General Information -->
                        @foreach($categories as $category)
                        <div class="category_fields col-span-2 sm:col-span-1">
                            <div class="grid grid-cols-3 justify-items-end">
                                {{ Form::label('', $category->name, ['class' => 'col-span-2 justify-self-start']) }}
                                <div class="flex flex-row">
                                    {{ link_to(route('categories.edit', $category->id), $title ='', ['class' => 'fas fa-edit pt-1']) }}
                                    &nbsp;
                                    {{ Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) }}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'name' => 'delete']) }}
                                    {{ Form::close() }}
                                </div>
                                
                            </div>
                            
                        </div>
                        @endforeach
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection