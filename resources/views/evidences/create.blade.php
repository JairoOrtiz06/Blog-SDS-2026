<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <title>{{ $evidence->exists ? 'Editar evidencia' : 'Registrar evidencia' }} | SDS 2026</title>
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
            width: min(960px, calc(100% - 2rem));
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
        select,
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
        select:focus,
        textarea:focus {
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

        .evidence-type {
            margin-top: 1.25rem;
            padding: 1rem;
            border: 1px solid #e1eadc;
            border-radius: 0.75rem;
            background: #f8fbf6;
        }

        .evidence-type > label:first-child {
            margin-top: 0;
        }

        .member-selection[hidden] {
            display: none;
        }

        .student-choice-list {
            display: grid;
            gap: 0.6rem;
            margin-top: 1rem;
        }

        fieldset.member-selection {
            min-width: 0;
            margin: 1rem 0 0;
            padding: 0;
            border: 0;
        }

        .student-choice {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            margin: 0;
            padding: 0.75rem;
            border: 1px solid #d5e5ce;
            border-radius: 0.55rem;
            background: white;
            cursor: pointer;
        }

        input[type="checkbox"] {
            width: 1.1rem;
            height: 1.1rem;
            margin: 0;
            accent-color: #287b2d;
        }

        .pair-selection-error {
            color: #991b1b;
        }

        .file-preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(8rem, 1fr));
            gap: 0.75rem;
            margin-top: 0.75rem;
        }

        .file-preview-grid img {
            display: block;
            width: 100%;
            height: 8rem;
            border: 1px solid #e1eadc;
            border-radius: 0.6rem;
            background: #f5f8f2;
            object-fit: cover;
        }

        .file-preview-grid button {
            overflow: hidden;
            padding: 0;
            border: 0;
            background: transparent;
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

        @media (max-width: 560px) {
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
        <x-back-button href="{{ route('evidences.index') }}" />
        <p class="eyebrow">Archivos del proyecto</p>
        <h1>{{ $evidence->exists ? 'Editar evidencia' : 'Registrar evidencia' }}</h1>
        <p class="intro">Asigna la evidencia a uno de los estudiantes o marca a los dos si realizaron la actividad juntos. No necesitan cuentas en el sistema.</p>

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
            action="{{ $evidence->exists ? route('evidences.update', $evidence) : route('evidences.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @if ($evidence->exists)
                @method('PUT')
            @endif

            <label for="title">Título</label>
            <input id="title" name="title" value="{{ old('title', $evidence->title) }}" maxlength="150" required>

            <label for="activity">Actividad</label>
            <select id="activity" name="activity" required>
                <option value="">Selecciona una actividad</option>
                @foreach ($activities as $activity)
                    <option
                        value="{{ $activity }}"
                        @selected(old('activity', $evidence->activity) === $activity)
                    >
                        {{ $activity }}
                    </option>
                @endforeach
            </select>

            @if ($evidence->exists)
                <p class="hint">
                    Tipo de evidencia: <strong>{{ $evidence->evidence_type === 'pair' ? 'En pareja · registro individual' : 'Individual' }}</strong>.
                    @if ($evidence->evidence_type === 'pair')
                        Esta evidencia corresponde a uno de los dos registros individuales creados para la pareja.
                    @endif
                </p>
                @php($selectedStudent = old('participant_name', $evidence->participant_name ?? $evidence->participant?->name))
                <label for="participant_name">Estudiante asignado a este registro</label>
                <select id="participant_name" name="participant_name" required>
                    <option value="">Selecciona un estudiante</option>
                    @foreach ($students as $student)
                        <option
                            value="{{ $student }}"
                            @selected($selectedStudent === $student)
                        >
                            {{ $student }}
                        </option>
                    @endforeach
                </select>
            @else
                @php($selectedType = old('evidence_type', 'individual'))
                <div class="evidence-type">
                    <label for="evidence_type">Tipo de evidencia</label>
                    <select id="evidence_type" name="evidence_type" required>
                        <option value="individual" @selected($selectedType === 'individual')>Individual · un estudiante</option>
                        <option value="pair" @selected($selectedType === 'pair')>En pareja · dos estudiantes</option>
                    </select>

                    <div id="individual-selection" class="member-selection" @if ($selectedType === 'pair') hidden @endif>
                        <label for="participant_name">Estudiante</label>
                        <select
                            id="participant_name"
                            name="participant_name"
                            @disabled($selectedType === 'pair')
                            @required($selectedType === 'individual')
                        >
                            <option value="">Selecciona un estudiante</option>
                            @foreach ($students as $student)
                                <option
                                    value="{{ $student }}"
                                    @selected(old('participant_name') === $student)
                                >
                                    {{ $student }}
                                </option>
                            @endforeach
                        </select>
                        <p class="hint">Se creará un registro de evidencia para el estudiante seleccionado.</p>
                    </div>

                    <fieldset
                        id="pair-selection"
                        class="member-selection"
                        @if ($selectedType !== 'pair') hidden disabled @endif
                    >
                        <legend>Estudiantes que realizaron la actividad</legend>
                        <div class="student-choice-list">
                            @foreach ($students as $student)
                                <label class="student-choice">
                                    <input
                                        type="checkbox"
                                        name="participant_names[]"
                                        value="{{ $student }}"
                                        @checked(in_array($student, (array) old('participant_names', []), true))
                                    >
                                    <span>{{ $student }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="hint">Marca los dos nombres. Se guardará una evidencia independiente para cada uno.</p>
                        <p id="pair-selection-error" class="pair-selection-error" role="alert" tabindex="-1" hidden>
                            Marca los dos nombres para continuar.
                        </p>
                    </fieldset>
                </div>
            @endif

            <label for="description">Descripción (opcional)</label>
            <textarea id="description" name="description" maxlength="5000">{{ old('description', $evidence->description) }}</textarea>

            <label for="evidence_date">Fecha de la actividad</label>
            <input
                id="evidence_date"
                name="evidence_date"
                type="date"
                value="{{ old('evidence_date', $evidence->evidence_date?->toDateString() ?? now()->toDateString()) }}"
                @required(! $evidence->exists)
            >

            @if ($evidence->exists)
                <p class="hint">Archivo principal: {{ $evidence->original_filename }}. Si lo reemplazas, las fotos adicionales se conservarán.</p>
                @if ($evidence->preview_type === 'image' || $evidence->attachments->isNotEmpty())
                    <p class="hint">Archivos asociados ({{ 1 + $evidence->attachments->count() }} de 8):</p>
                    <div class="file-preview-grid">
                        @if ($evidence->preview_type === 'image')
                            <a href="{{ route('evidences.preview', $evidence) }}" target="_blank" rel="noopener">
                                <img src="{{ route('evidences.preview', $evidence) }}" alt="Foto principal actual">
                            </a>
                        @endif
                        @foreach ($evidence->attachments as $attachment)
                            <a href="{{ route('evidences.attachments.preview', [$evidence, $attachment]) }}" target="_blank" rel="noopener">
                                <img src="{{ route('evidences.attachments.preview', [$evidence, $attachment]) }}" alt="{{ $attachment->original_filename }}">
                            </a>
                        @endforeach
                    </div>
                @endif
            @endif
            <label for="file">Archivo principal{{ $evidence->exists ? ' (opcional)' : '' }}</label>
            <input
                id="file"
                name="file"
                type="file"
                accept=".jpg,.jpeg,.png,.pdf,image/jpeg,image/png,application/pdf"
                @required(! $evidence->exists)
            >
            <p class="hint">Formatos permitidos: JPG, PNG o PDF. Tamaño máximo: 10 MB.</p>

            @php($remainingPhotoSlots = $evidence->exists ? max(0, 7 - $evidence->attachments->count()) : 7)
            @if ($remainingPhotoSlots > 0)
                <label for="additional_files">{{ $evidence->exists ? 'Agregar más fotos' : 'Agregar más fotos a esta evidencia' }}</label>
                <input
                    id="additional_files"
                    name="additional_files[]"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                    multiple
                >
                <p class="hint">
                    Puedes agregar hasta {{ $remainingPhotoSlots }} {{ $remainingPhotoSlots === 1 ? 'foto' : 'fotos' }} adicionales, JPG, PNG o WebP, máximo 10 MB cada una.
                    Para subir 6 fotos, elige una como archivo principal y agrega otras 5 aquí. Puedes seleccionarlas juntas o por tandas.
                </p>
                <p id="additional-files-status" class="hint" role="status" aria-live="polite"></p>
                <div id="additional-files-previews" class="file-preview-grid" aria-live="polite"></div>
                <button id="clear-additional-files" type="button" hidden>Quitar fotos seleccionadas</button>
            @else
                <p class="hint">Esta evidencia ya tiene el máximo de 8 archivos.</p>
            @endif

            <div class="actions">
                <button type="submit">{{ $evidence->exists ? 'Guardar cambios' : 'Guardar evidencia' }}</button>
                <a href="{{ route('evidences.index') }}">Cancelar</a>
            </div>
        </form>
    </main>
    @unless ($evidence->exists)
        <script>
            (() => {
                const typeSelect = document.getElementById('evidence_type');
                const individualSelection = document.getElementById('individual-selection');
                const individualSelect = document.getElementById('participant_name');
                const pairSelection = document.getElementById('pair-selection');
                const pairCheckboxes = Array.from(pairSelection.querySelectorAll('input[type="checkbox"]'));
                const pairSelectionError = document.getElementById('pair-selection-error');
                const form = typeSelect.form;

                const updateParticipantFields = () => {
                    const isPair = typeSelect.value === 'pair';
                    individualSelection.hidden = isPair;
                    individualSelect.disabled = isPair;
                    pairSelection.hidden = !isPair;
                    pairSelection.disabled = !isPair;
                    individualSelect.required = !isPair;
                };

                typeSelect.addEventListener('change', updateParticipantFields);
                form.addEventListener('submit', (event) => {
                    if (typeSelect.value !== 'pair') {
                        return;
                    }

                    const selectedCount = pairCheckboxes.filter((checkbox) => checkbox.checked).length;
                    pairSelectionError.hidden = selectedCount === 2;
                    if (selectedCount !== 2) {
                        event.preventDefault();
                        pairSelectionError.focus?.();
                    }
                });
                updateParticipantFields();
            })();
        </script>
    @endunless
    @if ($remainingPhotoSlots > 0)
        <script>
            (() => {
                const input = document.getElementById('additional_files');
                const previews = document.getElementById('additional-files-previews');
                const status = document.getElementById('additional-files-status');
                const clearButton = document.getElementById('clear-additional-files');
                const maximumFiles = {{ $remainingPhotoSlots }};
                const selectedFiles = [];
                const objectUrls = [];

                const renderPreviews = () => {
                    objectUrls.forEach((url) => URL.revokeObjectURL(url));
                    objectUrls.length = 0;
                    previews.replaceChildren();
                    clearButton.hidden = selectedFiles.length === 0;

                    selectedFiles.forEach((file) => {
                        const url = URL.createObjectURL(file);
                        objectUrls.push(url);

                        const image = document.createElement('img');
                        image.src = url;
                        image.alt = file.name;
                        previews.append(image);
                    });
                };

                input.addEventListener('change', () => {
                    const incomingFiles = Array.from(input.files);
                    const availableSlots = maximumFiles - selectedFiles.length;
                    const acceptedFiles = incomingFiles.slice(0, availableSlots);
                    selectedFiles.push(...acceptedFiles);

                    const transfer = new DataTransfer();
                    selectedFiles.forEach((file) => transfer.items.add(file));
                    input.files = transfer.files;

                    renderPreviews();
                    status.textContent = acceptedFiles.length < incomingFiles.length
                        ? `Se agregaron ${acceptedFiles.length} de ${incomingFiles.length} fotos.`
                        : `Llevas ${selectedFiles.length} de ${maximumFiles} fotos nuevas seleccionadas.`;
                });

                clearButton.addEventListener('click', () => {
                    selectedFiles.length = 0;
                    input.value = '';
                    status.textContent = 'Se quitaron las fotos seleccionadas.';
                    renderPreviews();
                });

                window.addEventListener('pagehide', () => {
                    objectUrls.forEach((url) => URL.revokeObjectURL(url));
                });
            })();
        </script>
    @endif
</body>
</html>
