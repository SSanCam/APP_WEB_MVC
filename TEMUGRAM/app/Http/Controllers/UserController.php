<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Muestra la vista con el formulario de registro
    public function registerForm()
    {
        return view('users.register');
    }

    // Registra un nuevo usuario
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                'unique:users,email',
                'regex:/^[A-Za-z][A-Za-z0-9]+@[A-Za-z][A-Za-z]+\.[A-Za-z]{2,}$/'
            ],
            'password' => 'required|string|min:6|confirmed|regex:/[A-Za-z0-9]/',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('success', 'Registro exitoso. Inicia sesión.');
    } 

    // Muestra el formulario para el login
    public function loginForm()
    {
        return view('users.login');
    }

    // Procesa el inicio de sesión del usuario
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('post.index')->with('success', 'Bienvenido');
        }

        return back()->withErrors([
            'email' => 'El usuario o contraseña no coinciden.'
        ]);
    }

    // Cierra la sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // Elimina el perfil del usuario autenticado
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        if($user instanceof User) {
            $user->delete();
        }

        return redirect()->route('register')->with('success', 'Usuario eliminado correctamente.');
    }
}
