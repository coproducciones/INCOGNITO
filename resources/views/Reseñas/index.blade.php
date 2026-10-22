@extends('layouts.app')

@section('title', 'Reseñas')

@section('content')

@if($modoMiCuenta ?? false)

<div class="w-full max-w-7xl">

    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-8">
        <div>
            <a href="{{ route('mi-cuenta') }}"
               class="font-bold uppercase tracking-widest transition-colors hover:text-white"
               style="font-size:9px;color:rgba(255,255,255,.4);">
                ← MI CUENTA
            </a>

            <h1 class="mt-5 font-black uppercase tracking-widest text-white"
                style="font-size:22px;letter-spacing:.15em;">
                MIS RESEÑAS
            </h1>

            <div class="mt-3 h-[3px] w-[60px]" style="background:#A99045;"></div>

            <p class="mt-3 font-bold uppercase tracking-widest"
               style="font-size:10px;color:rgba(255,255,255,.4);">
                OPINIONES QUE HAS COMPARTIDO SOBRE TUS PRODUCTOS
            </p>
        </div>

        <a href="{{ route('mi-cuenta.resenas.create') }}"
           class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all hover:opacity-90"
           style="font-size:10px;background:#A99045;color:#111111;border:1px solid #D8C17F;border-radius:4px;">
            ESCRIBIR RESEÑA
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
             style="font-size:10px;background:rgba(169,144,69,.10);border:1px solid rgba(169,144,69,.35);border-radius:4px;color:#D8C17F;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($resenas as $reseña)
            <article class="p-6 transition-all duration-200 hover:-translate-y-1"
                     style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);border-radius:6px;box-shadow:0 8px 24px rgba(0,0,0,.15);">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-black uppercase text-white" style="font-size:11px;">
                            {{ $reseña->producto?->nombre ?? 'PRODUCTO NO DISPONIBLE' }}
                        </p>

                        <p class="mt-2" style="font-size:13px;color:#D8C17F;">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $reseña->calificacion ? '★' : '☆' }}
                            @endfor
                        </p>
                    </div>

                    <span class="font-black" style="font-size:11px;color:#D8C17F;">
                        {{ $reseña->calificacion }}/5
                    </span>
                </div>

                <div class="mt-5">
                    <p class="font-bold uppercase tracking-widest"
                       style="font-size:9px;color:rgba(255,255,255,.4);">
                        COMENTARIO
                    </p>

                    <p class="mt-2 leading-relaxed" style="font-size:11px;color:rgba(255,255,255,.75);">
                        {{ $reseña->comentario ?: 'SIN COMENTARIO' }}
                    </p>
                </div>

                @if($reseña->respuesta)
                    <div class="mt-5 p-4"
                         style="background:rgba(169,144,69,.06);border-left:2px solid #A99045;border-radius:0 4px 4px 0;">
                        <p class="font-black uppercase tracking-widest"
                           style="font-size:9px;color:#D8C17F;">
                            RESPUESTA
                        </p>
                        <p class="mt-2" style="font-size:11px;color:rgba(255,255,255,.75);">
                            {{ $reseña->respuesta }}
                        </p>
                    </div>
                @endif

                <div class="mt-5 pt-4 flex flex-wrap items-center justify-between gap-3"
                     style="border-top:1px solid rgba(169,144,69,.18);">
                    <span style="font-size:9px;color:rgba(255,255,255,.35);">
                        {{ $reseña->fecha?->format('d/m/Y H:i') ?? 'SIN FECHA' }}
                    </span>

                    <div class="flex gap-2">
                        <a href="{{ route('mi-cuenta.resenas.edit', $reseña) }}"
                           class="px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/5"
                           style="font-size:9px;color:#D8C17F;border:1px solid rgba(169,144,69,.4);border-radius:4px;">
                            EDITAR
                        </a>

                        <form method="POST"
                              action="{{ route('mi-cuenta.resenas.destroy', $reseña) }}"
                              onsubmit="return confirm('¿Eliminar tu reseña?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-red-500/10"
                                    style="font-size:9px;color:#f87171;border:1px solid rgba(248,113,113,.25);border-radius:4px;background:transparent;cursor:pointer;">
                                ELIMINAR
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="md:col-span-2 xl:col-span-3 px-6 py-12 text-center"
                 style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);border-radius:6px;">
                <p class="font-black uppercase tracking-widest text-white" style="font-size:11px;">
                    TODAVÍA NO TIENES RESEÑAS
                </p>
                <p class="mt-2" style="font-size:10px;color:rgba(255,255,255,.4);">
                    Puedes reseñar productos de pedidos que ya estén completados.
                </p>
            </div>
        @endforelse
    </div>
</div>

@else

