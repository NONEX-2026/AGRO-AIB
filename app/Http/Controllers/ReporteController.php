<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\Trazabilidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Mostrar pagina de reportes con graficos.
     */
    public function index()
    {
        // Datos para grafico: lotes por producto
        $lotesPorProducto = Lote::select('producto', DB::raw('COUNT(*) as total'))
            ->groupBy('producto')
            ->orderBy('total', 'desc')
            ->get();

        // Datos para grafico: lotes por estado
        $lotesPorEstado = Lote::select('estado', DB::raw('COUNT(*) as total'))
            ->groupBy('estado')
            ->get();

        // Resumen completo de trazabilidad
        $resumen = Lote::with('registradoPor')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($lote) {
                return [
                    'codigo'    => $lote->codigo,
                    'producto'  => $lote->producto,
                    'etapa'     => $lote->etapa_actual,
                    'estado'    => $lote->estado,
                    'fecha'     => $lote->created_at->format('d/m/Y'),
                    'dias'      => $lote->diasEnProceso(),
                    'cantidad'  => $lote->cantidad_kg,
                ];
            });

        // Estadisticas generales
        $stats = [
            'total_lotes'       => Lote::count(),
            'total_kg'          => Lote::sum('cantidad_kg'),
            'completados'       => Lote::where('estado', 'Completado')->count(),
            'en_proceso'        => Lote::where('estado', 'En Proceso')->count(),
            'total_trazabilidad' => Trazabilidad::count(),
            'proveedores'       => Lote::distinct('proveedor')->count('proveedor'),
        ];

        return view('reportes.index', compact(
            'lotesPorProducto',
            'lotesPorEstado',
            'resumen',
            'stats'
        ));
    }

    /**
     * Vista para imprimir como PDF (sin paquetes externos).
     * Se abre en nueva ventana y el navegador genera el PDF.
     */
    public function exportPdf()
    {
        $lotes = Lote::with(['registradoPor', 'trazabilidad.responsable'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_lotes' => Lote::count(),
            'total_kg'    => Lote::sum('cantidad_kg'),
            'completados' => Lote::where('estado', 'Completado')->count(),
            'en_proceso'  => Lote::where('estado', 'En Proceso')->count(),
            'fecha_reporte' => now()->format('d/m/Y H:i'),
        ];

        // Retornar vista que auto-imprime
        return view('reportes.pdf', compact('lotes', 'stats'));
    }
}
