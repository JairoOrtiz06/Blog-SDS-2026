<!DOCTYPE html>
<html lang="es">
<head>
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
            padding: 1.25rem;
            border: 1px solid #e1eadc;
            border-radius: 0.9rem;
            background: white;
        }

        .topbar {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        h1,
        h2 {
            color: #173a1d;
        }

        h1 {
            margin: 0;
        }

        .topbar p,
        .metadata {
            color: #526052;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 0.75rem 1rem;
            border-radius: 999px;
            color: white;
            background: #287b2d;
            font-weight: 700;
            text-decoration: none;
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
        }

        .publication-card h2 {
            margin: 0 0 0.4rem;
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

        .state {
            display: inline-block;
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
            color: #205f26;
            background: #eff9e9;
            font-size: 0.85rem;
            font-weight: 700;
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
    <main>
        <header class="topbar">
            <div>
                <p><a href="{{ route('dashboard') }}">← Volver al panel</a></p>
                <h1>Administrar publicaciones</h1>
                <p>Redacta contenido, guarda borradores o publícalo en el blog.</p>
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
                            {{ $publication->category ?: 'Sin categoría' }}
                            · Actualizada {{ $publication->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div class="actions">
                        @if ($publication->status === 'draft')
                            <span class="state">Borrador</span>
                        @elseif (! $isPublic)
                            <span class="state">Programada</span>
                        @else
                            <span class="state">Publicada</span>
                            <a href="{{ route('blog.show', $publication->slug) }}">Ver en el blog</a>
                        @endif
                        <a href="{{ route('publications.edit', $publication) }}">Editar</a>
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
