@section('price_quantity_fields')
  <label>Quantity</label><br>
  <input type="text" name="quantity" value="{{ $product==null ? '' : $product->quantity }}"><br><br>

  <label>Price</label><br>
  <input type="text" name="price" value="{{ $product==null ? '' : $product->price }}"><br><br>
@endsection

<form method="POST" action="{{ route($action, $product==null ? '' : $product->id) }}" enctype="multipart/form-data">
  @method($method)
  @csrf
  <label>Product Name</label> <br>
  <input type="text" name="name" value="{{ $product==null ? '' : $product->name }}"> <br><br>

  <label>Description</label><br>
  <input type="text-area" name="description" value="{{ $product==null ? '' : $product->description }}"><br><br>

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

