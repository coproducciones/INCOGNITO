@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')

<div class="space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="text-sm font-medium uppercase tracking-widest text-[#00c896]">
                Gestión de proveedores
            </p>

            <h1 class="mt-2 text-2xl font-bold text-white sm:text-3xl">
                Proveedores
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                Consulta y administra los proveedores registrados en Incógnito.
            </p>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('proveedores.crear'))
            <a
                href="{{ route('proveedores.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#00c896] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90"
            >
                <span class="text-lg">+</span>
                Registrar proveedor
            </a>
        @endif

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="rounded-xl border border-[#00c896]/20 bg-[#00c896]/10 p-4 text-sm text-[#00c896]">
            {{ session('success') }}
        </div>
    @endif


    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))
        <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif


    {{-- RESUMEN --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="rounded-xl border border-white/10 bg-[#111111] p-5">
            <p class="text-sm text-gray-400">
                Total de proveedores
            </p>

            <p class="mt-3 text-3xl font-bold text-white">
                {{ $proveedores->count() }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Registros disponibles
            </p>
        </div>

        <div class="rounded-xl border border-white/10 bg-[#111111] p-5">
            <p class="text-sm text-gray-400">
                Usuarios relacionados
            </p>

            <p class="mt-3 text-3xl font-bold text-[#00c896]">
                {{ $proveedores->whereNotNull('id_usuario')->count() }}
            </p>

            <p class="mt-2 text-xs text-gray-500">
                Proveedores asociados a un usuario
            </p>
        </div>

    </div>


    {{-- TABLA DE PROVEEDORES --}}
    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">

        <div class="flex flex-col gap-2 border-b border-white/10 p-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-lg font-semibold text-white">
                    Listado de proveedores
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Información registrada y acciones disponibles.
                </p>
            </div>

            <span class="w-fit rounded-full border border-white/10 bg-[#1a1a1a] px-3 py-1 text-xs text-gray-300">
                {{ $proveedores->count() }} registros
            </span>

        </div>


        @if($proveedores->isEmpty())

            {{-- ESTADO VACÍO --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full border border-white/10 bg-[#1a1a1a]">
                    <span class="text-2xl text-[#00c896]">+</span>
                </div>

                <h3 class="mt-4 text-lg font-semibold text-white">
                    No hay proveedores registrados
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-gray-400">
                    Cuando registres un proveedor, su información aparecerá en este listado.
                </p>

                @if(auth()->check() && auth()->user()->tienePermiso('proveedores.crear'))
                    <a
                        href="{{ route('proveedores.create') }}"
                        class="mt-5 inline-flex rounded-lg bg-[#00c896] px-5 py-2.5 text-sm font-semibold text-black transition hover:opacity-90"
                    >
                        Registrar primer proveedor
                    </a>
                @endif

            </div>

        @else

            {{-- TABLA RESPONSIVA --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-white/10 text-left">

                    <thead class="bg-[#0d0d0d]">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Proveedor
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Usuario relacionado
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Contacto
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                                WhatsApp
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">

                        @foreach($proveedores as $proveedor)

                            <tr class="transition hover:bg-white/[0.03]">

                                {{-- PROVEEDOR --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        @if($proveedor->foto_url)
                                            <img
                                                src="{{ $proveedor->foto_url }}"
                                                alt="Foto de {{ $proveedor->especialidad }}"
                                                class="h-11 w-11 rounded-lg border border-white/10 object-cover"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-white/10 bg-[#1a1a1a] text-sm font-bold text-[#00c896]">
                                                {{ strtoupper(substr($proveedor->especialidad ?? 'P', 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="min-w-0">
                                            <p class="font-semibold text-white">
                                                {{ $proveedor->especialidad }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-500">
                                                ID #{{ $proveedor->id_proveedor }}
                                            </p>
                                        </div>

                                    </div>

                                </td>


                                {{-- USUARIO RELACIONADO --}}
                                <td class="px-5 py-4">

                                    @if($proveedor->usuario)
                                        <p class="text-sm font-medium text-gray-200">
                                            {{ $proveedor->usuario->nombre }}
                                        </p>

                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $proveedor->usuario->email }}
                                        </p>
                                    @else
                                        <span class="text-sm text-gray-500">
                                            Sin usuario relacionado
                                        </span>
                                    @endif

                                </td>


                                {{-- TELÉFONO --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="text-sm text-gray-300">
                                        {{ $proveedor->telefono ?: 'No registrado' }}
                                    </span>
                                </td>


                                {{-- WHATSAPP --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    @if($proveedor->whatsapp)
                                        <span class="text-sm text-gray-300">
                                            {{ $proveedor->whatsapp }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-500">
                                            No registrado
                                        </span>
                                    @endif

                                </td>


                                {{-- ACCIONES: EDITAR Y ELIMINAR --}}
                                <td class="px-5 py-4">

                                    <div class="flex flex-wrap items-center justify-end gap-2">

                                        {{-- EDITAR --}}
                                        @if(auth()->check() && auth()->user()->tienePermiso('proveedores.editar'))
                                            <a
                                                href="{{ route('proveedores.edit', $proveedor->id_proveedor) }}"
                                                class="rounded-lg border border-white/10 px-3 py-2 text-xs font-medium text-gray-300 transition hover:border-[#00c896]/40 hover:text-[#00c896]"
                                            >
                                                Editar
                                            </a>
                                        @endif


                                        {{-- ELIMINAR --}}
                                        @if(auth()->check() && auth()->user()->tienePermiso('proveedores.eliminar'))
                                            <form
                                                method="POST"
                                                action="{{ route('proveedores.destroy', $proveedor->id_proveedor) }}"
                                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proveedor?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="rounded-lg border border-red-500/20 px-3 py-2 text-xs font-medium text-red-300 transition hover:bg-red-500/10"
                                                >
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif


                                        {{-- SIN ACCIONES DISPONIBLES --}}
                                        @if(
                                            !auth()->check()
                                            || (
                                                !auth()->user()->tienePermiso('proveedores.editar')
                                                && !auth()->user()->tienePermiso('proveedores.eliminar')
                                            )
                                        )
                                            <span class="text-xs text-gray-500">
                                                Sin acciones disponibles
                                            </span>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

@endsection
