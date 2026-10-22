@extends('layouts.app')

@section('title', 'Gestión de contenido')

@section('content')

<div class="space-y-6">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px; letter-spacing:0.15em;"
            >
                CONTENIDOS
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                Administra la información pública del sistema.
            </p>
        </div>

        {{-- NUEVO CONTENIDO --}}
        @if(auth()->check() && auth()->user()->tienePermiso('contenido.crear'))
            <a
                href="{{ route('contenidos.create') }}"
                class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all duration-300 hover:opacity-90"
                style="
                    font-size:10px;
                    color:#111111;
                    background:#A99045;
                    border:1px solid #A99045;
                    border-radius:4px;
                    letter-spacing:0.1em;
                "
            >
                + NUEVO CONTENIDO
            </a>
        @endif

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div
            class="px-4 py-3 font-bold"
            style="
                font-size:12px;
                background:rgba(0,200,150,0.1);
                border:1px solid rgba(0,200,150,0.3);
                border-radius:4px;
                color:#00c896;
            "
        >
            {{ session('success') }}
        </div>
    @endif


    {{-- MENSAJES DE ERROR --}}
    @if($errors->any())
        <div
            class="px-4 py-3"
            style="
                font-size:12px;
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-radius:4px;
                color:#f87171;
            "
        >
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- TABLA DE CONTENIDOS --}}
    <div
        class="overflow-hidden"
        style="
            background:#1D1D1D;
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >
        <div class="overflow-x-auto">

            <table class="w-full text-left" style="min-width:750px;">

                {{-- ENCABEZADO DE LA TABLA --}}
                <thead>
                    <tr
                        style="
                            background:#151515;
                            border-bottom:1px solid rgba(169,144,69,0.3);
                        "
                    >
                        <th
                            class="px-5 py-4 font-black uppercase tracking-widest"
                            style="font-size:10px; color:#D8C17F;"
                        >
                            Título
                        </th>

                        <th
                            class="px-5 py-4 font-black uppercase tracking-widest"
                            style="font-size:10px; color:#D8C17F;"
                        >
                            Sección
                        </th>

                        <th
                            class="px-5 py-4 font-black uppercase tracking-widest"
                            style="font-size:10px; color:#D8C17F;"
                        >
                            Descripción
                        </th>

                        <th
                            class="px-5 py-4 text-right font-black uppercase tracking-widest"
                            style="font-size:10px; color:#D8C17F;"
                        >
                            Acciones
                        </th>
                    </tr>
                </thead>


                {{-- CUERPO DE LA TABLA --}}
                <tbody>

                    @forelse($contenidos as $contenido)

                        <tr
                            class="transition-colors duration-200 hover:bg-white/[0.02]"
                            style="border-bottom:1px solid rgba(255,255,255,0.05);"
                        >

                            {{-- TÍTULO --}}
                            <td
                                class="px-5 py-4 font-bold text-white"
                                style="font-size:12px;"
                            >
                                {{ $contenido->titulo }}
                            </td>

                            {{-- SECCIÓN --}}
                            <td
                                class="px-5 py-4 font-bold"
                                style="font-size:11px; color:#D8C17F;"
                            >
                                {{ $contenido->seccion }}
                            </td>

                            {{-- DESCRIPCIÓN --}}
                            <td
                                class="max-w-md px-5 py-4"
                                style="
                                    font-size:12px;
                                    color:rgba(255,255,255,0.55);
                                "
                            >
                                {{ \Illuminate\Support\Str::limit($contenido->descripcion ?? '', 100) ?: 'Sin descripción' }}
                            </td>

                            {{-- ACCIONES --}}
                            <td class="whitespace-nowrap px-5 py-4 text-right">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- VER --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('contenido.ver'))
                                        <a
                                            href="{{ route('contenidos.show', $contenido) }}"
                                            class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-white/[0.08]"
                                            style="
                                                font-size:9px;
                                                color:rgba(255,255,255,0.7);
                                                border:1px solid rgba(255,255,255,0.12);
                                                border-radius:4px;
                                            "
                                        >
                                            Ver
                                        </a>
                                    @endif


                                    {{-- EDITAR --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('contenido.editar'))
                                        <a
                                            href="{{ route('contenidos.edit', $contenido) }}"
                                            class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-[#A99045]/10"
                                            style="
                                                font-size:9px;
                                                color:#D8C17F;
                                                border:1px solid rgba(169,144,69,0.4);
                                                border-radius:4px;
                                            "
                                        >
                                            Editar
                                        </a>
                                    @endif


                                    {{-- ELIMINAR --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('contenido.eliminar'))
                                        <form
                                            method="POST"
                                            action="{{ route('contenidos.destroy', $contenido) }}"
                                            class="inline"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este contenido?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-red-500/10"
                                                style="
                                                    font-size:9px;
                                                    color:#f87171;
                                                    border:1px solid rgba(248,113,113,0.25);
                                                    border-radius:4px;
                                                    background:transparent;
                                                    cursor:pointer;
                                                "
                                            >
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- ESTADO VACÍO --}}
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center">

                                <p
                                    class="font-black uppercase tracking-widest"
                                    style="
                                        font-size:11px;
                                        color:rgba(255,255,255,0.7);
                                    "
                                >
                                    No hay contenidos registrados.
                                </p>

                                <p
                                    class="mt-2"
                                    style="
                                        font-size:12px;
                                        color:rgba(255,255,255,0.4);
                                    "
                                >
                                    Crea el primer contenido para que pueda asociarse a una multimedia.
                                </p>

                                @if(auth()->check() && auth()->user()->tienePermiso('contenido.crear'))
                                    <a
                                        href="{{ route('contenidos.create') }}"
                                        class="mt-5 inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all duration-300 hover:opacity-90"
                                        style="
                                            font-size:10px;
                                            color:#111111;
                                            background:#A99045;
                                            border:1px solid #A99045;
                                            border-radius:4px;
                                        "
                                    >
                                        Crear contenido
                                    </a>
                                @endif

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection