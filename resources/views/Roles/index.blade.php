@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="flex flex-wrap items-center justify-between gap-4">

        <div>
            <h1 class="text-2xl font-black uppercase tracking-widest text-white"
                style="letter-spacing: .15em;">
                Roles
            </h1>

            <div class="mt-3 h-[3px] w-[60px] rounded-full"
                 style="background-color: #A99045;"></div>
        </div>

        @if (auth()->check() && auth()->user()->tienePermiso('roles.crear'))

            <a
                href="{{ route('roles.create') }}"
                class="rounded-xl px-5 py-3 text-sm font-black uppercase tracking-widest transition hover:brightness-110"
                style="background-color: #A99045; color: #111111; letter-spacing: .08em;"
            >
                Nuevo rol
            </a>

        @endif

    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJES DE ÉXITO --}}
    {{-- ===================================================== --}}

    @if (session('success'))

        <div
            class="rounded-xl border p-4 text-sm font-medium"
            style="background-color: rgba(169, 144, 69, 0.12); border-color: rgba(169, 144, 69, 0.35); color: #D8C17F;"
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- MENSAJES DE ERROR --}}
    {{-- ===================================================== --}}

    @if (session('error'))

        <div
            class="rounded-xl border p-4 text-sm font-medium"
            style="background-color: rgba(127, 29, 29, 0.18); border-color: rgba(248, 113, 113, 0.3); color: #FCA5A5;"
        >
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- TABLA DE ROLES --}}
    {{-- ===================================================== --}}

    <div
        class="overflow-x-auto rounded-2xl border shadow-lg"
        style="background-color: #111111; border-color: rgba(169, 144, 69, 0.3);"
    >

        <table class="w-full text-sm">

            <thead>
                <tr
                    class="border-b"
                    style="background-color: #1D1D1D; border-color: rgba(169, 144, 69, 0.25);"
                >

                    <th
                        class="p-4 text-left text-xs font-black uppercase tracking-widest"
                        style="color: #D8C17F; letter-spacing: .1em;"
                    >
                        Nombre
                    </th>

                    <th
                        class="p-4 text-center text-xs font-black uppercase tracking-widest"
                        style="color: #D8C17F; letter-spacing: .1em;"
                    >
                        Permisos
                    </th>

                    <th
                        class="p-4 text-center text-xs font-black uppercase tracking-widest"
                        style="color: #D8C17F; letter-spacing: .1em;"
                    >
                        Acciones
                    </th>

                </tr>
            </thead>


            <tbody>

                @forelse($roles as $rol)

                    <tr
                        class="border-b transition hover:bg-white/[0.03]"
                        style="border-color: rgba(255, 255, 255, 0.06);"
                    >

                        {{-- Nombre del rol --}}
                        <td class="p-4 font-semibold text-white">
                            {{ $rol->nombre }}
                        </td>


                        {{-- Cantidad de permisos --}}
                        <td class="p-4 text-center">

                            <span
                                class="inline-flex min-w-10 items-center justify-center rounded-lg border px-3 py-1.5 text-sm font-bold"
                                style="background-color: rgba(169, 144, 69, 0.1); border-color: rgba(169, 144, 69, 0.3); color: #D8C17F;"
                            >
                                {{ $rol->permisos_count }}
                            </span>

                        </td>


                        {{-- Acciones --}}
                        <td class="p-4">

                            <div class="flex flex-wrap items-center justify-center gap-2">

                                {{-- Administrar permisos del rol --}}
                                @if (auth()->check() && auth()->user()->tienePermiso('roles.editar'))

                                    <a
                                        href="{{ route('roles.permisos', ['rol' => $rol->id_rol]) }}"
                                        class="rounded-lg border px-3 py-2 text-xs font-bold transition hover:brightness-125"
                                        style="background-color: rgba(169, 144, 69, 0.12); border-color: rgba(169, 144, 69, 0.3); color: #D8C17F;"
                                    >
                                        Permisos
                                    </a>

                                @endif


                                {{-- Editar rol --}}
                                @if (auth()->check() && auth()->user()->tienePermiso('roles.editar'))

                                    <a
                                        href="{{ route('roles.edit', ['rol' => $rol->id_rol]) }}"
                                        class="rounded-lg border px-3 py-2 text-xs font-bold text-gray-300 transition hover:bg-white/10 hover:text-white"
                                        style="border-color: rgba(255, 255, 255, 0.12);"
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
                                            class="rounded-lg border px-3 py-2 text-xs font-bold transition hover:brightness-125"
                                            style="background-color: rgba(127, 29, 29, 0.25); border-color: rgba(248, 113, 113, 0.25); color: #FCA5A5;"
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
                            class="p-10 text-center text-sm text-gray-400"
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
