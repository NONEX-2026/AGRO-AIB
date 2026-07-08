<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoteRequest;
use App\Models\Lote;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;

/**
 * Controlador de Lotes.
 * Maneja las operaciones CRUD de lotes agroindustriales.
 */
class LoteController extends Controller
{
    /**
     * Listar todos los lotes con filtros de busqueda.
     */
    public function index(Request $request)
    {
        $query = Lote::with('registradoPor');

        // Filtro de busqueda por codigo, producto o variedad
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function ($q) use ($busqueda) {
                $q->where('codigo', 'LIKE', "%{$busqueda}%")
                    ->orWhere('producto', 'LIKE', "%{$busqueda}%")
                    ->orWhere('variedad', 'LIKE', "%{$busqueda}%");
            });
        }

        // Filtro por etapa
        if ($request->filled('etapa')) {
            $query->where('etapa_actual', $request->etapa);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $lotes = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('lotes.index', compact('lotes'));
    }

    /**
     * Mostrar formulario para crear nuevo lote.
     */
    public function create()
    {
        $lote = null;
        return view('lotes.form', compact('lote'));
    }

    /**
     * Almacenar un nuevo lote en la base de datos.
     */
    public function store(LoteRequest $request)
    {
        // Generar codigo de lote secuencial
        $ultimoCodigo = Lote::max('id') ?? 0;
        $codigo = 'LOT-2026-' . str_pad($ultimoCodigo + 1, 3, '0', STR_PAD_LEFT);

        // Determinar estado segun la etapa
        $estado = $request->etapa_actual === 'Exportacion' ? 'Completado' : 'En Proceso';

        // Crear el lote
        $lote = Lote::create([
            'codigo'        => $codigo,
            'producto'      => $request->producto,
            'variedad'      => $request->variedad,
            'cantidad_kg'   => $request->cantidad_kg,
            'etapa_actual'  => $request->etapa_actual,
            'proveedor'     => $request->proveedor,
            'estado'        => $estado,
            'observaciones' => $request->observaciones,
            'registrado_por' => session('usuario_id'),
        ]);

        // Registrar primera entrada en trazabilidad
        Trazabilidad::create([
            'lote_id'       => $lote->id,
            'etapa'         => $request->etapa_actual,
            'fecha'         => $request->fecha,
            'observaciones' => $request->observaciones ?? 'Registro inicial del lote.',
            'responsable_id' => session('usuario_id'),
        ]);

        return redirect()->route('lotes.index')
            ->with('success', "Lote {$codigo} registrado exitosamente.");
    }

    /**
     * Mostrar formulario para editar un lote existente.
     */
    public function edit(Lote $lote)
    {
        return view('lotes.form', compact('lote'));
    }

    /**
     * Actualizar un lote existente.
     */
    public function update(LoteRequest $request, Lote $lote)
    {
        // Actualizar estado segun la etapa
        $estado = $request->etapa_actual === 'Exportacion' ? 'Completado' : 'En Proceso';

        $lote->update([
            'producto'      => $request->producto,
            'variedad'      => $request->variedad,
            'cantidad_kg'   => $request->cantidad_kg,
            'etapa_actual'  => $request->etapa_actual,
            'proveedor'     => $request->proveedor,
            'estado'        => $estado,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('lotes.index')
            ->with('success', "Lote {$lote->codigo} actualizado correctamente.");
    }

    /**
     * Eliminar un lote (eliminacion logica).
     */
    public function destroy(Lote $lote)
    {
        $codigo = $lote->codigo;
        $lote->delete();

        return redirect()->route('lotes.index')
            ->with('info', "Lote {$codigo} eliminado correctamente.");
    }
}
