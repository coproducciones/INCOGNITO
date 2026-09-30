@extends('layouts.app')

@section('title', 'Detalle de Reseña')

@section('content')

<div class="max-w-4xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

        <a
            href="{{ route('reseñas.index') }}"
            class="font-bold uppercase tracking-widest"
            style="
                font-size:9px;
                color:rgba(255,255,255,0.4);
            "
        >
            ← VOLVER A RESEÑAS
        </a>


        <div class="flex items-start justify-between mt-5">

            <div>

                <h1
                    class="font-black uppercase tracking-widest text-white"
                    style="
                        font-size:22px;
                        letter-spacing:0.15em;
                    "
                >
                    RESEÑA #{{ $reseña->id_reseña }}
                </h1>

                <p
                    class="mt-1 font-bold uppercase tracking-widest"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                    "
                >
                    DETALLE DE LA RESEÑA
                </p>

            </div>


            {{-- EDITAR --}}

            <a
                href="{{ route('reseñas.edit', $reseña) }}"
                class="font-black uppercase tracking-widest px-5 py-2 text-black"
                style="
                    font-size:10px;
                    background:#00c896;
                    border-radius:4px;
                "
            >
                EDITAR
            </a>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MENSAJE DE ÉXITO --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div
            class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
            style="
                font-size:10px;
                background:rgba(0,200,150,0.1);
                border:1px solid rgba(0,200,150,0.3);
                border-radius:4px;
                color:#00c896;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- INFORMACIÓN --}}
    {{-- ========================================================= --}}

    <div
        class="overflow-hidden"
        style="
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >

        {{-- USUARIO --}}

        <div
            class="px-6 py-5"
            style="
                border-bottom:1px solid rgba(255,255,255,0.06);
            "
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                USUARIO
            </span>

            <p
                class="font-bold text-white"
                style="font-size:13px;"
            >
                {{ $reseña->usuario?->nombre ?? 'SIN USUARIO' }}
            </p>

        </div>


        {{-- PRODUCTO --}}

        <div
            class="px-6 py-5"
            style="
                border-bottom:1px solid rgba(255,255,255,0.06);
            "
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                PRODUCTO
            </span>

            <p
                class="font-bold"
                style="
                    font-size:13px;
                    color:#00c896;
                "
            >
                {{ $reseña->producto?->nombre ?? 'SIN PRODUCTO' }}
            </p>

        </div>


        {{-- CLIENTE --}}

        <div
            class="px-6 py-5"
            style="
                border-bottom:1px solid rgba(255,255,255,0.06);
            "
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                CLIENTE
            </span>

            <p
                class="font-bold text-white"
                style="font-size:13px;"
            >
                {{ $reseña->cliente?->nombre ?? 'SIN CLIENTE' }}
            </p>

        </div>


        {{-- CALIFICACIÓN --}}

        <div
            class="px-6 py-5"
            style="
                border-bottom:1px solid rgba(255,255,255,0.06);
            "
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                CALIFICACIÓN
            </span>

            <div class="flex items-center gap-3">

                <span
                    class="font-black"
                    style="
                        font-size:20px;
                        color:#00c896;
                    "
                >
                    {{ $reseña->calificacion }}/5
                </span>

                <span
                    style="
                        font-size:14px;
                        color:#00c896;
                    "
                >
                    @for($i = 1; $i <= 5; $i++)

                        {{ $i <= $reseña->calificacion ? '★' : '☆' }}

                    @endfor
                </span>

            </div>

        </div>


        {{-- FECHA --}}

        <div
            class="px-6 py-5"
            style="
                border-bottom:1px solid rgba(255,255,255,0.06);
            "
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                FECHA
            </span>

            <p
                class="font-bold text-white"
                style="font-size:13px;"
            >
                {{ $reseña->fecha?->format('d/m/Y H:i') ?? 'SIN FECHA' }}
            </p>

        </div>


        {{-- COMENTARIO --}}

        <div
            class="px-6 py-5"
            style="
                border-bottom:1px solid rgba(255,255,255,0.06);
            "
        >

            <span
                class="block font-black uppercase tracking-widest mb-3"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                COMENTARIO
            </span>

            @if($reseña->comentario)

                <p
                    class="text-white leading-relaxed"
                    style="font-size:13px;"
                >
                    {{ $reseña->comentario }}
                </p>

            @else

                <p
                    style="
                        font-size:12px;
                        color:rgba(255,255,255,0.3);
                    "
                >
                    SIN COMENTARIO
                </p>

            @endif

        </div>


        {{-- RESPUESTA --}}

        <div class="px-6 py-5">

            <span
                class="block font-black uppercase tracking-widest mb-3"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                RESPUESTA
            </span>

            @if($reseña->respuesta)

                <p
                    class="text-white leading-relaxed"
                    style="font-size:13px;"
                >
                    {{ $reseña->respuesta }}
                </p>

            @else

                <p
                    style="
                        font-size:12px;
                        color:rgba(255,255,255,0.3);
                    "
                >
                    SIN RESPUESTA
                </p>

            @endif

        </div>

    </div>

</div>

@endsection

