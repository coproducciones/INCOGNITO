
@extends('layouts.app')

@section('title', 'Editar disponibilidad')

@section('content')
@php
    $esPersonal = $esMiDisponibilidad ?? false;
@endphp

<div class="mx-auto max-w-3xl space-y-6 px-4 py-6 sm:px-6">

    {{-- ENCABEZADO --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00c896]">
            Incógnito | Grupo de Diseño
        </p>

        <h1 class="mt-2 text-2xl font-bold text-white">
            {{ $esPersonal ? 'Editar mi disponibilidad' : 'Editar disponibilidad' }}
        </h1>

        <p class="mt-2 text-sm text-gray-400">
            Modifica la fecha y el estado de disponibilidad registrados.
        </p>
    </div>

    {{-- ERRORES --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-4">
            <p class="mb-2 font-semibold text-red-300">
                Revisa los siguientes errores:
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-200">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- INFORMACIÓN --}}
    <div class="rounded-xl border border-white/10 bg-[#111111] p-5">
        <p class="text-xs uppercase tracking-wider text-gray-500">
            Proveedor asociado
        </p>

        <p class="mt-2 font-semibold text-white">
            {{ $proveedor->especialidad }}
        </p>

        <p class="mt-1 text-sm text-gray-400">
            Fecha registrada:
            {{ $disponibilidad->fecha->format('d/m/Y') }}
        </p>
    </div>

    {{-- FORMULARIO --}}
    <form
        method="POST"
        action="{{ $esPersonal
            ? route('mi-disponibilidad.update', $disponibilidad)
            : route('proveedores.disponibilidades.update', [$proveedor, $disponibilidad]) }}"
        class="space-y-6 rounded-xl border border-white/10 bg-[#111111] p-6"
    >
        @csrf
        @method('PUT')

        <div>
            <label for="fecha" class="mb-2 block text-sm font-medium text-gray-300">
                Fecha de disponibilidad
            </label>

            <input
                type="date"
                id="fecha"
                name="fecha"
                value="{{ old('fecha', $disponibilidad->fecha->format('Y-m-d')) }}"
                required
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white outline-none transition focus:border-[#00c896]"
            >

            @error('fecha')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="disponible" class="mb-2 block text-sm font-medium text-gray-300">
                ¿Estarás disponible?
            </label>

            <select
                id="disponible"
                name="disponible"
                required
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white outline-none transition focus:border-[#00c896]"
            >
                <option
                    value="1"
                    @selected((string) old('disponible', (int) $disponibilidad->disponible) === '1')
                >
                    Sí, estaré disponible
                </option>

                <option
                    value="0"
                    @selected((string) old('disponible', (int) $disponibilidad->disponible) === '0')
                >
                    No estaré disponible
                </option>
            </select>

            @error('disponible')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- BOTONES --}}
        <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">

            <a
                href="{{ $esPersonal
                    ? route('mi-disponibilidad.index')
                    : route('proveedores.disponibilidades.index', $proveedor) }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-sm font-medium text-gray-300 transition hover:bg-white/5"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[#00c896] px-5 py-2 text-sm font-semibold text-black transition hover:opacity-90"
            >
                Guardar cambios
            </button>
        </div>
    </form>

</div>
@endsection
