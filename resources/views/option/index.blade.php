@extends('layouts.application')

@section('content')
    <div id="all_options">
        @foreach($attributes as $attribute)
            <h4>{{ $attribute->name }}</h4>
            
            @foreach($options as $k => $option)
                @if($attribute->id == $option->attribute_id)
                    <p>{{ $option->option }}</p>
                    {{ Form::button(link_to(route('options.edit', $option->id), $title = 'Editar')) }}
                    
                    {{ Form::open(['route' => ['options.destroy', $option->id], 'method' => 'DELETE']) }}
                        {{ Form::submit('Eliminar', ['name' => 'delete']) }}
                    {{ Form::close() }}
                @endif
            @endforeach
        @endforeach
    </div>
    {{ link_to(route('options.create'), $title = 'Crear nueva característica') }}
@endsection