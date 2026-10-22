@extends('layouts.app')

@section('title', 'Seguridad')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div>
        <h1 class="text-2xl font-black uppercase tracking-widest text-white"
            style="letter-spacing: .15em;">
            Gestión de usuarios y seguridad
        </h1>

        <div class="mt-3 h-[3px] w-[60px] rounded-full"
             style="background-color: #A99045;"></div>

        <p class="mt-3 text-sm text-gray-400">
            Administra los roles y estados asignados a los usuarios.
        </p>
    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ÉXITO --}}
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
    {{-- MENSAJE DE ERROR --}}
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
    {{-- TABLA DE USUARIOS --}}
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
                        Usuario
                    </th>

                    <th
                        class="p-4 text-left text-xs font-black uppercase tracking-widest"
                        style="color: #D8C17F; letter-spacing: .1em;"
                    >
                        Correo
                    </th>

                    <th
                        class="p-4 text-left text-xs font-black uppercase tracking-widest"
                        style="color: #D8C17F; letter-spacing: .1em;"
                    >
                        Rol
                    </th>

                    <th
                        class="p-4 text-left text-xs font-black uppercase tracking-widest"
                        style="color: #D8C17F; letter-spacing: .1em;"
                    >
                        Estado
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

                @forelse ($usuarios as $usuario)

                    <tr
                        class="border-b transition hover:bg-white/[0.03]"
                        style="border-color: rgba(255, 255, 255, 0.06);"
                    >

                        {{-- Usuario --}}
                        <td class="p-4 font-semibold text-white">
                            {{ trim($usuario->nombre . ' ' . ($usuario->apellido ?? '')) }}
                        </td>


                        {{-- Correo --}}
                        <td class="p-4 text-gray-300">
                            {{ $usuario->email }}
                        </td>


                        {{-- Rol --}}
                        <td class="p-4">

                            @if ($usuario->rol)

                                <span
                                    class="inline-flex items-center rounded-lg border px-3 py-1 text-xs font-semibold"
                                    style="background-color: rgba(169, 144, 69, 0.1); border-color: rgba(169, 144, 69, 0.3); color: #D8C17F;"
                                >
                                    {{ $usuario->rol->nombre }}
                                </span>

                            @else

                                <span class="text-gray-500">
                                    Sin rol
                                </span>

                            @endif

                        </td>


                        {{-- Estado --}}
                        <td class="p-4">

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
                        <td class="p-4 text-center">

                            <a
                                href="{{ route('seguridad.usuarios.edit', $usuario) }}"
                                class="inline-block rounded-lg border px-4 py-2 text-xs font-bold transition hover:brightness-125"
                                style="background-color: rgba(169, 144, 69, 0.12); border-color: rgba(169, 144, 69, 0.3); color: #D8C17F;"
                            >
                                Editar seguridad
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="5"
                            class="p-10 text-center text-sm text-gray-400"
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
