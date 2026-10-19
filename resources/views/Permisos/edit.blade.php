@extends('layouts.app')

@section('title', 'Editar permiso')

@section('content')

<div class="max-w-xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO                                            --}}
    {{-- ===================================================== --}}

    <div class="mb-6">

        <h1 class="text-2xl font-semibold">
            Editar permiso
        </h1>

        <p class="mt-1 text-sm text-gray-400">
            Modifica la información del permiso seleccionado.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- ERRORES DE VALIDACIÓN                                 --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div class="mb-6 p-4 rounded-lg bg-red-900/40 border border-red-500/20">

            <p class="font-semibold text-red-300 mb-2">
                No se pudo guardar el permiso.
            </p>

            <ul class="list-disc list-inside text-sm text-red-300">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- FORMULARIO                                            --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('permisos.update', ['permiso' => $permiso->id_permiso]) }}"
        class="space-y-4"
    >

        @csrf
        @method('PUT')


        {{-- ================================================= --}}
        {{-- NOMBRE DEL PERMISO                                 --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="nombre"
                class="block mb-1 text-sm text-gray-300"
            >
                Nombre
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Nombre"
                value="{{ old('nombre', $permiso->nombre) }}"
                class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
                required
            >

            @error('nombre')

                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ================================================= --}}
        {{-- MÓDULO                                             --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="modulo"
                class="block mb-1 text-sm text-gray-300"
            >
                Módulo
            </label>

            <input
                type="text"
                id="modulo"
                name="modulo"
                placeholder="Módulo"
                value="{{ old('modulo', $permiso->modulo) }}"
                class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
                required
            >

            @error('modulo')

                <p class="mt-1 text-sm text-red-400">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ================================================= --}}
        {{-- BOTONES                                            --}}
        {{-- ================================================= --}}

        <div class="flex gap-3 pt-4">

            @if (auth()->check() && auth()->user()->tienePermiso('permisos.editar'))

                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-500"
                >
                    Guardar cambios
                </button>

            @endif

            <a
                href="{{ route('permisos.index') }}"
                class="px-4 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection