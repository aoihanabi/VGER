@component('mail::message')
# ¡Tu pedido se procesó con éxito!

Ya recibimos tu pedido, en un lapso de 2 a 3 días laborales estará listo para enviarlo. <br><br>
Te contactaremos tan pronto esté listo para realizar la transacción y ajustar los detalles del envío por el medio que prefieras. A continuación un resumen de tu pedido:

@component('mail::table')
| Artículo        |  Detalles       | Cantidad       | Precio   |
| :-------------- | :-------------- |:--------------:| --------:|
@foreach ($order_details as $prod)
| {{ $prod->name }} | {{ $prod->description }} | {{ $prod->purchased_quantity }} | ₡{{ number_format($prod->subtotal, 2, ".", " ") }} |
@endforeach
@endcomponent

## El total de la compra es ₡{{ number_format($order->total, 2, ".", " ") }}

@component('mail::button', ['url' => route('products')])
Seguir Comprando
@endcomponent

Gracias por preferirnos,<br>
{{ config('app.name') }}
@endcomponent
