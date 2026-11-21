<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            background:
                radial-gradient(ellipse at 85% 0, rgb(222 239 212 / 38%), transparent 28rem),
                #f5f8f2;
        }

        main {
            width: min(920px, calc(100% - 2rem));
            margin: 2.25rem auto;
            padding: clamp(1.25rem, 5vw, 2.5rem);
            border: 1px solid #e1eadc;
            border-radius: 1.1rem;
            background: white;
            box-shadow: 0 12px 36px rgb(23 58 29 / 7%);
        }

        h1 {
            margin: 0.25rem 0 0.5rem;
            color: #173a1d;
            font-size: clamp(1.6rem, 3vw, 2.1rem);
            letter-spacing: -0.035em;
        }

        .eyebrow {
            margin: 1.5rem 0 0;
            color: #43813d;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.12em;
            text-transform: uppercase;
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
            outline: 3px solid rgb(85 169 39 / 25%);
            border-color: #55a927;
            outline-offset: 1px;
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
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(8rem, 1fr));
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .cover-gallery .cover-preview {
            width: 100%;
            height: 8rem;
            margin: 0;
            object-fit: cover;
        }

        .cover-gallery .image-zoom-trigger {
            overflow: hidden;
            width: 100%;
            padding: 0;
            border: 0;
            border-radius: 0.6rem;
            background: transparent;
            cursor: zoom-in;
        }

        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            margin-top: 1.25rem;
        }

        .field-grid label {
            margin-top: 0;
        }

        .section-heading {
            margin: 1.75rem 0 0.25rem;
            padding-top: 1.25rem;
            border-top: 1px solid #edf2e9;
            color: #173a1d;
            font-size: 1rem;
            font-weight: 800;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 1.25rem;
            border-top: 1px solid #edf2e9;
        }

        button {
            min-height: 2.8rem;
            padding: 0.8rem 1.1rem;
            border: 1px solid #287b2d;
            border-radius: 0.65rem;
            color: white;
            background: #287b2d;
            font: inherit;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 150ms ease, transform 150ms ease;
        }

        button:hover,
        button:focus-visible {
            background: #205f26;
            transform: translateY(-1px);
        }

        @media (max-width: 640px) {
            .field-grid {
                grid-template-columns: 1fr;
            }

            .actions button {
                width: 100%;
            }
        }

        a {
            color: #236c2a;
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        <x-back-button href="{{ route('publications.index') }}" />
        <p class="eyebrow">Gestión de contenido</p>
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

            <div class="field-grid">
                <div>
                    <label for="authors">Autor o autores</label>
                    <input
                        id="authors"
                        name="authors"
                        value="{{ old('authors', $publication->authors) }}"
                        maxlength="500"
                        placeholder="Ej.: Comité organizador SDS 2026"
                    >
                    <p class="hint">Si hay varios autores, sepáralos con comas. Obligatorio para publicar.</p>
                </div>
                <div>
                    <label for="category_id">Categoría / actividad</label>
                    <select id="category_id" name="category_id">
                        <option value="">Selecciona una categoría</option>
                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected((string) old('category_id', $publication->category_id) === (string) $category->id)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <p id="activity-guidance" class="hint" role="status" aria-live="polite">
                        Describe hechos reales, reflexión propia y evidencia.
                    </p>
                    <p class="hint"><a href="{{ route('categories.index') }}">Administrar categorías</a></p>
                </div>
            </div>

            <p class="section-heading">Contenido de la publicación</p>
            <label for="excerpt">Resumen (opcional)</label>
            <textarea id="excerpt" name="excerpt" maxlength="1000">{{ old('excerpt', $publication->excerpt) }}</textarea>

            <label for="content">Contenido</label>
            <textarea id="content" name="content" maxlength="50000" required>{{ old('content', $publication->content) }}</textarea>

            <label for="activity_date">Fecha de la actividad</label>
            <input
                id="activity_date"
                name="activity_date"
                type="date"
                value="{{ old('activity_date', $publication->activity_date?->format('Y-m-d')) }}"
            >
            <p class="hint">Obligatoria para publicar. Esta fecha es distinta de la fecha en que el artículo se publica en el blog.</p>

            <p class="section-heading">Evidencia visual</p>
            <label for="images">Imágenes de evidencia</label>
            <input
                id="images"
                name="images[]"
                type="file"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                multiple
            >
            <p class="hint">
                Puedes seleccionar hasta 8 imágenes JPG, PNG o WebP, de máximo 5 MB cada una.
                Puedes seleccionarlas juntas o volver a abrir el selector para agregarlas por tandas.
                Se requiere al menos una imagen para publicar. Al editar, las nuevas imágenes reemplazarán la galería actual.
            </p>
            <p id="selected-images-heading" class="hint" hidden>Imágenes que seleccionaste:</p>
            <div id="selected-image-previews" class="cover-gallery" aria-live="polite"></div>
            <p id="selected-images-status" class="hint" role="status" aria-live="polite"></p>
            <button id="clear-selected-images" type="button" hidden>Quitar todas las fotos seleccionadas</button>
            @if ($publication->image_path || $publication->images->isNotEmpty())
                <p>Galería actual:</p>
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
            const activityInput = document.getElementById('category_id');
            const activityGuidance = document.getElementById('activity-guidance');
            const activityGuides = [
                { match: ['ponencia'], text: 'Incluye el tema, quién expuso, las ideas centrales y los aprendizajes.' },
                { match: ['taller'], text: 'Describe las herramientas, el procedimiento, la práctica realizada y los resultados.' },
                { match: ['bingo'], text: 'Cuenta la dinámica, cómo fue la experiencia y cómo participaron las personas.' },
                { match: ['feria'], text: 'Describe los proyectos visitados, las tecnologías presentadas y las ideas de innovación.' },
                { match: ['pizza', 'comelona'], text: 'Describe cómo se desarrolló la actividad, la convivencia y la experiencia compartida.' },
                { match: ['torneo', 'futbol', 'fútbol'], text: 'Describe el desarrollo, los equipos y la participación como jugador o espectador.' },
                { match: ['parrillada'], text: 'Describe la actividad, la convivencia y tu reflexión sobre la experiencia.' },
            ];
            const defaultActivityGuidance = 'Describe los hechos reales, incluye reflexión propia y adjunta evidencia de la actividad.';

            const updateActivityGuidance = () => {
                const activity = activityInput.selectedOptions[0].text.trim().toLocaleLowerCase();
                const guide = activityGuides.find(({ match }) =>
                    match.some((keyword) => activity.includes(keyword))
                );
                activityGuidance.textContent = guide
                    ? `${guide.text} Incluye hechos reales y tu reflexión propia.`
                    : defaultActivityGuidance;
            };

            activityInput.addEventListener('change', updateActivityGuidance);
            updateActivityGuidance();

            const input = document.getElementById('images');
            const previews = document.getElementById('selected-image-previews');
            const heading = document.getElementById('selected-images-heading');
            const selectionStatus = document.getElementById('selected-images-status');
            const clearSelectionButton = document.getElementById('clear-selected-images');
            const objectUrls = [];
            const selectedFiles = [];
            const maximumImages = 8;

            const renderSelectedImages = () => {
                objectUrls.forEach((url) => URL.revokeObjectURL(url));
                objectUrls.length = 0;
                previews.replaceChildren();
                heading.hidden = selectedFiles.length === 0;
                clearSelectionButton.hidden = selectedFiles.length === 0;

                selectedFiles.forEach((file) => {
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
            };

            input.addEventListener('change', () => {
                const incomingFiles = Array.from(input.files);
                const remainingSlots = maximumImages - selectedFiles.length;
                const acceptedFiles = incomingFiles.slice(0, remainingSlots);
                selectedFiles.push(...acceptedFiles);

                const transfer = new DataTransfer();
                selectedFiles.forEach((file) => transfer.items.add(file));
                input.files = transfer.files;

                renderSelectedImages();
                selectionStatus.textContent = acceptedFiles.length < incomingFiles.length
                    ? `Se agregaron ${acceptedFiles.length} de ${incomingFiles.length} fotos. El máximo es ${maximumImages}.`
                    : `Llevas ${selectedFiles.length} de ${maximumImages} fotos seleccionadas. Puedes volver a elegir fotos para agregarlas.`;
            });

            clearSelectionButton.addEventListener('click', () => {
                selectedFiles.length = 0;
                input.value = '';
                selectionStatus.textContent = 'Se quitaron las fotos seleccionadas.';
                renderSelectedImages();
            });

            window.addEventListener('pagehide', () => {
                objectUrls.forEach((url) => URL.revokeObjectURL(url));
            });
        })();
    </script>
    <x-image-lightbox />
</body>
</html>
