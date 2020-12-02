@extends('layouts.application')

@section('content')
  <div class="max-w-7xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <div class="md:grid md:grid-cols-3 md:gap-6">
      <div>
        <h2 class="text-lg font-medium text-gray-900">Editar usuario</h2>
        <p class="mt-1 text-sm text-gray-600">Modifica la información del usuario</p>
      </div>

      <div class="mt-5 md:mt-0 md:col-span-2">
        {{ Form::model($user, ['route' => ['users.update', $user], 'method' => 'PUT']) }}
            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">
                        <!-- General Information -->
                        <div id="user" class="col-span-6 sm:col-span-4">
                            {{ Form::label('name', 'Nombre', ['class' => 'block font-medium text-sm text-gray-700']) }}
                            {{ Form::text('name', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
                            <br>
                            {{ Form::label('role', 'Rol', ['class' => 'block font-medium text-sm text-gray-700']) }}
                            {{ Form::select('role', $roles, $user->role, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
                            <br>
                            {{ Form::label('email', 'Correo', ['class' => 'block font-medium text-sm text-gray-700']) }}
                            {{ Form::text('email', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full disabled:opacity-50', 'disabled']) }}
                            <br>                            
                            {{ Form::label('phone', 'Teléfono', ['class' => 'block font-medium text-sm text-gray-700']) }}
                            {{ Form::text('phone', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
                            <br>                            
                            {{ Form::label('address', 'Dirección', ['class' => 'block font-medium text-sm text-gray-700']) }}
                            {{ Form::text('address', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
                        </div>
                    </div>
                    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
                    {{ Form::submit('Guardar cambios', ['class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold 
                                                                    text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                                                    focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}
                    </div>
                </div>
                
            </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@endsection