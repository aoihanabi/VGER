<h1>{{ $prod->prd_name }}</h1>
<div>
  <li>{{ $prod->prd_description }}</li>
  <li>{{ $prod->prd_quantity }}</li>
  <li>{{ $prod->prd_price }}</li>  
</div>

<div>
  @foreach ($imgs as $m)
    @if ($m->img_type == 'PR')
      <img src="{{ url($m->img_url) }}" style="width: 400px; height: 300px;"></img><br>
    @else 
      <img src="{{ url($m->img_url) }}" style="width: 150px; height: 150px;"></img>
    @endif

  @endforeach
</div>