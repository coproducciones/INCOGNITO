@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')

<div class="max-w-2xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO                                            --}}
    {{-- ===================================================== --}}

    <h1 class="text-2xl font-semibold mb-2">
        Seguridad del usuario
    </h1>

    <p class="text-sm text-gray-400 mb-6">
        Actualiza el rol y el estado del usuario.
    </p>

    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR GENERAL                              --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div class="mb-6 p-4 rounded-lg bg-red-900/40 border border-red-500/20">

            <p class="font-semibold text-red-300 mb-2">
                Se encontraron algunos errores:
            </p>

            <ul class="list-disc list-inside text-sm text-red-300">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    {{-- ===================================================== --}}
    {{-- FORMULARIO                                            --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('seguridad.usuarios.update', $usuario) }}"
        class="space-y-4"
    >

        @csrf

        @method('PUT')

        {{-- ================================================= --}}
        {{-- NOMBRE                                             --}}
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
                value="{{ old('nombre', $usuario->nombre) }}"
                class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
                required
            >

        </div>

        {{-- ================================================= --}}
        {{-- APELLIDO                                           --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="apellido"
                class="block mb-1 text-sm text-gray-300"
            >
                Apellido
            </label>

            <input
                type="text"
                id="apellido"
                name="apellido"
                value="{{ old('apellido', $usuario->apellido ?? '') }}"
                class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
            >

        </div>

        {{-- ================================================= --}}
        {{-- CORREO                                             --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="email"
                class="block mb-1 text-sm text-gray-300"
            >
                Correo electrónico
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $usuario->email) }}"
                class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
                required
            >

        </div>

        {{-- ================================================= --}}
        {{-- ROL                                                --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="id_rol"
                class="block mb-1 text-sm text-gray-300"
            >
                Rol
            </label>

            <select
                id="id_rol"
                name="id_rol"
                class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
            >

                <option value="">
                    Sin rol
                </option>

                @foreach ($roles as $rol)

                    <option
                        value="{{ $rol->id_rol }}"
                        @selected(
                            old('id_rol', $usuario->id_rol) == $rol->id_rol
                        )
                    >
                        {{ $rol->nombre }}
                    </option>

                @endforeach

            </select>

        </div>

{{-- ESTADO DEL USUARIO --}}

<div>
    <label
        for="id_estado"
        class="block mb-1 text-sm text-gray-300"
    >
        Estado del usuario
    </label>

    <select
        id="id_estado"
        name="id_estado"
        class="w-full rounded-lg bg-black border border-white/10 px-3 py-2 text-white"
        required
    >
        @forelse ($estados as $estado)
            <option
                value="{{ $estado->id_estado }}"
                @selected(
                    (string) old('id_estado', $usuario->id_estado)
                    === (string) $estado->id_estado
                )
            >
                {{ $estado->nombre }}
            </option>
        @empty
            <option value="" disabled selected>
                No hay estados de usuario registrados
            </option>
        @endforelse
    </select>

    @if ($estados->isEmpty())
        <p class="mt-2 text-sm text-amber-400">
            Debes registrar los estados Activo e Inactivo
            para el tipo USUARIO.
        </p>
    @endif
</div>

        {{-- ================================================= --}}
        {{-- BOTONES                                            --}}
        {{-- ================================================= --}}

        <div class="flex gap-3 pt-4">

            {{-- Guardar --}}
            <button
                type="submit"
                class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-500"
            >
                Guardar cambios
            </button>

            {{-- Cancelar --}}
            <a
                href="{{ route('seguridad.usuarios.index') }}"
                class="px-4 py-2 rounded-lg border border-white/10 text-gray-300 hover:bg-white/5"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection

