@extends('layouts.application')

@section('content')
    <div>
        <h2>Editar característica</h2>
        {{ Form::model($option, ['route' => ['options.update', $option], 'method' => 'PUT']) }}
            @include('option._option')
        {{ Form::close() }}
        <a href="/options">Ver todas</a>
    </div>
@endsection