<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php($productName = config('app.name') === 'Laravel' ? 'Admin Kit' : config('app.name', 'Admin Kit'))
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $productName }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="product-home">
    <div class="product-shell">
        <header class="product-nav">
            <a href="{{ url('/') }}" class="product-brand" aria-label="{{ $productName }}">
                <span class="product-brand-mark">A</span>
                <span>
                    <strong>{{ $productName }}</strong>
                    <small>Control room</small>
                </span>
            </a>

            <nav class="product-nav-links" aria-label="Navegación principal">
                <a href="#capacidades">Capacidades</a>
                <a href="#flujo">Cómo funciona</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="product-nav-action">Abrir panel <span aria-hidden="true">↗</span></a>
                    @else
                        <a href="{{ route('login') }}" class="product-nav-action">Entrar <span aria-hidden="true">↗</span></a>
                    @endauth
                @endif
            </nav>
        </header>

        <main>
            <section class="product-hero">
                <div class="hero-copy">
                    <p class="eyebrow"><span></span> Plataforma de gestión operativa</p>
                    <h1>Todo tu trabajo importante, <em>en un solo lugar.</em></h1>
                    <p class="hero-lead">Una base de administración clara para dirigir equipos, contenido y actividad sin perder el control de lo que ocurre.</p>

                    <div class="hero-actions">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="button button-dark">Ir al panel <span aria-hidden="true">→</span></a>
                            @else
                                <a href="{{ route('login') }}" class="button button-dark">Ver la aplicación <span aria-hidden="true">→</span></a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="button button-quiet">Crear cuenta</a>
                                @endif
                            @endauth
                        @endif
                    </div>

                    <div class="hero-note">
                        <span class="status-dot"></span>
                        <span>Lista para trabajar</span>
                        <span class="note-divider"></span>
                        <span>Roles, contenido y auditoría incluidos</span>
                    </div>
                </div>

                <div class="hero-preview" aria-label="Vista previa del panel de administración">
                    <div class="preview-glow"></div>
                    <div class="preview-window">
                        <div class="preview-topbar">
                            <div class="preview-brand"><span class="preview-logo">A</span><span>Admin control</span></div>
                            <div class="preview-top-actions"><span></span><span></span><b>AM</b></div>
                        </div>
                        <div class="preview-body">
                            <aside class="preview-sidebar">
                                <div class="preview-side-title">WORKSPACE</div>
                                <div class="preview-nav active"><i></i>Resumen</div>
                                <div class="preview-nav"><i></i>Usuarios</div>
                                <div class="preview-nav"><i></i>Contenido</div>
                                <div class="preview-nav"><i></i>Actividad</div>
                                <div class="preview-side-title lower">CONFIGURACIÓN</div>
                                <div class="preview-nav"><i></i>Preferencias</div>
                            </aside>
                            <div class="preview-content">
                                <div class="preview-heading"><div><small>Martes, 22 septiembre</small><h2>Buenos días, Admin</h2></div><span class="preview-pill">● Sistema operativo</span></div>
                                <div class="preview-stats">
                                    <div><small>USUARIOS</small><strong>1,248</strong><em>+12% este mes</em></div>
                                    <div><small>CONTENIDO</small><strong>486</strong><em>32 publicados hoy</em></div>
                                    <div><small>ACTIVIDAD</small><strong>94%</strong><em>Operación estable</em></div>
                                </div>
                                <div class="preview-chart">
                                    <div class="preview-chart-head"><b>Actividad reciente</b><span>Últimos 7 días</span></div>
                                    <div class="chart-bars"><i style="height: 36%"></i><i style="height: 54%"></i><i style="height: 44%"></i><i style="height: 70%"></i><i style="height: 58%"></i><i style="height: 84%"></i><i style="height: 74%"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="preview-tag tag-a"><b>01</b><span>Visión completa</span></div>
                    <div class="preview-tag tag-b"><b>02</b><span>Decisiones rápidas</span></div>
                </div>
            </section>

            <section id="capacidades" class="capabilities">
                <div class="section-intro"><p class="eyebrow"><span></span> Una base que crece contigo</p><h2>Menos ruido.<br><em>Más claridad.</em></h2></div>
                <div class="capability-grid">
                    <article><span class="cap-number">01</span><h3>Gobierna el acceso</h3><p>Roles y permisos para que cada persona vea exactamente lo que necesita.</p></article>
                    <article><span class="cap-number">02</span><h3>Entiende el pulso</h3><p>Actividad, métricas y notificaciones reunidas en un panel fácil de leer.</p></article>
                    <article><span class="cap-number">03</span><h3>Deja rastro</h3><p>Auditoría de acciones importantes para trabajar con confianza y contexto.</p></article>
                </div>
            </section>

            <section id="flujo" class="closing-banner">
                <div><p class="eyebrow"><span></span> Empieza ahora</p><h2>Tu operación merece<br><em>un lugar mejor.</em></h2></div>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="button button-light">Entrar al sistema <span aria-hidden="true">↗</span></a>
                @endif
            </section>
        </main>

        <footer class="product-footer"><span>{{ $productName }}</span><span>Gestión con intención · {{ date('Y') }}</span></footer>
    </div>
</body>
</html>
