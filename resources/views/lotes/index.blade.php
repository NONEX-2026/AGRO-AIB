@extends('layouts.app')

@section('title', 'Gestion de Lotes')
@section('pageTitle', 'Gestion de Lotes')
@section('pageSubtitle', 'Registro y seguimiento de lotes agroindustriales')

@section('content')
    <!-- Filtros y busqueda -->
    <div class="flex flex-wrap items-end justify-between gap-3 mb-6">
        <div class="flex flex-wrap gap-3">
            <form method="GET" action="{{ route('lotes.index') }}" class="flex flex-wrap gap-3">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-aib-muted text-[13px]"></i>
                    <input type="text" name="buscar" class="input-aib" style="padding-left:36px;width:260px;"
                        placeholder="Buscar por codigo o producto..." value="{{ request('buscar') }}">
                </div>
                <select name="etapa" class="input-aib" style="width:180px;">
                    <option value="">Todas las etapas</option>
                    @foreach (['Cultivo', 'Recepcion', 'Procesamiento', 'Empaque', 'Almacenamiento', 'Exportacion'] as $e)
                        <option value="{{ $e }}" {{ request('etapa') == $e ? 'selected' : '' }}>
                            {{ $e }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-outline btn-sm"><i class="fas fa-filter"></i> Filtrar</button>
            </form>
        </div>
        <a href="{{ route('lotes.create') }}" class="btn-gold" style="width:auto;">
            <i class="fas fa-plus"></i> Nuevo Lote
        </a>
    </div>

    <!-- Tabla de lotes -->
    <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Producto</th>
                        <th>Variedad</th>
                        <th>Etapa</th>
                        <th>Cantidad (kg)</th>
                        <th>Fecha Registro</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($lotes->count() == 0)
                        <tr>
                            <td colspan="8" class="text-center py-12 text-aib-muted">No se encontraron lotes con los
                                filtros aplicados.</td>
                        </tr>
                    @endif
                    @foreach ($lotes as $l)
                        <tr>
                            <td class="text-aib-accent font-bold">{{ $l->codigo }}</td>
                            <td class="font-medium text-aib-fg">{{ $l->producto }}</td>
                            <td>{{ $l->variedad }}</td>
                            <td><span class="badge badge-info">{{ $l->etapa_actual }}</span></td>
                            <td>{{ number_format($l->cantidad_kg, 0) }}</td>
                            <td>{{ $l->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($l->estado === 'Completado')
                                    <span class="badge badge-success"><i class="fas fa-check-circle"></i> Completado</span>
                                @else
                                    <span class="badge badge-warning"><i class="fas fa-clock"></i> En Proceso</span>
                                @endif
                            </td>
                            <td>
                                <div class="flex gap-1.5">
                                    <a href="{{ route('trazabilidad.show', $l->codigo) }}" class="btn-outline btn-sm"
                                        title="Ver trazabilidad">
                                        <i class="fas fa-route"></i>
                                    </a>
                                    <a href="{{ route('lotes.edit', $l) }}" class="btn-success-aib btn-sm" title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('lotes.destroy', $l) }}"
                                        onsubmit="return confirm('¿Esta seguro de eliminar el lote {{ $l->codigo }}?');"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-danger-aib btn-sm" title="Eliminar"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Paginacion -->
    @if ($lotes->hasPages())
        <div class="mt-6 flex justify-center gap-1">
            {{ $lotes->links() }}
        </div>
    @endif
@endsection
