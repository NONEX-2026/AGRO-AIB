<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderByRaw("FIELD(rol, 'Administrador','Supervisor','Operario agrícola','Operario de planta','Empaquetador','Transporte')")->orderBy('nombre')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $usuario = null;
        return view('usuarios.form', compact('usuario'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:200',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6|max:100',
            'rol'      => 'required|in:Administrador,Supervisor,Operario agrícola,Operario de planta,Empaquetador,Transporte',
            'estado'   => 'required|in:Activo,Inactivo',
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique'   => 'Este nombre de usuario ya existe.',
            'password.required' => 'La contrasena es obligatoria.',
            'password.min'      => 'La contrasena debe tener al menos 6 caracteres.',
            'rol.required'      => 'Seleccione un rol.',
            'estado.required'   => 'Seleccione un estado.',
        ]);

        User::create([
            'nombre'   => $request->nombre,
            'username' => $request->username,
            'password' => $request->password,
            'rol'      => $request->rol,
            'estado'   => $request->estado,
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario {$request->username} creado correctamente.");
    }

    public function edit(User $usuario)
    {
        return view('usuarios.form', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre'   => 'required|string|max:200',
            'username' => 'required|string|max:50|unique:users,username,' . $usuario->id,
            'password' => 'nullable|string|min:6|max:100',
            'rol'      => 'required|in:Administrador,Supervisor,Operario agrícola,Operario de planta,Empaquetador,Transporte',
            'estado'   => 'required|in:Activo,Inactivo',
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique'   => 'Este nombre de usuario ya existe.',
            'password.min'      => 'La contrasena debe tener al menos 6 caracteres.',
            'rol.required'      => 'Seleccione un rol.',
            'estado.required'   => 'Seleccione un estado.',
        ]);

        $datos = [
            'nombre'  => $request->nombre,
            'username' => $request->username,
            'rol'     => $request->rol,
            'estado'  => $request->estado,
        ];

        if ($request->filled('password')) {
            $datos['password'] = $request->password;
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')
            ->with('success', "Usuario {$usuario->username} actualizado correctamente.");
    }

    public function toggleEstado(User $usuario)
    {
        if ($usuario->id === session('usuario_id')) {
            return back()->with('error', 'No puede desactivar su propia cuenta.');
        }

        $nuevoEstado = $usuario->estado === 'Activo' ? 'Inactivo' : 'Activo';
        $usuario->update(['estado' => $nuevoEstado]);

        return back()->with('success', "Usuario {$usuario->username} cambiado a {$nuevoEstado}.");
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === session('usuario_id')) {
            return back()->with('error', 'No puede eliminar su propia cuenta.');
        }

        $username = $usuario->username;
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('info', "Usuario {$username} eliminado correctamente.");
    }
}