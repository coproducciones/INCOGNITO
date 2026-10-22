@extends('layouts.app')

@section('title', 'Proveedores')

@section('content')

<div class="space-y-6 px-4 py-6 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-[#D8C17F]">
                Gestión de proveedores
            </p>

            <h1 class="mt-2 text-2xl font-black uppercase tracking-widest text-white sm:text-3xl">
                Proveedores
            </h1>

            <p class="mt-2 text-sm text-white/50">
                Consulta y administra los proveedores registrados en Incógnito.
            </p>

            <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('proveedores.crear'))
            <a
                href="{{ route('proveedores.create') }}"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#A99045] px-5 py-3 text-xs font-black uppercase tracking-widest text-[#111111] transition hover:bg-[#D8C17F]"
            >
                <span class="text-lg">+</span>
                Registrar proveedor
            </a>
        @endif

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="rounded-xl border border-[#A99045]/30 bg-[#A99045]/10 p-4 text-sm text-[#D8C17F]">
            {{ session('success') }}
        </div>
    @endif


    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))
        <div class="rounded-xl border border-red-400/30 bg-red-400/10 p-4 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif


    {{-- RESUMEN --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="rounded-xl border border-[#A99045]/20 bg-[#111111] p-5 shadow-lg shadow-black/10 transition hover:border-[#A99045]/40">
            <p class="text-xs font-bold uppercase tracking-wider text-white/50">
                Total de proveedores
            </p>

            <p class="mt-3 text-3xl font-black text-white">
                {{ $proveedores->count() }}
            </p>

            <p class="mt-2 text-xs text-white/35">
                Registros disponibles
            </p>

            <div class="mt-4 h-px w-full bg-white/10"></div>
        </div>

        <div class="rounded-xl border border-[#A99045]/20 bg-[#111111] p-5 shadow-lg shadow-black/10 transition hover:border-[#A99045]/40">
            <p class="text-xs font-bold uppercase tracking-wider text-white/50">
                Usuarios relacionados
            </p>

            <p class="mt-3 text-3xl font-black text-[#D8C17F]">
                {{ $proveedores->whereNotNull('id_usuario')->count() }}
            </p>

            <p class="mt-2 text-xs text-white/35">
                Proveedores asociados a un usuario
            </p>

            <div class="mt-4 h-px w-full bg-white/10"></div>
        </div>

    </div>


    {{-- TABLA DE PROVEEDORES --}}
    <div class="overflow-hidden rounded-xl border border-[#A99045]/20 bg-[#111111] shadow-xl shadow-black/20">

        <div class="flex flex-col gap-3 border-b border-white/10 p-5 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-sm font-black uppercase tracking-widest text-white">
                    Listado de proveedores
                </h2>

                <p class="mt-2 text-xs text-white/45">
                    Información registrada y acciones disponibles.
                </p>
            </div>

            <span class="w-fit rounded-lg border border-[#A99045]/30 bg-[#1D1D1D] px-3 py-2 text-xs font-bold text-[#D8C17F]">
                {{ $proveedores->count() }} registros
            </span>

        </div>


        @if($proveedores->isEmpty())

            {{-- ESTADO VACÍO --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#1D1D1D]">
                    <span class="text-2xl font-bold text-[#D8C17F]">+</span>
                </div>

                <h3 class="mt-4 text-base font-black uppercase tracking-wider text-white">
                    No hay proveedores registrados
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm leading-relaxed text-white/45">
                    Cuando registres un proveedor, su información aparecerá en este listado.
                </p>

                @if(auth()->check() && auth()->user()->tienePermiso('proveedores.crear'))
                    <a
                        href="{{ route('proveedores.create') }}"
                        class="mt-5 inline-flex rounded-lg bg-[#A99045] px-5 py-3 text-xs font-black uppercase tracking-widest text-[#111111] transition hover:bg-[#D8C17F]"
                    >
                        Registrar primer proveedor
                    </a>
                @endif

            </div>

        @else

            {{-- TABLA RESPONSIVA --}}
            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-white/10 text-left">

                    <thead class="bg-[#0D0D0D]">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-4 text-xs font-black uppercase tracking-widest text-[#D8C17F]">
                                Proveedor
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-black uppercase tracking-widest text-[#D8C17F]">
                                Usuario relacionado
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-black uppercase tracking-widest text-[#D8C17F]">
                                Contacto
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-xs font-black uppercase tracking-widest text-[#D8C17F]">
                                WhatsApp
                            </th>

                            <th class="whitespace-nowrap px-5 py-4 text-right text-xs font-black uppercase tracking-widest text-[#D8C17F]">
                                Acciones
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">

                        @foreach($proveedores as $proveedor)

                            <tr class="transition duration-200 hover:bg-[#A99045]/[0.04]">

                                {{-- PROVEEDOR --}}
                                <td class="px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        @if($proveedor->foto_url)
                                            <img
                                                src="{{ $proveedor->foto_url }}"
                                                alt="Foto de {{ $proveedor->especialidad }}"
                                                class="h-11 w-11 rounded-lg border border-[#A99045]/30 object-cover"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-[#A99045]/30 bg-[#1D1D1D] text-sm font-black text-[#D8C17F]">
                                                {{ strtoupper(substr($proveedor->especialidad ?? 'P', 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="min-w-0">
                                            <p class="text-sm font-bold text-white">
                                                {{ $proveedor->especialidad }}
                                            </p>

                                            <p class="mt-1 text-xs text-white/35">
                                                ID #{{ $proveedor->id_proveedor }}
                                            </p>
                                        </div>

                                    </div>

                                </td>


                                {{-- USUARIO RELACIONADO --}}
                                <td class="px-5 py-4">

                                    @if($proveedor->usuario)
                                        <p class="text-sm font-semibold text-white/85">
                                            {{ $proveedor->usuario->nombre }}
                                        </p>

                                        <p class="mt-1 text-xs text-white/40">
                                            {{ $proveedor->usuario->email }}
                                        </p>
                                    @else
                                        <span class="text-sm text-white/35">
                                            Sin usuario relacionado
                                        </span>
                                    @endif

                                </td>


                                {{-- TELÉFONO --}}
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="text-sm text-white/70">
                                        {{ $proveedor->telefono ?: 'No registrado' }}
                                    </span>
                                </td>


                                {{-- WHATSAPP --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    @if($proveedor->whatsapp)
                                        <span class="text-sm text-white/70">
                                            {{ $proveedor->whatsapp }}
                                        </span>
                                    @else
                                        <span class="text-sm text-white/35">
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
                                                class="rounded-lg border border-[#A99045]/40 bg-[#1D1D1D] px-3 py-2 text-xs font-bold uppercase tracking-wider text-[#D8C17F] transition hover:border-[#D8C17F] hover:bg-[#A99045]/10"
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
                                                    class="rounded-lg border border-red-400/30 bg-red-400/[0.04] px-3 py-2 text-xs font-bold uppercase tracking-wider text-red-300 transition hover:bg-red-400/10"
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
                                            <span class="text-xs text-white/35">
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
