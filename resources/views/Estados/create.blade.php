@extends('layouts.app')

@section('title', 'Crear estado')

@section('content')
<div class="mx-auto max-w-3xl space-y-8 pb-10">

    {{-- ENCABEZADO --}}
    <div class="flex items-center gap-4">
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-[#A99045]/30 bg-[#A99045]/10 text-[#D8C17F]">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 4v16m8-8H4"
                />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                Crear estado
            </h1>

            <p class="mt-1 text-sm text-white/50">
                Registra un nuevo estado en el sistema.
            </p>
        </div>
    </div>

    {{-- FORMULARIO --}}
    <div class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#1D1D1D] shadow-xl shadow-black/20">

        <div class="border-b border-white/[0.08] px-6 py-5 sm:px-8">
            <h2 class="text-lg font-semibold text-white">
                Información del estado
            </h2>

            <p class="mt-1 text-sm text-white/50">
                Completa los campos para crear un nuevo registro.
            </p>
        </div>

        <form
            method="POST"
            action="{{ route('estados.store') }}"
            class="space-y-6 p-6 sm:p-8"
        >
            @csrf

            {{-- ERRORES DE VALIDACIÓN --}}
            @if ($errors->any())
                <div
                    class="rounded-xl border border-red-500/20 bg-red-500/10 p-4"
                    role="alert"
                >
                    <p class="font-semibold text-red-300">
                        Revisa los siguientes campos:
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-200/90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TIPO --}}
            <div>
                <label
                    for="tipo"
                    class="mb-2 block text-sm font-semibold text-white/80"
                >
                    Tipo de estado
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="tipo"
                    name="tipo"
                    value="{{ old('tipo') }}"
                    placeholder="Ej. General, académico, administrativo"
                    autocomplete="off"
                    required
                    aria-describedby="tipo-ayuda"
                    class="w-full rounded-xl border border-white/[0.10] bg-[#151515] px-4 py-3 text-sm text-white placeholder-white/30 outline-none transition focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20 @error('tipo') border-red-500 @enderror"
                >

                <p id="tipo-ayuda" class="mt-2 text-xs text-white/40">
                    Especifica la categoría a la que pertenece el estado.
                </p>

                @error('tipo')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- NOMBRE --}}
            <div>
                <label
                    for="nombre"
                    class="mb-2 block text-sm font-semibold text-white/80"
                >
                    Nombre del estado
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    placeholder="Ej. Activo, pendiente, finalizado"
                    autocomplete="off"
                    required
                    aria-describedby="nombre-ayuda"
                    class="w-full rounded-xl border border-white/[0.10] bg-[#151515] px-4 py-3 text-sm text-white placeholder-white/30 outline-none transition focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20 @error('nombre') border-red-500 @enderror"
                >

                <p id="nombre-ayuda" class="mt-2 text-xs text-white/40">
                    Introduce el nombre que identificará este estado.
                </p>

                @error('nombre')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- INFORMACIÓN --}}
            <div class="flex items-start gap-3 rounded-xl border border-[#A99045]/20 bg-[#A99045]/[0.06] p-4">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="mt-0.5 h-5 w-5 shrink-0 text-[#D8C17F]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.852l.041-.02M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-5.25h.008v.008H12V6.75z"
                    />
                </svg>

                <p class="text-sm leading-6 text-white/60">
                    Los campos marcados con
                    <span class="font-semibold text-red-400">*</span>
                    son obligatorios. Verifica la información antes de guardar.
                </p>
            </div>

            {{-- BOTONES --}}
            <div class="flex flex-col-reverse gap-3 border-t border-white/[0.08] pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('estados.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/[0.12] px-5 py-3 text-sm font-semibold text-white/70 transition hover:border-white/20 hover:bg-white/[0.05] hover:text-white focus:outline-none focus:ring-2 focus:ring-white/20"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"
                        />
                    </svg>

                    Cancelar
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#A99045] px-6 py-3 text-sm font-semibold text-black shadow-lg shadow-black/20 transition hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#D8C17F]/50 focus:ring-offset-2 focus:ring-offset-[#1D1D1D]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Guardar estado
                </button>
            </div>

        </form>
    </div>

    <p class="text-center text-xs text-white/30">
        Gestión de estados generales
    </p>

</div>
@endsection
