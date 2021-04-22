@component('mail::message')

<img src="https://dummyimage.com/200x150/000/fff.png" style="display: block; margin-left: auto; margin-right: auto;" alt="App Logo"></img>
<br>
<!-- {{ asset('images/logos/VGER_LOGO.jpg') }} -->
# ¡Bienvenido/a {{ $user['name'] }}!

Tu cuenta en Ventas Gerizim se creó con éxito! <br><br>
Usa esta contraseña para acceder: <br> 

@component('mail::panel')
**{{ $user['pass'] }}** <br>
@endcomponent

Asegúrate de cambiarla tras ingresar a la página, para garantizar la seguridad de tu cuenta.

@component('mail::button', ['url' => route('login')])
Ingresa ahora
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
