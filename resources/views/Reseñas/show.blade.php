@extends('layouts.app')

@section('title', 'Detalle de Reseña')

@section('content')

<div class="w-full max-w-4xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

        <a
            href="{{ route('reseñas.index') }}"
            class="font-bold uppercase tracking-widest transition-colors hover:text-white"
            style="font-size:9px;color:rgba(255,255,255,.4);"
        >
            ← VOLVER A RESEÑAS
        </a>

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-5 mt-5">

            <div>

                <h1
                    class="font-black uppercase tracking-widest text-white"
                    style="font-size:22px;letter-spacing:.15em;"
                >
                    RESEÑA #{{ $reseña->id_reseña }}
                </h1>

                <div class="mt-3 h-[3px] w-[60px]" style="background:#A99045;"></div>

                <p
                    class="mt-3 font-bold uppercase tracking-widest"
                    style="font-size:10px;color:rgba(255,255,255,.4);"
                >
                    DETALLE DE LA RESEÑA
                </p>

            </div>

            {{-- EDITAR --}}

            <a
                href="{{ route('reseñas.edit', $reseña) }}"
                class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:opacity-90"
                style="font-size:10px;background:#A99045;color:#111111;border:1px solid #D8C17F;border-radius:4px;"
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
            style="font-size:10px;background:rgba(169,144,69,.10);border:1px solid rgba(169,144,69,.35);border-radius:4px;color:#D8C17F;"
        >
            {{ session('success') }}
        </div>

    @endif

    {{-- ========================================================= --}}
    {{-- INFORMACIÓN --}}
    {{-- ========================================================= --}}

    <div
        class="overflow-hidden"
        style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);border-radius:6px;box-shadow:0 8px 24px rgba(0,0,0,.15);"
    >

        {{-- USUARIO --}}

        <div
            class="px-6 py-5"
            style="border-bottom:1px solid rgba(169,144,69,.15);"
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="font-size:9px;color:rgba(255,255,255,.4);"
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
            style="border-bottom:1px solid rgba(169,144,69,.15);"
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="font-size:9px;color:rgba(255,255,255,.4);"
            >
                PRODUCTO
            </span>

            <p
                class="font-bold"
                style="font-size:13px;color:#D8C17F;"
            >
                {{ $reseña->producto?->nombre ?? 'SIN PRODUCTO' }}
            </p>

        </div>

        {{-- CLIENTE --}}

        <div
            class="px-6 py-5"
            style="border-bottom:1px solid rgba(169,144,69,.15);"
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="font-size:9px;color:rgba(255,255,255,.4);"
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
            style="border-bottom:1px solid rgba(169,144,69,.15);"
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="font-size:9px;color:rgba(255,255,255,.4);"
            >
                CALIFICACIÓN
            </span>

            <div class="flex items-center gap-3">

                <span
                    class="font-black"
                    style="font-size:20px;color:#D8C17F;"
                >
                    {{ $reseña->calificacion }}/5
                </span>

                <span
                    style="font-size:14px;color:#D8C17F;"
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
            style="border-bottom:1px solid rgba(169,144,69,.15);"
        >

            <span
                class="block font-black uppercase tracking-widest mb-2"
                style="font-size:9px;color:rgba(255,255,255,.4);"
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
            style="border-bottom:1px solid rgba(169,144,69,.15);"
        >

            <span
                class="block font-black uppercase tracking-widest mb-3"
                style="font-size:9px;color:rgba(255,255,255,.4);"
            >
                COMENTARIO
            </span>

            @if($reseña->comentario)

                <p
                    class="leading-relaxed"
                    style="font-size:13px;color:rgba(255,255,255,.8);"
                >
                    {{ $reseña->comentario }}
                </p>

            @else

                <p
                    style="font-size:12px;color:rgba(255,255,255,.3);"
                >
                    SIN COMENTARIO
                </p>

            @endif

        </div>

        {{-- RESPUESTA --}}

        <div class="px-6 py-5">

            <span
                class="block font-black uppercase tracking-widest mb-3"
                style="font-size:9px;color:#D8C17F;"
            >
                RESPUESTA
            </span>

            @if($reseña->respuesta)

                <div
                    class="p-4"
                    style="background:rgba(169,144,69,.06);border-left:2px solid #A99045;border-radius:0 4px 4px 0;"
                >
                    <p
                        class="leading-relaxed"
                        style="font-size:13px;color:rgba(255,255,255,.8);"
                    >
                        {{ $reseña->respuesta }}
                    </p>
                </div>

            @else

                <p
                    style="font-size:12px;color:rgba(255,255,255,.3);"
                >
                    SIN RESPUESTA
                </p>

            @endif

        </div>

    </div>

</div>

@endsection