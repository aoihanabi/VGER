<div class="shadow overflow-hidden sm:rounded-md">
  <div class="px-4 py-5 bg-white sm:p-6">
    <div class="grid grid-cols-6 gap-6">
      <!-- General Information -->
      <div class="product_fields col-span-6 sm:col-span-4">
          {{ Form::label('code', 'Código', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::text('code', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
          <br>
          {{ Form::label('name', 'Nombre', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::text('name', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
          <br>
          {{ Form::label('description', 'Descripción', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::textarea('description', null, ['rows' => 3, 'class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
          
      </div>
      <!-- Product Attributes -->
      <div id="product_attributes" class="col-span-6 sm:col-span-4">
        {{ Form::label('', 'Atributos', ['class' => 'block font-medium text-sm text-gray-700']) }}
        <div class="grid grid-cols-3">
          @foreach($attrs as $k => $attr)
            <label for="attribute_checks[{{ $k }}]">
              {{ Form::checkbox("attribute_checks[$k]", "$attr->id", $prod_attributes==null ? '' : in_array($attribute_checks->id, $prod_attributes), ['class' => 'attributes form-checkbox']) }}
              <span id="attribute_name" class="ml-2 text-sm text-gray-700">{{ $attr->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
      
      <!-- Product Options -->
      <div id="product_options" class="col-span-6 sm:col-span-4">
        <div class="flex flex-row justify-end">
          {{ Form::label('', 'Opciones', ['class' => 'block font-medium text-sm text-gray-700 flex-1']) }}
          {{ Form::button('+', ['id' => 'btn_add_options', 'class' => 'my-2 px-2 col-end-3 text-white bg-blue-700 hover:bg-blue-800 rounded']) }}
        </div>
        <div id="option_dropdowns" class="grid grid-cols-3">
          
          <div id="opts" class="col-span-2">
            {{ Form::select('colors', $colors->pluck('option', 'id'), null, ['id'=>'Color', 'hidden', 'class' => 'form-input w-full m-1']) }}
            {{ Form::select('sizes', $sizes->pluck('option', 'id'), null, ['id'=>'Talla', 'hidden', 'class' => 'form-input w-full m-1']) }}
            {{ Form::select('styles', $styles->pluck('option', 'id'), null, ['id'=>'Estilo', 'hidden', 'class' => 'form-input w-full m-1']) }}
          </div>
          <div id="amounts" class="col-start-3 row-start-1 row-end-4 grid items-center place-items-center">
            {{ Form::selectRange('', 1, 50, 1, ['id' => 'number_hid', 'class' => 'opt_amount form-input', 'hidden']) }}
            {{ Form::button('X', ['id' => 'btn_remove_hid', 'class' => "btn_remove_options my-2 px-2 col-end-3 text-white bg-red-700 hover:bg-red-800 rounded", 'hidden']) }}
          </div>
          <input type='text' id='contador' name='contador' value='0' hidden />
        </div>
        <!-- Quantity & Price -->
        <div class="product_fields col-span-6 sm:col-span-4">
          <br>
          {{ Form::label('quantity', 'Cantidad en inventario', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::text('quantity', 0, ['id' => 'quantity', 'class' => 'form-input rounded-md shadow-sm mt-1 block w-full', 'readonly']) }}
          <br>
          {{ Form::label('price', 'Precio', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::text('price', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
        </div>
      </div>
      <!-- Product Categories -->
      <div id="product_categories" class="col-span-6 sm:col-span-4">
        {{ Form::label('', 'Categorías', ['class' => 'block font-medium text-sm text-gray-700 mb-2']) }}
        <div class="grid grid-cols-3">
          @foreach ($categories as $k => $category)
            <label for="categ_checks[{{ $k }}]">
              {{ Form::checkbox("categ_checks[$k]", "$category->id", $prod_categs==null ? '' : in_array($categ_checks->id, $prod_categs), ['class' => 'form-checkbox']) }}
              <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
            </label>
          @endforeach
        </div>
      </div>

      <!-- Product Images -->
      <div id="product_images" class="col-span-6 sm:col-span-4">
          {{ Form::label('', "Cargar imagen principal", ['class' => 'block font-medium text-sm text-gray-700 mb-2']) }}
          {{ Form::file('main_image') }}
          <br><br>
          {{ Form::label('', "Cargar imagen(es) secundarias", ['class' => 'block font-medium text-sm text-gray-700 mb-2']) }}
          {{ Form::file('sec_images[]', ['multiple' => 'multiple']) }}
      </div>      
    </div>
    <div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
      {{ Form::submit('Guardar cambios', ['class' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold 
                                                      text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none 
                                                      focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150']) }}
    </div>
    
    

  </div>
    
</div>