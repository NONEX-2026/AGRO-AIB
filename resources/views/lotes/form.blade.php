@extends('layouts.app')

@section('title', $lote ? 'Editar Lote' : 'Nuevo Lote')
@section('pageTitle', $lote ? 'Editar Lote ' . $lote->codigo : 'Registrar Nuevo Lote')
@section('pageSubtitle', 'Complete los datos del lote agroindustrial')

@section('content')
    <div class="max-w-3xl">
        <form method="POST" action="{{ $lote ? route('lotes.update', $lote) : route('lotes.store') }}"
            class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
            @csrf
            @if ($lote)
                @method('PUT')
            @endif

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Producto</label>
                    <select name="producto" class="input-aib" required>
                        <option value="">Seleccione un producto</option>
                        @foreach (['Esparrago', 'Palta', 'Mango', 'Uva', 'Arandano', 'Paprika', 'Aceituna'] as $p)
                            <option value="{{ $p }}"
                                {{ isset($lote) && $lote->producto === $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Variedad</label>
                    <input type="text" name="variedad" class="input-aib" placeholder="Ej: Hass, Kent, Verde..."
                        value="{{ old('variedad', $lote->variedad ?? '') }}" required>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Cantidad (kg)</label>
                    <input type="number" name="cantidad_kg" class="input-aib" placeholder="Ej: 5000" min="0.01"
                        step="0.01" value="{{ old('cantidad_kg', $lote->cantidad_kg ?? '') }}" required>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Etapa Actual</label>
                    <select name="etapa_actual" class="input-aib" required>
                        @foreach (['Cultivo', 'Recepcion', 'Procesamiento', 'Empaque', 'Almacenamiento', 'Exportacion'] as $e)
                            <option value="{{ $e }}"
                                {{ isset($lote) && $lote->etapa_actual === $e ? 'selected' : '' }}>{{ $e }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Proveedor</label>
                    <input type="text" name="proveedor" class="input-aib" placeholder="Nombre del proveedor"
                        value="{{ old('proveedor', $lote->proveedor ?? '') }}" required>
                </div>
                @if (!$lote)
                    <div>
                        <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Fecha de Registro</label>
                        <input type="date" name="fecha" class="input-aib"
                            value="{{ old('fecha', now()->format('Y-m-d')) }}" required>
                    </div>
                @endif
                <div class="md:col-span-2">
                    <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Observaciones</label>
                    <textarea name="observaciones" class="input-aib" rows="3" placeholder="Observaciones adicionales..."
                        style="resize:vertical;">{{ old('observaciones', $lote->observaciones ?? '') }}</textarea>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-aib-border flex justify-end gap-3">
                <a href="{{ route('lotes.index') }}" class="btn-outline">Cancelar</a>
                <button type="submit" class="btn-gold" style="width:auto;"><i class="fas fa-save"></i>
                    {{ $lote ? 'Actualizar' : 'Registrar' }} Lote</button>
            </div>
        </form>
    </div>
@endsection
