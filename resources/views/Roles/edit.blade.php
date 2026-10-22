@extends('layouts.app')

@section('title', 'Editar rol')

@section('content')

<div class="mx-auto max-w-4xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="mb-8">
        <h1 class="text-2xl font-black uppercase tracking-widest text-white"
            style="letter-spacing: .15em;">
            Editar rol
        </h1>

        <div class="mt-3 h-[3px] w-[60px] rounded-full"
             style="background-color: #A99045;"></div>

        <p class="mt-3 text-sm text-gray-400">
            Modifica el nombre y los permisos asignados a este rol.
        </p>
    </div>


    {{-- ===================================================== --}}
    {{-- ERRORES GENERALES --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div class="mb-6 rounded-xl border p-4"
             style="background-color: rgba(127, 29, 29, 0.18); border-color: rgba(248, 113, 113, 0.3);">

            <p class="mb-2 font-bold text-red-300">
                No se pudo actualizar el rol.
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
        action="{{ route('roles.update', ['rol' => $rol->id_rol]) }}"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- ================================================= --}}
        {{-- INFORMACIÓN DEL ROL --}}
        {{-- ================================================= --}}

        <div class="rounded-2xl border p-6 shadow-lg"
             style="background-color: #111111; border-color: rgba(169, 144, 69, 0.3);">

            <h2 class="mb-5 text-lg font-black uppercase tracking-widest text-white"
                style="letter-spacing: .1em;">
                Información del rol
            </h2>

            <div>
                <label
                    for="nombre"
                    class="mb-2 block text-xs font-bold uppercase tracking-widest"
                    style="color: #D8C17F;"
                >
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $rol->nombre) }}"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-white outline-none transition focus:ring-2"
                    style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.12); --tw-ring-color: #A99045;"
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.12)'"
                    required
                >

                @error('nombre')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PERMISOS --}}
        {{-- ================================================= --}}

        <div class="overflow-hidden rounded-2xl border shadow-lg"
             style="background-color: #111111; border-color: rgba(169, 144, 69, 0.3);">

            <div class="border-b px-6 py-5"
                 style="border-color: rgba(169, 144, 69, 0.2);">

                <h2 class="text-sm font-black uppercase tracking-widest text-white"
                    style="letter-spacing: .12em;">
                    Permisos del rol
                </h2>

                <p class="mt-2 text-sm text-gray-400">
                    Marca o desmarca los permisos que tendrá este rol.
                </p>

            </div>


            <div class="divide-y"
                 style="--tw-divide-opacity: 1;">

                @forelse ($permisos as $permiso)

                    @php

                        $permisosActuales = $rol->permisos
                            ->pluck('id_permiso')
                            ->map(fn ($id) => (int) $id)
                            ->toArray();

                        $seleccionado = in_array(
                            (int) $permiso->id_permiso,
                            old(
                                'permisos',
                                $permisosActuales
                            )
                        );

                    @endphp


                    <label
                        for="permiso_{{ $permiso->id_permiso }}"
                        class="flex cursor-pointer items-center gap-4 px-6 py-4 transition hover:bg-white/5"
                        style="border-color: rgba(255, 255, 255, 0.06);"
                    >

                        <input
                            type="checkbox"
                            id="permiso_{{ $permiso->id_permiso }}"
                            name="permisos[]"
                            value="{{ $permiso->id_permiso }}"
                            @checked($seleccionado)
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

                        <span class="text-xs font-semibold"
                              style="color: #A99045;">
                            #{{ $permiso->id_permiso }}
                        </span>

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
                    Guardar cambios
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
