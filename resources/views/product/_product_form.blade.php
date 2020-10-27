@section('options_fields')
  @foreach($attrs as $attr)
    <label> {{ $attr->name }} </label><br>
    <div>
      @foreach ($options as $k => $opt)
        @if ($attr->id == $opt->attribute_id)
          
          <input type="checkbox" value="{{ $opt->attribute_id }},{{ $opt->id }}" name="opt_checks[{{$k}}]"
            @if ($product != null)
              @foreach ($product->values as $option)
                @if( $option->pivot->option_id == $opt->id)
                  checked
                @endif
              @endforeach
            @endif
          >
          <label for="opt_checks[{{$k}}]">{{ $opt->option }}</label>

        @endif
      @endforeach  
    </div>
  @endforeach
@endsection

<form method="POST" action="{{ route($action, $product==null ? '' : $product->id) }}" enctype="multipart/form-data">
  @method($method)
  @csrf

  <label>Product Name</label> <br>
  <input type="text" name="name" value="{{ $product==null ? '' : $product->name }}"> <br><br>

  <label>Description</label><br>
  <input type="text-area" name="description" value="{{ $product==null ? '' : $product->description }}"><br><br>

  <label>Quantity </label>
  <input type="text" name="quantity" value="{{ $product==null ? '' : $product->quantity }}"><br><br>    

  <label>Price </label>
  <input type="text" name="price" value="{{ $product==null ? '' : $product->price }}"><br><br>
  
  @if($product == null )
    @yield('options_fields')
  @elseif(Auth::user()->role === 'admin')
    @yield('options_fields')
  @endif

  <div class="form-group">
    <label for="main_image">Main Image:</label><br>
    <input type="file" class="form-control" name="main_image"/><br><br>
    <label for="sec_images">Secondary Images</label><br>
    <input type="file" class="form-control" name="sec_images[]" multiple="multiple"/>
  </div>
  <br>
  <input type="submit" name="btn_create_prod">
</form>

