<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador del Dashboard.
 * Muestra la vista general del sistema de trazabilidad.
 */
class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal.
     */
    public function index()
    {
        // Contadores de lotes por etapa
        $totalLotes = Lote::count();
        $enCultivo = Lote::whereIn('etapa_actual', ['Cultivo', 'Recepcion'])->count();
        $enProceso = Lote::whereIn('etapa_actual', ['Procesamiento', 'Empaque', 'Almacenamiento'])->count();
        $exportados = Lote::where('etapa_actual', 'Exportacion')->count();

        // Datos para grafico de produccion mensual (ultimos 6 meses)
        $produccionMensual = Lote::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as mes"),
            DB::raw('COUNT(*) as total'),
            DB::raw("SUM(CASE WHEN etapa_actual = 'Exportacion' THEN 1 ELSE 0 END) as completados")
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Distribucion por etapa
        $etapas = ['Cultivo', 'Recepcion', 'Procesamiento', 'Empaque', 'Almacenamiento', 'Exportacion'];
        $distribucionEtapas = [];
        foreach ($etapas as $etapa) {
            $distribucionEtapas[] = Lote::where('etapa_actual', $etapa)->count();
        }

        // Ultimos 5 lotes registrados
        $ultimosLotes = Lote::with('registradoPor')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalLotes',
            'enCultivo',
            'enProceso',
            'exportados',
            'produccionMensual',
            'distribucionEtapas',
            'etapas',
            'ultimosLotes'
        ));
    }
}
