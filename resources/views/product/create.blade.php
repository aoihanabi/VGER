<form action="{{ route('products.store') }}" method="POST">
  @csrf
  <label>Product Name</label> <br>
  <input type="text" name="name"> <br><br>

  <label>Description</label><br>
  <input type="text-area" name="description"><br><br>
  
  <label>Quantity</label><br>
  <input type="text" name="quantity"><br><br>
  
  <label>Price</label><br>
  <input type="text" name="price"><br><br>

  <input type="submit" name="btn_create_prod">
</form>