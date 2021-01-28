<div class="shadow overflow-hidden sm:rounded-md">
  <div class="px-4 py-5 bg-white sm:p-6">
    <div class="grid grid-cols-6 gap-6">
        <!-- General Information -->
        <div class="category_fields col-span-6 sm:col-span-4">
            {{ Form::label('name', 'Nombre de la Categoría', ['class' => 'block font-medium text-sm text-gray-700']) }}
            {{ Form::text('name', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
        </div>    
    </div>
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        {{ Form::submit('Guardar', ['class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold 
                                    text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                    focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}
    </div>
</div>