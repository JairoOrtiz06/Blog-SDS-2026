<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f5f8f2">
    <meta name="description" content="SDS 2026: conoce la Semana de Sistemas de la UES-FMO, Green IoT, sus actividades y patrocinadores.">
    <link rel="canonical" href="{{ route('home') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_SV">
    <meta property="og:site_name" content="SDS 2026 · GREEN IoT">
    <meta property="og:title" content="SDS 2026 | Green IoT">
    <meta property="og:description" content="Conoce la Semana de Sistemas de la UES-FMO, Green IoT, sus actividades y patrocinadores.">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:image" content="{{ asset('images/logo-sds-green-iot.png') }}">
    <meta property="og:image:alt" content="Logotipo SDS 2026 Green IoT">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SDS 2026 | Green IoT">
    <meta name="twitter:description" content="Conoce la Semana de Sistemas de la UES-FMO, Green IoT, sus actividades y patrocinadores.">
    <meta name="twitter:image" content="{{ asset('images/logo-sds-green-iot.png') }}">
    <title>SDS 2026 | Green IoT</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Arial, Helvetica, sans-serif;
            color: #172117;
            background: #f5f8f2;
            font-synthesis: none;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            --forest: #173a1d;
            --green: #287b2d;
            --lime: #55a927;
            --muted: #526052;
            --line: #e1eadc;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background:
                radial-gradient(ellipse at 78% 12%, rgb(222 239 212 / 35%), transparent 32rem),
                #f5f8f2;
        }

        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgb(23 58 29 / 8%);
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 0.7rem;
            color: var(--forest);
            font-size: 0.94rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-decoration: none;
        }

        .brand-mark {
            display: grid;
            width: 2.45rem;
            height: 2.45rem;
            place-items: center;
            border: 1px solid #d5e5ce;
            border-radius: 0.75rem;
            color: var(--green);
            background: white;
        }

        .brand-mark svg {
            width: 1.3rem;
            height: 1.3rem;
        }

        .login-link {
            display: inline-flex;
            min-height: 2.65rem;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 0.95rem;
            border: 1px solid #ccddc5;
            border-radius: 0.65rem;
            color: #205f26;
            font-size: 0.84rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 150ms ease, border-color 150ms ease;
        }

        .login-link:hover,
        .login-link:focus-visible {
            border-color: #287b2d;
            background: #eff9e9;
        }

        .header-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 0.65rem;
        }

        main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 1.5rem 3.5rem;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(320px, 0.95fr);
            align-items: center;
            gap: clamp(2.5rem, 7vw, 6rem);
            padding: clamp(2rem, 6vw, 5rem) 0 clamp(2.5rem, 7vw, 5.5rem);
        }

        .poster {
            display: block;
            width: 100%;
            height: auto;
            filter: drop-shadow(0 1rem 1.5rem rgb(24 60 22 / 16%));
        }

        .poster-caption {
            display: flex;
            align-items: center;
            gap: 0.55rem;
            margin-top: 0.85rem;
            color: #637163;
            font-size: 0.76rem;
            letter-spacing: 0.02em;
        }

        .poster-caption::before {
            width: 0.45rem;
            height: 0.45rem;
            border-radius: 50%;
            background: var(--lime);
            content: "";
        }

        .eyebrow {
            margin: 0 0 0.9rem;
            color: #368b2d;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        h1 {
            max-width: 11ch;
            margin: 0;
            color: var(--forest);
            font-size: clamp(2.4rem, 5.3vw, 4.35rem);
            letter-spacing: -0.055em;
            line-height: 1.04;
        }

        h1 span {
            color: var(--lime);
        }

        .intro {
            max-width: 38rem;
            margin: 1.25rem 0 0;
            color: var(--muted);
            font-size: clamp(1rem, 1.6vw, 1.15rem);
            line-height: 1.75;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 0.7rem;
            margin-top: 1.6rem;
        }

        .hero-link {
            display: inline-flex;
            min-height: 2.9rem;
            align-items: center;
            justify-content: center;
            padding: 0.8rem 1.1rem;
            border: 1px solid var(--green);
            border-radius: 0.65rem;
            color: white;
            background: var(--green);
            font-size: 0.87rem;
            font-weight: 700;
            text-decoration: none;
            transition: background-color 150ms ease, transform 150ms ease;
        }

        .hero-link:hover,
        .hero-link:focus-visible {
            background: #1d5e25;
            transform: translateY(-1px);
        }

        .hero-link-secondary {
            border-color: #ccddc5;
            color: #205f26;
            background: transparent;
        }

        .hero-link-secondary:hover,
        .hero-link-secondary:focus-visible {
            border-color: #287b2d;
            color: #205f26;
            background: #eff9e9;
        }

        .about {
            display: grid;
            grid-template-columns: minmax(0, 0.7fr) minmax(0, 1.3fr);
            gap: clamp(1.5rem, 4vw, 3.5rem);
            padding: clamp(1.5rem, 4vw, 3.25rem);
            border: 1px solid var(--line);
            border-radius: 1rem;
            background: white;
            box-shadow: 0 0.75rem 2rem rgb(23 58 29 / 3%);
        }

        .about h2 {
            margin: 0;
            color: var(--forest);
            font-size: clamp(1.5rem, 3vw, 2rem);
            letter-spacing: -0.035em;
        }

        .about p {
            margin: 0;
            color: var(--muted);
            font-size: 0.98rem;
            line-height: 1.85;
        }

        .sponsors {
            margin-top: 2rem;
            padding: clamp(1.5rem, 4vw, 3rem);
            border: 1px solid rgb(255 255 255 / 12%);
            border-radius: 1rem;
            color: white;
            background:
                radial-gradient(ellipse at 12% 0%, rgb(85 169 39 / 23%), transparent 38%),
                linear-gradient(125deg, #173a1d, #205f26);
            box-shadow: 0 1rem 2.5rem rgb(23 58 29 / 12%);
        }

        .sponsors-heading {
            max-width: 62rem;
            margin: 0 auto 1.5rem;
        }

        .sponsors-summary {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(15rem, 0.75fr);
            align-items: end;
            gap: 2rem;
        }

        .sponsors h2 {
            margin: 0;
            color: white;
            font-size: clamp(1.8rem, 4vw, 2.8rem);
            letter-spacing: -0.05em;
            line-height: 1.12;
        }

        .sponsors p {
            margin: 0;
            color: #d7e8d0;
            font-size: 0.94rem;
            line-height: 1.75;
        }

        .sponsors .eyebrow {
            margin-bottom: 0.75rem;
            color: #b6df94;
            font-size: 0.68rem;
        }

        .video-frame {
            width: min(100%, 62rem);
            margin: 0 auto;
        }

        .video-stage {
            position: relative;
            isolation: isolate;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 20rem) minmax(0, 1fr);
            width: 100%;
            align-items: center;
            place-items: center;
            overflow: hidden;
            padding: 0.8rem;
            border: 1px solid rgb(255 255 255 / 20%);
            border-radius: 1rem;
            background: #0c140d;
            box-shadow: 0 1.5rem 3.5rem rgb(0 0 0 / 25%);
        }

        .video-stage::before,
        .video-stage::after {
            position: absolute;
            z-index: -1;
            inset: -2rem;
            content: "";
            pointer-events: none;
        }

        .video-stage::before {
            background: url("{{ asset('images/patrocinadores-poster.svg') }}") center 42% / cover no-repeat;
            filter: blur(1.5rem) saturate(0.8);
            opacity: 0.5;
            transform: scale(1.08);
        }

        .video-stage::after {
            background:
                linear-gradient(90deg, rgb(9 20 10 / 48%), transparent 35% 65%, rgb(9 20 10 / 48%)),
                linear-gradient(0deg, rgb(9 20 10 / 32%), transparent 35% 65%, rgb(9 20 10 / 32%));
        }

        .sponsors-video {
            position: relative;
            z-index: 1;
            display: block;
            grid-column: 2;
            width: 100%;
            height: auto;
            aspect-ratio: 9 / 16;
            border: 1px solid rgb(255 255 255 / 18%);
            border-radius: 0.75rem;
            background: #0c140d;
            object-fit: contain;
            box-shadow: 0 0.75rem 2rem rgb(0 0 0 / 35%);
        }

        .video-play-button {
            display: none;
            align-items: center;
            gap: 0.7rem;
            padding: 0.65rem 1rem 0.65rem 0.65rem;
            border: 1px solid rgb(255 255 255 / 70%);
            border-radius: 999px;
            color: #173a1d;
            background: rgb(255 255 255 / 95%);
            box-shadow: 0 0.75rem 2rem rgb(0 0 0 / 28%);
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform 150ms ease, box-shadow 150ms ease;
        }

        .video-actions.has-play-button .video-play-button:not([hidden]) {
            display: inline-flex;
        }

        .video-play-button:hover,
        .video-play-button:focus-visible {
            transform: translateY(-1px);
            box-shadow: 0 1rem 2.5rem rgb(0 0 0 / 35%);
        }

        .video-actions {
            display: flex;
            min-height: 4.5rem;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 0.75rem;
        }

        .video-play-icon {
            display: grid;
            width: 2.35rem;
            height: 2.35rem;
            place-items: center;
            border-radius: 50%;
            color: white;
            background: var(--green);
        }

        .video-play-icon svg {
            width: 1rem;
            height: 1rem;
            margin-left: 0.12rem;
        }

        .video-play-error {
            max-width: 100%;
            margin: 0.5rem 0;
            padding: 0.7rem 0.85rem;
            border-radius: 0.6rem;
            color: #7f1d1d;
            background: white;
            font-size: 0.82rem;
            text-align: center;
        }

        .video-caption {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            padding: 0.85rem 0.25rem 0;
            color: #c8dfbe;
            font-size: 0.76rem;
            text-align: center;
        }

        footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            max-width: 1280px;
            margin: 0 auto;
            padding: 1.5rem;
            border-top: 1px solid rgb(23 58 29 / 9%);
            color: #667366;
            font-size: 0.78rem;
        }

        footer a {
            color: #205f26;
            font-weight: 700;
            text-decoration: none;
        }

        .status-message {
            margin: 1rem auto 0;
            padding: 0.9rem 1rem;
            border: 1px solid #b7dca8;
            border-radius: 0.75rem;
            color: #205f26;
            background: #eff9e9;
        }

        @media (max-width: 760px) {
            .hero,
            .about {
                grid-template-columns: 1fr;
            }

            .hero {
                gap: 2rem;
            }

            .poster {
                max-width: 34rem;
                margin: 0 auto;
            }

            .hero-copy {
                order: -1;
            }

            .sponsors-summary {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .video-frame {
                width: min(100%, 23rem);
            }

            .video-stage {
                grid-template-columns: minmax(0, 1fr);
                padding: 0.35rem;
                border-radius: 0.85rem;
            }

            .video-stage::before,
            .video-stage::after {
                display: none;
            }

            .sponsors-video {
                grid-column: 1;
                width: 100%;
                height: auto;
                aspect-ratio: 9 / 16;
                border-radius: 0.6rem;
            }

            footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 420px) {
            .site-header,
            main {
                padding-right: 1rem;
                padding-left: 1rem;
            }
        }
    </style>
</head>
<body>
    <x-site-navigation />

    <main>
        @if (session('status'))
            <p class="status-message" role="status">{{ session('status') }}</p>
        @endif

        <section class="hero" aria-labelledby="hero-title">
            <div class="poster-wrap">
                <img
                    class="poster"
                    src="{{ asset('images/logo-sds-green-iot.png') }}"
                    alt="Logotipo verde SDS 26 Green IoT con símbolo Wi‑Fi"
                    width="1152"
                    height="768"
                >
                <p class="poster-caption">SDS 2026 <span aria-hidden="true">·</span> GREEN IoT</p>
            </div>

            <div class="hero-copy">
                <p class="eyebrow">Innovación · Tecnología · Sostenibilidad</p>
                <h1 id="hero-title">Tecnología conectada a un futuro <span>verde.</span></h1>
                <p class="intro">
                    Te damos la bienvenida a SDS 2026: una semana para acercarnos al Internet
                    de las Cosas (IoT) y a las posibilidades de una tecnología más sostenible.
                </p>
                <div class="hero-actions">
                    <a class="hero-link" href="#sobre-sds">Conoce la propuesta</a>
                    <a class="hero-link hero-link-secondary" href="#patrocinadores">Ver patrocinadores</a>
                </div>
            </div>
        </section>

        <section class="about" id="sobre-sds" aria-labelledby="about-title">
            <h2 id="about-title">¿Qué significa Green IoT?</h2>
            <p>
                Green IoT une dispositivos conectados con una mirada responsable sobre el uso
                de la tecnología y los recursos. SDS 2026 invita a estudiantes y visitantes a
                descubrir este tema y conocer más sobre la Semana de Sistemas.
            </p>
        </section>

        <section class="sponsors" id="patrocinadores" aria-labelledby="sponsors-title">
            <div class="sponsors-heading">
                <p class="eyebrow">Aliados de la innovación</p>
                <div class="sponsors-summary">
                    <h2 id="sponsors-title">Patrocinadores de la SDS</h2>
                    <p>
                        La Semana de Sistemas crece gracias a las organizaciones que creen en
                        el talento, la tecnología y un futuro más sostenible.
                    </p>
                </div>
            </div>
            <figure class="video-frame">
                <div class="video-stage">
                    <video
                        class="sponsors-video"
                        controls
                        playsinline
                        preload="none"
                        poster="{{ asset('images/patrocinadores-poster.svg') }}"
                        aria-label="Video de los patrocinadores de la Semana de Sistemas 2026"
                    >
                        <source src="{{ asset('videos/patrocinadores-sds.mp4') }}" type="video/mp4">
                        Tu navegador no puede reproducir este video.
                    </video>
                </div>
                <div class="video-actions">
                    <button
                        class="video-play-button"
                        type="button"
                        aria-label="Reproducir video de los patrocinadores"
                        hidden
                    >
                        <span class="video-play-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8 5.8c0-.8.9-1.3 1.6-.9l9.1 5.5a1.8 1.8 0 0 1 0 3.1l-9.1 5.5c-.7.4-1.6-.1-1.6-.9V5.8Z"/>
                            </svg>
                        </span>
                        <span>Reproducir video</span>
                    </button>
                    <p class="video-play-error" role="alert" hidden>
                        No se pudo iniciar el video. Intenta de nuevo desde los controles.
                    </p>
                </div>
                <figcaption class="video-caption">
                    Presentación oficial de los patrocinadores · SDS 2026
                </figcaption>
            </figure>
        </section>

        <script>
            (() => {
                const stage = document.querySelector('.video-stage');
                const video = stage.querySelector('video');
                const controls = document.querySelector('.video-actions');
                const playButton = controls.querySelector('.video-play-button');
                const errorMessage = controls.querySelector('.video-play-error');

                controls.classList.add('has-play-button');
                playButton.hidden = false;

                playButton.addEventListener('click', () => {
                    errorMessage.hidden = true;
                    video.play().catch(() => {
                        errorMessage.hidden = false;
                    });
                });

                video.addEventListener('play', () => {
                    playButton.hidden = true;
                    errorMessage.hidden = true;
                });

                video.addEventListener('pause', () => {
                    playButton.hidden = false;
                });

                video.addEventListener('ended', () => {
                    playButton.hidden = false;
                });
            })();
        </script>
    </main>

    <footer>
        <span>Universidad de El Salvador · Facultad Multidisciplinaria Oriental</span>
        <a href="{{ route('blog.index') }}">Explorar publicaciones</a>
    </footer>
</body>
</html>
