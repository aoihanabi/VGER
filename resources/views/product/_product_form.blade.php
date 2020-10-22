@section('price_quantity_fields')
  @foreach($attrs as $attr)
    <label> {{ $attr->name }} </label><br>
    @foreach ($options as $k => $opt)
      @if ($attr->id == $opt->attribute_id)

        <input type="checkbox" value="{{ $opt->attribute_id }},{{ $opt->id }}" name="opt_checks[{{$k}}]">
        <label for="opt_checks[{{$k}}]">{{ $opt->option }}</label>

      @endif
    @endforeach

    <!--<dynamic-input input_name='{{ Str::lower($attr->name) }}'></dynamic-input>

    <input type="text" name="{{Str::lower($attr->name)}}[0]" value="{{ $product==null ? '' : $product->quantity }}"><br><br>
    
    <label>Quantity </label>
    <input type="text" name="quantity[0]" value="{{ $product==null ? '' : $product->quantity }}"><br><br>    

    <label>Price </label>
    <input type="text" name="price[0]" value="{{ $product==null ? '' : $product->price }}"><br><br>-->
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
    @yield('price_quantity_fields')
  @elseif(Auth::user()->role === 'admin')
    @yield('price_quantity_fields')
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

