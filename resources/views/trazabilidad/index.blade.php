@extends('layouts.app')

@section('title', 'Trazabilidad')
@section('pageTitle', 'Trazabilidad')
@section('pageSubtitle', 'Seguimiento completo de la cadena productiva')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-aib-card border border-aib-border rounded-2xl p-8 mb-6">
            <label class="block text-[13px] font-semibold text-aib-fg2 mb-2">Ingrese el codigo de lote</label>
            <form method="GET" action="{{ route('trazabilidad.show', '_CODE_') }}" id="trazForm" class="flex gap-3">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-aib-muted text-[13px]"></i>
                    <input type="text" name="codigo" id="trazInput" class="input-aib" style="padding-left:36px;"
                        placeholder="Ej: LOT-2026-001" required>
                </div>
                <button type="submit" class="btn-gold" style="width:auto;"><i class="fas fa-search"></i> Buscar</button>
            </form>
        </div>

        <!-- Listado rapido de lotes -->
        <div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-aib-border">
                <h3 class="text-base font-bold">Lotes Disponibles</h3>
            </div>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th>Etapa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Lote::orderBy('codigo')->get() as $l)
                            <tr>
                                <td class="text-aib-accent font-bold">{{ $l->codigo }}</td>
                                <td>{{ $l->producto }} — {{ $l->variedad }}</td>
                                <td><span class="badge badge-info">{{ $l->etapa_actual }}</span></td>
                                <td>
                                    <a href="{{ route('trazabilidad.show', $l->codigo) }}" class="btn-outline btn-sm"><i
                                            class="fas fa-eye"></i> Ver Trazabilidad</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Interceptar el form para reemplazar _CODE_ con el valor ingresado
        document.getElementById('trazForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const code = document.getElementById('trazInput').value.trim().toUpperCase();
            if (code) {
                window.location.href = '/trazabilidad/' + encodeURIComponent(code);
            }
        });
    </script>
@endpush