<div class="w-full">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-5 mb-8">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px;letter-spacing:.15em;"
            >
                RESEÑAS
            </h1>

            <div class="mt-3 h-[3px] w-[60px]" style="background:#A99045;"></div>

            <p
                class="font-bold uppercase tracking-widest mt-3"
                style="font-size:10px;color:rgba(255,255,255,.4);"
            >
                GESTIÓN DE RESEÑAS
            </p>

        </div>

        {{-- NUEVA RESEÑA --}}

        <a
            href="{{ route('reseñas.create') }}"
            class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:opacity-90"
            style="font-size:10px;background:#A99045;color:#111111;border:1px solid #D8C17F;border-radius:4px;letter-spacing:.1em;"
        >
            + NUEVA RESEÑA
        </a>

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
    {{-- TABLA --}}
    {{-- ========================================================= --}}

    <div
        class="overflow-x-auto"
        style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);border-radius:6px;box-shadow:0 8px 24px rgba(0,0,0,.15);"
    >

        <table class="w-full">

            {{-- ENCABEZADO --}}

            <thead>

                <tr style="background:rgba(169,144,69,.06);border-bottom:1px solid rgba(169,144,69,.3);">

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        ID
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        USUARIO
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        PRODUCTO
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        CLIENTE
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        CALIFICACIÓN
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        FECHA
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px;color:#D8C17F;"
                    >
                        ACCIONES
                    </th>

                </tr>

            </thead>

            {{-- CUERPO --}}

            <tbody>

                @forelse($resenas as $reseña)

                    <tr
                        class="transition-colors hover:bg-white/[0.02]"
                        style="border-bottom:1px solid rgba(255,255,255,.05);"
                    >

                        {{-- ID --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:12px;"
                        >
                            {{ $reseña->id_reseña }}
                        </td>

                        {{-- USUARIO --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:12px;"
                        >

                            @if($reseña->usuario)

                                {{ $reseña->usuario->nombre }}

                            @else

                                <span style="color:rgba(255,255,255,.3);">
                                    SIN USUARIO
                                </span>

                            @endif

                        </td>

                        {{-- PRODUCTO --}}

                        <td
                            class="px-6 py-4 font-bold"
                            style="font-size:12px;color:#D8C17F;"
                        >

                            @if($reseña->producto)

                                {{ $reseña->producto->nombre }}

                            @else

                                <span style="color:rgba(255,255,255,.3);">
                                    SIN PRODUCTO
                                </span>

                            @endif

                        </td>

                        {{-- CLIENTE --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:12px;"
                        >

                            @if($reseña->cliente)

                                {{ $reseña->cliente->nombre }}

                            @else

                                <span style="color:rgba(255,255,255,.3);">
                                    SIN CLIENTE
                                </span>

                            @endif

                        </td>

                        {{-- CALIFICACIÓN --}}

                        <td class="px-6 py-4 whitespace-nowrap">

                            <span
                                class="font-black"
                                style="font-size:12px;color:#D8C17F;"
                            >
                                {{ $reseña->calificacion }}/5
                            </span>

                        </td>

                        {{-- FECHA --}}

                        <td
                            class="px-6 py-4 font-bold text-white whitespace-nowrap"
                            style="font-size:11px;"
                        >

                            @if($reseña->fecha)

                                {{ $reseña->fecha->format('d/m/Y H:i') }}

                            @else

                                <span style="color:rgba(255,255,255,.3);">
                                    SIN FECHA
                                </span>

                            @endif

                        </td>

                        {{-- ACCIONES --}}

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-2">

                                {{-- VER --}}

                                <a
                                    href="{{ route('reseñas.show', $reseña) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/10"
                                    style="min-width:60px;font-size:9px;color:rgba(255,255,255,.7);border:1px solid rgba(255,255,255,.15);border-radius:4px;"
                                >
                                    VER
                                </a>

                                {{-- EDITAR --}}

                                <a
                                    href="{{ route('reseñas.edit', $reseña) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/5"
                                    style="min-width:60px;font-size:9px;color:#D8C17F;border:1px solid rgba(169,144,69,.4);border-radius:4px;"
                                >
                                    EDITAR
                                </a>

                                {{-- ELIMINAR --}}

                                <form
                                    action="{{ route('reseñas.destroy', $reseña) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar esta reseña?')"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-red-500/10"
                                        style="min-width:75px;font-size:9px;color:#f87171;border:1px solid rgba(248,113,113,.25);border-radius:4px;background:transparent;cursor:pointer;"
                                    >
                                        ELIMINAR
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-6 py-10 text-center font-bold uppercase tracking-widest"
                            style="font-size:10px;color:rgba(255,255,255,.4);"
                        >
                            NO HAY RESEÑAS REGISTRADAS
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endif

@endsection
