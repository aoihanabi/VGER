<!DOCTYPE html>
<html>
<head>
  <title>Productos</title>
</head>
<body>
  <h1>Productos Disponibles</h1>
  <hr>
  
  @foreach($products as $key => $prod)
    <div>
      <img src="{{ url($main_imgs[$key]) }}" style="width: 300px; height: 200px;"></img>
      <br>
      <a href="products/{{ $prod->prd_id }}"><b>{{ $prod->prd_name }}</b> <br></a>
    </div>
    <hr>
  @endforeach

</body>
</html>