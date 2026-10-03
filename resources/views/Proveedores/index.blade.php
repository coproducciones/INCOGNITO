@extends('layouts.app')

@section('title', 'Gestión de proveedores')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-white">
                Proveedores
            </h1>

            <p class="text-sm text-gray-400">
                Gestión de perfiles y disponibilidad.
            </p>
        </div>

        <a
            href="{{ route('proveedores.create') }}"
            class="px-4 py-2 rounded-lg bg-[#00c896] text-black font-semibold"
        >
            Nuevo proveedor
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- MENSAJE DE ÉXITO --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="mb-4 rounded-lg border border-green-500/30 bg-green-500/10 px-4 py-3 text-green-300">
            {{ session('success') }}
        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- TABLA --}}
    {{-- ========================================================= --}}

    <div class="overflow-x-auto rounded-xl border border-white/10 bg-[#111111]">

        <table class="min-w-full text-sm text-gray-200">

            <thead class="border-b border-white/10 text-left text-xs uppercase tracking-wider text-gray-400">

                <tr>

                    {{-- ID --}}
                    <th class="px-4 py-3">
                        ID
                    </th>

                    {{-- Usuario --}}
                    <th class="px-4 py-3">
                        Usuario
                    </th>

                    {{-- Especialidad --}}
                    <th class="px-4 py-3">
                        Especialidad
                    </th>

                    {{-- Teléfono --}}
                    <th class="px-4 py-3">
                        Teléfono
                    </th>

                    {{-- WhatsApp --}}
                    <th class="px-4 py-3">
                        WhatsApp
                    </th>

                    {{-- Acciones --}}
                    <th class="px-4 py-3">
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-white/5">

                @forelse($proveedores as $proveedor)

                    <tr>

                        {{-- ================================================= --}}
                        {{-- ID DEL PROVEEDOR --}}
                        {{-- ================================================= --}}

                        <td class="px-4 py-3">

                            <span class="inline-flex items-center rounded-md border border-white/10 bg-white/5 px-2 py-1 text-xs font-semibold text-gray-300">
                                #{{ $proveedor->id_proveedor }}
                            </span>

                        </td>


                        {{-- ================================================= --}}
                        {{-- USUARIO --}}
                        {{-- ================================================= --}}

                        <td class="px-4 py-3">

                            {{ $proveedor->usuario?->nombre ?? 'Sin usuario' }}

                        </td>


                        {{-- ================================================= --}}
                        {{-- ESPECIALIDAD --}}
                        {{-- ================================================= --}}

                        <td class="px-4 py-3">

                            {{ $proveedor->especialidad }}

                        </td>


                        {{-- ================================================= --}}
                        {{-- TELÉFONO --}}
                        {{-- ================================================= --}}

                        <td class="px-4 py-3">

                            {{ $proveedor->telefono }}

                        </td>


                        {{-- ================================================= --}}
                        {{-- WHATSAPP --}}
                        {{-- ================================================= --}}

                        <td class="px-4 py-3">

                            {{ $proveedor->whatsapp ?? '—' }}

                        </td>


                        {{-- ================================================= --}}
                        {{-- ACCIONES --}}
                        {{-- ================================================= --}}

                        <td class="px-4 py-3">

                            <div class="flex flex-wrap gap-2">

                                <a
                                    href="{{ route('proveedores.edit', $proveedor) }}"
                                    class="text-yellow-300 hover:text-yellow-200"
                                >
                                    Editar
                                </a>

                                <a
                                    href="{{ route('proveedores.disponibilidades.index', $proveedor) }}"
                                    class="text-[#00c896] hover:text-[#00e0aa]"
                                >
                                    Disponibilidad
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('proveedores.destroy', $proveedor) }}"
                                    onsubmit="return confirm('¿Eliminar este proveedor?')"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="text-red-300 hover:text-red-200"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-4 py-8 text-center text-gray-500"
                        >
                            No hay proveedores registrados.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection