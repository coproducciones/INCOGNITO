@extends('layouts.app')

@section('title', 'Disponibilidad del proveedor')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Disponibilidad</h1>
            <p class="text-gray-400">{{ $proveedor->especialidad }}</p>
        </div>
        <a href="{{ route('proveedores.disponibilidades.create', $proveedor) }}" class="px-4 py-2 rounded-lg bg-[#00c896] text-black font-semibold">Nueva fecha</a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-green-300">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-white/10 bg-[#111111]">
        <table class="min-w-full text-sm text-gray-200">
            <thead class="border-b border-white/10 text-left text-xs uppercase tracking-wider text-gray-400">
                <tr><th class="px-4 py-3">Fecha</th><th class="px-4 py-3">Disponible</th><th class="px-4 py-3">Acciones</th></tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($disponibilidades as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->fecha->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">{{ $item->disponible ? 'Sí' : 'No' }}</td>
                        <td class="px-4 py-3">
                            <div class="flex gap-3">
                                <a href="{{ route('proveedores.disponibilidades.edit', [$proveedor, $item]) }}" class="text-yellow-300">Editar</a>
                                <form method="POST" action="{{ route('proveedores.disponibilidades.destroy', [$proveedor, $item]) }}" onsubmit="return confirm('¿Eliminar esta fecha?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-300">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">No hay registros de disponibilidad.</td></tr>
                @endforelse
                
            </tbody>
        </table>
    </div>
           {{-- ===================================================== --}}
        {{-- BOTONES --}}
        {{-- ===================================================== --}}

        <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">
            
            <a
                href="{{ route('proveedores.index') }}"
                class="rounded-lg bg-[#ffffff] px-5 py-2 text-sm font-semibold text-black transition hover:opacity-90"
            >
                Cancelar
            </a>

        </div>
</div>

@endsection
