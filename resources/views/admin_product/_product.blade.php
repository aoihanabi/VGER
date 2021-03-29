  <?php
    //For loading dynamicly added option dropdowns after validation error ocurrs
    $lastColors = Request::old('color');
    $lastTallas = Request::old('talla');
    $lastEstilos = Request::old('estilo');
    $lastAmount = Request::old('opt_amount');
    // print_r($lastColors != null ? $lastcolors : "colors null | ");
    // print_r($lastTallas != null ? $lastallas :"tallas null | ");
    // print_r($lastEstilos != null ? $lastestilos:"estilos nul | ");
  ?>
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
              {{ Form::checkbox("attribute_checks[$k]", "$attr->id", $prod_attributes==null ? '' : in_array($attr->id, $prod_attributes), ['class' => 'attributes form-checkbox']) }}
              <span id="attribute_name" class="ml-2 text-sm text-gray-700">{{ $attr->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
      
      <!-- Product Options -->
      <div id="product_options" class="col-span-6 sm:col-span-4">
        <div class="flex flex-row justify-end">
          {{ Form::label('', 'Opciones', ['class' => 'block font-medium text-sm text-gray-700 flex-1']) }}
          {{ Form::button('', ['id' => 'btn_add_options', 'class' => 'fas fa-plus my-2 p-2 col-end-3 text-white bg-blue-700 hover:bg-blue-800 rounded']) }}
        </div>
        <div id="option_dropdowns" class="grid grid-cols-3">
          <!-- WHEN EDIT -->
          @if ($prod_options != null)
            @foreach ($prod_options as $k => $options)

              @include('admin_product._product_form_dropdowns', 
                      ['opts_div_id' => $k,
                       'opts_div_hidden' => '',
                       
                       'color_name' => $options->color != null ? 'color['.$k.']' : 'colors',
                       'all_colors' => $colors,
                       'color_selected' => $options->color != null ? $options->color->id : null,
                       'color_id' => 'Color_'.$k,
                       'color_hidden' => $options->color != null ? '' : 'hidden',
                       
                       'talla_name' => $options->talla != null ? 'talla['.$k.']' : 'sizes',
                       'all_tallas' => $sizes,
                       'talla_selected' => $options->talla != null ? $options->talla->id : null,
                       'talla_id' => 'Talla_'.$k,
                       'talla_hidden' => $options->talla != null ? '' : 'hidden',
                       
                       'estilo_name' => $options->estilo != null ? 'estilo['.$k.']' : 'styles',
                       'all_estilos' => $styles,
                       'estilo_selected' => $options->estilo != null ? $options->estilo->id : null,
                       'estilo_id' => 'Estilo_'.$k,
                       'estilo_hidden' => $options->estilo != null ? '' : 'hidden',

                       'amount_div_id' => 'amounts_'.$k,
                       'amount_div_hidden' => '',
                       'amount_name' => 'opt_amount['.$k.']',
                       'amount_selected' => $prod_options_amount != null ? $prod_options_amount[$k] : '1',
                       'amount_id' => 'number_'.$k,
                       'amount_hidden' => $prod_options_amount != null ? '' : 'hidden',
                       
                       'remove_btn_hidden' => $prod_options_amount != null ? '' : 'hidden',
                       'remove_counter' => $k,

                       'divider_id' => 'divider_'.$k,
                       'divider_hidden' => ''
                      ])
              
            @endforeach
          @endif

          <!-- WHEN ERROR -->
          @if ($errors->any())
            @if($lastAmount != null)
              @for ($i = 0; $i < count($lastAmount); $i++)
                @include('admin_product._product_form_dropdowns', 
                        ['opts_div_id' => $i,
                          'opts_div_hidden' => '',
                          
                          'color_name' => $lastColors != null ? 'color['.$i.']' : 'colors',
                          'all_colors' => $colors,
                          'color_selected' => $lastColors != null ? $lastColors[$i] : null,
                          'color_id' => 'Color_'.$i,
                          'color_hidden' => $lastColors != null ? '' : 'hidden',
                          
                          'talla_name' => $lastTallas != null ? 'talla['.$i.']' : 'sizes',
                          'all_tallas' => $sizes,
                          'talla_selected' => $lastTallas != null ? $lastTallas[$i] : null,
                          'talla_id' => 'Talla_'.$i,
                          'talla_hidden' => $lastTallas != null ? '' : 'hidden',
                          
                          'estilo_name' => $lastEstilos != null ? 'estilo['.$i.']' : 'styles',
                          'all_estilos' => $styles,
                          'estilo_selected' => $lastEstilos != null ? $lastEstilos[$i] : null,
                          'estilo_id' => 'Estilo_'.$i,
                          'estilo_hidden' => $lastEstilos != null ? '' : 'hidden',

                          'amount_div_id' => 'amounts_'.$i,
                          'amount_div_hidden' => '',
                          'amount_name' => 'opt_amount['.$i.']',
                          'amount_selected' => $lastAmount != null ? $lastAmount[$i] : '1',
                          'amount_id' => 'number_'.$i,
                          'amount_hidden' => $lastAmount != null ? '' : 'hidden',
                          
                          'remove_btn_hidden' => $lastAmount != null ? '' : 'hidden',
                          'remove_counter' => $i,

                          'divider_id' => 'divider_'.$i,
                          'divider_hidden' => ''
                        ])
              @endfor
            @endif
          @endif
          
          <!-- ALWAYS  -->
          @include('admin_product._product_form_dropdowns', 
                  ['opts_div_id' => 'opts',
                    'opts_div_hidden' => 'hidden',
                    
                    'color_name' => 'colors',
                    'all_colors' => $colors,
                    'color_selected' => null,
                    'color_id' => 'Color',
                    'color_hidden' => 'hidden',
                    
                    'talla_name' => 'sizes',
                    'all_tallas' => $sizes,
                    'talla_selected' => null,
                    'talla_id' => 'Talla',
                    'talla_hidden' => 'hidden',
                    
                    'estilo_name' => 'styles',
                    'all_estilos' => $styles,
                    'estilo_selected' => null,
                    'estilo_id' => 'Estilo',
                    'estilo_hidden' => 'hidden',

                    'amount_div_id' => 'amounts',
                    'amount_div_hidden' => 'hidden',
                    'amount_name' => '',
                    'amount_selected' => '1',
                    'amount_id' => 'number_hid',
                    'amount_hidden' => 'hidden',
                    
                    'remove_btn_hidden' => 'hidden',
                    'remove_counter' => '',

                    'divider_id' => 'divider',
                    'divider_hidden' => 'hidden'
                  ])
          
          <input type='text' id='contador' name='contador' value='{{ $prod_options != null ? count($prod_options) : "0" }}' hidden />
          
        </div>
        <!-- Quantity & Price -->
        <div class="product_fields col-span-6 sm:col-span-4">
          <br>
          {{ Form::label('quantity', 'Cantidad en inventario', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::text('quantity', null, ['id' => 'quantity', 'class' => 'form-input rounded-md shadow-sm mt-1 block w-full', 'readonly']) }}
          <br>
          {{ Form::label('price', 'Precio', ['class' => 'block font-medium text-sm text-gray-700']) }}
          {{ Form::text('price', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
        </div>
      </div>
      
      <!-- Product Search Keywords -->
      <div id="product_keywords" class="col-span-6 sm:col-span-4">
        {{ Form::label('keywords', 'Palabras clave para búsqueda', ['class' => 'block font-medium text-sm text-gray-700']) }}
        {{ Form::text('keywords', null, ['class' => 'form-input rounded-md shadow-sm mt-1 block w-full']) }}
      </div>

      <!-- Product Categories -->
      <div id="product_categories" class="col-span-6 sm:col-span-4">
        {{ Form::label('', 'Categorías', ['class' => 'block font-medium text-sm text-gray-700 mb-2']) }}
        <div class="grid grid-cols-3">
          @foreach ($categories as $k => $category)
            <label for="categ_checks[{{ $k }}]">
              {{ Form::checkbox("categ_checks[$k]", "$category->id", $prod_categs==null ? '' : in_array($category->id, $prod_categs), ['class' => 'form-checkbox']) }}
              <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
            </label>
          @endforeach
        </div>
      </div>
      
      <!-- Product Images -->
      <div id="product_images" class="col-span-6 sm:col-span-4">
          
          {{ Form::label('', "Cargar imagen principal", ['class' => 'block font-medium text-sm text-gray-700 mb-2']) }}
          <div class="flex flex-row">
            <div class="relative my-1 p-0.5 box-border border-1 rounded shadow-md h-full w-full
                        cursor-pointer hover:opacity-75">
                
                <i class="fas fa-trash h-full w-full 
                        absolute z-0 p-2 text-center text-transparent text-2xl hover:text-red-800"></i>
                <img src="{{ url($main_img->url) }}" class="object-cover rounded"></img>
            
            </div>
            <div class="my-1 p-0.5 h-full w-full"></div>
          </div>
          {{ Form::file('main_image') }}

          <br><br>
          
          {{ Form::label('', "Cargar imagen(es) secundarias", ['class' => 'block font-medium text-sm text-gray-700 mb-2']) }}
          <div class="grid grid-cols-3 my-2 h-1/4 place-content-center">
            @foreach ($second_imgs as $img)
                <div class="relative my-1 p-0.5 box-border border-1 rounded shadow-md h-full w-full 
                          cursor-pointer hover:opacity-75">
                
                    <i class="fas fa-trash h-full w-full 
                            absolute z-0 p-2 text-center text-transparent text-2xl hover:text-red-700"></i>
                    <img src="{{ url($img->url) }}" class="h-full w-full object-cover rounded"></img>

                </div>
            @endforeach
          </div>
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
