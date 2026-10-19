@extends('layouts.app')

@section('title', 'Seguridad')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO                                            --}}
    {{-- ===================================================== --}}

    <div>
        <h1 class="text-2xl font-semibold">
            Gestión de usuarios y seguridad
        </h1>

        <p class="mt-1 text-sm text-gray-400">
            Administra los roles y estados asignados a los usuarios.
        </p>
    </div>

    {{-- ===================================================== --}}
    {{-- MENSAJE DE ÉXITO                                      --}}
    {{-- ===================================================== --}}

    @if (session('success'))
        <div class="p-3 rounded bg-emerald-900/40 text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR                                      --}}
    {{-- ===================================================== --}}

    @if (session('error'))
        <div class="p-3 rounded bg-red-900/40 text-red-300">
            {{ session('error') }}
        </div>
    @endif

    {{-- ===================================================== --}}
    {{-- TABLA DE USUARIOS                                     --}}
    {{-- ===================================================== --}}

    <div class="overflow-x-auto rounded-xl border border-white/10">

        <table class="w-full text-sm">

            <thead>
                <tr class="border-b border-white/10 text-gray-400">

                    <th class="p-3 text-left">
                        Usuario
                    </th>

                    <th class="p-3 text-left">
                        Correo
                    </th>

                    <th class="p-3 text-left">
                        Rol
                    </th>

                    <th class="p-3 text-left">
                        Estado
                    </th>

                    <th class="p-3 text-center">
                        Acciones
                    </th>

                </tr>
            </thead>

            <tbody>

                @forelse ($usuarios as $usuario)

                    <tr class= border-b border-white/5 hover:bg-white/[0.02]>

                        {{-- Usuario --}}
                        <td class="p-3">
                            {{ trim($usuario->nombre . ' ' . ($usuario->apellido ?? '')) }}
                        </td>

                        {{-- Correo --}}
                        <td class="p-3 text-gray-300">
                            {{ $usuario->email }}
                        </td>

                        {{-- Rol --}}
                        <td class="p-3">

                            @if ($usuario->rol)
                                <span class="text-emerald-400">
                                    {{ $usuario->rol->nombre }}
                                </span>
                            @else
                                <span class="text-gray-500">
                                    Sin rol
                                </span>
                            @endif

                        </td>

                        {{-- Estado --}}
                        <td class="p-3">

                            @if ($usuario->estado)
                                <span class="text-gray-300">
                                    {{ $usuario->estado->nombre }}
                                </span>
                            @else
                                <span class="text-gray-500">
                                    Sin estado
                                </span>
                            @endif

                        </td>

                        {{-- Acciones --}}
                        <td class="p-3 text-center">

                            <a
                                href="{{ route('seguridad.usuarios.edit', $usuario) }}"
                                class="text-emerald-400 hover:text-emerald-300"
                            >
                                Editar seguridad
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="5"
                            class="p-8 text-center text-gray-500"
                        >
                            No hay usuarios registrados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

