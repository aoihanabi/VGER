<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="{{asset('../css/app.css')}}">
  <title>Hi Test</title>
</head>
<body>
  <h2> TEST ! </h2>
  <br>
  @foreach ($products as $p)
    <li>{{ $p }}</li>
  @endforeach
</body>
</html>