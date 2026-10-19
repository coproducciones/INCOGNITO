@extends('layouts.app')

@section('title', 'Crear rol')

@section('content')

<div class="max-w-4xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO                                            --}}
    {{-- ===================================================== --}}

    <div class="mb-6">

        <h1 class="text-2xl font-semibold">
            Crear rol
        </h1>

        <p class="mt-1 text-sm text-gray-400">
            Registra un nuevo rol y asigna los permisos que tendrá.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- ERRORES GENERALES                                    --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-500/20 bg-red-900/40 p-4">

            <p class="mb-2 font-semibold text-red-300">
                No se pudo crear el rol.
            </p>

            <ul class="list-inside list-disc text-sm text-red-300">

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
        action="{{ route('roles.store') }}"
        class="space-y-6"
    >

        @csrf


        {{-- ================================================= --}}
        {{-- INFORMACIÓN DEL ROL                               --}}
        {{-- ================================================= --}}

        <div
            class="rounded-xl border border-white/10 bg-[#111111] p-5"
        >

            <h2 class="mb-4 text-lg font-semibold text-white">
                Información del rol
            </h2>


            {{-- Nombre --}}

            <div>

                <label
                    for="nombre"
                    class="mb-1 block text-sm text-gray-300"
                >
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    placeholder="Ejemplo: Administrador"
                    class="w-full rounded-lg border border-white/10 bg-black px-3 py-2 text-white"
                    required
                >

                @error('nombre')

                    <p class="mt-1 text-sm text-red-400">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PERMISOS                                           --}}
        {{-- ================================================= --}}

        <div
            class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]"
        >

            <div class="border-b border-white/10 px-5 py-4">

                <h2 class="font-semibold text-white">
                    Permisos del rol
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Selecciona los permisos que tendrá este rol.
                </p>

            </div>


            <div class="divide-y divide-white/5">

                @forelse ($permisos as $permiso)

                    @php
                        $seleccionado = in_array(
                            $permiso->id_permiso,
                            old('permisos', [])
                        );
                    @endphp

                    <label
                        for="permiso_{{ $permiso->id_permiso }}"
                        class="flex cursor-pointer items-center gap-4 px-5 py-4 hover:bg-white/5"
                    >

                        <input
                            type="checkbox"
                            id="permiso_{{ $permiso->id_permiso }}"
                            name="permisos[]"
                            value="{{ $permiso->id_permiso }}"
                            @checked($seleccionado)
                            class="h-4 w-4 rounded border-white/20 bg-black text-emerald-500 focus:ring-emerald-500"
                        >

                        <div class="min-w-0 flex-1">

                            <div class="font-medium text-white">
                                {{ $permiso->nombre }}
                            </div>

                            <div class="mt-1 text-sm text-gray-500">

                                Módulo:

                                <span class="text-gray-400">
                                    {{ $permiso->modulo }}
                                </span>

                            </div>

                        </div>

                        <span class="text-xs text-gray-600">
                            #{{ $permiso->id_permiso }}
                        </span>

                    </label>

                @empty

                    <div class="px-5 py-10 text-center">

                        <p class="text-gray-400">
                            No hay permisos registrados.
                        </p>

                        @if (auth()->check() && auth()->user()->tienePermiso('permisos.crear'))

                            <a
                                href="{{ route('permisos.create') }}"
                                class="mt-3 inline-block text-sm text-emerald-400 hover:text-emerald-300"
                            >
                                Crear un permiso
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- BOTONES                                            --}}
        {{-- ================================================= --}}

        <div class="flex gap-3">

            @if (auth()->check() && auth()->user()->tienePermiso('roles.crear'))

                <button
                    type="submit"
                    class="rounded-lg bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-500"
                >
                    Guardar
                </button>

            @endif

            <a
                href="{{ route('roles.index') }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-gray-300 hover:bg-white/5"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection