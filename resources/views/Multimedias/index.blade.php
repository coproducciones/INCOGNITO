@extends('layouts.app')

@section('title', 'Gestión de media')

@section('content')

<div class="space-y-6">

    {{-- ============================================================
         ENCABEZADO
    ============================================================ --}}

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-white">
                Media
            </h1>

            <p class="text-sm text-gray-400">
                Administra imágenes, videos y otros recursos asociados.
            </p>
        </div>

        <a
            href="{{ route('multimedias.create') }}"
            class="rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:bg-[#00b085]"
        >
            Nuevo recurso
        </a>

    </div>


    {{-- ============================================================
         MENSAJE DE ÉXITO
    ============================================================ --}}

    @if(session('success'))

        <div class="rounded-lg bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>

    @endif


    {{-- ============================================================
         ERRORES
    ============================================================ --}}

    @if($errors->any())

        <div class="rounded-lg bg-red-500/10 px-4 py-3 text-sm text-red-300">

            <ul class="list-inside list-disc">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ============================================================
         TABLA
    ============================================================ --}}

    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">

        <div class="overflow-x-auto">

            <table class="min-w-full text-left text-sm text-gray-300">

                <thead class="bg-[#1a1a1a] text-xs uppercase tracking-wider text-gray-400">

                    <tr>

                        <th class="px-5 py-4">
                            ID
                        </th>

                        <th class="px-5 py-4">
                            URL
                        </th>

                        <th class="px-5 py-4">
                            Tipo
                        </th>

                        <th class="px-5 py-4">
                            Destacado
                        </th>

                        <th class="px-5 py-4">
                            Asociación
                        </th>

                        <th class="px-5 py-4 text-right">
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-white/5">

                    @forelse($medias as $media)

                        <tr class= hover:bg-white/[0.02]>

                            {{-- ID REAL DE LA TABLA --}}
                            <td class="px-5 py-4 text-gray-500">
                                {{ $media->id }}
                            </td>


                            {{-- URL --}}
                            <td class="max-w-xs truncate px-5 py-4 text-white">
                                {{ $media->url }}
                            </td>


                            {{-- TIPO --}}
                            <td class="px-5 py-4">
                                {{ $media->tipo }}
                            </td>


                            {{-- DESTACADO --}}
                            <td class="px-5 py-4">

                                @if($media->destacado)

                                    <span class="text-green-400">
                                        Sí
                                    </span>

                                @else

                                    <span class="text-gray-500">
                                        No
                                    </span>

                                @endif

                            </td>


                            {{-- ASOCIACIÓN --}}
                            <td class="px-5 py-4">

                                @if($media->producto)

                                    <span class="text-blue-400">
                                        Producto:
                                    </span>

                                    {{ $media->producto->nombre }}

                                @elseif($media->contenido)

                                    <span class="text-purple-400">
                                        Contenido:
                                    </span>

                                    {{ $media->contenido->titulo }}

                                @else

                                    <span class="text-gray-500">
                                        Sin asociación
                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}
                            <td class="px-5 py-4 text-right">

                                {{-- ==================================================
                                     EDITAR

                                     Ejemplo:
                                     ID = 1

                                     URL:
                                     /multimedias/1/edit
                                =================================================== --}}

                                <a
                                    href="{{ route('multimedias.edit', ['media' => $media->id]) }}"
                                    class="mr-3 text-[#00c896] hover:text-[#00b085]"
                                >
                                    Editar
                                </a>


                                {{-- ==================================================
                                     ELIMINAR

                                     Ejemplo:
                                     ID = 1

                                     URL:
                                     /multimedias/1

                                     Laravel recibe POST y gracias a _method
                                     lo interpreta como DELETE.
                                =================================================== --}}

                                <form
                                    method="POST"
                                    action="{{ route('multimedias.destroy', ['media' => $media->id]) }}"
                                    class="inline"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('¿Eliminar este recurso?')"
                                        class="text-red-400 hover:text-red-300"
                                    >
                                        Eliminar
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-8 text-center text-gray-500"
                            >
                                No hay recursos registrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
