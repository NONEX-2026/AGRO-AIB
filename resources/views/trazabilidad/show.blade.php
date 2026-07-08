@extends('layouts.app')

@section('title', 'Trazabilidad — ' . $lote->codigo)
@section('pageTitle', 'Trazabilidad del Lote')
@section('pageSubtitle', $lote->codigo . ' — ' . $lote->producto . ' ' . $lote->variedad)

@section('content')
    <!-- Datos del lote -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-aib-card border border-aib-border rounded-2xl p-5">
            <div class="text-[12px] text-aib-muted mb-1">Codigo de Lote</div>
            <div class="text-2xl font-black text-aib-accent">{{ $lote->codigo }}</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-2xl p-5">
            <div class="text-[12px] text-aib-muted mb-1">Producto</div>
            <div class="text-lg font-bold">{{ $lote->producto }} — {{ $lote->variedad }}</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-2xl p-5">
            <div class="text-[12px] text-aib-muted mb-1">Estado Actual</div>
            <div>
                @if ($lote->estado === 'Completado')
                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Completado</span>
                @else
                    <span class="badge badge-warning"><i class="fas fa-clock"></i> En Proceso</span>
                @endif
                <span class="badge badge-info ml-1">{{ $lote->etapa_actual }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-aib-card border border-aib-border rounded-2xl p-5">
            <div class="text-[12px] text-aib-muted">Cantidad</div>
            <div class="text-xl font-bold">{{ number_format($lote->cantidad_kg, 0) }} kg</div>
        </div>
        <div class="bg-aib-card border border-aib-border rounded-2xl p-5">
            <div class="text-[12px] text-aib-muted">Proveedor</div>
            <div class="text-base font-medium">{{ $lote->proveedor }}</div>
        </div>
    </div>

    <!-- Historial de trazabilidad -->
    <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden mb-6">
        <div class="p-5 border-b border-aib-border flex items-center justify-between">
            <h3 class="text-base font-bold">Historial de Trazabilidad</h3>
            @if ($siguienteEtapa && in_array(session('usuario_rol'), ['Administrador', 'Supervisor']))
                <button onclick="document.getElementById('avanzarModal').classList.remove('hidden')"
                    class="btn-gold btn-sm">
                    <i class="fas fa-forward"></i> Avanzar a {{ $siguienteEtapa }}
                </button>
            @endif
        </div>
        <div class="p-6">
            <div class="timeline">
                @foreach ($lote->trazabilidad as $t)
                    <div class="timeline-item">
                        <div class="flex justify-between items-start mb-1">
                            <span class="font-bold text-[15px] text-aib-fg">{{ $t->etapa }}</span>
                            <span class="text-[12px] text-aib-muted">{{ $t->fecha->format('d/m/Y') }}</span>
                        </div>
                        <p class="text-[13px] text-aib-fg2 mb-1">{{ $t->observaciones }}</p>
                        <span class="text-[11px] text-aib-muted"><i
                                class="fas fa-user mr-1"></i>{{ $t->responsable->nombre }}</span>
                    </div>
                @endforeach
            </div>

            @if (count($etapasPendientes) > 0)
                <div class="mt-6 p-4 rounded-xl border border-dashed text-center"
                    style="background:rgba(212,160,23,0.06);border-color:rgba(212,160,23,0.2);">
                    <i class="fas fa-hourglass-half text-aib-accent mr-1"></i>
                    <span class="text-[13px] text-aib-fg2">Etapas pendientes:
                        {{ implode(' → ', $etapasPendientes) }}</span>
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('trazabilidad.index') }}" class="btn-outline"><i class="fas fa-arrow-left"></i> Volver a busqueda</a>

    <!-- Modal para avanzar etapa -->
    <div id="avanzarModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center"
        style="background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);">
        <div class="bg-aib-card border border-aib-border rounded-2xl w-[500px] max-w-[95vw]"
            style="box-shadow:0 25px 80px rgba(0,0,0,0.6);animation:modalIn 0.3s ease-out;">
            <div class="p-6 border-b border-aib-border flex items-center justify-between">
                <h3 class="text-lg font-bold">Registrar Avance de Etapa</h3>
                <button onclick="document.getElementById('avanzarModal').classList.add('hidden')"
                    class="bg-transparent border-none text-aib-muted text-xl cursor-pointer"><i
                        class="fas fa-times"></i></button>
            </div>
            <form method="POST" action="{{ route('trazabilidad.avanzar') }}">
                @csrf
                <input type="hidden" name="lote_id" value="{{ $lote->id }}">
                <input type="hidden" name="nueva_etapa" value="{{ $siguienteEtapa }}">
                <div class="p-6">
                    <p class="text-aib-fg2 text-sm mb-4">Lote: <strong class="text-aib-accent">{{ $lote->codigo }}</strong>
                        — Avanzar a: <strong class="text-green-400">{{ $siguienteEtapa }}</strong></p>
                    <div class="mb-4">
                        <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Fecha</label>
                        <input type="date" name="fecha" class="input-aib" value="{{ now()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Observaciones de la etapa</label>
                        <textarea name="observaciones" class="input-aib" rows="3" placeholder="Detalle del proceso en esta etapa..."
                            style="resize:vertical;"></textarea>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-aib-border flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('avanzarModal').classList.add('hidden')"
                        class="btn-outline">Cancelar</button>
                    <button type="submit" class="btn-gold" style="width:auto;"><i class="fas fa-forward"></i> Avanzar
                        Etapa</button>
                </div>
            </form>
        </div>
    </div>
@endsection
