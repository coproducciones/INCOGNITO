@extends('layouts.app')

@section('title', 'Detalle del proveedor')

@section('content')

@php
    $usuarioActual = auth()->user();
    $nombreProveedor = $proveedor->usuario?->nombre ?? 'Proveedor #' . $proveedor->id_proveedor;
    $disponibilidades = $proveedor->disponibilidades->sortBy('fecha')->take(10);
    $totalProductos = $proveedor->productos()->count();
@endphp

<div class="mx-auto max-w-4xl px-4 py-6">

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-xl font-black uppercase tracking-widest text-white">
                {{ $nombreProveedor }}
            </h1>

            <p class="mt-1 text-xs font-bold uppercase tracking-widest text-white/40">
                Detalle del proveedor
            </p>

            <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>
        </div>

        <div class="flex flex-wrap gap-3">
            <a
                href="{{ route('proveedores.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-white/15 px-4 py-2.5 text-xs font-bold uppercase tracking-widest text-white transition hover:border-[#A99045] hover:text-[#D8C17F]"
            >
                Volver
            </a>

            @if ($usuarioActual && $usuarioActual->tienePermiso('proveedores.editar'))
                <a
                    href="{{ route('proveedores.edit', $proveedor) }}"
                    class="inline-flex items-center justify-center rounded-lg bg-[#A99045] px-4 py-2.5 text-xs font-extrabold uppercase tracking-widest text-black transition hover:bg-[#D8C17F]"
                >
                    Editar
                </a>
            @endif
        </div>
    </div>

    {{-- DATOS PRINCIPALES --}}
    <div class="space-y-6 rounded-xl border border-[#A99045]/25 bg-[#111111] p-5 shadow-xl shadow-black/20 sm:p-8">

        <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <div>
                <dt class="mb-1 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">Usuario</dt>
                <dd class="text-sm text-white">{{ $proveedor->usuario?->nombre ?? 'Sin usuario asociado' }}</dd>
                @if ($proveedor->usuario?->email)
                    <dd class="text-xs text-white/50">{{ $proveedor->usuario->email }}</dd>
                @endif
            </div>

            <div>
                <dt class="mb-1 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">Especialidad</dt>
                <dd class="text-sm text-white">{{ $proveedor->especialidad }}</dd>
            </div>

            <div>
                <dt class="mb-1 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">Teléfono</dt>
                <dd class="text-sm text-white">{{ $proveedor->telefono ?: 'No registrado' }}</dd>
            </div>

            <div>
                <dt class="mb-1 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">WhatsApp</dt>
                <dd class="text-sm text-white">
                    @if ($proveedor->whatsapp_url)
                        <a
                            href="{{ $proveedor->whatsapp_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="text-[#D8C17F] underline underline-offset-4 hover:text-white"
                        >
                            {{ $proveedor->whatsapp }}
                        </a>
                    @else
                        No registrado
                    @endif
                </dd>
            </div>

            <div class="sm:col-span-2">
                <dt class="mb-1 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">Descripción</dt>
                <dd class="text-sm leading-7 text-white/80">
                    {{ $proveedor->descripcion ?: 'Sin descripción.' }}
                </dd>
            </div>

            <div class="sm:col-span-2">
                <dt class="mb-2 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">Categorías</dt>
                <dd class="flex flex-wrap gap-2">
                    @forelse ($proveedor->categorias as $categoria)
                        <span class="rounded-full border border-[#A99045]/30 bg-[#A99045]/10 px-3 py-1 text-xs font-semibold text-[#D8C17F]">
                            {{ $categoria->nombre }}
                        </span>
                    @empty
                        <span class="text-sm text-white/50">Sin categorías asignadas.</span>
                    @endforelse
                </dd>
            </div>

            <div>
                <dt class="mb-1 text-xs font-bold uppercase tracking-wider text-[#D8C17F]">Productos</dt>
                <dd class="text-sm text-white">{{ $totalProductos }}</dd>
            </div>

        </dl>
    </div>

    {{-- DISPONIBILIDAD --}}
    <div class="mt-6 rounded-xl border border-[#A99045]/25 bg-[#111111] p-5 sm:p-8">
        <h2 class="mb-4 text-xs font-bold uppercase tracking-widest text-[#D8C17F]">
            Disponibilidad registrada
        </h2>

        @if ($disponibilidades->isNotEmpty())
            <ul class="divide-y divide-white/10">
                @foreach ($disponibilidades as $disponibilidad)
                    <li class="flex items-center justify-between py-3 text-sm">
                        <span class="text-white">{{ $disponibilidad->fecha?->format('d/m/Y') }}</span>

                        @if ($disponibilidad->disponible)
                            <span class="text-xs font-semibold text-green-300">Disponible</span>
                        @else
                            <span class="text-xs font-semibold text-amber-200">No disponible</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-sm text-white/50">Este proveedor aún no registra disponibilidad.</p>
        @endif
    </div>

</div>

@endsection
