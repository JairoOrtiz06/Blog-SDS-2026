<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>{{ $publication->exists ? 'Editar publicación' : 'Nueva publicación' }} | SDS 2026</title>
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
            width: min(780px, calc(100% - 2rem));
            margin: 2rem auto;
            padding: clamp(1.25rem, 5vw, 2.5rem);
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
        }

        h1 {
            margin-top: 0.75rem;
            color: #173a1d;
        }

        .intro,
        .hint {
            color: #526052;
            line-height: 1.6;
        }

        label {
            display: block;
            margin: 1rem 0 0.4rem;
            color: #334433;
            font-weight: 700;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd9c5;
            border-radius: 0.55rem;
            font: inherit;
        }

        textarea {
            min-height: 10rem;
            resize: vertical;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: 2px solid #55a927;
        }

        .errors {
            padding: 0.75rem 1rem;
            border-radius: 0.55rem;
            color: #991b1b;
            background: #fef2f2;
        }

        .cover-preview {
            display: block;
            width: min(100%, 28rem);
            max-height: 18rem;
            margin-top: 0.75rem;
            border-radius: 0.6rem;
            object-fit: cover;
        }

        .cover-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .cover-gallery .cover-preview {
            width: min(100%, 16rem);
        }

        .cover-gallery .image-zoom-trigger {
            width: auto;
            padding: 0;
            border: 0;
            border-radius: 0;
            background: transparent;
            cursor: zoom-in;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        button {
            padding: 0.8rem 1.1rem;
            border: 0;
            border-radius: 999px;
            color: white;
            background: #287b2d;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
        }

        a {
            color: #236c2a;
        }
    </style>
</head>
<body>
    <main>
        <p><a href="{{ route('publications.index') }}">← Volver a publicaciones</a></p>
        <h1>{{ $publication->exists ? 'Editar publicación' : 'Nueva publicación' }}</h1>
        <p class="intro">Completa el contenido y elige si deseas guardarlo como borrador o publicarlo.</p>

        @if ($errors->any())
            <div class="errors" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ $publication->exists ? route('publications.update', $publication) : route('publications.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @if ($publication->exists)
                @method('PUT')
            @endif

            <label for="title">Título</label>
            <input
                id="title"
                name="title"
                value="{{ old('title', $publication->title) }}"
                maxlength="255"
                required
            >

            <label for="category">Categoría (opcional)</label>
            <input
                id="category"
                name="category"
                value="{{ old('category', $publication->category) }}"
                maxlength="100"
                placeholder="Ej.: IoT, actividades, noticias"
            >

            <label for="excerpt">Resumen (opcional)</label>
            <textarea id="excerpt" name="excerpt" maxlength="1000">{{ old('excerpt', $publication->excerpt) }}</textarea>

            <label for="content">Contenido</label>
            <textarea id="content" name="content" maxlength="50000" required>{{ old('content', $publication->content) }}</textarea>

            <label for="images">Imágenes de portada (opcional)</label>
            <input
                id="images"
                name="images[]"
                type="file"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                multiple
            >
            <p class="hint">
                Puedes seleccionar hasta 2 imágenes JPG, PNG o WebP, de máximo 5 MB cada una.
                En computadora, mantén Ctrl (o Cmd en Mac) para seleccionar ambas.
                Haz clic en las vistas previas para ampliarlas. Al editar, las nuevas imágenes reemplazarán las actuales.
            </p>
            <p id="selected-images-heading" class="hint" hidden>Imágenes que seleccionaste:</p>
            <div id="selected-image-previews" class="cover-gallery" aria-live="polite"></div>
            @if ($publication->image_path || $publication->images->isNotEmpty())
                <p>Imágenes actuales:</p>
                <div class="cover-gallery">
                    @if ($publication->image_path)
                        <button
                            class="image-zoom-trigger"
                            type="button"
                            data-image-zoom
                            data-image-src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($publication->image_path) }}"
                            data-image-alt="Portada de {{ $publication->title }}"
                            aria-label="Ampliar portada actual"
                        >
                            <img
                                class="cover-preview"
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($publication->image_path) }}"
                                alt=""
                            >
                        </button>
                    @endif
                    @foreach ($publication->images as $image)
                        <button
                            class="image-zoom-trigger"
                            type="button"
                            data-image-zoom
                            data-image-src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}"
                            data-image-alt="{{ $image->original_filename }}"
                            aria-label="Ampliar {{ $image->original_filename }}"
                        >
                            <img
                                class="cover-preview"
                                src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->path) }}"
                                alt=""
                            >
                        </button>
                    @endforeach
                </div>
            @endif

            <label for="status">Estado</label>
            <select id="status" name="status" required>
                <option value="draft" @selected(old('status', $publication->status ?: 'draft') === 'draft')>
                    Guardar como borrador
                </option>
                <option value="published" @selected(old('status', $publication->status) === 'published')>
                    Publicar
                </option>
            </select>

            <label for="published_at">Fecha y hora de publicación (opcional)</label>
            <input
                id="published_at"
                name="published_at"
                type="datetime-local"
                value="{{ old('published_at', $publication->published_at?->format('Y-m-d\TH:i')) }}"
            >
            <p class="hint">Si eliges publicar y dejas la fecha vacía, se publicará inmediatamente. Una fecha futura programa la publicación.</p>

            <div class="actions">
                <button type="submit">{{ $publication->exists ? 'Guardar cambios' : 'Guardar publicación' }}</button>
                <a href="{{ route('publications.index') }}">Cancelar</a>
            </div>
        </form>
    </main>
    <script>
        (() => {
            const input = document.getElementById('images');
            const previews = document.getElementById('selected-image-previews');
            const heading = document.getElementById('selected-images-heading');
            const objectUrls = [];

            input.addEventListener('change', () => {
                objectUrls.forEach((url) => URL.revokeObjectURL(url));
                objectUrls.length = 0;
                previews.replaceChildren();
                heading.hidden = input.files.length === 0;

                Array.from(input.files).forEach((file) => {
                    if (!file.type.startsWith('image/')) {
                        return;
                    }

                    const url = URL.createObjectURL(file);
                    objectUrls.push(url);

                    const button = document.createElement('button');
                    button.className = 'image-zoom-trigger';
                    button.type = 'button';
                    button.dataset.imageZoom = '';
                    button.dataset.imageSrc = url;
                    button.dataset.imageAlt = file.name;
                    button.setAttribute('aria-label', `Ampliar ${file.name}`);

                    const image = document.createElement('img');
                    image.className = 'cover-preview';
                    image.src = url;
                    image.alt = '';

                    button.append(image);
                    previews.append(button);
                });
            });

            window.addEventListener('pagehide', () => {
                objectUrls.forEach((url) => URL.revokeObjectURL(url));
            });
        })();
    </script>
    <x-image-lightbox />
</body>
</html>
