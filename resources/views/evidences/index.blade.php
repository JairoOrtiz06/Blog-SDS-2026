<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>Evidencias | SDS 2026</title>
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
        .evidence-card {
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
        .metadata,
        .description {
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

        .evidence-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 0.65rem;
            margin: 0 0 1.25rem;
        }

        .evidence-filter {
            display: inline-flex;
            min-height: 2.7rem;
            align-items: center;
            justify-content: center;
            padding: 0.65rem 1rem;
            border: 1px solid #d5e5ce;
            border-radius: 999px;
            color: #205f26;
            background: white;
            font-size: 0.88rem;
            font-weight: 700;
            text-decoration: none;
        }

        .evidence-filter[aria-current="page"] {
            border-color: #287b2d;
            color: white;
            background: #287b2d;
        }

        .status-message {
            padding: 0.9rem 1rem;
            border: 1px solid #b7dca8;
            border-radius: 0.65rem;
            color: #205f26;
            background: #eff9e9;
        }

        .errors {
            padding: 0.75rem 1rem;
            border-radius: 0.55rem;
            color: #991b1b;
            background: #fef2f2;
        }

        .evidence-list {
            display: grid;
            gap: 1rem;
        }

        .evidence-card h2 {
            margin: 0 0 0.5rem;
            color: #173a1d;
            font-size: 1.08rem;
            letter-spacing: -0.015em;
        }

        .evidence-card {
            transition: border-color 150ms ease, box-shadow 150ms ease;
        }

        .evidence-card:hover {
            border-color: #c8ddbf;
            box-shadow: 0 9px 24px rgb(23 58 29 / 7%);
        }

        .metadata {
            margin: 0;
            font-size: 0.92rem;
        }

        .description {
            white-space: pre-line;
        }

        .evidence-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(min(100%, 9rem), 1fr));
            gap: 0.8rem;
            max-width: 46rem;
            margin-top: 0.9rem;
        }

        .evidence-gallery-item {
            min-width: 0;
        }

        .evidence-preview {
            display: block;
            width: 100%;
            height: 7.5rem;
            border: 1px solid #e1eadc;
            border-radius: 0.65rem;
            background: #f5f8f2;
            object-fit: cover;
        }

        .evidence-preview-trigger {
            display: block;
            width: 100%;
            padding: 0;
            border: 0;
            background: transparent;
            cursor: zoom-in;
        }

        .evidence-preview-trigger:focus-visible {
            outline: 3px solid #287b2d;
            outline-offset: 3px;
        }

        .evidence-filename {
            display: -webkit-box;
            overflow: hidden;
            margin: 0.35rem 0 0;
            color: #526052;
            font-size: 0.76rem;
            line-height: 1.35;
            overflow-wrap: anywhere;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .file-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.55rem;
            margin-top: 0.5rem;
        }

        .file-actions form {
            margin: 0;
        }

        .download {
            display: inline-flex;
            min-height: 2.4rem;
            align-items: center;
            margin-top: 0.5rem;
            padding: 0.5rem 0.75rem;
            border: 1px solid #d5e5ce;
            border-radius: 0.55rem;
            color: #205f26;
            background: white;
            font-size: 0.83rem;
            font-weight: 700;
            text-decoration: none;
        }

        .download:hover,
        .download:focus-visible {
            border-color: #287b2d;
            background: #eff9e9;
        }

        .empty-state {
            padding: 2rem;
            border: 1px solid #e1eadc;
            border-radius: 0.9rem;
            color: #526052;
            background: white;
        }

        a {
            color: #236c2a;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        <header class="topbar">
            <div>
                <x-back-button href="{{ route('dashboard') }}" />
                <p class="eyebrow">Archivos del proyecto</p>
                <h1>Evidencias</h1>
                <p class="description">Registro de archivos asociados a actividades.</p>
                <span class="toolbar-count">{{ $evidences->total() }} archivos</span>
            </div>
            <a class="button" href="{{ route('evidences.create') }}">Registrar evidencia</a>
        </header>

        @if (session('status'))
            <p class="status-message" role="status">{{ session('status') }}</p>
        @endif

        @if ($errors->any())
            <div class="errors" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <nav class="evidence-filters" aria-label="Evidencias por estudiante">
            @foreach ($evidenceViews as $viewKey => $view)
                <a
                    class="evidence-filter"
                    href="{{ route('evidences.index', ['student' => $viewKey]) }}"
                    @if ($selectedView === $viewKey) aria-current="page" @endif
                >
                    {{ $view['label'] }}
                </a>
            @endforeach
        </nav>

        <section class="evidence-list" aria-label="{{ $evidenceViews[$selectedView]['label'] }}">
            @forelse ($evidences as $evidence)
                <article class="evidence-card">
                    <h2>{{ $evidence->title }}</h2>
                    <p class="metadata">
                        Actividad: {{ $evidence->activity }}
                        · Fecha: {{ $evidence->evidence_date->format('d/m/Y') }}
                        · Registrada por: {{ $evidence->user->name }}
                        · Tipo: {{ $evidence->evidence_type === 'pair' ? 'En pareja' : 'Individual' }}
                    </p>
                    <p class="metadata">
                        Integrante: {{ $evidence->participant_name ?? $evidence->participant?->name ?? 'Pendiente de asignar' }}
                    </p>
                    @if ($evidence->description)
                        <p class="description">{{ $evidence->description }}</p>
                    @endif
                    @if ($evidence->preview_type === 'pdf')
                        <p class="metadata">Documento PDF: {{ $evidence->original_filename }}</p>
                    @elseif ($evidence->preview_type !== 'image')
                        <p class="metadata">Archivo: {{ $evidence->original_filename }}</p>
                    @endif
                    @if ($evidence->preview_type === 'image' || $evidence->attachments->isNotEmpty())
                        <div class="evidence-gallery" aria-label="Fotos de esta evidencia">
                            @if ($evidence->preview_type === 'image')
                                <div class="evidence-gallery-item">
                                    <button
                                        class="evidence-preview-trigger"
                                        type="button"
                                        data-image-zoom
                                        data-image-gallery="evidence-{{ $evidence->id }}"
                                        data-lightbox-item
                                        data-image-index="0"
                                        data-image-src="{{ route('evidences.preview', $evidence) }}"
                                        data-image-alt="{{ $evidence->title }} — {{ $evidence->participant_name ?? $evidence->participant?->name }}"
                                        aria-label="Ampliar foto principal"
                                    >
                                        <img class="evidence-preview" src="{{ route('evidences.preview', $evidence) }}" alt="">
                                    </button>
                                    <p class="evidence-filename" title="{{ $evidence->original_filename }}">{{ $evidence->original_filename }}</p>
                                </div>
                            @endif
                            @foreach ($evidence->attachments as $attachment)
                                <div class="evidence-gallery-item">
                                    <button
                                        class="evidence-preview-trigger"
                                        type="button"
                                        data-image-zoom
                                        data-image-gallery="evidence-{{ $evidence->id }}"
                                        data-lightbox-item
                                        data-image-index="{{ $loop->index + ($evidence->preview_type === 'image' ? 1 : 0) }}"
                                        data-image-src="{{ route('evidences.attachments.preview', [$evidence, $attachment]) }}"
                                        data-image-alt="{{ $evidence->title }} — {{ $attachment->original_filename }}"
                                        aria-label="Ampliar foto {{ $loop->iteration + ($evidence->preview_type === 'image' ? 1 : 0) }}"
                                    >
                                        <img class="evidence-preview" src="{{ route('evidences.attachments.preview', [$evidence, $attachment]) }}" alt="">
                                    </button>
                                    <p class="evidence-filename" title="{{ $attachment->original_filename }}">{{ $attachment->original_filename }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="file-actions">
                        @if ($evidence->preview_type === 'pdf')
                            <a class="download" href="{{ route('evidences.preview', $evidence) }}" target="_blank" rel="noopener">
                                Ver PDF
                            </a>
                        @endif
                        <a class="download" href="{{ route('evidences.download', $evidence) }}">
                            Descargar
                        </a>
                        @foreach ($evidence->attachments as $attachment)
                            <a class="download" href="{{ route('evidences.attachments.download', [$evidence, $attachment]) }}">
                                Descargar {{ $attachment->original_filename }}
                            </a>
                        @endforeach
                        <a class="download" href="{{ route('evidences.edit', $evidence) }}">Editar evidencia</a>
                        <form
                            action="{{ route('evidences.destroy', $evidence) }}"
                            method="POST"
                            onsubmit="return confirm('¿Eliminar esta evidencia y su archivo? Esta acción no se puede deshacer.')"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="download" type="submit">Eliminar evidencia</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="empty-state">Todavía no hay evidencias para {{ $evidenceViews[$selectedView]['label'] }}.</p>
            @endforelse
        </section>

        @if ($evidences->hasPages())
            <nav class="pagination" aria-label="Paginación">
                @if ($evidences->onFirstPage())
                    <span>Anterior</span>
                @else
                    <a href="{{ $evidences->previousPageUrl() }}">Anterior</a>
                @endif
                <span>Página {{ $evidences->currentPage() }} de {{ $evidences->lastPage() }}</span>
                @if ($evidences->hasMorePages())
                    <a href="{{ $evidences->nextPageUrl() }}">Siguiente</a>
                @else
                    <span>Siguiente</span>
                @endif
            </nav>
        @endif
    </main>
    <x-image-lightbox />
</body>
</html>
