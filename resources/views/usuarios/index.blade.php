@extends('layouts.app')

@section('title', 'Usuarios')
@section('pageTitle', 'Gestion de Usuarios')
@section('pageSubtitle', 'Administracion de usuarios por roles')

@section('content')
<!-- Resumen de roles -->
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:24px;">
    <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
        <div class="text-xl font-black" style="color:#d4a017;">{{ $usuarios->where('rol','Administrador')->count() }}</div>
        <div class="text-[11px] text-aib-muted mt-1">Administrador</div>
    </div>
    <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
        <div class="text-xl font-black" style="color:#38bdf8;">{{ $usuarios->where('rol','Supervisor')->count() }}</div>
        <div class="text-[11px] text-aib-muted mt-1">Supervisor</div>
    </div>
    <div class="bg-aib-card border border-aib-border rounded-xl p-4 text-center">
        <div class="text-xl font-black" style="color:#4ade80;">{{ $usuarios->whereNotIn('rol',['Administrador','Supervisor'])->count() }}</div>
        <div class="text-[11px] text-aib-muted mt-1">Operativos</div>
    </div>
</div>

<div class="flex items-center justify-between mb-6">
    <p class="text-aib-fg2 text-sm">Gestion de usuarios del sistema</p>
    <a href="/usuarios/crear" class="btn-gold" style="width:auto;"><i class="fas fa-user-plus"></i> Nuevo Usuario</a>
</div>

<div class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr><th>Usuario</th><th>Nombre Completo</th><th>Rol</th><th>Estado</th><th>Ultimo Acceso</th><th>Acciones</th></tr>
            </thead>
            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td class="text-aib-accent font-bold">{{ $u->username }}</td>
                    <td>{{ $u->nombre }}</td>
                    <td>
                        @switch($u->rol)
                            @case('Administrador')
                                <span class="badge" style="background:rgba(212,160,23,0.12);color:#d4a017;"><i class="fas fa-shield-halved"></i> {{ $u->rol }}</span>
                                @break
                            @case('Supervisor')
                                <span class="badge badge-info"><i class="fas fa-eye"></i> {{ $u->rol }}</span>
                                @break
                            @case('Operario agrícola')
                                <span class="badge badge-success"><i class="fas fa-seedling"></i> {{ $u->rol }}</span>
                                @break
                            @case('Operario de planta')
                                <span class="badge" style="background:rgba(56,189,248,0.12);color:#38bdf8;"><i class="fas fa-industry"></i> {{ $u->rol }}</span>
                                @break
                            @case('Empaquetador')
                                <span class="badge" style="background:rgba(167,139,250,0.12);color:#a78bfa;"><i class="fas fa-box"></i> {{ $u->rol }}</span>
                                @break
                            @case('Transporte')
                                <span class="badge" style="background:rgba(251,146,60,0.12);color:#fb923c;"><i class="fas fa-truck"></i> {{ $u->rol }}</span>
                                @break
                        @endswitch
                    </td>
                    <td>
                        @if($u->estado === 'Activo')
                            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:8px;"></i> Activo</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-circle" style="font-size:8px;"></i> Inactivo</span>
                        @endif
                    </td>
                    <td class="text-[13px]">{{ $u->ultimo_acceso ? $u->ultimo_acceso->format('d/m/Y H:i') : 'Nunca' }}</td>
                    <td>
                        <div class="flex gap-1.5">
                            <a href="/usuarios/{{ $u->id }}/editar" class="btn-success-aib btn-sm" title="Editar"><i class="fas fa-pen"></i></a>
                            @if($u->id !== session('usuario_id'))
                            <form method="POST" action="/usuarios/{{ $u->id }}/estado" style="display:inline;">
                                @csrf @method('PUT')
                                <button type="submit" class="btn-outline btn-sm" title="{{ $u->estado === 'Activo' ? 'Desactivar' : 'Activar' }}">
                                    <i class="fas fa-{{ $u->estado === 'Activo' ? 'ban' : 'check' }}"></i>
                                </button>
                            </form>
                            <form method="POST" action="/usuarios/{{ $u->id }}" onsubmit="return confirm('Eliminar usuario {{$u->username}}?');" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger-aib btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection