<h1>{{ $prod->name }}</h1>
<div>
  <li>{{ $prod->description }}</li>
  <li>{{ $prod->quantity }}</li>
  <li>{{ $prod->price }}</li>  
</div>

<div>
  @foreach ($imgs as $m)
    @if ($m->type == 'MN')
      <img src="{{ url($m->url) }}" style="width: 400px; height: 300px;"></img><br>
    @else 
      <img src="{{ url($m->url) }}" style="width: 150px; height: 150px;"></img>
    @endif

  @endforeach
</div>