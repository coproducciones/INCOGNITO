@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO                                            --}}
    {{-- ===================================================== --}}

    <div class="flex justify-between items-center">

        <div>

            <h1 class="text-2xl font-semibold">
                Permisos
            </h1>

            <p class="mt-1 text-sm text-gray-400">
                Gestiona los permisos disponibles para los roles.
            </p>

        </div>


        {{-- Crear permiso --}}

        @if (auth()->check() && auth()->user()->tienePermiso('permisos.crear'))

            <a
                href="{{ route('permisos.create') }}"
                class="px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-500"
            >
                Nuevo permiso
            </a>

        @endif

    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ÉXITO                                     --}}
    {{-- ===================================================== --}}

    @if (session('success'))

        <div class="p-3 rounded bg-emerald-900/40 text-emerald-300">
            {{ session('success') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR                                     --}}
    {{-- ===================================================== --}}

    @if (session('error'))

        <div class="p-3 rounded bg-red-900/40 text-red-300">
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- TABLA DE PERMISOS                                    --}}
    {{-- ===================================================== --}}

    <div class="overflow-x-auto rounded-xl border border-white/10">

        <table class="w-full text-sm">

            <thead>

                <tr class="border-b border-white/10 text-gray-400">

                    <th class="p-3 text-left">
                        Nombre
                    </th>

                    <th class="p-3 text-left">
                        Módulo
                    </th>

                    <th class="p-3 text-center">
                        Roles
                    </th>

                    <th class="p-3 text-center">
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse ($permisos as $permiso)

                    <tr class= border-b border-white/5 hover:bg-white/[0.02] >

                        {{-- Nombre --}}

                        <td class="p-3">
                            {{ $permiso->nombre }}
                        </td>


                        {{-- Módulo --}}

                        <td class="p-3 text-gray-300">
                            {{ $permiso->modulo }}
                        </td>


                        {{-- Cantidad de roles --}}

                        <td class="p-3 text-center">

                            <span class="text-emerald-400">
                                {{ $permiso->roles_count ?? 0 }}
                            </span>

                        </td>


                        {{-- Acciones --}}

                        <td class="p-3">

                            <div class="flex gap-3 justify-center">

                                {{-- Editar --}}

                                @if (auth()->check() && auth()->user()->tienePermiso('permisos.editar'))

                                    <a
                                        href="{{ route('permisos.edit', ['permiso' => $permiso->id_permiso]) }}"
                                        class="text-emerald-400 hover:text-emerald-300"
                                    >
                                        Editar
                                    </a>

                                @endif


                                {{-- Eliminar --}}

                                @if (auth()->check() && auth()->user()->tienePermiso('permisos.eliminar'))

                                    <form
                                        method="POST"
                                        action="{{ route('permisos.destroy', ['permiso' => $permiso->id_permiso]) }}"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este permiso?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-400 hover:text-red-300"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="p-8 text-center text-gray-500"
                        >
                            No hay permisos registrados.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection