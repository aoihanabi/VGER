<!DOCTYPE html>
<html>
<head>
  <title>Editar Producto</title>
</head>
<body>
  <div>
    @include('product._product_form', ['action' => 'products.update', 'method' => 'PUT'])
  </div>
</body>
</html>