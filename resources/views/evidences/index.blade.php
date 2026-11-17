<!DOCTYPE html>
<html lang="es">
<head>
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
        .metadata,
        .description {
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
        }

        .metadata {
            margin: 0;
            font-size: 0.92rem;
        }

        .description {
            white-space: pre-line;
        }

        .download {
            display: inline-block;
            margin-top: 0.5rem;
            font-weight: 700;
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
    <main>
        <header class="topbar">
            <div>
                <p><a href="{{ route('dashboard') }}">← Volver al panel</a></p>
                <h1>Evidencias</h1>
                <p>Registro de archivos asociados a actividades.</p>
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

        <section class="evidence-list" aria-label="Evidencias registradas">
            @forelse ($evidences as $evidence)
                <article class="evidence-card">
                    <h2>{{ $evidence->title }}</h2>
                    <p class="metadata">
                        Actividad: {{ $evidence->activity }}
                        · Fecha: {{ $evidence->evidence_date->format('d/m/Y') }}
                        · Registrada por: {{ $evidence->user->name }}
                    </p>
                    @if ($evidence->description)
                        <p class="description">{{ $evidence->description }}</p>
                    @endif
                    <a class="download" href="{{ route('evidences.download', $evidence) }}">
                        Descargar {{ $evidence->original_filename }}
                    </a>
                </article>
            @empty
                <p class="empty-state">Todavía no se han registrado evidencias.</p>
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
</body>
</html>
