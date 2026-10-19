@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <h1 class="text-2xl font-semibold">
            Roles
        </h1>

        @if (auth()->check() && auth()->user()->tienePermiso('roles.crear'))

            <a
                href="{{ route('roles.create') }}"
                class="px-4 py-2 rounded bg-emerald-600 text-white hover:bg-emerald-500"
            >
                Nuevo rol
            </a>

        @endif

    </div>


    @if(session('success'))

        <div class="p-3 rounded bg-emerald-900/40 text-emerald-300">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="p-3 rounded bg-red-900/40 text-red-300">
            {{ session('error') }}
        </div>

    @endif


    <div class="overflow-x-auto rounded-lg border border-white/10">

        <table class="w-full text-sm">

            <thead>

                <tr class="border-b border-white/10">

                    <th class="p-3 text-left">
                        Nombre
                    </th>

                    <th class="p-3">
                        Permisos
                    </th>

                    <th class="p-3">
                        Acciones
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($roles as $rol)

                    <tr class="border-b border-white/5">

                        <td class="p-3">
                            {{ $rol->nombre }}
                        </td>

                        <td class="p-3 text-center">
                            {{ $rol->permisos_count }}
                        </td>

                        <td class="p-3">

                            <div class="flex gap-2 justify-center">

                                {{-- Administrar permisos del rol --}}
                                @if (auth()->check() && auth()->user()->tienePermiso('roles.editar'))

                                    <a
                                        href="{{ route('roles.permisos', ['rol' => $rol->id_rol]) }}"
                                        class="px-3 py-1 rounded bg-white/10"
                                    >
                                        Permisos
                                    </a>

                                @endif


                                {{-- Editar rol --}}
                                @if (auth()->check() && auth()->user()->tienePermiso('roles.editar'))

                                    <a
                                        href="{{ route('roles.edit', ['rol' => $rol->id_rol]) }}"
                                        class="px-3 py-1 rounded bg-white/10"
                                    >
                                        Editar
                                    </a>

                                @endif


                                {{-- Eliminar rol --}}
                                @if (auth()->check() && auth()->user()->tienePermiso('roles.eliminar'))

                                    <form
                                        method="POST"
                                        action="{{ route('roles.destroy', ['rol' => $rol->id_rol]) }}"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este rol?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-3 py-1 rounded bg-red-900/50 text-red-200"
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
                            colspan="3"
                            class="p-8 text-center text-gray-500"
                        >
                            No hay roles registrados.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection