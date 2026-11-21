
<!DOCTYPE html>
<html lang="es">
<head>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#173a1d">
    <title>Iniciar sesión | Blog SDS 2026</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f8f2, #eaf4e5);
        }

        .login-container {
            margin: 4rem auto 2rem;
            background: white;
            width: 100%;
            max-width: 400px;
            padding: 35px;
            border: 1px solid #e1eadc;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgb(24 60 22 / 12%);
        }

        h1 {
            text-align: center;
            color: #173a1d;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            color: #526052;
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #334433;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #cbd9c5;
            border-radius: 7px;
            font-size: 15px;
        }

        input:focus {
            outline: 2px solid #55a927;
        }

        button {
            width: 100%;
            padding: 13px;
            background: #287b2d;
            color: white;
            border: none;
            border-radius: 7px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d5e25;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #526052;
            font-size: 13px;
        }

        .footer a {
            color: #287b2d;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <x-site-navigation />

    <div class="login-container">

        <h1>Blog SDS 2026</h1>

        <p class="subtitle">Acceso a tu cuenta de Blog SDS 2026</p>

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.authenticate') }}" method="POST">

            @csrf

            <label for="email">Correo electrónico</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Ingrese su correo"
                required
                autocomplete="username"
            >

            <label for="password">Contraseña</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Ingrese su contraseña"
                required
                autocomplete="current-password"
            >

            <button type="submit">
                Iniciar sesión
            </button>

        </form>

        <p class="footer">
            Acceso reservado al administrador.
            <br><br>
            Semana de Sistemas 2026 | UES-FMO
        </p>

    </div>

</body>
</html>
