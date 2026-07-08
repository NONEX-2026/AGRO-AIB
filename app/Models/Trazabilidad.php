<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trazabilidad extends Model
{
    use HasFactory;

    /**
     * Nombre exacto de la tabla.
     * Laravel pluraliza mal "trazabilidad" → "trazabilidads"
     * Por eso lo forzamos aqui.
     */
    protected $table = 'trazabilidad';

    /**
     * Campos asignables masivamente.
     */
    protected $fillable = [
        'lote_id',
        'etapa',
        'fecha',
        'observaciones',
        'responsable_id',
    ];

    /**
     * Conversiones de tipos.
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

    /**
     * Relacion: trazabilidad pertenece a un lote.
     */
    public function lote()
    {
        return $this->belongsTo(Lote::class, 'lote_id');
    }

    /**
     * Relacion: trazabilidad pertenece a un usuario (responsable).
     */
    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
