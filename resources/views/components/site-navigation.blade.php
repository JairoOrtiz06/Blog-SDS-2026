<style>
    .global-site-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        max-width: 1280px;
        margin: 0 auto;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgb(23 58 29 / 8%);
    }

    .global-site-brand {
        display: inline-flex;
        flex: 0 0 auto;
        align-items: center;
        gap: 0.7rem;
        color: #173a1d;
        font-size: 0.94rem;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-decoration: none;
    }

    .global-site-brand-mark {
        display: grid;
        width: 2.45rem;
        height: 2.45rem;
        place-items: center;
        border: 1px solid #d5e5ce;
        border-radius: 0.75rem;
        color: #287b2d;
        background: white;
    }

    .global-site-brand-mark svg {
        width: 1.3rem;
        height: 1.3rem;
    }

    .global-site-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        justify-content: flex-end;
        gap: 0.65rem;
    }

    .global-site-link {
        display: inline-flex;
        width: auto;
        min-height: 2.65rem;
        align-items: center;
        justify-content: center;
        padding: 0.6rem 0.95rem;
        border: 1px solid #ccddc5;
        border-radius: 0.65rem;
        color: #205f26;
        background: transparent;
        font: inherit;
        font-size: 0.84rem;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: background-color 150ms ease, border-color 150ms ease;
    }

    .global-site-link:hover,
    .global-site-link:focus-visible {
        border-color: #287b2d;
        background: #eff9e9;
    }

    .global-site-link-primary {
        border-color: #287b2d;
        color: white;
        background: #287b2d;
    }

    .global-site-link-primary:hover,
    .global-site-link-primary:focus-visible {
        color: white;
        background: #1d5e25;
    }

    .global-site-actions form {
        margin: 0;
    }

    .global-back-button {
        display: inline-flex;
        min-height: 2.8rem;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        padding: 0.7rem 1rem;
        border: 1px solid #ccddc5;
        border-radius: 0.65rem;
        color: #205f26;
        background: white;
        font: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        text-decoration: none;
        transition: background-color 150ms ease, border-color 150ms ease;
    }

    .global-back-button:hover,
    .global-back-button:focus-visible {
        border-color: #287b2d;
        background: #eff9e9;
    }

    .global-back-button:focus-visible {
        outline: 3px solid rgb(85 169 39 / 35%);
        outline-offset: 2px;
    }

    @media (max-width: 1100px) {
        .global-site-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 0.85rem 1rem;
        }

        .global-site-actions {
            width: 100%;
            justify-content: flex-start;
            gap: 0.5rem;
        }

        .global-site-link {
            min-height: 2.45rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }
    }
</style>

<header class="global-site-header mx-auto flex max-w-7xl items-center justify-between gap-4">
    <a class="global-site-brand" href="{{ route('home') }}">
        <span class="global-site-brand-mark" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 4c-8 0-14 3.5-14 10a6 6 0 0 0 6 6c6.5 0 8-7 8-16Z"/>
                <path d="M4 21c2-5 5.5-8.5 11-11"/>
            </svg>
        </span>
        SDS 2026 · GREEN IoT
    </a>

    <nav class="global-site-actions flex flex-wrap items-center justify-end gap-2" aria-label="Navegación principal">
        <a class="global-site-link" href="{{ route('home') }}">Inicio</a>
        <a class="global-site-link" href="{{ route('home') }}#patrocinadores">Patrocinadores</a>
        <a class="global-site-link" href="{{ route('blog.index') }}">Publicaciones</a>
        @guest
            <a class="global-site-link" href="{{ route('login') }}">Iniciar sesión</a>
        @else
            @if (auth()->user()->isAdmin())
                <a class="global-site-link" href="{{ route('dashboard') }}">Panel administrativo</a>
                <a class="global-site-link" href="{{ route('categories.index') }}">Categorías</a>
                <a class="global-site-link" href="{{ route('evidences.index') }}">Evidencias</a>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="global-site-link" type="submit">Cerrar sesión</button>
            </form>
        @endguest
    </nav>
</header>
