@extends('layouts.app')

@section('title', 'Gestión de contenido')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">Contenido</h1>
            <p class="text-sm text-gray-400">Administra la información pública del sistema.</p>
        </div>
        <a href="{{ route('contenidos.create') }}" class="rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:bg-[#00a87e]">Nuevo contenido</a>
    </div>

    @if(session('success'))
        <div class="rounded-lg border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-gray-300">
                <thead class="border-b border-white/10 bg-[#1a1a1a] text-xs uppercase tracking-wider text-gray-400">
                    <tr><th class="px-5 py-4">Título</th><th class="px-5 py-4">Sección</th><th class="px-5 py-4">Descripción</th><th class="px-5 py-4 text-right">Acciones</th></tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                @forelse($contenidos as $contenido)
                    <tr class="hover:bg-white/[0.02]">
                        <td class="px-5 py-4 font-medium text-white">{{ $contenido->titulo }}</td>
                        <td class="px-5 py-4">{{ $contenido->seccion }}</td>
                        <td class="max-w-md px-5 py-4">{{ Str::limit($contenido->descripcion, 100) }}</td>
                        <td class="px-5 py-4 text-right"><a class="mr-3 text-[#00c896]" href="{{ route('contenidos.edit', $contenido) }}">Editar</a><form class="inline" method="POST" action="{{ route('contenidos.destroy', $contenido) }}">@csrf @method('DELETE')<button onclick="return confirm('¿Eliminar este contenido?')" class="text-red-400">Eliminar</button></form></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-gray-500">No hay contenido registrado.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
