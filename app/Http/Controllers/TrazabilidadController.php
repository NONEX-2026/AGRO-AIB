<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;

/**
 * Controlador de Trazabilidad.
 * Maneja el seguimiento completo de la cadena productiva.
 */
class TrazabilidadController extends Controller
{
    /**
     * Mostrar formulario de busqueda de trazabilidad.
     */
    public function index()
    {
        return view('trazabilidad.index');
    }

    /**
     * Buscar y mostrar la trazabilidad de un lote por su codigo.
     */
    public function show($codigo)
    {
        // Buscar lote por codigo
        $lote = Lote::with(['trazabilidad.responsable', 'registradoPor'])
            ->where('codigo', strtoupper($codigo))
            ->first();

        if (!$lote) {
            return redirect()->route('trazabilidad.index')
                ->with('error', "No existe ningun lote con el codigo: {$codigo}");
        }

        // Etapas ordenadas de la cadena productiva
        $etapas = [
            'Cultivo',
            'Recepcion',
            'Procesamiento',
            'Empaque',
            'Almacenamiento',
            'Exportacion'
        ];

        // Etapas ya completadas
        $etapasCompletadas = $lote->trazabilidad->pluck('etapa')->toArray();

        // Siguiente etapa disponible
        $siguienteEtapa = null;
        $indiceActual = array_search($lote->etapa_actual, $etapas);
        if ($indiceActual !== false && $indiceActual < count($etapas) - 1) {
            $siguienteEtapa = $etapas[$indiceActual + 1];
        }

        // Etapas pendientes
        $etapasPendientes = array_slice($etapas, $indiceActual + 1);

        // Verificar permisos para avanzar etapa
        $puedeAvanzar = $siguienteEtapa !== null;

        return view('trazabilidad.show', compact(
            'lote',
            'etapas',
            'etapasCompletadas',
            'siguienteEtapa',
            'etapasPendientes',
            'puedeAvanzar'
        ));
    }

    /**
     * Avanzar un lote a la siguiente etapa de la cadena productiva.
     */
    public function avanzarEtapa(Request $request)
    {
        // Validar datos
        $request->validate([
            'lote_id'      => 'required|exists:lotes,id',
            'nueva_etapa'  => 'required|in:Recepcion,Procesamiento,Empaque,Almacenamiento,Exportacion',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $lote = Lote::findOrFail($request->lote_id);

        // Verificar que la etapa sea la siguiente correcta
        $siguiente = $lote->siguienteEtapa();
        if ($siguiente !== $request->nueva_etapa) {
            return back()->with('error', 'La etapa seleccionada no es la siguiente en la cadena productiva.');
        }

        // Crear registro de trazabilidad
        Trazabilidad::create([
            'lote_id'       => $lote->id,
            'etapa'         => $request->nueva_etapa,
            'fecha'         => $request->fecha ?? now()->toDateString(),
            'observaciones' => $request->observaciones ?? "Avance a etapa: {$request->nueva_etapa}",
            'responsable_id' => session('usuario_id'),
        ]);

        // Actualizar etapa y estado del lote
        $estado = $request->nueva_etapa === 'Exportacion' ? 'Completado' : 'En Proceso';
        $lote->update([
            'etapa_actual' => $request->nueva_etapa,
            'estado'       => $estado,
        ]);

        return redirect()->route('trazabilidad.show', $lote->codigo)
            ->with('success', "Lote avanzado a la etapa: {$request->nueva_etapa}");
    }
}
