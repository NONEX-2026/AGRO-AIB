<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Uso: ->middleware('role:Administrador,Supervisor')
     * Permite acceso si el usuario tiene alguno de los roles indicados.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $userId = session('usuario_id');

        if (!$userId) {
            return redirect('/')
                ->with('error', 'Debe iniciar sesion.');
        }

        $user = User::find($userId);

        if (!$user || !in_array($user->rol, $roles)) {
            return redirect('/dashboard')
                ->with('error', 'No tiene permisos para acceder a esa seccion. Rol requerido: ' . implode(' o ', $roles));
        }

        return $next($request);
    }
}