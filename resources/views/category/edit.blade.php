@extends('layouts.application')

@section('content')
    <div>
        <h2>Editar categoría</h2>
        {{ Form::model($category, ['route' => ['categories.update', $category], 'method' => 'PUT']) }}
            @include('category._category')
        {{ Form::close() }}
        <a href="/categories">Ver todas</a>
    </div>
@endsection