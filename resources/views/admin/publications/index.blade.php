<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>Administrar publicaciones | SDS 2026</title>
    <style>
        :root {
            font-family: Arial, Helvetica, sans-serif;
            color: #172117;
            background: #f5f8f2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
        }

        main {
            width: min(1050px, calc(100% - 2rem));
            margin: 2rem auto;
        }

        .topbar,
        .publication-card,
        .empty-state {
            padding: 1.4rem;
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 5px 18px rgb(23 58 29 / 4%);
        }

        .topbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(120deg, #fff, #f8fbf6);
        }

        h1,
        h2 {
            color: #173a1d;
        }

        h1 {
            margin: 0.2rem 0 0;
            font-size: clamp(1.45rem, 3vw, 1.9rem);
            letter-spacing: -0.035em;
        }

        .eyebrow {
            margin: 0 0 0.25rem;
            color: #43813d;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .topbar .description,
        .metadata {
            color: #526052;
            line-height: 1.6;
        }

        .button {
            display: inline-flex;
            min-height: 2.8rem;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.1rem;
            border: 1px solid #287b2d;
            border-radius: 0.65rem;
            color: white;
            background: #287b2d;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 150ms ease, transform 150ms ease;
        }

        .button:hover,
        .button:focus-visible {
            background: #205f26;
            transform: translateY(-1px);
        }

        .toolbar-count {
            display: inline-block;
            margin-top: 0.6rem;
            padding: 0.3rem 0.6rem;
            border: 1px solid #e1eadc;
            border-radius: 999px;
            color: #526052;
            background: white;
            font-size: 0.76rem;
            font-weight: 700;
        }

        .status-message {
            padding: 0.9rem 1rem;
            border: 1px solid #b7dca8;
            border-radius: 0.65rem;
            color: #205f26;
            background: #eff9e9;
        }

        .publication-list {
            display: grid;
            gap: 1rem;
        }

        .publication-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .publication-card:hover {
            border-color: #c8ddbf;
            box-shadow: 0 9px 24px rgb(23 58 29 / 7%);
        }

        .publication-card h2 {
            margin: 0 0 0.4rem;
            font-size: 1.08rem;
            letter-spacing: -0.015em;
        }

        .metadata {
            margin: 0;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
        }

        .actions form {
            margin: 0;
        }

        .state {
            display: inline-block;
            padding: 0.4rem 0.7rem;
            border-radius: 999px;
            color: #526052;
            background: #f0f2ef;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .state--published {
            color: #205f26;
            background: #eff9e9;
        }

        .state--scheduled {
            color: #895c0b;
            background: #fff5d8;
        }

        .action-link {
            display: inline-flex;
            min-height: 2.4rem;
            align-items: center;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d5e5ce;
            border-radius: 0.55rem;
            color: #205f26;
            background: white;
            font-size: 0.83rem;
            font-weight: 700;
            text-decoration: none;
        }

        .action-link:hover,
        .action-link:focus-visible {
            border-color: #287b2d;
            background: #eff9e9;
        }

        button.action-link {
            color: #a22b2b;
            border-color: #e8caca;
            font: inherit;
            cursor: pointer;
        }

        button.action-link:hover,
        button.action-link:focus-visible {
            border-color: #a22b2b;
            background: #fff5f5;
        }

        .empty-state {
            color: #526052;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        a {
            color: #236c2a;
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        <header class="topbar">
            <div>
                <x-back-button href="{{ route('dashboard') }}" />
                <p class="eyebrow">Gestión de contenido</p>
                <h1>Publicaciones</h1>
                <p class="description">Redacta contenido, guarda borradores o publícalo en el blog.</p>
                <span class="toolbar-count">{{ $publications->total() }} registros</span>
            </div>
            <a class="button" href="{{ route('publications.create') }}">Nueva publicación</a>
        </header>

        @if (session('status'))
            <p class="status-message" role="status">{{ session('status') }}</p>
        @endif

        <section class="publication-list" aria-label="Publicaciones administradas">
            @forelse ($publications as $publication)
                @php
                    $isPublic = $publication->status === 'published'
                        && (! $publication->published_at || $publication->published_at->lte(now()));
                @endphp
                <article class="publication-card">
                    <div>
                        <h2>{{ $publication->title }}</h2>
                        <p class="metadata">
                            {{ $publication->category?->name ?: 'Sin categoría' }}
                            · Actividad: {{ $publication->activity_date?->format('d/m/Y') ?? 'Sin fecha' }}
                            · Actualizada {{ $publication->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="actions">
                        @if ($publication->status === 'draft')
                            <span class="state">Borrador</span>
                        @elseif (! $isPublic)
                            <span class="state state--scheduled">Programada</span>
                        @else
                            <span class="state state--published">Publicada</span>
                            <a class="action-link" href="{{ route('blog.show', $publication->slug) }}">Ver en el blog</a>
                        @endif
                        <a class="action-link" href="{{ route('publications.edit', $publication) }}">Editar</a>
                        <form
                            action="{{ route('publications.destroy', $publication) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar esta publicación y sus imágenes? Esta acción no se puede deshacer.')"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="action-link action-link--danger" type="submit">Eliminar</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-state">Todavía no hay publicaciones. Crea una para empezar.</p>
            @endforelse
        </section>

        @if ($publications->hasPages())
            <nav class="pagination" aria-label="Paginación">
                @if ($publications->onFirstPage())
                    <span>Anterior</span>
                @else
                    <a href="{{ $publications->previousPageUrl() }}">Anterior</a>
                @endif
                <span>Página {{ $publications->currentPage() }} de {{ $publications->lastPage() }}</span>
                @if ($publications->hasMorePages())
                    <a href="{{ $publications->nextPageUrl() }}">Siguiente</a>
                @else
                    <span>Siguiente</span>
                @endif
            </nav>
        @endif
    </main>
</body>
</html>
