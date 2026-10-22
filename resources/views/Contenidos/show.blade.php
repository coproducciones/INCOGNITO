@extends('layouts.app')

@section('title', 'Detalle de contenido')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    {{-- TARJETA PRINCIPAL --}}
    <div
        class="p-6 sm:p-8"
        style="
            background:#1D1D1D;
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >

        {{-- ENCABEZADO --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

            <div class="min-w-0">

                <p
                    class="font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    DETALLE DE CONTENIDO
                </p>

                <h1
                    class="mt-3 font-black text-white break-words"
                    style="font-size:24px; letter-spacing:0.04em;"
                >
                    {{ $contenido->titulo }}
                </h1>

                <p
                    class="mt-3 font-bold"
                    style="font-size:12px; color:rgba(255,255,255,0.45);"
                >
                    Sección:
                    <span style="color:#D8C17F;">
                        {{ $contenido->seccion ?: 'Sin sección' }}
                    </span>
                </p>

            </div>

            {{-- EDITAR CONTENIDO --}}
            @if(auth()->check() && auth()->user()->tienePermiso('contenido.editar'))
                <a
                    href="{{ route('contenidos.edit', $contenido) }}"
                    class="inline-flex shrink-0 items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all duration-300 hover:opacity-90"
                    style="
                        font-size:10px;
                        color:#111111;
                        background:#A99045;
                        border:1px solid #A99045;
                        border-radius:4px;
                    "
                >
                    Editar contenido
                </a>
            @endif

        </div>


        {{-- DESCRIPCIÓN --}}
        <div
            class="mt-8 pt-6"
            style="border-top:1px solid rgba(255,255,255,0.08);"
        >

            <h2
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:#D8C17F;"
            >
                DESCRIPCIÓN
            </h2>

            <p
                class="mt-4 whitespace-pre-line leading-7"
                style="font-size:13px; color:rgba(255,255,255,0.75);"
            >{{ $contenido->descripcion ?: 'Sin descripción.' }}</p>

        </div>


        {{-- CATEGORÍAS ASOCIADAS --}}
        <div
            class="mt-8 pt-6"
            style="border-top:1px solid rgba(255,255,255,0.08);"
        >

            <h2
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:#D8C17F;"
            >
                CATEGORÍAS ASOCIADAS
            </h2>

            <div class="mt-4 flex flex-wrap gap-2">

                @forelse($contenido->categorias as $categoria)

                    <span
                        class="inline-flex items-center px-3 py-2 font-bold"
                        style="
                            font-size:11px;
                            color:#D8C17F;
                            background:rgba(169,144,69,0.10);
                            border:1px solid rgba(169,144,69,0.3);
                            border-radius:4px;
                        "
                    >
                        {{ $categoria->nombre }}
                    </span>

                @empty

                    <p
                        class="text-sm"
                        style="color:rgba(255,255,255,0.4);"
                    >
                        Este contenido no tiene categorías asociadas.
                    </p>

                @endforelse

            </div>

        </div>


        {{-- MULTIMEDIAS RELACIONADAS --}}
        <div
            class="mt-8 pt-6"
            style="border-top:1px solid rgba(255,255,255,0.08);"
        >

            <h2
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:#D8C17F;"
            >
                MULTIMEDIAS RELACIONADAS
            </h2>

            @forelse($contenido->media as $media)

                <div
                    class="mt-4 flex flex-col gap-4 p-4 sm:flex-row sm:items-center sm:justify-between"
                    style="
                        background:#151515;
                        border:1px solid rgba(255,255,255,0.08);
                        border-radius:4px;
                    "
                >

                    <div class="min-w-0">

                        <p
                            class="font-bold text-white"
                            style="font-size:12px;"
                        >
                            {{ $media->tipo }}
                        </p>

                        <p
                            class="mt-2 break-all"
                            style="
                                font-size:11px;
                                color:rgba(255,255,255,0.4);
                            "
                        >
                            {{ $media->url }}
                        </p>

                    </div>

                    {{-- VER MULTIMEDIA --}}
                    @if(auth()->check() && auth()->user()->tienePermiso('multimedia.ver'))
                        <a
                            href="{{ route('multimedias.show', ['media' => $media->id]) }}"
                            class="inline-flex shrink-0 items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-[#A99045]/10"
                            style="
                                font-size:9px;
                                color:#D8C17F;
                                border:1px solid rgba(169,144,69,0.4);
                                border-radius:4px;
                            "
                        >
                            Ver multimedia
                        </a>
                    @endif

                </div>

            @empty

                <p
                    class="mt-4 text-sm"
                    style="color:rgba(255,255,255,0.4);"
                >
                    Todavía no hay multimedias asociadas a este contenido.
                </p>

            @endforelse

        </div>


        {{-- VOLVER A CONTENIDOS --}}
        <div
            class="mt-8 pt-6"
            style="border-top:1px solid rgba(255,255,255,0.08);"
        >

            <a
                href="{{ route('contenidos.index') }}"
                class="inline-flex items-center gap-2 font-black uppercase tracking-widest transition-colors duration-200 hover:text-[#D8C17F]"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.55);
                "
            >
                <span aria-hidden="true">←</span>
                Volver a contenidos
            </a>

        </div>

    </div>

</div>

@endsection