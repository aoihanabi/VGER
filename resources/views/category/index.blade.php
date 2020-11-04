@extends('layouts.application')

@section('content')
    <div id="categories">
        @foreach($categories as $category)
            <div>
                <p>{{ $category->name }}</p>
                {{ Form::button(link_to(route('categories.edit', $category->id), $title = 'Editar')) }}

                {{ Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) }}
                    {{ Form::submit('Eliminar', ['name' => 'delete']) }}
                {{ Form::close() }}
            </div>
        @endforeach
        {{ link_to(route('categories.create'), $title = 'Crear nueva categoría') }}
    </div>
@endsection