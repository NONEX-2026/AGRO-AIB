@extends('layouts.app')

@section('title', 'Dashboard')
@section('pageTitle', 'Dashboard')
@section('pageSubtitle', 'Vista general del sistema de trazabilidad')

@section('content')
    <!-- Tarjetas de estadisticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <div class="stat-card bg-aib-card border border-aib-border rounded-2xl p-6 fade-up">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4"
                style="background:rgba(212,160,23,0.12);color:#d4a017;">
                <i class="fas fa-boxes-stacked"></i>
            </div>
            <div class="text-3xl font-black leading-none">{{ $totalLotes }}</div>
            <div class="text-[13px] text-aib-fg2 mt-1.5">Lotes Registrados</div>
            <div class="text-xs mt-2 font-semibold text-green-400"><span class="pulse-dot"></span> Activos</div>
        </div>
        <div class="stat-card bg-aib-card border border-aib-border rounded-2xl p-6 fade-up delay-1">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4"
                style="background:rgba(74,222,128,0.12);color:#4ade80;">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="text-3xl font-black leading-none">{{ $enCultivo }}</div>
            <div class="text-[13px] text-aib-fg2 mt-1.5">En Cultivo / Recepcion</div>
            <div class="text-xs mt-2 font-semibold text-green-400"><i class="fas fa-arrow-up"></i> Proceso activo</div>
        </div>
        <div class="stat-card bg-aib-card border border-aib-border rounded-2xl p-6 fade-up delay-2">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4"
                style="background:rgba(56,189,248,0.12);color:#38bdf8;">
                <i class="fas fa-industry"></i>
            </div>
            <div class="text-3xl font-black leading-none">{{ $enProceso }}</div>
            <div class="text-[13px] text-aib-fg2 mt-1.5">En Procesamiento</div>
            <div class="text-xs mt-2 font-semibold text-sky-400"><i class="fas fa-cog fa-spin"></i> En curso</div>
        </div>
        <div class="stat-card bg-aib-card border border-aib-border rounded-2xl p-6 fade-up delay-3">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl mb-4"
                style="background:rgba(244,114,182,0.12);color:#f472b6;">
                <i class="fas fa-ship"></i>
            </div>
            <div class="text-3xl font-black leading-none">{{ $exportados }}</div>
            <div class="text-[13px] text-aib-fg2 mt-1.5">Exportados</div>
            <div class="text-xs mt-2 font-semibold text-pink-400"><i class="fas fa-check-circle"></i> Completados</div>
        </div>
    </div>

    <!-- Graficos -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-8">
        <div class="lg:col-span-2 bg-aib-card border border-aib-border rounded-2xl overflow-hidden fade-up delay-2">
            <div class="p-5 border-b border-aib-border flex items-center justify-between">
                <h3 class="text-base font-bold">Produccion Mensual</h3>
                <span class="badge badge-success">2026</span>
            </div>
            <div class="p-5" style="height:280px;">
                <canvas id="chartProduccion"></canvas>
            </div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden fade-up delay-3">
            <div class="p-5 border-b border-aib-border">
                <h3 class="text-base font-bold">Distribucion por Etapa</h3>
            </div>
            <div class="p-5" style="height:280px;">
                <canvas id="chartEtapas"></canvas>
            </div>
        </div>
    </div>

    <!-- Ultimos lotes -->
    <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden fade-up delay-4">
        <div class="p-5 border-b border-aib-border flex items-center justify-between">
            <h3 class="text-base font-bold">Ultimos Lotes Registrados</h3>
            <a href="{{ route('lotes.index') }}" class="btn-outline btn-sm">Ver todos <i
                    class="fas fa-arrow-right ml-1"></i></a>
        </div>
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Codigo Lote</th>
                        <th>Producto</th>
                        <th>Etapa</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ultimosLotes as $l)
                        <tr>
                            <td class="text-aib-accent font-bold">{{ $l->codigo }}</td>
                            <td>{{ $l->producto }}</td>
                            <td><span class="badge badge-info">{{ $l->etapa_actual }}</span></td>
                            <td>{{ $l->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($l->estado === 'Completado')
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Completado</span>
                                @else
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> En Proceso</span>
                                @endif
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
        // Grafico de produccion mensual
        new Chart(document.getElementById('chartProduccion'), {
            type: 'bar',
            data: {
                labels: ['Sep', 'Oct', 'Nov', 'Dic', 'Ene', 'Feb'],
                datasets: [{
                    label: 'Lotes Registrados',
                    data: [1, 2, 1, 2, 2, 0],
                    backgroundColor: 'rgba(212,160,23,0.6)',
                    borderColor: 'rgba(212,160,23,1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 28,
                }, {
                    label: 'Completados',
                    data: [0, 0, 0, 1, 1, 0],
                    backgroundColor: 'rgba(74,222,128,0.6)',
                    borderColor: 'rgba(74,222,128,1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    barThickness: 28,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#a3b89e',
                            font: {
                                family: 'DM Sans'
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6b8264'
                        },
                        grid: {
                            color: 'rgba(46,74,40,0.2)'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#6b8264',
                            stepSize: 1
                        },
                        grid: {
                            color: 'rgba(46,74,40,0.2)'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafico de distribucion por etapa
        new Chart(document.getElementById('chartEtapas'), {
            type: 'doughnut',
            data: {
                labels: @json($etapas),
                datasets: [{
                    data: @json($distribucionEtapas),
                    backgroundColor: ['#4ade80', '#38bdf8', '#d4a017', '#a78bfa', '#f472b6', '#fb923c'],
                    borderColor: '#1c2a18',
                    borderWidth: 3,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#a3b89e',
                            font: {
                                family: 'DM Sans',
                                size: 11
                            },
                            padding: 12,
                            usePointStyle: true,
                            pointStyleWidth: 8
                        }
                    }
                }
            }
        });
    </script>
@endpush
