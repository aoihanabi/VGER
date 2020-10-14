<form method="POST" action="{{ route($action, $product==null ? '' : $product->id) }}" enctype="multipart/form-data">
  @method($method)
  @csrf
  <label>Product Name</label> <br>
  <input type="text" name="name" value="{{ $product==null ? '' : $product->name }}"> <br><br>

  <label>Description</label><br>
  <input type="text-area" name="description" value="{{ $product==null ? '' : $product->description }}"><br><br>
  
  <label>Quantity</label><br>
  <input type="text" name="quantity" value="{{ $product==null ? '' : $product->quantity }}"><br><br>
  
  <label>Price</label><br>
  <input type="text" name="price" value="{{ $product==null ? '' : $product->price }}"><br><br>

  <div class="form-group">
    <label for="main_image">Main Image:</label><br>
    <input type="file" class="form-control" name="main_image"/><br><br>
    <label for="sec_images">Secondary Images</label><br>
    <input type="file" class="form-control" name="sec_images[]" multiple="multiple"/>
  </div>

  <input type="submit" name="btn_create_prod">
</form>