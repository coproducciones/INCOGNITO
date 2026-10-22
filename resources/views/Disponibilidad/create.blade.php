@extends('layouts.app')

@section('title', 'Registrar disponibilidad')

@section('content')
@php
    $esPersonal = $esMiDisponibilidad ?? false;
@endphp

<div class="mx-auto max-w-3xl space-y-6 px-4 py-6 sm:px-6">

    {{-- ENCABEZADO --}}
    <div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#D8C17F]">
            Incógnito | Grupo de Diseño
        </p>

        <h1 class="mt-2 text-2xl font-bold tracking-tight text-white">
            {{ $esPersonal ? 'Agregar mi disponibilidad' : 'Registrar disponibilidad' }}
        </h1>

        <p class="mt-2 text-sm text-white/50">
            Registra una fecha y especifica si estarás disponible para ofrecer tus servicios.
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
    <div class="rounded-2xl border border-white/[0.08] bg-[#1D1D1D] p-5 sm:p-6">
        <div class="mb-4 flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#A99045]/10">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-[#D8C17F]"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s8-4 8-11V5l-8-3-8 3v5c0 7 8 11 8 11Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                </svg>
            </div>

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.15em] text-white/40">
                    Proveedor asociado
                </p>

                <p class="mt-1 font-semibold text-white">
                    {{ $proveedor->especialidad }}
                </p>
            </div>
        </div>

        <p class="text-sm leading-relaxed text-white/50">
            {{ $esPersonal
                ? 'La fecha se asociará automáticamente a tu perfil.'
                : 'La fecha se asociará al proveedor seleccionado.' }}
        </p>
    </div>

    {{-- FORMULARIO --}}
    <form
        method="POST"
        action="{{ $esPersonal
            ? route('mi-disponibilidad.store')
            : route('proveedores.disponibilidades.store', $proveedor) }}"
        class="space-y-6 rounded-2xl border border-white/[0.08] bg-[#1D1D1D] p-5 sm:p-7"
    >
        @csrf

        <div>
            <label for="fecha" class="mb-2 block text-sm font-medium text-white/80">
                Fecha de disponibilidad
            </label>

            <input
                type="date"
                id="fecha"
                name="fecha"
                value="{{ old('fecha') }}"
                required
                class="w-full rounded-xl border border-white/[0.10] bg-[#151515] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/30"
            >

            @error('fecha')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="disponible" class="mb-2 block text-sm font-medium text-white/80">
                ¿Estarás disponible?
            </label>

            <select
                id="disponible"
                name="disponible"
                required
                class="w-full rounded-xl border border-white/[0.10] bg-[#151515] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/30"
            >
                <option value="">Selecciona una opción</option>

                <option value="1" @selected(old('disponible') === '1')>
                    Sí, estaré disponible
                </option>

                <option value="0" @selected(old('disponible') === '0')>
                    No estaré disponible
                </option>
            </select>

            @error('disponible')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- BOTONES --}}
        <div class="flex flex-wrap justify-end gap-3 border-t border-white/[0.08] pt-5">

            <a
                href="{{ $esPersonal
                    ? route('mi-disponibilidad.index')
                    : route('proveedores.disponibilidades.index', $proveedor) }}"
                class="inline-flex items-center justify-center rounded-xl border border-white/[0.12] px-5 py-2.5 text-sm font-medium text-white/70 transition hover:border-white/20 hover:bg-white/[0.05] hover:text-white"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-[#A99045] px-5 py-2.5 text-sm font-semibold text-black transition hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#D8C17F]/50 focus:ring-offset-2 focus:ring-offset-[#1D1D1D]"
            >
                Guardar disponibilidad
            </button>
        </div>
    </form>

</div>
@endsection
