<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#173a1d">
    <title>Panel de gestión | SDS 2026</title>

    <style>
        :root {
            color-scheme: light;
            font-family: Arial, Helvetica, sans-serif;
            color: #172117;
            background: #f5f8f2;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            --green-950: #173a1d;
            --green-900: #205f26;
            --green-700: #287b2d;
            --green-100: #eaf4e5;
            --green-50: #f5f8f2;
            --text-muted: #637163;
            --border: #e1eadc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-width: 320px;
            min-height: 100vh;
            margin: 0;
        }

        a {
            color: inherit;
        }

        button {
            font: inherit;
        }

        .app-shell {
            min-height: 100vh;
        }

        .main {
            min-height: 100vh;
            margin-left: 0;
            padding: 0 clamp(1.25rem, 4vw, 3.5rem) 2rem;
        }

        .topbar {
            display: flex;
            min-height: 4.5rem;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            border-bottom: 1px solid var(--border);
        }

        .breadcrumb {
            color: var(--text-muted);
            font-size: 0.82rem;
        }

        .breadcrumb strong {
            color: var(--green-950);
        }

        .content {
            width: min(1120px, 100%);
            margin: 0 auto;
        }

        .welcome {
            position: relative;
            display: flex;
            min-height: 208px;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            overflow: hidden;
            margin: 2rem 0 1.75rem;
            padding: clamp(1.5rem, 4vw, 2.75rem);
            border-radius: 1rem;
            color: white;
            background:
                radial-gradient(ellipse at 92% 18%, rgb(133 187 90 / 32%), transparent 32%),
                linear-gradient(115deg, #173a1d, #205f26 72%, #287b2d);
        }

        .welcome::after {
            position: absolute;
            top: -4.5rem;
            right: 8%;
            width: 17rem;
            height: 17rem;
            border: 1px solid rgb(255 255 255 / 13%);
            border-radius: 50%;
            box-shadow: 0 0 0 2.1rem rgb(255 255 255 / 4%), 0 0 0 4.2rem rgb(255 255 255 / 3%);
            content: "";
            pointer-events: none;
        }

        .welcome-copy,
        .welcome-action {
            position: relative;
            z-index: 1;
        }

        .eyebrow {
            margin-bottom: 0.7rem;
            color: #c9e6b8;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
        }

        .welcome h1 {
            max-width: 18ch;
            font-size: clamp(1.65rem, 3vw, 2.3rem);
            letter-spacing: -0.035em;
            line-height: 1.12;
        }

        .welcome p {
            max-width: 39rem;
            margin-top: 0.8rem;
            color: #e1eedc;
            font-size: 0.92rem;
            line-height: 1.65;
        }

        .welcome-action {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            min-height: 2.9rem;
            padding: 0.75rem 1.15rem;
            border: 1px solid white;
            border-radius: 0.65rem;
            color: var(--green-950);
            background: white;
            font-size: 0.83rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 150ms ease, transform 150ms ease;
        }

        .welcome-action:hover,
        .welcome-action:focus-visible {
            background: #eaf4e5;
            transform: translateY(-1px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            min-width: 0;
            padding: 1.15rem 1.25rem;
            border: 1px solid var(--border);
            border-radius: 0.85rem;
            background: white;
            box-shadow: 0 3px 12px rgb(23 58 29 / 3%);
        }

        .stat-label {
            display: block;
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .stat-value {
            display: block;
            margin-top: 0.55rem;
            color: var(--green-950);
            font-size: clamp(1.7rem, 3vw, 2.2rem);
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1;
        }

        .stat-detail {
            display: block;
            margin-top: 0.55rem;
            color: var(--text-muted);
            font-size: 0.72rem;
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 1rem;
            margin: 0 0 1rem;
        }

        .section-heading h2 {
            color: var(--green-950);
            font-size: 1.12rem;
            letter-spacing: -0.02em;
        }

        .section-heading p {
            margin-top: 0.35rem;
            color: var(--text-muted);
            font-size: 0.82rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .card {
            display: flex;
            min-height: 216px;
            flex-direction: column;
            align-items: flex-start;
            padding: 1.35rem;
            border: 1px solid var(--border);
            border-radius: 0.85rem;
            background: white;
            box-shadow: 0 3px 12px rgb(23 58 29 / 3%);
            transition: border-color 150ms ease, box-shadow 150ms ease, transform 150ms ease;
        }

        .card:hover {
            transform: translateY(-2px);
            border-color: #b7dca8;
            box-shadow: 0 9px 22px rgb(23 58 29 / 8%);
        }

        .card-icon {
            display: grid;
            width: 2.6rem;
            height: 2.6rem;
            place-items: center;
            border: 1px solid #dcebd4;
            border-radius: 0.7rem;
            color: var(--green-700);
            background: var(--green-50);
        }

        .card-icon svg {
            width: 1.3rem;
            height: 1.3rem;
        }

        .card h3 {
            margin-top: 1rem;
            color: var(--green-950);
            font-size: 1rem;
        }

        .card p {
            max-width: 34rem;
            margin-top: 0.45rem;
            color: var(--text-muted);
            font-size: 0.83rem;
            line-height: 1.6;
        }

        .card-link {
            display: inline-flex;
            align-items: center;
            margin-top: auto;
            padding: 0.65rem 0.85rem;
            border: 1px solid #d5e5ce;
            border-radius: 0.55rem;
            color: var(--green-900);
            background: #fbfdf9;
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
            transition: border-color 150ms ease, background-color 150ms ease;
        }

        .card-link:hover,
        .card-link:focus-visible {
            border-color: #9dc78d;
            background: var(--green-100);
        }

        .card-link:focus-visible,
        .welcome-action:focus-visible {
            outline: 3px solid rgb(85 169 39 / 38%);
            outline-offset: 3px;
        }

        .account-details {
            display: grid;
            width: 100%;
            grid-template-columns: 1fr auto;
            gap: 0.45rem 1rem;
            margin-top: 1rem;
            padding-top: 0.85rem;
            border-top: 1px solid #edf2e9;
            font-size: 0.78rem;
        }

        .account-details dt {
            color: var(--text-muted);
        }

        .account-details dd {
            overflow: hidden;
            color: #344234;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .footer {
            margin-top: 2.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border);
            color: #80917f;
            font-size: 0.73rem;
            line-height: 1.6;
            text-align: center;
        }

        @media (max-width: 900px) {
            .main {
                margin-left: 0;
                padding-inline: 1.4rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .welcome {
                align-items: flex-start;
                flex-direction: column;
                gap: 1.25rem;
            }
        }

        @media (max-width: 680px) {
            .main {
                min-height: auto;
                margin-left: 0;
                padding: 0 1rem 1.5rem;
            }

            .topbar {
                min-height: 3.75rem;
            }

            .welcome {
                min-height: 0;
                margin: 1.25rem 0 1.5rem;
                padding: 1.4rem;
            }

            .welcome::after {
                right: -9rem;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                gap: 0.7rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .card {
                min-height: 195px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <div class="app-shell">
        <main class="main">
            <header class="topbar">
                <p class="breadcrumb">SDS 2026 <span aria-hidden="true">/</span> <strong>Panel principal</strong></p>
            </header>

            <div class="content">
                <section class="welcome" aria-labelledby="welcome-title">
                    <div class="welcome-copy">
                        <p class="eyebrow">Espacio de gestión · Semana de Sistemas</p>
                        <h1 id="welcome-title">Bienvenido, {{ $usuario->name }}</h1>
                        <p>Administra las publicaciones y evidencias de la Semana de Sistemas desde un solo lugar.</p>
                    </div>
                    <a class="welcome-action" href="{{ route('publications.create') }}">
                        Nueva publicación
                    </a>
                </section>

                <section class="stats-grid" aria-label="Resumen del contenido">
                    <article class="stat-card">
                        <span class="stat-label">Publicaciones</span>
                        <strong class="stat-value" data-stat="publications">{{ $publicationsCount }}</strong>
                        <span class="stat-detail">Entradas en total</span>
                    </article>
                    <article class="stat-card">
                        <span class="stat-label">Publicadas</span>
                        <strong class="stat-value" data-stat="published">{{ $publishedCount }}</strong>
                        <span class="stat-detail">Visibles en el blog</span>
                    </article>
                    <article class="stat-card">
                        <span class="stat-label">Borradores</span>
                        <strong class="stat-value" data-stat="drafts">{{ $draftsCount }}</strong>
                        <span class="stat-detail">Pendientes de publicar</span>
                    </article>
                    <article class="stat-card">
                        <span class="stat-label">Evidencias</span>
                        <strong class="stat-value" data-stat="evidences">{{ $evidencesCount }}</strong>
                        <span class="stat-detail">Archivos registrados</span>
                    </article>
                </section>

                <section aria-labelledby="tools-title">
                    <div class="section-heading">
                        <div>
                            <h2 id="tools-title">Herramientas de administración</h2>
                            <p>Elige una sección para continuar.</p>
                        </div>
                    </div>

                    <div class="cards">
                        <article class="card">
                            <span class="card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 4h14a2 2 0 0 1 2 2v14H7a4 4 0 0 1-4-4V6a2 2 0 0 1 2-2Z"/>
                                    <path d="M7 20a3 3 0 0 1 0-6h14M8 8h8M8 11h6"/>
                                </svg>
                            </span>
                            <h3>Publicaciones</h3>
                            <p>Redacta noticias, administra borradores y publica contenido en el blog.</p>
                            <a class="card-link" href="{{ route('publications.index') }}">
                                Administrar publicaciones
                            </a>
                        </article>

                        <article class="card">
                            <span class="card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 5h6l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                                    <path d="M12 11v6m-2-2 2 2 2-2"/>
                                </svg>
                            </span>
                            <h3>Evidencias</h3>
                            <p>Registra y consulta archivos de respaldo relacionados con las actividades.</p>
                            <a class="card-link" href="{{ route('evidences.index') }}">
                                Administrar evidencias
                            </a>
                        </article>

                        <article class="card" id="cuenta">
                            <span class="card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="8" r="4"/>
                                    <path d="M4 21a8 8 0 0 1 16 0"/>
                                </svg>
                            </span>
                            <h3>Cuenta activa</h3>
                            <p>Información de la cuenta que tiene abierta la sesión administrativa.</p>
                            <dl class="account-details">
                                <dt>Nombre</dt>
                                <dd>{{ $usuario->name }}</dd>
                                <dt>Correo</dt>
                                <dd>{{ $usuario->email }}</dd>
                            </dl>
                        </article>

                        <article class="card">
                            <span class="card-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 21h18M5 21V7l7-4 7 4v14M9 10h.01M15 10h.01M9 14h.01M15 14h.01M10 21v-4h4v4"/>
                                </svg>
                            </span>
                            <h3>Semana de Sistemas 2026</h3>
                            <p>Plataforma informativa de actividades y contenido académico de la UES-FMO.</p>
                            <a class="card-link" href="{{ route('home') }}">
                                Ir al inicio del sitio
                            </a>
                        </article>
                    </div>
                </section>

                <footer class="footer">
                    Universidad de El Salvador · Facultad Multidisciplinaria Oriental · Semana de Sistemas 2026
                </footer>
            </div>
        </main>
    </div>
</body>
</html>
