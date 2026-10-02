@extends('layouts.app')

@section('title', 'Pedidos')

@section('content')

<div class="w-full">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="
                    font-size:22px;
                    letter-spacing:0.15em;
                "
            >
                PEDIDOS
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-1"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.4);
                "
            >
                GESTIÓN Y SEGUIMIENTO DE PEDIDOS
            </p>

        </div>

        {{-- NUEVO PEDIDO --}}

        <a
            href="{{ route('pedidos.create') }}"
            class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 text-black transition-all hover:opacity-80"
            style="
                font-size:10px;
                background:#00c896;
                border-radius:4px;
                letter-spacing:0.1em;
            "
        >
            + NUEVO PEDIDO
        </a>

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
    {{-- ERRORES GENERALES --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div
            class="mb-6 px-4 py-3"
            style="
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-radius:4px;
            "
        >

            <p
                class="font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:#f87171;
                "
            >
                SE PRODUJERON ERRORES
            </p>

            <ul class="mt-2">

                @foreach($errors->all() as $error)

                    <li
                        class="font-bold"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.6);
                        "
                    >
                        • {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- TABLA --}}
    {{-- ========================================================= --}}

    <div
        class="overflow-x-auto"
        style="
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >

        <table class="w-full">

            {{-- ENCABEZADO --}}

            <thead>

                <tr
                    style="
                        border-bottom:1px solid rgba(255,255,255,0.08);
                    "
                >

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        ID
                    </th>

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        USUARIO
                    </th>

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        ESTADO
                    </th>

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        DETALLES
                    </th>

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        TOTAL
                    </th>

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        FECHA
                    </th>

                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.4);">
                        ACCIONES
                    </th>

                </tr>

            </thead>


            {{-- CUERPO --}}

            <tbody>

                @forelse($pedidos as $pedido)

                    <tr
                        style="
                            border-bottom:1px solid rgba(255,255,255,0.05);
                        "
                    >

                        {{-- ID --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:12px;"
                        >
                            #{{ $pedido->id_pedido }}
                        </td>


                        {{-- USUARIO --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:12px;"
                        >
                            {{ $pedido->usuario?->nombre ?? 'SIN USUARIO' }}
                        </td>


                        {{-- ESTADO --}}

                        <td class="px-6 py-4">

                            @php
                                $estado = strtolower($pedido->estado?->nombre ?? '');
                            @endphp

                            @if($estado === 'pendiente')

                                <span
                                    class="font-black uppercase tracking-widest px-3 py-1"
                                    style="
                                        font-size:9px;
                                        background:rgba(251,191,36,0.15);
                                        color:#fbbf24;
                                        border-radius:3px;
                                    "
                                >
                                    {{ strtoupper($pedido->estado->nombre) }}
                                </span>

                            @elseif(in_array($estado, ['completado', 'entregado']))

                                <span
                                    class="font-black uppercase tracking-widest px-3 py-1"
                                    style="
                                        font-size:9px;
                                        background:rgba(0,200,150,0.15);
                                        color:#00c896;
                                        border-radius:3px;
                                    "
                                >
                                    {{ strtoupper($pedido->estado->nombre) }}
                                </span>

                            @elseif($estado === 'cancelado')

                                <span
                                    class="font-black uppercase tracking-widest px-3 py-1"
                                    style="
                                        font-size:9px;
                                        background:rgba(248,113,113,0.15);
                                        color:#f87171;
                                        border-radius:3px;
                                    "
                                >
                                    {{ strtoupper($pedido->estado->nombre) }}
                                </span>

                            @else

                                <span
                                    class="font-black uppercase tracking-widest px-3 py-1"
                                    style="
                                        font-size:9px;
                                        background:rgba(255,255,255,0.08);
                                        color:rgba(255,255,255,0.6);
                                        border-radius:3px;
                                    "
                                >
                                    {{ strtoupper($pedido->estado?->nombre ?? 'SIN ESTADO') }}
                                </span>

                            @endif

                        </td>


                        {{-- DETALLES --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:12px;"
                        >
                            {{ $pedido->detalles_count }}
                        </td>


                        {{-- TOTAL --}}

                        <td
                            class="px-6 py-4 font-black"
                            style="
                                font-size:12px;
                                color:#00c896;
                            "
                        >
                            ${{ number_format((float)$pedido->total, 0, ',', '.') }}
                        </td>


                        {{-- FECHA --}}

                        <td
                            class="px-6 py-4 font-bold"
                            style="
                                font-size:11px;
                                color:rgba(255,255,255,0.5);
                            "
                        >
                            {{ $pedido->fecha_pedido?->format('d/m/Y H:i') }}
                        </td>


                        {{-- ACCIONES --}}

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-2">

                                {{-- VER --}}

                                <a
                                    href="{{ route('pedidos.show', ['pedido' => $pedido->id_pedido]) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/10"
                                    style="
                                        min-width:60px;
                                        font-size:9px;
                                        color:rgba(255,255,255,0.6);
                                        border:1px solid rgba(255,255,255,0.12);
                                        border-radius:4px;
                                    "
                                >
                                    VER
                                </a>


                                {{-- EDITAR --}}

                                <a
                                    href="{{ route('pedidos.edit', ['pedido' => $pedido->id_pedido]) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-yellow-500/10"
                                    style="
                                        min-width:60px;
                                        font-size:9px;
                                        color:#fbbf24;
                                        border:1px solid rgba(251,191,36,0.25);
                                        border-radius:4px;
                                    "
                                >
                                    EDITAR
                                </a>


                                {{-- BORRAR --}}

                                <form
                                    action="{{ route('pedidos.destroy', $pedido->id_pedido) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-red-500/10"
                                        style="
                                            min-width:60px;
                                            font-size:9px;
                                            color:#f87171;
                                            border:1px solid rgba(248,113,113,0.25);
                                            border-radius:4px;
                                        "
                                    >
                                        BORRAR
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-6 py-12 text-center font-bold uppercase tracking-widest"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.3);
                            "
                        >
                            NO HAY PEDIDOS REGISTRADOS
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection