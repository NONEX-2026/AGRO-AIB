<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos asignables masivamente.
     */
    protected $fillable = [
        'nombre',
        'username',
        'password',
        'rol',
        'estado',
        'ultimo_acceso',
    ];

    /**
     * Ocultar contraseña en serializaciones.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversiones de tipos.
     */
    protected function casts(): array
    {
        return [
            'ultimo_acceso' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relacion: usuario registra muchos lotes.
     */
    public function lotesRegistrados()
    {
        return $this->hasMany(Lote::class, 'registrado_por');
    }

    /**
     * Relacion: usuario es responsable de muchas trazabilidades.
     */
    public function trazabilidades()
    {
        return $this->hasMany(Trazabilidad::class, 'responsable_id');
    }

    /**
     * Verificar si el usuario tiene un rol especifico.
     */
    public function tieneRol(string $rol): bool
    {
        return $this->rol === $rol;
    }

    /**
     * Verificar si el usuario es administrador.
     */
    public function esAdmin(): bool
    {
        return $this->rol === 'Administrador';
    }

    /**
     * Verificar si el usuario puede gestionar usuarios.
     */
    public function puedeGestionarUsuarios(): bool
    {
        return $this->rol === 'Administrador';
    }

    /**
     * Verificar si el usuario puede avanzar etapas.
     */
    public function puedeAvanzarEtapa(): bool
    {
        return in_array($this->rol, ['Administrador', 'Supervisor']);
    }

    /**
     * Obtener iniciales del nombre.
     */
    public function iniciales(): string
    {
        $partes = explode(' ', $this->nombre);
        return strtoupper(
            substr($partes[0], 0, 1) .
            (isset($partes[1]) ? substr($partes[1], 0, 1) : '')
        );
    }
}