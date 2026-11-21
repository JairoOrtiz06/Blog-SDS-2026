<!DOCTYPE html>
<html lang="es">
<head>
    @php
        $metaDescription = $publication->excerpt
            ?: \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', trim(strip_tags($publication->content))), 160);
        $shareImagePath = $publication->images->first()?->path ?? $publication->image_path;
        $shareImageUrl = $shareImagePath
            ? url(\Illuminate\Support\Facades\Storage::disk('public')->url($shareImagePath))
            : asset('images/logo-sds-green-iot.png');
        $publicationUrl = route('blog.show', $publication->slug);
    @endphp
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ $publicationUrl }}">
    <meta property="og:type" content="article">
    <meta property="og:locale" content="es_SV">
    <meta property="og:site_name" content="SDS 2026 · GREEN IoT">
    <meta property="og:title" content="{{ $publication->title }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $publicationUrl }}">
    <meta property="og:image" content="{{ $shareImageUrl }}">
    <meta property="og:image:alt" content="Imagen de {{ $publication->title }}">
    @if ($publication->published_at)
        <meta property="article:published_time" content="{{ $publication->published_at->toIso8601String() }}">
    @endif
    @if ($publication->category)
        <meta property="article:section" content="{{ $publication->category->name }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $publication->title }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $shareImageUrl }}">
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

        main {
            width: min(1120px, calc(100% - 2rem));
            margin: 0 auto;
        }

        .publication-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(15rem, 18rem);
            align-items: start;
            gap: 1.5rem;
            margin: 2rem 0 4rem;
        }

        .publication-layout--single {
            grid-template-columns: minmax(0, 1fr);
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

        .publication-content-column > article {
            margin: 0;
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

        .publication-layout:not(.publication-layout--single) h1 {
            font-size: clamp(1.8rem, 3.5vw, 2.8rem);
        }

        .category {
            color: #368b2d;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .date,
        .excerpt,
        .authors {
            color: #526052;
        }

        .authors {
            margin: 0.5rem 0;
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

        .publication-gallery {
            margin: 1.5rem 0;
        }

        .gallery-stage {
            position: relative;
            overflow: hidden;
            border-radius: 0.85rem;
            background: #e9eee7;
        }

        .gallery-main {
            display: block;
            overflow: hidden;
            width: 100%;
            padding: 0;
            border: 0;
            background: transparent;
            cursor: zoom-in;
        }

        .gallery-main .cover {
            width: 100%;
            height: min(58vw, 34rem);
            min-height: 15rem;
            max-height: 34rem;
            object-fit: contain;
        }

        .gallery-counter {
            position: absolute;
            top: 0.85rem;
            right: 0.85rem;
            padding: 0.4rem 0.65rem;
            border-radius: 999px;
            color: white;
            background: rgb(20 30 20 / 72%);
            font-size: 0.85rem;
            font-weight: 700;
        }

        .gallery-control {
            position: absolute;
            top: 50%;
            display: inline-flex;
            min-width: 5.5rem;
            height: 2.8rem;
            align-items: center;
            justify-content: center;
            padding: 0 0.9rem;
            border: 1px solid rgb(255 255 255 / 70%);
            border-radius: 999px;
            color: #173a1d;
            background: rgb(255 255 255 / 88%);
            font-size: 0.8rem;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .gallery-control-previous {
            left: 0.9rem;
        }

        .gallery-control-next {
            right: 0.9rem;
        }

        .gallery-thumbnails {
            display: flex;
            gap: 0.65rem;
            overflow-x: auto;
            padding: 0.8rem 0.2rem 0.45rem;
            scrollbar-color: #9baa95 transparent;
        }

        .gallery-thumbnail {
            flex: 0 0 5.5rem;
            overflow: hidden;
            height: 3.8rem;
            padding: 0.15rem;
            border: 2px solid transparent;
            border-radius: 0.45rem;
            background: transparent;
            cursor: pointer;
        }

        .gallery-thumbnail[aria-pressed="true"] {
            border-color: #287b2d;
        }

        .gallery-thumbnail:focus-visible,
        .gallery-control:focus-visible,
        .gallery-main:focus-visible {
            outline: 3px solid #55a927;
            outline-offset: 3px;
        }

        .gallery-thumbnail img {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 0.25rem;
            object-fit: cover;
        }

        @media (max-width: 600px) {
            .gallery-main .cover {
                height: min(68vw, 25rem);
                min-height: 12rem;
            }

            .gallery-thumbnail {
                flex-basis: 4.7rem;
                height: 3.3rem;
            }

            .gallery-control {
                min-width: 5.5rem;
                height: 2.45rem;
            }
        }

        .content {
            color: #344234;
            font-size: 1.05rem;
            line-height: 1.85;
            white-space: pre-line;
        }

        .related-publications {
            padding: 1.25rem;
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
        }

        .related-publications h2 {
            margin: 0 0 1.1rem;
            color: #173a1d;
            font-size: 1.15rem;
            line-height: 1.3;
        }

        .related-publication-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .related-publication-card {
            overflow: hidden;
            border: 1px solid #e1eadc;
            border-radius: 0.7rem;
            background: white;
        }

        .related-publication-media {
            display: block;
            width: 100%;
            aspect-ratio: 16 / 9;
            overflow: hidden;
            background: #e9eee7;
        }

        .related-publication-image {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .related-publication-placeholder {
            display: block;
            width: 100%;
            height: 100%;
        }

        .related-publication-body {
            min-width: 0;
            padding: 0.85rem;
        }

        .related-publication-category {
            margin: 0 0 0.4rem;
            color: #368b2d;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .related-publication-title {
            margin: 0;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .related-publication-title a {
            color: #173a1d;
            text-decoration: none;
        }

        .related-publication-title a:hover,
        .related-publication-title a:focus-visible {
            text-decoration: underline;
        }

        .related-publication-date {
            display: block;
            margin-top: 0.4rem;
            color: #526052;
            font-size: 0.75rem;
        }

        @media (max-width: 900px) {
            .publication-layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .related-publication-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

        }

        @media (max-width: 600px) {
            .related-publication-grid {
                grid-template-columns: 1fr;
            }
        }

    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        <div class="publication-layout {{ $relatedPublications->isEmpty() ? 'publication-layout--single' : '' }}">
            <div class="publication-content-column">
                <article>
                    <x-back-button href="{{ route('blog.index') }}" />
            @if ($publication->category)
                <p class="category">{{ $publication->category->name }}</p>
            @endif
            <h1>{{ $publication->title }}</h1>
            @if ($publication->authors)
                <p class="authors"><strong>Autor(es):</strong> {{ $publication->authors }}</p>
            @endif
            @if ($publication->activity_date)
                <time class="date" datetime="{{ $publication->activity_date->toDateString() }}">
                    Fecha de actividad: {{ $publication->activity_date->format('d/m/Y') }}
                </time>
            @endif
            @if ($publication->excerpt)
                <p class="excerpt">{{ $publication->excerpt }}</p>
            @endif
            @php
                $galleryItems = $publication->images->map(fn ($image) => [
                    'src' => \Illuminate\Support\Facades\Storage::disk('public')->url($image->path),
                    'alt' => $image->original_filename,
                ]);
                if ($galleryItems->isEmpty() && $publication->image_path) {
                    $galleryItems->push([
                        'src' => \Illuminate\Support\Facades\Storage::disk('public')->url($publication->image_path),
                        'alt' => 'Imagen de '.$publication->title,
                    ]);
                }
            @endphp
            @if ($galleryItems->isNotEmpty())
                <section class="publication-gallery" aria-label="Galería de imágenes">
                    <div class="gallery-stage">
                        <button
                            class="gallery-main"
                            type="button"
                            data-image-zoom
                            data-image-index="0"
                            data-image-src="{{ $galleryItems[0]['src'] }}"
                            data-image-alt="{{ $galleryItems[0]['alt'] }}"
                            aria-label="Ampliar imagen 1 de {{ $galleryItems->count() }}"
                            @if ($galleryItems->count() > 1)
                                data-image-gallery="publication"
                            @endif
                        >
                            <img class="cover" src="{{ $galleryItems[0]['src'] }}" alt="{{ $galleryItems[0]['alt'] }}">
                        </button>
                        @if ($galleryItems->count() > 1)
                            <span class="gallery-counter" data-gallery-counter aria-live="polite">
                                1 de {{ $galleryItems->count() }}
                            </span>
                            <button
                                class="gallery-control gallery-control-previous"
                                type="button"
                                data-gallery-previous
                                aria-label="Imagen anterior"
                            >Anterior</button>
                            <button
                                class="gallery-control gallery-control-next"
                                type="button"
                                data-gallery-next
                                aria-label="Imagen siguiente"
                            >Siguiente</button>
                        @endif
                    </div>
                    @if ($galleryItems->count() > 1)
                        <div class="gallery-thumbnails" aria-label="Seleccionar imagen">
                            @foreach ($galleryItems as $index => $image)
                                <button
                                    class="gallery-thumbnail"
                                    type="button"
                                    data-gallery-thumbnail
                                    data-lightbox-item
                                    data-image-gallery="publication"
                                    data-image-index="{{ $index }}"
                                    data-image-src="{{ $image['src'] }}"
                                    data-image-alt="{{ $image['alt'] }}"
                                    aria-label="Mostrar imagen {{ $index + 1 }} de {{ $galleryItems->count() }}"
                                    aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                                >
                                    <img src="{{ $image['src'] }}" alt="" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </section>
            @endif
                    <div class="content">{{ $publication->content }}</div>
                </article>
            </div>

            @if ($relatedPublications->isNotEmpty())
                <aside class="related-publications" aria-labelledby="related-publications-title">
                    <h2 id="related-publications-title">También te puede interesar</h2>
                    <div class="related-publication-grid">
                        @foreach ($relatedPublications as $relatedPublication)
                            @php
                                $relatedImagePath = $relatedPublication->images->first()?->path
                                    ?? $relatedPublication->image_path;
                            @endphp
                            <article class="related-publication-card">
                                <a
                                    class="related-publication-media"
                                    href="{{ route('blog.show', $relatedPublication->slug) }}"
                                    aria-label="Leer {{ $relatedPublication->title }}"
                                >
                                    @if ($relatedImagePath)
                                        <img
                                            class="related-publication-image"
                                            src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($relatedImagePath) }}"
                                            alt=""
                                            loading="lazy"
                                        >
                                    @else
                                        <span class="related-publication-placeholder" aria-hidden="true"></span>
                                    @endif
                                </a>
                                <div class="related-publication-body">
                                    @if ($relatedPublication->category)
                                        <p class="related-publication-category">{{ $relatedPublication->category->name }}</p>
                                    @endif
                                    <h3 class="related-publication-title">
                                        <a href="{{ route('blog.show', $relatedPublication->slug) }}">
                                            {{ $relatedPublication->title }}
                                        </a>
                                    </h3>
                                    @if ($relatedPublication->activity_date)
                                        <time
                                            class="related-publication-date"
                                            datetime="{{ $relatedPublication->activity_date->toDateString() }}"
                                        >
                                            {{ $relatedPublication->activity_date->format('d/m/Y') }}
                                        </time>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </aside>
            @endif
        </div>
    </main>
    <x-image-lightbox />
    <script>
        (() => {
            const mainImage = document.querySelector('.gallery-main');
            if (!mainImage) {
                return;
            }

            const thumbnails = Array.from(document.querySelectorAll('[data-gallery-thumbnail]'));
            if (thumbnails.length < 2) {
                return;
            }

            const counter = document.querySelector('[data-gallery-counter]');
            let currentIndex = 0;

            const showImage = (index) => {
                currentIndex = (index + thumbnails.length) % thumbnails.length;
                const thumbnail = thumbnails[currentIndex];
                const image = mainImage.querySelector('img');

                mainImage.dataset.imageSrc = thumbnail.dataset.imageSrc;
                mainImage.dataset.imageAlt = thumbnail.dataset.imageAlt;
                mainImage.dataset.imageIndex = String(currentIndex);
                mainImage.setAttribute('aria-label', `Ampliar imagen ${currentIndex + 1} de ${thumbnails.length}`);
                image.src = thumbnail.dataset.imageSrc;
                image.alt = thumbnail.dataset.imageAlt;
                counter.textContent = `${currentIndex + 1} de ${thumbnails.length}`;

                thumbnails.forEach((item, itemIndex) => {
                    item.setAttribute('aria-pressed', String(itemIndex === currentIndex));
                });
            };

            thumbnails.forEach((thumbnail, index) => {
                thumbnail.addEventListener('click', () => showImage(index));
            });
            document.querySelector('[data-gallery-previous]').addEventListener('click', () => showImage(currentIndex - 1));
            document.querySelector('[data-gallery-next]').addEventListener('click', () => showImage(currentIndex + 1));
        })();
    </script>
</body>
</html>
