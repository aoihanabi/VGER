@extends('layouts.application')

@section('content')
    <div>
        <h2>Crear nueva categoría</h2>
        {{ Form::open(['route' => 'categories.store']) }}
            @include('category._category')
        {{ Form::close() }}
        <a href="/categories">Ver todas</a>
    </div>
@endsection