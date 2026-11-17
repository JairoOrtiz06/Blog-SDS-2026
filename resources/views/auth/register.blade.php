<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#173a1d">
    <title>Crear cuenta | Blog SDS 2026</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: #f5f8f2;
        }

        .register-container {
            width: 100%;
            max-width: 430px;
            padding: 35px;
            border: 1px solid #e1eadc;
            border-radius: 14px;
            background: white;
            box-shadow: 0 10px 30px rgb(24 60 22 / 12%);
        }

        h1 {
            margin-bottom: 10px;
            color: #173a1d;
            text-align: center;
        }

        .subtitle {
            margin-bottom: 28px;
            color: #526052;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #334433;
            font-weight: bold;
        }

        input {
            width: 100%;
            margin-bottom: 18px;
            padding: 12px;
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
            border: 0;
            border-radius: 7px;
            color: white;
            background: #287b2d;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #1d5e25;
        }

        .errors {
            margin-bottom: 18px;
            color: #b91c1c;
            font-size: 14px;
        }

        .footer {
            margin-top: 24px;
            color: #526052;
            font-size: 14px;
            text-align: center;
        }

        .footer a {
            color: #287b2d;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <main class="register-container">
        <h1>Crear cuenta</h1>
        <p class="subtitle">Únete a la comunidad de Blog SDS 2026</p>

        @if ($errors->any())
            <div class="errors" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <label for="name">Nombre</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                autocomplete="name"
                required
            >

            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >

            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                autocomplete="new-password"
                minlength="8"
                required
            >

            <label for="password_confirmation">Confirmar contraseña</label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
                minlength="8"
                required
            >

            <button type="submit">Crear cuenta</button>
        </form>

        <p class="footer">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
        </p>
    </main>
</body>
</html>
