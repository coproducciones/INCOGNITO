@extends('layouts.app')

@section('title', 'Usuarios y proveedores')

@section('content')
<div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
    <div>
        <h1 class="font-black uppercase tracking-widest text-white" style="font-size:22px; letter-spacing:0.15em;">
            USUARIOS Y PROVEEDORES
        </h1>
        <p class="mt-1 font-bold uppercase tracking-widest" style="font-size:10px; color:rgba(255,255,255,0.4);">
            TODAS LAS CUENTAS REGISTRADAS EN LA PLATAFORMA
        </p>
    </div>

    @if(auth()->check() && auth()->user()->tienePermiso('usuarios.ver'))
        <a href="{{ route('usuarios.index') }}"
           class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-opacity hover:opacity-80"
           style="font-size:10px; color:#111; background:#A99045; border:1px solid #A99045; border-radius:4px;">
            GESTIONAR USUARIOS
        </a>
    @endif
</div>

@if(session('success'))
    <div class="mb-6 px-4 py-3 font-bold" style="font-size:12px; background:rgba(0,200,150,0.1); border:1px solid rgba(0,200,150,0.3); border-radius:4px; color:#00c896;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 rounded border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="overflow-x-auto" style="background:#1D1D1D; border:1px solid rgba(255,255,255,0.08); border-radius:6px;">
    <table class="w-full" style="min-width:1000px;">
        <thead>
            <tr style="background:#151515; border-bottom:1px solid rgba(169,144,69,0.3);">
                @foreach(['ID', 'NOMBRE', 'CORREO', 'TELÉFONO', 'TIPO DE CUENTA', 'DETALLE DE PERFIL', 'ESTADO', 'ACCIONES'] as $encabezado)
                    <th class="px-5 py-4 text-left font-black uppercase tracking-widest" style="font-size:10px; color:#D8C17F;">
                        {{ $encabezado }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
                @php
                    $rolNombre = strtolower(trim((string) optional($usuario->rol)->nombre));
                    $tipoCuenta = match ($rolNombre) {
                        'visitante' => 'Visitante',
                        'cliente' => 'Cliente',
                        'proveedor' => 'Proveedor',
                        default => optional($usuario->rol)->nombre ?: 'Sin rol asignado',
                    };
                    $estadoNombre = optional($usuario->estado)->nombre ?: 'Sin estado';
                    $estadoNormalizado = strtolower(trim($estadoNombre));
                    $estaActivo = in_array($estadoNormalizado, ['activo', 'activa', 'active', 'habilitado', 'habilitada'], true);
                @endphp
                <tr class="transition-colors hover:bg-white/[0.02]" style="border-bottom:1px solid rgba(255,255,255,0.05);">
                    <td class="px-5 py-4 font-bold" style="font-size:12px; color:#D8C17F;">#{{ $usuario->id }}</td>
                    <td class="px-5 py-4 font-bold text-white" style="font-size:12px;">{{ $usuario->nombre }}</td>
                    <td class="px-5 py-4 text-white/70" style="font-size:12px;">{{ $usuario->email }}</td>
                    <td class="px-5 py-4 text-white/70" style="font-size:12px;">{{ $usuario->telefono ?: 'No registrado' }}</td>
                    <td class="px-5 py-4" style="font-size:11px;">
                        <span class="inline-flex rounded px-3 py-1 font-black uppercase tracking-wide" style="background:rgba(169,144,69,0.13); color:#D8C17F;">
                            {{ $tipoCuenta }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-white/70" style="font-size:11px;">
                        @if($usuario->proveedor)
                            {{ $usuario->proveedor->especialidad ?: 'Perfil de proveedor' }}
                        @elseif($usuario->cliente)
                            {{ $usuario->cliente->empresa ?: 'Perfil de cliente' }}
                        @else
                            —
                        @endif
                    </td>
                    <td class="px-5 py-4" style="font-size:10px;">
                        <span class="inline-flex rounded px-3 py-1 font-black uppercase tracking-wide"
                              style="background:{{ $estaActivo ? 'rgba(0,200,150,0.12)' : 'rgba(248,113,113,0.12)' }}; color:{{ $estaActivo ? '#00c896' : '#f87171' }};">
                            {{ $estadoNombre }}
                        </span>
                    </td>
                    <td class="px-5 py-4" style="font-size:10px;">
                        @if(auth()->check() && auth()->user()->tienePermiso('usuarios.editar'))
                            <a href="{{ route('seguridad.usuarios.edit', $usuario->id) }}"
                               class="inline-flex rounded px-3 py-2 font-black uppercase tracking-wide transition-opacity hover:opacity-80"
                               style="border:1px solid rgba(169,144,69,0.35); color:#D8C17F;">
                                EDITAR CUENTA
                            </a>
                        @else
                            <span style="color:rgba(255,255,255,0.3);">SIN ACCIONES</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center font-bold" style="font-size:12px; color:rgba(255,255,255,0.45);">
                        Todavía no hay usuarios registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($usuarios->hasPages())
    <div class="mt-6">
        {{ $usuarios->links() }}
    </div>
@endif
@endsection