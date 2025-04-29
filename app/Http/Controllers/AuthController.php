<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Mostrar formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Registrar un nuevo usuario
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->input('name'))->first();

        if ($user) {

            return back()->with('error', 'This name is already taken ');


        }

        $user = new User();
        $user->name = $request->input('name');
        $user->password = $request->input('password'); // Se encripta automáticamente
        $user->created = now();
        $user->lastlogin = now();
        $user->online = 1;
        $user->banned = 0;
        $user->save();

        Session::put('user', $user);

        return redirect('/')->with('success', '¡Registro exitoso!');
    }


    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Iniciar sesión
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $request->input('name'))->first();

        if ($user && $user->checkPassword($request->input('password'))) {
            // Autenticamos manualmente
            Auth::login($user); // <- Esto usa el Auth system

            $user->lastlogin = now();
            $user->online = 1;
            $user->save();

            return redirect('/inventory')->with('success', '¡Has iniciado sesión exitosamente!');
        } else {
            return back()->with('error', 'Incorrect username or password');
        }
    }


    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada.');
    }
}
