<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>Registrar evidencia | SDS 2026</title>
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
            width: min(680px, calc(100% - 2rem));
            margin: 2rem auto;
            padding: clamp(1.25rem, 5vw, 2.5rem);
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
        }

        h1 {
            margin-top: 0;
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
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd9c5;
            border-radius: 0.55rem;
            font: inherit;
        }

        textarea {
            min-height: 8rem;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: 2px solid #55a927;
        }

        .errors {
            padding: 0.75rem 1rem;
            border-radius: 0.55rem;
            color: #991b1b;
            background: #fef2f2;
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
        <p><a href="{{ route('evidences.index') }}">← Volver a evidencias</a></p>
        <h1>Registrar evidencia</h1>
        <p class="intro">Completa los datos de la actividad y adjunta su archivo de respaldo.</p>

        @if ($errors->any())
            <div class="errors" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('evidences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label for="title">Título</label>
            <input id="title" name="title" value="{{ old('title') }}" maxlength="150" required>

            <label for="activity">Actividad</label>
            <input id="activity" name="activity" value="{{ old('activity') }}" maxlength="150" required>

            <label for="description">Descripción (opcional)</label>
            <textarea id="description" name="description" maxlength="5000">{{ old('description') }}</textarea>

            <label for="evidence_date">Fecha de la actividad</label>
            <input
                id="evidence_date"
                name="evidence_date"
                type="date"
                value="{{ old('evidence_date', now()->toDateString()) }}"
                required
            >

            <label for="file">Archivo de evidencia</label>
            <input
                id="file"
                name="file"
                type="file"
                accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf"
                required
            >
            <p class="hint">Formatos permitidos: JPG, PNG o PDF. Tamaño máximo: 10 MB.</p>

            <div class="actions">
                <button type="submit">Guardar evidencia</button>
                <a href="{{ route('evidences.index') }}">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
