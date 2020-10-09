<!DOCTYPE html>
<html>
<head>
  <title>Productos</title>
</head>
<body>
  <h1>Productos Disponibles</h1>
  <hr>
  <a href="products/create">Create a new product</a>
  @foreach($products as $key => $prod)
    <div>
      <img src="{{ asset($main_imgs[$key]) }}" style="width: 300px; height: 200px;"></img>
      <br>
      <a href="products/{{ $prod->prd_id }}"><b>{{ $prod->prd_name }}</b> <br></a>
    </div>
    <hr>
  @endforeach
  <br>
</body>
</html>