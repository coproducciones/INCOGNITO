@extends('layouts.app')

@section('title', 'Permisos del rol')

@section('content')

<div class="max-w-4xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO                                            --}}
    {{-- ===================================================== --}}

    <div class="mb-6">

        <h1 class="text-2xl font-semibold">
            Permisos: {{ $rol->nombre }}
        </h1>

        <p class="mt-1 text-sm text-gray-400">
            Selecciona los permisos que tendrá este rol.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ÉXITO                                     --}}
    {{-- ===================================================== --}}

    @if (session('success'))

        <div class="mb-6 rounded-lg border border-emerald-500/20 bg-emerald-900/30 p-4 text-emerald-300">
            {{ session('success') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR                                     --}}
    {{-- ===================================================== --}}

    @if (session('error'))

        <div class="mb-6 rounded-lg border border-red-500/20 bg-red-900/30 p-4 text-red-300">
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- ERRORES DE VALIDACIÓN                                --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div class="mb-6 rounded-lg border border-red-500/20 bg-red-900/30 p-4">

            <p class="mb-2 font-semibold text-red-300">
                Se encontraron errores:
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
    {{-- FORMULARIO                                           --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('roles.permisos.sync', ['rol' => $rol->id_rol]) }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- ================================================= --}}
        {{-- LISTA DE PERMISOS                                 --}}
        {{-- ================================================= --}}

        <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">

            <div class="border-b border-white/10 px-5 py-4">

                <h2 class="font-semibold text-white">
                    Permisos disponibles
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Marca los permisos que deseas asignar al rol.
                </p>

            </div>


            <div class="divide-y divide-white/5">

                @forelse ($permisos as $permiso)

                    @php

                        $asignado = $rol->permisos->contains(
                            'id_permiso',
                            $permiso->id_permiso
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
                            @checked($asignado)
                            class="h-4 w-4 rounded border-white/20 bg-black text-emerald-500 focus:ring-emerald-500"
                        >


                        <div class="flex-1">

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


                        <div class="text-xs text-gray-600">
                            #{{ $permiso->id_permiso }}
                        </div>

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
        {{-- BOTONES                                           --}}
        {{-- ================================================= --}}

        <div class="flex gap-3">

            @if (auth()->check() && auth()->user()->tienePermiso('roles.editar'))

                <button
                    type="submit"
                    class="rounded-lg bg-emerald-600 px-4 py-2 font-semibold text-white hover:bg-emerald-500"
                >
                    Guardar permisos
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