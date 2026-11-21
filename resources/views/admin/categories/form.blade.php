<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>{{ $category->exists ? 'Editar categoría' : 'Nueva categoría' }} | SDS 2026</title>
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
            width: min(700px, calc(100% - 2rem));
            margin: 2rem auto;
            padding: clamp(1.25rem, 4vw, 2rem);
            border: 1px solid #e1eadc;
            border-radius: 1rem;
            background: white;
            box-shadow: 0 12px 36px rgb(23 58 29 / 7%);
        }

        h1 {
            margin: 0.25rem 0 0.5rem;
            color: #173a1d;
        }

        .eyebrow,
        .hint {
            color: #526052;
        }

        .eyebrow {
            margin: 1.5rem 0 0;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        label {
            display: block;
            margin: 1.5rem 0 0.4rem;
            font-weight: 700;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cbd9c5;
            border-radius: 0.55rem;
            font: inherit;
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
            gap: 1rem;
            margin-top: 1.75rem;
        }

        button,
        .cancel {
            display: inline-flex;
            min-height: 2.7rem;
            align-items: center;
            justify-content: center;
            padding: 0.7rem 1rem;
            border: 1px solid #287b2d;
            border-radius: 0.6rem;
            color: white;
            background: #287b2d;
            font: inherit;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .cancel {
            border-color: #d5e5ce;
            color: #205f26;
            background: white;
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        <x-back-button href="{{ route('categories.index') }}" />
        <p class="eyebrow">Gestión de contenido</p>
        <h1>{{ $category->exists ? 'Editar categoría' : 'Nueva categoría' }}</h1>
        <p class="hint">Las categorías asignadas a publicaciones no se pueden eliminar hasta que se reasignen.</p>

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
            action="{{ $category->exists ? route('categories.update', $category) : route('categories.store') }}"
            method="POST"
        >
            @csrf
            @if ($category->exists)
                @method('PUT')
            @endif

            <label for="name">Nombre</label>
            <input
                id="name"
                name="name"
                value="{{ old('name', $category->name) }}"
                maxlength="100"
                required
                autofocus
            >

            <div class="actions">
                <button type="submit">{{ $category->exists ? 'Guardar cambios' : 'Crear categoría' }}</button>
                <a class="cancel" href="{{ route('categories.index') }}">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
