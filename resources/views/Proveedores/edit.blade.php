@extends('layouts.app')

@section('title', 'Editar proveedor')

@section('content')

<div class="max-w-3xl mx-auto px-4 py-6">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-white">
                    Editar proveedor
                </h1>

                <p class="mt-1 text-sm text-gray-400">
                    Actualiza la información del proveedor.
                </p>
            </div>

            <div class="rounded-lg border border-white/10 bg-[#111111] px-4 py-2">
                <span class="text-xs text-gray-500">
                    ID
                </span>

                <span class="ml-1 text-sm font-semibold text-[#00c896]">
                    #{{ $proveedor->id_proveedor }}
                </span>
            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ERRORES DE VALIDACIÓN --}}
    {{-- ========================================================= --}}

    @if ($errors->any())

        <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">

            <p class="mb-2 font-semibold text-red-300">
                No se pudo actualizar el proveedor.
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-200">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- FORMULARIO --}}
    {{-- ========================================================= --}}

    <form
        method="POST"
        action="{{ route('proveedores.update', $proveedor) }}"
        class="space-y-6 rounded-xl border border-white/10 bg-[#111111] p-6"
    >

        @csrf

        @method('PUT')


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
                        @selected(
                            old(
                                'id_usuario',
                                $proveedor->id_usuario
                            ) == $usuario->id
                        )
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
                value="{{ old('especialidad', $proveedor->especialidad) }}"
                required
                maxlength="100"
                placeholder="Ej. Fotografía, diseño gráfico..."
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
                value="{{ old('telefono', $proveedor->telefono) }}"
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
                value="{{ old('whatsapp', $proveedor->whatsapp) }}"
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
        {{-- DESCRIPCIÓN --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="descripcion"
                class="mb-2 block text-sm font-medium text-gray-300"
            >
                Descripción
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                rows="4"
                maxlength="500"
                placeholder="Describe brevemente los servicios o características del proveedor..."
                class="w-full resize-none rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-[#00c896]"
            >{{ old('descripcion', $proveedor->descripcion) }}</textarea>

            @error('descripcion')

                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- FOTO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="foto_url"
                class="mb-2 block text-sm font-medium text-gray-300"
            >
                URL de fotografía
            </label>

            <input
                type="url"
                id="foto_url"
                name="foto_url"
                value="{{ old('foto_url', $proveedor->foto_url) }}"
                maxlength="500"
                placeholder="https://ejemplo.com/foto.jpg"
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-[#00c896]"
            >

            <p class="mt-1 text-xs text-gray-500">
                Puedes dejar este campo vacío si el proveedor no tiene fotografía.
            </p>

            @error('foto_url')

                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- INFORMACIÓN ACTUAL --}}
        {{-- ===================================================== --}}

        <div class="rounded-lg border border-white/10 bg-[#0d0d0d] p-4">

            <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                Información del registro
            </p>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                <div>
                    <span class="block text-xs text-gray-500">
                        Proveedor
                    </span>

                    <span class="text-sm text-gray-200">
                        #{{ $proveedor->id_proveedor }}
                    </span>
                </div>

                <div>
                    <span class="block text-xs text-gray-500">
                        Usuario actual
                    </span>

                    <span class="text-sm text-gray-200">
                        {{ $proveedor->usuario?->nombre ?? 'Sin usuario' }}
                    </span>
                </div>

                @if ($proveedor->creado_en)

                    <div>
                        <span class="block text-xs text-gray-500">
                            Registrado
                        </span>

                        <span class="text-sm text-gray-200">
                            {{ $proveedor->creado_en->format('d/m/Y H:i') }}
                        </span>
                    </div>

                @endif

                @if ($proveedor->actualizado_en)

                    <div>
                        <span class="block text-xs text-gray-500">
                            Última actualización
                        </span>

                        <span class="text-sm text-gray-200">
                            {{ $proveedor->actualizado_en->format('d/m/Y H:i') }}
                        </span>
                    </div>

                @endif

            </div>

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
                Actualizar proveedor
            </button>

        </div>

    </form>

</div>

@endsection