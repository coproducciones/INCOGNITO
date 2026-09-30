@extends('layouts.app')

@section('title', 'Reseñas')

@section('content')

<div>

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="flex items-center justify-between mb-8">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="
                    font-size:22px;
                    letter-spacing:0.15em;
                "
            >
                RESEÑAS
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-1"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.4);
                "
            >
                GESTIÓN DE RESEÑAS
            </p>

        </div>


        {{-- NUEVA RESEÑA --}}

        <a
            href="{{ route('reseñas.create') }}"
            class="font-black uppercase tracking-widest px-5 py-2 text-black"
            style="
                font-size:11px;
                background:#00c896;
                border-radius:4px;
                letter-spacing:0.1em;
            "
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

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        ID
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        USUARIO
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        PRODUCTO
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        CLIENTE
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        CALIFICACIÓN
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        FECHA
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        ACCIONES
                    </th>

                </tr>

            </thead>


            {{-- CUERPO --}}

            <tbody>

                @forelse($resenas as $reseña)

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

                                <span
                                    style="
                                        color:rgba(255,255,255,0.3);
                                    "
                                >
                                    SIN USUARIO
                                </span>

                            @endif

                        </td>


                        {{-- PRODUCTO --}}

                        <td
                            class="px-6 py-4 font-bold"
                            style="
                                font-size:12px;
                                color:#00c896;
                            "
                        >

                            @if($reseña->producto)

                                {{ $reseña->producto->nombre }}

                            @else

                                <span
                                    style="
                                        color:rgba(255,255,255,0.3);
                                    "
                                >
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

                                <span
                                    style="
                                        color:rgba(255,255,255,0.3);
                                    "
                                >
                                    SIN CLIENTE
                                </span>

                            @endif

                        </td>


                        {{-- CALIFICACIÓN --}}

                        <td class="px-6 py-4">

                            <span
                                class="font-black"
                                style="
                                    font-size:12px;
                                    color:#00c896;
                                "
                            >
                                {{ $reseña->calificacion }}/5
                            </span>

                        </td>


                        {{-- FECHA --}}

                        <td
                            class="px-6 py-4 font-bold text-white"
                            style="font-size:11px;"
                        >

                            @if($reseña->fecha)

                                {{ $reseña->fecha->format('d/m/Y H:i') }}

                            @else

                                <span
                                    style="
                                        color:rgba(255,255,255,0.3);
                                    "
                                >
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
                                    href="{{ route('reseñas.edit', $reseña) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-emerald-500/10"
                                    style="
                                        min-width:60px;
                                        font-size:9px;
                                        color:#00c896;
                                        border:1px solid rgba(0,200,150,0.25);
                                        border-radius:4px;
                                    "
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
                                        class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest"
                                        style="
                                            min-width:75px;
                                            font-size:9px;
                                            color:#f87171;
                                            border:1px solid rgba(248,113,113,0.25);
                                            border-radius:4px;
                                            background:transparent;
                                            cursor:pointer;
                                        "
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
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.3);
                            "
                        >
                            NO HAY RESEÑAS REGISTRADAS
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection

