<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>{{ $publication->title }} | SDS 2026</title>
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
            width: min(900px, calc(100% - 2rem));
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

        article {
            margin: 2rem 0 4rem;
            padding: clamp(1.25rem, 5vw, 3rem);
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
        }

        h1 {
            margin: 0.75rem 0;
            color: #173a1d;
            font-size: clamp(2rem, 6vw, 3.5rem);
            line-height: 1.1;
        }

        .category {
            color: #368b2d;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .date,
        .excerpt {
            color: #526052;
        }

        .excerpt {
            font-size: 1.15rem;
            line-height: 1.7;
        }

        .cover {
            display: block;
            width: 100%;
            max-height: 32rem;
            border-radius: 0.75rem;
            object-fit: cover;
        }

        .article-image {
            margin: 1.5rem 0;
        }

        .article-image .image-zoom-trigger {
            display: block;
            width: 100%;
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            cursor: zoom-in;
        }

        .content {
            color: #344234;
            font-size: 1.05rem;
            line-height: 1.85;
            white-space: pre-line;
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <header class="site-header">
        <a class="brand" href="{{ route('home') }}">SDS 2026 · GREEN IoT</a>
        <nav class="header-links" aria-label="Navegación">
            <a href="{{ route('blog.index') }}">Publicaciones</a>
            @guest
                <a href="{{ route('register') }}">Crear cuenta</a>
                <a href="{{ route('login') }}">Iniciar sesión</a>
            @else
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('dashboard') }}">Panel administrativo</a>
                @endif
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            @endguest
        </nav>
    </header>

    <main>
        <article>
            @if ($publication->category)
                <p class="category">{{ $publication->category }}</p>
            @endif
            <h1>{{ $publication->title }}</h1>
            @if ($publication->published_at)
                <time class="date" datetime="{{ $publication->published_at->toDateString() }}">
                    {{ $publication->published_at->format('d/m/Y') }}
                </time>
            @endif
            @if ($publication->excerpt)
                <p class="excerpt">{{ $publication->excerpt }}</p>
            @endif
            @foreach ($publication->images as $image)
                <div class="article-image">
                    <button
                        class="image-zoom-trigger"
                        type="button"
                        data-image-zoom
                        data-image-src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}"
                        data-image-alt="{{ $image->original_filename }}"
                        aria-label="Ampliar imagen {{ $image->original_filename }}"
                    >
                        <img
                            class="cover"
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}"
                            alt=""
                        >
                    </button>
                </div>
            @endforeach
            @if ($publication->images->isEmpty() && $publication->image_path)
                <div class="article-image">
                    <button
                        class="image-zoom-trigger"
                        type="button"
                        data-image-zoom
                        data-image-src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($publication->image_path) }}"
                        data-image-alt="Imagen de {{ $publication->title }}"
                        aria-label="Ampliar imagen de {{ $publication->title }}"
                    >
                        <img
                            class="cover"
                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($publication->image_path) }}"
                            alt=""
                        >
                    </button>
                </div>
            @endif
            <div class="content">{{ $publication->content }}</div>
            <a class="back-link" href="{{ route('blog.index') }}">← Volver a publicaciones</a>
        </article>
    </main>
    <x-image-lightbox />
</body>
</html>
