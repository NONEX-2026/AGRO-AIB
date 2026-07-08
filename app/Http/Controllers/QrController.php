<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use Illuminate\Http\Request;

class QrController extends Controller
{
    public function index()
    {
        $lotes = Lote::orderBy('codigo', 'desc')->get();
        $lote = null;
        return view('qr.index', compact('lotes', 'lote'));
    }

    public function generate(Lote $lote)
    {
        $lotes = Lote::orderBy('codigo', 'desc')->get();
        return view('qr.index', compact('lotes', 'lote'));
    }

    public function getData(Lote $lote)
    {
        $texto = "AGROINDUSTRIAS AIB\n";
        $texto .= "Trazabilidad de Producto\n";
        $texto .= "Sede Ica - Peru\n";
        $texto .= "--------------------------\n";
        $texto .= "LOTE: " . $lote->codigo . "\n";
        $texto .= "PRODUCTO: " . $lote->producto . "\n";
        $texto .= "VARIEDAD: " . $lote->variedad . "\n";
        $texto .= "CANTIDAD: " . number_format($lote->cantidad_kg, 0) . " kg\n";
        $texto .= "PROVEEDOR: " . $lote->proveedor . "\n";
        $texto .= "ETAPA: " . $lote->etapa_actual . "\n";
        $texto .= "ESTADO: " . $lote->estado . "\n";
        $texto .= "REGISTRO: " . $lote->created_at->format('d/m/Y') . "\n";
        $texto .= "--------------------------\n";
        $texto .= "Producto trazable AIB";

        return response()->json([
            'codigo'      => $lote->codigo,
            'producto'    => $lote->producto,
            'variedad'    => $lote->variedad,
            'etapa'       => $lote->etapa_actual,
            'cantidad_kg' => number_format($lote->cantidad_kg, 0) . ' kg',
            'proveedor'   => $lote->proveedor,
            'estado'      => $lote->estado,
            'contenido_qr' => $texto,
        ]);
    }

    public function verPaginaPublica($codigo)
    {
        $lote = Lote::with('trazabilidad.responsable')
            ->where('codigo', strtoupper($codigo))
            ->first();

        if (!$lote) {
            abort(404, 'Lote no encontrado');
        }

        $etapas = ['Cultivo', 'Recepcion', 'Procesamiento', 'Empaque', 'Almacenamiento', 'Exportacion'];
        $indiceActual = array_search($lote->etapa_actual, $etapas);

        return view('qr.publica', compact('lote', 'etapas', 'indiceActual'));
    }
}
