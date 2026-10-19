
@extends('layouts.app')

@section('title', ($esMiDisponibilidad ?? false) ? 'Mi disponibilidad' : 'Disponibilidad del proveedor')

@section('content')
@php
    $esPersonal = $esMiDisponibilidad ?? false;
@endphp

<div class="mx-auto max-w-7xl space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#00c896]">
                Incógnito | Grupo de Diseño
            </p>

            <h1 class="mt-2 text-2xl font-bold text-white sm:text-3xl">
                {{ $esPersonal ? 'Mi disponibilidad' : 'Disponibilidad del proveedor' }}
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                {{ $esPersonal
                    ? 'Administra las fechas en las que puedes ofrecer tus servicios.'
                    : 'Consulta y administra las fechas disponibles de este proveedor.' }}
            </p>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('disponibilidad.crear'))
            <a
                href="{{ $esPersonal
                    ? route('mi-disponibilidad.create')
                    : route('proveedores.disponibilidades.create', $proveedor) }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#00c896] px-5 py-3 text-sm font-semibold text-black transition hover:opacity-90"
            >
                <span class="mr-2 text-lg">+</span>
                Nueva fecha
            </a>
        @endif
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('info'))
        <div class="rounded-xl border border-blue-500/20 bg-blue-500/10 p-4 text-sm text-blue-300">
            {{ session('info') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-4">
            <p class="mb-2 font-semibold text-red-300">
                No se pudo completar la operación.
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-200">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- INFORMACIÓN DEL PROVEEDOR --}}
    <div class="rounded-xl border border-white/10 bg-[#111111] p-5">
        <p class="text-xs font-medium uppercase tracking-wider text-gray-500">
            Proveedor
        </p>

        <h2 class="mt-2 text-lg font-semibold text-white">
            {{ $proveedor->especialidad }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ $esPersonal
                ? 'Estas fechas pertenecen a tu perfil.'
                : 'Estás consultando las fechas de este proveedor.' }}
        </p>
    </div>

    {{-- TABLA --}}
    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">

        <div class="flex items-center justify-between border-b border-white/10 px-5 py-4">
            <h2 class="font-semibold text-white">
                Fechas registradas
            </h2>

            <span class="rounded-full border border-white/10 px-3 py-1 text-xs text-gray-400">
                {{ $disponibilidades->count() }}
                {{ $disponibilidades->count() === 1 ? 'registro' : 'registros' }}
            </span>
        </div>

        @if($disponibilidades->isEmpty())
            <div class="px-6 py-12 text-center">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-white/5 text-2xl text-gray-400">
                    &#128197;
                </div>

                <h3 class="mt-4 font-semibold text-white">
                    No hay fechas registradas
                </h3>

                <p class="mt-2 text-sm text-gray-400">
                    {{ $esPersonal
                        ? 'Agrega las fechas en las que estarás disponible para ofrecer tus servicios.'
                        : 'Este proveedor todavía no tiene fechas de disponibilidad registradas.' }}
                </p>

                @if(auth()->check() && auth()->user()->tienePermiso('disponibilidad.crear'))
                    <a
                        href="{{ $esPersonal
                            ? route('mi-disponibilidad.create')
                            : route('proveedores.disponibilidades.create', $proveedor) }}"
                        class="mt-5 inline-flex rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:opacity-90"
                    >
                        Registrar primera fecha
                    </a>
                @endif
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/[0.03]">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Fecha
                            </th>

                            <th class="px-5 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Estado
                            </th>

                            <th class="px-5 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-400">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">
                        @foreach($disponibilidades as $item)
                            <tr class="transition hover:bg-white/[0.02]">
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-white">
                                    {{ $item->fecha->format('d/m/Y') }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    @if($item->disponible)
                                        <span class="inline-flex rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-300">
                                            Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full border border-red-500/20 bg-red-500/10 px-3 py-1 text-xs font-medium text-red-300">
                                            No disponible
                                        </span>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-5 py-4">
                                    <div class="flex items-center justify-end gap-4">

                                        @if(auth()->check() && auth()->user()->tienePermiso('disponibilidad.editar'))
                                            <a
                                                href="{{ $esPersonal
                                                    ? route('mi-disponibilidad.edit', $item)
                                                    : route('proveedores.disponibilidades.edit', [$proveedor, $item]) }}"
                                                class="text-sm font-medium text-[#00c896] hover:underline"
                                            >
                                                Editar
                                            </a>
                                        @endif

                                        @if(auth()->check() && auth()->user()->tienePermiso('disponibilidad.eliminar'))
                                            <form
                                                method="POST"
                                                action="{{ $esPersonal
                                                    ? route('mi-disponibilidad.destroy', $item)
                                                    : route('proveedores.disponibilidades.destroy', [$proveedor, $item]) }}"
                                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta fecha?')"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-sm font-medium text-red-400 hover:text-red-300"
                                                >
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif

                                        @if(
                                            !auth()->check()
                                            || (
                                                !auth()->user()->tienePermiso('disponibilidad.editar')
                                                && !auth()->user()->tienePermiso('disponibilidad.eliminar')
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

    {{-- VOLVER --}}
    <div>
        @if($esPersonal)
            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center text-sm text-gray-400 transition hover:text-[#00c896]"
            >
                &larr; Volver al panel
            </a>
        @else
            <a
                href="{{ route('proveedores.index') }}"
                class="inline-flex items-center text-sm text-gray-400 transition hover:text-[#00c896]"
            >
                &larr; Volver a proveedores
            </a>
        @endif
    </div>

</div>
@endsection
