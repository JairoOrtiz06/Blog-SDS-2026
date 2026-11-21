<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>Categorías | SDS 2026</title>
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
            padding: clamp(1.25rem, 4vw, 2rem);
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 12px 36px rgb(23 58 29 / 7%);
        }

        .topbar,
        .category-row,
        .actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .topbar {
            margin-bottom: 1.5rem;
        }

        h1 {
            margin: 0.25rem 0 0.5rem;
            color: #173a1d;
        }

        .eyebrow,
        .metadata {
            color: #526052;
        }

        .eyebrow {
            margin: 0;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .category-row {
            padding: 1rem 0;
            border-top: 1px solid #edf2e9;
        }

        .category-row h2,
        .metadata {
            margin: 0.25rem 0;
        }

        .button,
        .action-link,
        button {
            display: inline-flex;
            min-height: 2.5rem;
            align-items: center;
            justify-content: center;
            padding: 0.55rem 0.85rem;
            border: 1px solid #287b2d;
            border-radius: 0.6rem;
            color: white;
            background: #287b2d;
            font: inherit;
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .action-link {
            border-color: #d5e5ce;
            color: #205f26;
            background: white;
        }

        .actions form {
            margin: 0;
        }

        .delete-button {
            border-color: #e8caca;
            color: #a22b2b;
            background: white;
        }

        .status-message,
        .errors {
            padding: 0.85rem 1rem;
            border-radius: 0.6rem;
            background: #eff9e9;
        }

        .errors {
            color: #991b1b;
            background: #fef2f2;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 640px) {
            .topbar,
            .category-row {
                align-items: flex-start;
                flex-direction: column;
            }
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
                <h1>Categorías</h1>
                <p class="metadata">Organiza las actividades y clasifica las publicaciones.</p>
            </div>
            <a class="button" href="{{ route('categories.create') }}">Nueva categoría</a>
        </header>

        @if (session('status'))
            <p class="status-message" role="status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="errors" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <section aria-label="Categorías registradas">
            @forelse ($categories as $category)
                <article class="category-row">
                    <div>
                        <h2>{{ $category->name }}</h2>
                        <p class="metadata">
                            {{ $category->publications_count }}
                            {{ $category->publications_count === 1 ? 'publicación' : 'publicaciones' }}
                        </p>
                    </div>
                    <div class="actions">
                        <a class="action-link" href="{{ route('categories.edit', $category) }}">Editar</a>
                        <form
                            action="{{ route('categories.destroy', $category) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar esta categoría?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="delete-button" type="submit">Eliminar</button>
                        </form>
                    </div>
                </article>
            @empty
                <p>Todavía no hay categorías registradas.</p>
            @endforelse
        </section>

        @if ($categories->hasPages())
            <nav class="pagination" aria-label="Paginación">
                @if ($categories->onFirstPage())
                    <span>Anterior</span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}">Anterior</a>
                @endif
                <span>Página {{ $categories->currentPage() }} de {{ $categories->lastPage() }}</span>
                @if ($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}">Siguiente</a>
                @else
                    <span>Siguiente</span>
                @endif
            </nav>
        @endif
    </main>
</body>
</html>
