<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php($productName = config('app.name') === 'Laravel' ? 'Admin Kit' : config('app.name', 'Admin Kit'))
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $productName }} · {{ request()->routeIs('register') ? 'Crear cuenta' : 'Acceso' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="guest-home">
    <div class="guest-shell">
        <aside class="guest-aside">
            <a href="{{ url('/') }}" class="guest-brand">
                <span class="product-brand-mark">A</span>
                <span>
                    <strong>{{ $productName }}</strong>
                    <small>Control room</small>
                </span>
            </a>

            <div class="guest-aside-copy">
                <p class="eyebrow"><span></span> {{ request()->routeIs('register') ? 'Empieza con orden' : 'Tu espacio de control' }}</p>
                <h1>{{ request()->routeIs('register') ? 'Una mejor forma de trabajar empieza aquí.' : 'Vuelve a tener el control.' }}</h1>
                <p>{{ request()->routeIs('register') ? 'Crea tu cuenta y organiza usuarios, contenido y actividad desde un único lugar.' : 'Accede a una vista clara de tu operación, tus equipos y todo lo que está pasando.' }}</p>
            </div>

            <div class="guest-aside-footer">
                <span class="guest-status"><i></i> Sistema operativo</span>
                <span>Roles · Contenido · Auditoría</span>
            </div>
        </aside>

        <main class="guest-main">
            <div class="guest-topline">
                <span>{{ request()->routeIs('register') ? 'Nuevo espacio' : 'Acceso seguro' }}</span>
                <a href="{{ url('/') }}">Volver al inicio <span aria-hidden="true">↗</span></a>
            </div>

            <div class="guest-card">
                <div class="guest-heading">
                    <p class="eyebrow"><span></span> {{ request()->routeIs('register') ? 'Registro' : 'Bienvenido' }}</p>
                    <h2>{{ request()->routeIs('register') ? 'Crea tu cuenta' : 'Inicia sesión' }}</h2>
                    <p>{{ request()->routeIs('register') ? 'Tardarás menos de un minuto.' : 'Continúa donde lo dejaste.' }}</p>
                </div>
                {{ $slot }}
            </div>

            <p class="guest-legal">Al continuar aceptas el uso responsable de la plataforma.</p>
        </main>
    </div>
</body>
</html>
