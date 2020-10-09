<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
  @csrf
  <label>Product Name</label> <br>
  <input type="text" name="name"> <br><br>

  <label>Description</label><br>
  <input type="text-area" name="description"><br><br>
  
  <label>Quantity</label><br>
  <input type="text" name="quantity"><br><br>
  
  <label>Price</label><br>
  <input type="text" name="price"><br><br>

  <div class="form-group">
    <label for="main_image">Main Image:</label><br>
    <input type="file" class="form-control" name="main_image"/><br><br>
    <input type="file" class="form-control" name="sec_images[]" multiple="multiple"/>
  </div>

  <input type="submit" name="btn_create_prod">
</form>