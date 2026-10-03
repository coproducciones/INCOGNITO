@extends('layouts.app')

@section('title', 'Registrar proveedor')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-6">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">
            Registrar proveedor
        </h1>

        <p class="mt-1 text-sm text-gray-400">
            Registra la información principal del proveedor.
        </p>
    </div>


    {{-- ========================================================= --}}
    {{-- MENSAJES DE VALIDACIÓN --}}
    {{-- ========================================================= --}}

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">

            <p class="mb-2 font-semibold text-red-300">
                Se encontraron los siguientes errores:
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-200">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- ========================================================= --}}
    {{-- FORMULARIO --}}
    {{-- ========================================================= --}}

    <form
        method="POST"
        action="{{ route('proveedores.store') }}"
        class="space-y-6 rounded-xl border border-white/10 bg-[#111111] p-6"
    >

        @csrf


        {{-- ===================================================== --}}
        {{-- USUARIO --}}
        {{-- ===================================================== --}}

        <div>
            <label
                for="id_usuario"
                class="mb-2 block text-sm font-medium text-gray-300"
            >
                Usuario
            </label>

            <select
                id="id_usuario"
                name="id_usuario"
                required
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white outline-none transition focus:border-[#00c896]"
            >
                <option value="">
                    Selecciona un usuario
                </option>

                @foreach ($usuarios as $usuario)
                    <option
                        value="{{ $usuario->id }}"
                        @selected(old('id_usuario') == $usuario->id)
                    >
                        {{ $usuario->nombre }}
                        —
                        {{ $usuario->email }}
                    </option>
                @endforeach
            </select>

            @error('id_usuario')
                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- ===================================================== --}}
        {{-- ESPECIALIDAD --}}
        {{-- ===================================================== --}}

        <div>
            <label
                for="especialidad"
                class="mb-2 block text-sm font-medium text-gray-300"
            >
                Especialidad
            </label>

            <input
                type="text"
                id="especialidad"
                name="especialidad"
                value="{{ old('especialidad') }}"
                required
                maxlength="100"
                placeholder="Ej. Diseño gráfico, fotografía, producción..."
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-[#00c896]"
            >

            @error('especialidad')
                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- ===================================================== --}}
        {{-- TELÉFONO --}}
        {{-- ===================================================== --}}

        <div>
            <label
                for="telefono"
                class="mb-2 block text-sm font-medium text-gray-300"
            >
                Teléfono
            </label>

            <input
                type="text"
                id="telefono"
                name="telefono"
                value="{{ old('telefono') }}"
                required
                maxlength="20"
                placeholder="Ej. 3001234567"
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-[#00c896]"
            >

            @error('telefono')
                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- ===================================================== --}}
        {{-- WHATSAPP --}}
        {{-- ===================================================== --}}

        <div>
            <label
                for="whatsapp"
                class="mb-2 block text-sm font-medium text-gray-300"
            >
                WhatsApp
            </label>

            <input
                type="text"
                id="whatsapp"
                name="whatsapp"
                value="{{ old('whatsapp') }}"
                maxlength="20"
                placeholder="Ej. 3001234567"
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-[#00c896]"
            >

            @error('whatsapp')
                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>
            @enderror
        </div>


        {{-- ===================================================== --}}
        {{-- BOTONES --}}
        {{-- ===================================================== --}}

        <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">

            <a
                href="{{ route('proveedores.index') }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-sm font-medium text-gray-300 transition hover:bg-white/5"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[#00c896] px-5 py-2 text-sm font-semibold text-black transition hover:opacity-90"
            >
                Guardar proveedor
            </button>

        </div>

    </form>

</div>

@endsection

@csrf
