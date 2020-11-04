@extends('layouts.application')

@section('content')
    <div id="categories">
        <div>
            @foreach($categories as $category)
                <p>{{ $category->name }}</p>

                {{ Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) }}
                    {{ Form::submit('Eliminar', ['name' => 'delete']) }}
                {{ Form::close() }}
            @endforeach
        </div>
    </div>
@endsection