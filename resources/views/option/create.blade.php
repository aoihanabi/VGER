@extends('layouts.application')

@section('content')
    <div>
        <h2>Crear una nueva característica</h2>
        {{ Form::open(['route' => 'options.store']) }}
            @include('option._option')
        {{ Form::close() }}
        <a href="/options">Ver todas</a>
    </div>
@endsection