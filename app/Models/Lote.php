<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    /**
     * Campos asignables masivamente.
     */
    protected $fillable = [
        'codigo',
        'producto',
        'variedad',
        'cantidad_kg',
        'etapa_actual',
        'proveedor',
        'estado',
        'observaciones',
        'registrado_por',
    ];

    /**
     * Conversiones de tipos.
     */
    protected function casts(): array
    {
        return [
            'cantidad_kg' => 'decimal:2',
            'fecha' => 'date',
        ];
    }

    /**
     * Relacion: lote pertenece a un usuario (quien lo registro).
     */
    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Relacion: lote tiene muchas trazabilidades.
     */
    public function trazabilidad()
    {
        return $this->hasMany(Trazabilidad::class, 'lote_id')->orderBy('fecha');
    }

    /**
     * Obtener la siguiente etapa en la cadena productiva.
     */
    public function siguienteEtapa(): ?string
    {
        $etapas = [
            'Cultivo',
            'Recepcion',
            'Procesamiento',
            'Empaque',
            'Almacenamiento',
            'Exportacion'
        ];
        $indice = array_search($this->etapa_actual, $etapas);
        if ($indice !== false && $indice < count($etapas) - 1) {
            return $etapas[$indice + 1];
        }
        return null;
    }

    /**
     * Verificar si el lote esta completo (exportado).
     */
    public function estaCompletado(): bool
    {
        return $this->etapa_actual === 'Exportacion';
    }

    /**
     * Generar contenido para el codigo QR.
     */
    public function contenidoQR(): string
    {
        $url = url("/trazabilidad/{$this->codigo}");
        return json_encode([
            'codigo'      => $this->codigo,
            'producto'    => $this->producto,
            'variedad'    => $this->variedad,
            'etapa'       => $this->etapa_actual,
            'cantidad_kg' => $this->cantidad_kg,
            'proveedor'   => $this->proveedor,
            'estado'      => $this->estado,
            'url_traza'   => $url,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * Calcular dias desde el registro.
     */
    public function diasEnProceso(): int
    {
        return $this->created_at->diffInDays(now());
    }
}
