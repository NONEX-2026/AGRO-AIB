@extends('layouts.app')

@section('title', $usuario ? 'Editar Usuario' : 'Nuevo Usuario')
@section('pageTitle', $usuario ? 'Editar Usuario' : 'Nuevo Usuario')
@section('pageSubtitle', $usuario ? 'Modificar datos del usuario' : 'Crear una nueva cuenta de acceso')

@section('content')
<div class="max-w-xl">
    <form method="POST" action="{{ $usuario ? route('usuarios.update', $usuario) : route('usuarios.store') }}" class="bg-aib-card border border-aib-border rounded-2xl overflow-hidden">
        @csrf
        @if($usuario) @method('PUT') @endif

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Nombre Completo</label>
                <input type="text" name="nombre" class="input-aib" placeholder="Nombre y apellido" value="{{ old('nombre', $usuario->nombre ?? '') }}" required>
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Nombre de Usuario</label>
                <input type="text" name="username" class="input-aib" placeholder="Nombre de usuario" value="{{ old('username', $usuario->username ?? '') }}" required>
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">
                    Contrasena @if($usuario) <span class="text-aib-muted font-normal">(dejar vacio para no cambiar)</span> @endif
                </label>
                <input type="password" name="password" class="input-aib" placeholder="{{ $usuario ? 'Nueva contrasena' : 'Contrasena' }}" {{ $usuario ? '' : 'required' }} minlength="6">
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Rol</label>
                <select name="rol" class="input-aib" required>
                    <option value="Administrador" {{ isset($usuario) && $usuario->rol === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="Supervisor" {{ isset($usuario) && $usuario->rol === 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                    <option value="Operario agrícola" {{ isset($usuario) && $usuario->rol === 'Operario agrícola' ? 'selected' : '' }}>Operario agrícola</option>
                    <option value="Operario de planta" {{ isset($usuario) && $usuario->rol === 'Operario de planta' ? 'selected' : '' }}>Operario de planta</option>
                    <option value="Empaquetador" {{ isset($usuario) && $usuario->rol === 'Empaquetador' ? 'selected' : '' }}>Empaquetador</option>
                    <option value="Transporte" {{ isset($usuario) && $usuario->rol === 'Transporte' ? 'selected' : '' }}>Transporte</option>
                </select>
            </div>
            <div>
                <label class="block text-[13px] font-semibold text-aib-fg2 mb-1.5">Estado</label>
                <select name="estado" class="input-aib" required>
                    <option value="Activo" {{ isset($usuario) && $usuario->estado === 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Inactivo" {{ isset($usuario) && $usuario->estado === 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-aib-border flex justify-end gap-3">
            <a href="/usuarios" class="btn-outline">Cancelar</a>
            <button type="submit" class="btn-gold" style="width:auto;"><i class="fas fa-save"></i> Guardar</button>
        </div>
    </form>
</div>
@endsection