@extends('layouts.app')

@section('title', 'Reportes')
@section('pageTitle', 'Reportes')
@section('pageSubtitle', 'Informes de produccion y trazabilidad')

@section('content')
    <!-- Estadisticas generales -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
            <div class="text-2xl font-black text-aib-accent">{{ $stats['total_lotes'] }}</div>
            <div class="text-[11px] text-aib-muted mt-1">Total Lotes</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
            <div class="text-2xl font-black text-green-400">{{ number_format($stats['total_kg'], 0) }}</div>
            <div class="text-[11px] text-aib-muted mt-1">Total kg</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
            <div class="text-2xl font-black text-green-400">{{ $stats['completados'] }}</div>
            <div class="text-[11px] text-aib-muted mt-1">Completados</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
            <div class="text-2xl font-black text-yellow-400">{{ $stats['en_proceso'] }}</div>
            <div class="text-[11px] text-aib-muted mt-1">En Proceso</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
            <div class="text-2xl font-black text-sky-400">{{ $stats['total_trazabilidad'] }}</div>
            <div class="text-[11px] text-aib-muted mt-1">Reg. Trazabilidad</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
            <div class="text-2xl font-black text-purple-400">{{ $stats['proveedores'] }}</div>
            <div class="text-[11px] text-aib-muted mt-1">Proveedores</div>
        </div>
    </div>

    <!-- Graficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
        <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-aib-border">
                <h3 class="text-base font-bold">Lotes por Producto</h3>
            </div>
            <div class="p-5" style="height:280px;"><canvas id="chartProducto"></canvas></div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-aib-border">
                <h3 class="text-base font-bold">Lotes por Estado</h3>
            </div>
            <div class="p-5" style="height:280px;"><canvas id="chartEstado"></canvas></div>
        </div>
    </div>

    <!-- Tabla resumen -->
    <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
        <div class="p-5 border-b border-aib-border flex items-center justify-between">
            <h3 class="text-base font-bold">Resumen de Trazabilidad</h3>
            <a href="{{ route('reportes.pdf') }}" class="btn-outline btn-sm"><i class="fas fa-file-pdf"></i> Exportar
                PDF</a>
        </div>
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Etapa Actual</th>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                        <th>Dias en Proceso</th>
                        <th>QR</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resumen as $r)
                        <tr>
                            <td class="text-aib-accent font-bold">{{ $r['codigo'] }}</td>
                            <td>{{ $r['producto'] }}</td>
                            <td><span class="badge badge-info">{{ $r['etapa'] }}</span></td>
                            <td>
                                @if ($r['estado'] === 'Completado')
                                    <span class="badge badge-success">Completado</span>
                                @else
                                    <span class="badge badge-warning">En Proceso</span>
                                @endif
                            </td>
                            <td>{{ $r['fecha'] }}</td>
                            <td>{{ $r['dias'] }} dias</td>
                            <td>
                                <a href="{{ route('qr.generate', \App\Models\Lote::where('codigo', $r['codigo'])->first()) }}"
                                    class="btn-outline btn-sm"><i class="fas fa-qrcode"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Grafico por producto
        new Chart(document.getElementById('chartProducto'), {
            type: 'bar',
            data: {
                labels: @json($lotesPorProducto->pluck('producto')),
                datasets: [{
                    label: 'Cantidad de Lotes',
                    data: @json($lotesPorProducto->pluck('total')),
                    backgroundColor: ['rgba(212,160,23,0.6)', 'rgba(74,222,128,0.6)',
                        'rgba(56,189,248,0.6)', 'rgba(167,139,250,0.6)', 'rgba(244,114,182,0.6)',
                        'rgba(251,146,60,0.6)', 'rgba(163,184,158,0.6)'
                    ],
                    borderColor: ['#d4a017', '#4ade80', '#38bdf8', '#a78bfa', '#f472b6', '#fb923c',
                        '#a3b89e'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6b8264'
                        },
                        grid: {
                            color: 'rgba(46,74,40,0.2)'
                        },
                        beginAtZero: true
                    },
                    y: {
                        ticks: {
                            color: '#a3b89e'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Grafico por estado
        new Chart(document.getElementById('chartEstado'), {
            type: 'pie',
            data: {
                labels: @json($lotesPorEstado->pluck('estado')),
                datasets: [{
                    data: @json($lotesPorEstado->pluck('total')),
                    backgroundColor: ['rgba(74,222,128,0.7)', 'rgba(251,191,36,0.7)',
                        'rgba(239,68,68,0.7)'],
                    borderColor: '#1c2a18',
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#a3b89e',
                            font: {
                                family: 'DM Sans',
                                size: 12
                            },
                            padding: 16,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    </script>
@endpush
