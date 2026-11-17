<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de registro.
     */
    public function showRegistration()
    {
        return view('auth.register');
    }

    /**
     * Crear una cuenta normal.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.max' => 'El correo electrónico no puede superar los 255 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        $user = User::create($validated);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('home')
            ->with('status', 'Tu cuenta se creó correctamente.');
    }

    /**
     * Mostrar el formulario de inicio de sesión.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(
                Auth::user()->isAdmin() ? 'dashboard' : 'home'
            );
        }

        return view('auth.login');
    }

    /**
     * Validar las credenciales del usuario.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('dashboard'));
            }

            return redirect()->route('home');
        }

        return back()
            ->withErrors([
                'email' => 'Las credenciales no son correctas.',
            ])
            ->onlyInput('email');
    }

    /**
     * Cerrar la sesión del usuario.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
