<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('usuario_id')) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Usuario o contrasena incorrectos.');
        }

        if ($user->estado !== 'Activo') {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Cuenta desactivada.');
        }

        session([
            'usuario_id'       => $user->id,
            'usuario_nombre'   => $user->nombre,
            'usuario_rol'      => $user->rol,
            'usuario_username' => $user->username,
        ]);

        $user->update(['ultimo_acceso' => now()]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }
}