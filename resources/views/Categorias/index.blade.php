@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

<div class="p-6">

    {{-- ENCABEZADO --}}
    <div class="flex justify-between items-center mb-6">

        <div>
            <h1 class="text-white font-black text-xl uppercase tracking-widest">
                CATEGORÍAS
            </h1>

            <p
                class="text-xs uppercase tracking-widest mt-1"
                style="color:rgba(255,255,255,0.4);"
            >
                GESTIÓN DE CATEGORÍAS
            </p>
        </div>

        <a
            href="{{ route('categorias.create') }}"
            class="flex items-center gap-2 px-5 py-2 font-black uppercase tracking-widest transition-colors"
            style="
                background-color:#00c896;
                color:#000;
                border-radius:4px;
                font-size:11px;
            "
        >
            + NUEVA CATEGORÍA
        </a>

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div
            class="mb-5 px-4 py-3 font-bold text-sm uppercase tracking-wider"
            style="
                background-color:rgba(0,200,150,0.1);
                border:1px solid rgba(0,200,150,0.3);
                color:#00c896;
                border-radius:4px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))

        <div
            class="mb-5 px-4 py-3 font-bold text-sm uppercase tracking-wider"
            style="
                background-color:rgba(248,113,113,0.1);
                border:1px solid rgba(248,113,113,0.3);
                color:#f87171;
                border-radius:4px;
            "
        >
            {{ session('error') }}
        </div>

    @endif


    {{-- TABLA --}}
    <div
        style="
            background-color:#1a1a1a;
            border:1px solid rgba(255,255,255,0.08);
            border-radius:4px;
            overflow:hidden;
        "
    >

        <div class="overflow-x-auto">

            <table class="w-full">

                {{-- CABECERA --}}
                <thead>

                    <tr
                        style="
                            border-bottom:1px solid rgba(255,255,255,0.08);
                        "
                    >

                        <th
                            class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="
                                color:rgba(255,255,255,0.4);
                                font-size:10px;
                            "
                        >
                            ID
                        </th>

                        <th
                            class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="
                                color:rgba(255,255,255,0.4);
                                font-size:10px;
                            "
                        >
                            Nombre
                        </th>

                        <th
                            class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="
                                color:rgba(255,255,255,0.4);
                                font-size:10px;
                            "
                        >
                            Descripción
                        </th>

                        <th
                            class="px-6 py-4 text-center font-black uppercase tracking-widest"
                            style="
                                color:rgba(255,255,255,0.4);
                                font-size:10px;
                            "
                        >
                            Acciones
                        </th>

                    </tr>

                </thead>


                {{-- CUERPO --}}
                <tbody>

                    @forelse($categorias as $categoria)

                        <tr
                            style="
                                border-bottom:1px solid rgba(255,255,255,0.05);
                            "
                            onmouseenter="this.style.background='rgba(255,255,255,0.03)'"
                            onmouseleave="this.style.background='transparent'"
                        >

                            {{-- ID --}}
                            <td
                                class="px-6 py-4 font-bold"
                                style="
                                    color:rgba(255,255,255,0.35);
                                    font-size:12px;
                                "
                            >
                                #{{ $categoria->id }}
                            </td>


                            {{-- NOMBRE --}}
                            <td
                                class="px-6 py-4 font-bold text-white"
                                style="font-size:13px;"
                            >
                                {{ $categoria->nombre }}
                            </td>


                            {{-- DESCRIPCIÓN --}}
                            <td
                                class="px-6 py-4"
                                style="
                                    color:rgba(255,255,255,0.55);
                                    font-size:12px;
                                "
                            >
                                {{ $categoria->descripcion ?: 'Sin descripción' }}
                            </td>


                            {{-- ACCIONES --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- VER --}}
                                    <a
                                        href="{{ route('categorias.show', $categoria) }}"
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
                                        href="{{ route('categorias.edit', $categoria) }}"
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
                                        action="{{ route('categorias.destroy', $categoria) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar esta categoría?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-red-500/10"
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
                                colspan="4"
                                class="px-6 py-10 text-center font-bold uppercase tracking-widest"
                                style="
                                    color:rgba(255,255,255,0.25);
                                    font-size:11px;
                                "
                            >
                                NO HAY CATEGORÍAS REGISTRADAS.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection