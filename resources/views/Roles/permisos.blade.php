@extends('layouts.app')

@section('title', 'Permisos del rol')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="mb-8">

        <h1 class="text-2xl font-black uppercase tracking-widest text-white"
            style="letter-spacing: .15em;">
            Permisos: {{ $rol->nombre }}
        </h1>

        <div class="mt-3 h-[3px] w-[60px] rounded-full"
             style="background-color: #A99045;"></div>

        <p class="mt-3 text-sm text-gray-400">
            Selecciona los permisos que tendrá este rol.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ÉXITO --}}
    {{-- ===================================================== --}}

    @if (session('success'))

        <div
            class="mb-6 rounded-xl border p-4 text-sm font-medium"
            style="background-color: rgba(169, 144, 69, 0.12); border-color: rgba(169, 144, 69, 0.35); color: #D8C17F;"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR --}}
    {{-- ===================================================== --}}

    @if (session('error'))

        <div
            class="mb-6 rounded-xl border p-4 text-sm font-medium"
            style="background-color: rgba(127, 29, 29, 0.18); border-color: rgba(248, 113, 113, 0.3); color: #FCA5A5;"
        >
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- ERRORES DE VALIDACIÓN --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div
            class="mb-6 rounded-xl border p-4"
            style="background-color: rgba(127, 29, 29, 0.18); border-color: rgba(248, 113, 113, 0.3);"
        >

            <p class="mb-2 font-bold text-red-300">
                Se encontraron errores:
            </p>

            <ul class="list-inside list-disc space-y-1 text-sm text-red-300">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- FORMULARIO --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('roles.permisos.sync', ['rol' => $rol->id_rol]) }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- ================================================= --}}
        {{-- LISTA DE PERMISOS --}}
        {{-- ================================================= --}}

        <div
            class="overflow-hidden rounded-2xl border shadow-lg"
            style="background-color: #111111; border-color: rgba(169, 144, 69, 0.3);"
        >

            <div
                class="border-b px-6 py-5"
                style="background-color: #151515; border-color: rgba(169, 144, 69, 0.25);"
            >

                <h2 class="text-sm font-black uppercase tracking-widest text-white"
                    style="letter-spacing: .12em;">
                    Permisos disponibles
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Marca los permisos que deseas asignar al rol.
                </p>

            </div>


            <div class="divide-y"
                 style="border-color: rgba(255, 255, 255, 0.06);">

                @forelse ($permisos as $permiso)

                    @php

                        $asignado = $rol->permisos->contains(
                            'id_permiso',
                            $permiso->id_permiso
                        );

                    @endphp


                    <label
                        for="permiso_{{ $permiso->id_permiso }}"
                        class="flex cursor-pointer items-center gap-4 px-6 py-4 transition hover:bg-white/[0.04]"
                        style="border-color: rgba(255, 255, 255, 0.06);"
                    >

                        <input
                            type="checkbox"
                            id="permiso_{{ $permiso->id_permiso }}"
                            name="permisos[]"
                            value="{{ $permiso->id_permiso }}"
                            @checked($asignado)
                            class="h-4 w-4 cursor-pointer rounded border-white/20 bg-black focus:ring-2"
                            style="accent-color: #A99045; --tw-ring-color: #A99045;"
                        >


                        <div class="min-w-0 flex-1">

                            <div class="font-semibold text-white">
                                {{ $permiso->nombre }}
                            </div>

                            <div class="mt-1 text-sm text-gray-500">

                                Módulo:

                                <span class="text-gray-300">
                                    {{ $permiso->modulo }}
                                </span>

                            </div>

                        </div>


                        <div class="text-xs font-semibold"
                             style="color: #A99045;">
                            #{{ $permiso->id_permiso }}
                        </div>

                    </label>

                @empty

                    <div class="px-6 py-10 text-center">

                        <p class="text-sm text-gray-400">
                            No hay permisos registrados.
                        </p>

                        @if (auth()->check() && auth()->user()->tienePermiso('permisos.crear'))

                            <a
                                href="{{ route('permisos.create') }}"
                                class="mt-4 inline-block text-sm font-semibold transition hover:underline"
                                style="color: #D8C17F;"
                            >
                                Crear un permiso
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- BOTONES --}}
        {{-- ================================================= --}}

        <div class="flex flex-wrap gap-3 pt-2">

            @if (auth()->check() && auth()->user()->tienePermiso('roles.editar'))

                <button
                    type="submit"
                    class="rounded-xl px-6 py-3 text-sm font-black uppercase tracking-widest transition hover:brightness-110"
                    style="background-color: #A99045; color: #111111; letter-spacing: .08em;"
                >
                    Guardar permisos
                </button>

            @endif


            <a
                href="{{ route('roles.index') }}"
                class="rounded-xl border px-6 py-3 text-sm font-semibold text-gray-300 transition hover:bg-white/5"
                style="border-color: rgba(255, 255, 255, 0.15);"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection
