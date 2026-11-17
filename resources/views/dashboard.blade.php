<!DOCTYPE html>
<html lang="es">
<head>
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

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 2;
            display: flex;
            width: 264px;
            flex-direction: column;
            padding: 1.5rem 1rem 1rem;
            color: #f5f8f2;
            background: var(--green-950);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.25rem 0.5rem 1.75rem;
            color: white;
            text-decoration: none;
        }

        .brand-mark {
            display: grid;
            width: 2.5rem;
            height: 2.5rem;
            flex: 0 0 auto;
            place-items: center;
            border: 1px solid rgb(255 255 255 / 18%);
            border-radius: 0.75rem;
            color: #d7edc9;
            background: rgb(255 255 255 / 9%);
        }

        .brand-mark svg {
            width: 1.35rem;
            height: 1.35rem;
        }

        .brand-name {
            display: block;
            font-size: 0.94rem;
            font-weight: 800;
            letter-spacing: 0.025em;
        }

        .brand-caption {
            display: block;
            margin-top: 0.25rem;
            color: #c1d7b8;
            font-size: 0.72rem;
        }

        .nav-label {
            margin: 0 0.7rem 0.65rem;
            color: #a5cd8e;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .menu {
            display: grid;
            gap: 0.3rem;
        }

        .menu a {
            display: flex;
            min-height: 2.8rem;
            align-items: center;
            gap: 0.8rem;
            padding: 0.7rem 0.75rem;
            border-radius: 0.65rem;
            color: #dce8d8;
            font-size: 0.88rem;
            text-decoration: none;
            transition: background-color 150ms ease, color 150ms ease;
        }

        .menu a:hover,
        .menu a:focus-visible {
            color: white;
            background: rgb(255 255 255 / 9%);
        }

        .menu a.active {
            color: white;
            background: #287b2d;
            box-shadow: inset 3px 0 #c5e5ae;
        }

        .menu svg {
            width: 1.15rem;
            height: 1.15rem;
            flex: 0 0 auto;
            opacity: 0.9;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .sidebar-divider {
            height: 1px;
            margin: 1rem 0;
            border: 0;
            background: rgb(255 255 255 / 13%);
        }

        .profile {
            overflow: hidden;
            padding: 0.65rem 0.7rem;
            border: 1px solid rgb(255 255 255 / 12%);
            border-radius: 0.7rem;
            background: rgb(255 255 255 / 6%);
        }

        .profile-name,
        .profile-email {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-name {
            font-size: 0.82rem;
            font-weight: 700;
        }

        .profile-email {
            margin-top: 0.25rem;
            color: #c1d7b8;
            font-size: 0.72rem;
        }

        .logout {
            width: 100%;
            margin-top: 0.65rem;
            padding: 0.65rem 0.75rem;
            border: 1px solid rgb(255 255 255 / 15%);
            border-radius: 0.65rem;
            color: #f5f8f2;
            background: transparent;
            cursor: pointer;
            text-align: left;
            transition: background-color 150ms ease;
        }

        .logout:hover,
        .logout:focus-visible {
            background: rgb(255 255 255 / 9%);
        }

        .main {
            min-height: 100vh;
            margin-left: 264px;
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

        .view-site {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--green-900);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
        }

        .view-site:hover {
            color: var(--green-700);
            text-decoration: underline;
        }

        .view-site svg {
            width: 1rem;
            height: 1rem;
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
            gap: 0.55rem;
            padding: 0.75rem 1rem;
            border: 1px solid rgb(255 255 255 / 35%);
            border-radius: 0.65rem;
            color: white;
            background: rgb(255 255 255 / 9%);
            font-size: 0.83rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 150ms ease;
        }

        .welcome-action:hover,
        .welcome-action:focus-visible {
            background: rgb(255 255 255 / 17%);
        }

        .welcome-action svg {
            width: 1rem;
            height: 1rem;
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
            gap: 0.4rem;
            margin-top: auto;
            padding-top: 1.1rem;
            color: var(--green-900);
            font-size: 0.82rem;
            font-weight: 700;
            text-decoration: none;
        }

        .card-link:hover {
            color: var(--green-700);
            text-decoration: underline;
        }

        .card-link svg {
            width: 0.95rem;
            height: 0.95rem;
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
            .sidebar {
                width: 224px;
            }

            .main {
                margin-left: 224px;
                padding-inline: 1.4rem;
            }

            .welcome {
                align-items: flex-start;
                flex-direction: column;
                gap: 1.25rem;
            }
        }

        @media (max-width: 680px) {
            .sidebar {
                position: static;
                width: auto;
                padding: 0.9rem 1rem;
            }

            .brand {
                padding: 0.15rem 0.25rem 0.8rem;
            }

            .nav-label,
            .sidebar-bottom,
            .menu a:first-child {
                display: none;
            }

            .menu {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .menu a {
                min-height: 2.55rem;
                justify-content: center;
                padding: 0.55rem;
                font-size: 0.78rem;
            }

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
    <div class="app-shell">
        <aside class="sidebar">
            <a class="brand" href="{{ route('dashboard') }}">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 4c-8 0-14 3.5-14 10a6 6 0 0 0 6 6c6.5 0 8-7 8-16Z"/>
                        <path d="M4 21c2-5 5.5-8.5 11-11"/>
                    </svg>
                </span>
                <span>
                    <span class="brand-name">SDS 2026 · GREEN IoT</span>
                    <span class="brand-caption">UES · Facultad Multidisciplinaria Oriental</span>
                </span>
            </a>

            <p class="nav-label">Administración</p>
            <nav class="menu" aria-label="Menú principal">
                <a class="active" href="{{ route('dashboard') }}" aria-current="page">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-6v-7h-4v7H4a1 1 0 0 1-1-1z"/>
                    </svg>
                    Panel principal
                </a>
                <a href="{{ route('publications.index') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 4h14a2 2 0 0 1 2 2v14H7a4 4 0 0 1-4-4V6a2 2 0 0 1 2-2Z"/>
                        <path d="M7 20a3 3 0 0 1 0-6h14M8 8h8M8 11h6"/>
                    </svg>
                    Publicaciones
                </a>
                <a href="{{ route('evidences.index') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M4 5h6l2 2h8a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Z"/>
                        <path d="M12 11v6m-2-2 2 2 2-2"/>
                    </svg>
                    Evidencias
                </a>
                <a href="{{ route('blog.index') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 3h7v7M10 14 21 3M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/>
                    </svg>
                    Ver sitio público
                </a>
            </nav>

            <div class="sidebar-bottom">
                <hr class="sidebar-divider">
                <div class="profile" aria-label="Cuenta activa">
                    <p class="profile-name">{{ $usuario->name }}</p>
                    <p class="profile-email">{{ $usuario->email }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout" type="submit">Cerrar sesión</button>
                </form>
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <p class="breadcrumb">SDS 2026 <span aria-hidden="true">/</span> <strong>Panel principal</strong></p>
                <a class="view-site" href="{{ route('blog.index') }}">
                    Ver blog público
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 3h7v7M10 14 21 3M19 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6"/>
                    </svg>
                </a>
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
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </a>
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
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
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M5 12h14m-6-6 6 6-6 6"/>
                                </svg>
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
