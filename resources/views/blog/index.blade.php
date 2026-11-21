<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <meta name="description" content="Noticias, ideas y contenido sobre Green IoT y la Semana de Sistemas 2026 de la UES-FMO.">
    <link rel="canonical" href="{{ route('blog.index') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_SV">
    <meta property="og:site_name" content="SDS 2026 · GREEN IoT">
    <meta property="og:title" content="Publicaciones SDS 2026">
    <meta property="og:description" content="Noticias, ideas y contenido sobre Green IoT y la Semana de Sistemas 2026 de la UES-FMO.">
    <meta property="og:url" content="{{ route('blog.index') }}">
    <meta property="og:image" content="{{ asset('images/logo-sds-green-iot.png') }}">
    <meta property="og:image:alt" content="Logotipo SDS 2026 Green IoT">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Publicaciones SDS 2026">
    <meta name="twitter:description" content="Noticias, ideas y contenido sobre Green IoT y la Semana de Sistemas 2026 de la UES-FMO.">
    <meta name="twitter:image" content="{{ asset('images/logo-sds-green-iot.png') }}">
    <title>Publicaciones | SDS 2026</title>
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

        a {
            color: #236c2a;
        }

        .site-header,
        main {
            width: min(1120px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .site-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 0;
        }

        .brand {
            color: #174b20;
            font-weight: 800;
            text-decoration: none;
        }

        .header-links {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .intro {
            padding: 2rem 0 1.25rem;
        }

        .intro p {
            max-width: 42rem;
            color: #526052;
            line-height: 1.7;
        }

        h1,
        h2 {
            color: #173a1d;
        }

        .filters {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(180px, 0.4fr) auto auto;
            gap: 0.75rem;
            padding: 1rem;
            border: 1px solid #e1eadc;
            border-radius: 0.9rem;
            background: white;
        }

        input,
        select,
        button,
        .clear-filter {
            min-height: 2.8rem;
            padding: 0.65rem 0.85rem;
            border: 1px solid #cbd9c5;
            border-radius: 0.55rem;
            font: inherit;
        }

        button {
            border-color: #287b2d;
            color: white;
            background: #287b2d;
            font-weight: 700;
            cursor: pointer;
        }

        .clear-filter {
            display: inline-flex;
            align-items: center;
            color: #205f26;
            text-decoration: none;
        }

        .publication-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 1.25rem;
            margin: 1.5rem 0 3rem;
        }

        .publication-card,
        .empty-state {
            overflow: hidden;
            border: 1px solid #e1eadc;
            border-radius: 0.9rem;
            background: white;
        }

        .publication-card img {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            object-fit: cover;
        }

        .publication-card .image-zoom-trigger {
            display: block;
            width: 100%;
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            cursor: zoom-in;
        }

        .publication-card-body {
            padding: 1.15rem;
        }

        .category {
            color: #368b2d;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .publication-card h2 {
            margin: 0.5rem 0;
            font-size: 1.2rem;
        }

        .publication-card h2 a {
            color: inherit;
            text-decoration: none;
        }

        .publication-card p,
        .publication-date {
            color: #526052;
            line-height: 1.6;
        }

        .empty-state {
            grid-column: 1 / -1;
            padding: 2rem;
            color: #526052;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .pagination a {
            text-decoration: none;
        }

        @media (max-width: 800px) {
            .publication-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .filters,
            .publication-grid {
                grid-template-columns: 1fr;
            }

            .header-links {
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        <section class="intro">
            <p class="category">Semana de Sistemas · UES-FMO</p>
            <h1>Publicaciones SDS 2026</h1>
            <p>Noticias, ideas y contenido sobre Green IoT y la Semana de Sistemas.</p>
        </section>

        <form class="filters" action="{{ route('blog.index') }}" method="GET">
            <input
                type="search"
                name="q"
                value="{{ $filters['q'] ?? '' }}"
                placeholder="Buscar publicaciones..."
                aria-label="Buscar publicaciones"
            >
            <select name="category" aria-label="Filtrar por categoría">
                <option value="">Todas las categorías</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected((string) ($filters['category'] ?? '') === (string) $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Buscar</button>
            @if (! empty($filters['q']) || ! empty($filters['category']))
                <a class="clear-filter" href="{{ route('blog.index') }}">Limpiar</a>
            @endif
        </form>

        <section class="publication-grid" aria-label="Listado de publicaciones">
            @forelse ($publications as $publication)
                <article class="publication-card">
                    @php
                        $coverPath = $publication->images->first()?->path ?? $publication->image_path;
                    @endphp
                    @if ($coverPath)
                        <button
                            class="image-zoom-trigger"
                            type="button"
                            data-image-zoom
                            data-image-src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverPath) }}"
                            data-image-alt="Imagen de {{ $publication->title }}"
                            aria-label="Ampliar imagen de {{ $publication->title }}"
                        >
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($coverPath) }}"
                                alt=""
                                loading="lazy"
                            >
                        </button>
                    @endif
                    <div class="publication-card-body">
                        @if ($publication->category)
                            <span class="category">{{ $publication->category->name }}</span>
                        @endif
                        <h2>
                            <a href="{{ route('blog.show', $publication->slug) }}">
                                {{ $publication->title }}
                            </a>
                        </h2>
                        @if ($publication->excerpt)
                            <p>{{ $publication->excerpt }}</p>
                        @else
                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($publication->content), 160) }}</p>
                        @endif
                        @if ($publication->activity_date)
                            <time class="publication-date" datetime="{{ $publication->activity_date->toDateString() }}">
                                {{ $publication->activity_date->format('d/m/Y') }}
                            </time>
                        @endif
                    </div>
                </article>
            @empty
                <p class="empty-state">
                    @if (! empty($filters['q']) || ! empty($filters['category']))
                        No encontramos publicaciones con esos filtros.
                    @else
                        Aún no hay publicaciones disponibles. Vuelve pronto.
                    @endif
                </p>
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
    <x-image-lightbox />
</body>
</html>
