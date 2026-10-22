@extends('layouts.app')

@section('title', 'Productos')

@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px; letter-spacing:0.15em;"
            >
                PRODUCTOS
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-2"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                GESTIÓN DE PRODUCTOS
            </p>

            <div
                class="mt-4"
                style="
                    width:60px;
                    height:3px;
                    background:#A99045;
                    border-radius:2px;
                "
            ></div>

        </div>


        {{-- =========================================================
             CREAR PRODUCTO
             Solo usuarios con permiso
             ========================================================= --}}

        @if(auth()->check() && auth()->user()->tienePermiso('productos.crear'))

            <a
                href="{{ route('productos.create') }}"
                class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:opacity-80"
                style="
                    font-size:10px;
                    color:#111111;
                    background:#A99045;
                    border:1px solid #A99045;
                    border-radius:4px;
                    letter-spacing:0.1em;
                "
            >
                + NUEVO PRODUCTO
            </a>

        @endif

    </div>


    {{-- =============================================================
         MENSAJE DE ÉXITO
         ============================================================= --}}

    @if(session('success'))

        <div
            class="mb-6 px-4 py-3 font-bold"
            style="
                font-size:11px;
                background:rgba(169,144,69,0.10);
                border:1px solid rgba(169,144,69,0.30);
                border-left:3px solid #A99045;
                border-radius:4px;
                color:#D8C17F;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- =============================================================
         TABLA DE PRODUCTOS

         IMPORTANTE:
         Esta tabla es pública.
         No se envuelve en ningún @if de permisos.
         ============================================================= --}}

    <div
        class="overflow-x-auto"
        style="
            background:#111111;
            border:1px solid rgba(169,144,69,0.25);
            border-radius:6px;
            box-shadow:0 10px 30px rgba(0,0,0,0.20);
        "
    >

        <table class="w-full">

            <thead>

                <tr
                    style="
                        background:#1D1D1D;
                        border-bottom:1px solid rgba(169,144,69,0.30);
                    "
                >

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        ID
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        NOMBRE
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        CATEGORÍA
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        PRECIO
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        STOCK
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        ESTADO
                    </th>

                    <th
                        class="px-6 py-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        ACCIONES
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($productos as $producto)

                    <tr
                        style="
                            border-bottom:1px solid rgba(255,255,255,0.06);
                            transition:background 0.2s ease;
                        "
                        onmouseover="this.style.background='#1D1D1D'"
                        onmouseout="this.style.background='transparent'"
                    >

                        {{-- ID --}}

                        <td
                            class="px-6 py-4 font-bold whitespace-nowrap"
                            style="font-size:12px; color:rgba(255,255,255,0.75);"
                        >
                            {{ $producto->id }}
                        </td>


                        {{-- NOMBRE --}}

                        <td
                            class="px-6 py-4 font-bold whitespace-nowrap"
                            style="font-size:12px; color:#FFFFFF;"
                        >
                            {{ $producto->nombre }}
                        </td>


                        {{-- CATEGORÍA --}}

                        <td
                            class="px-6 py-4 font-bold whitespace-nowrap"
                            style="font-size:12px; color:#D8C17F;"
                        >
                            {{ $producto->categoria?->nombre ?? 'SIN CATEGORÍA' }}
                        </td>


                        {{-- PRECIO --}}

                        <td
                            class="px-6 py-4 font-bold whitespace-nowrap"
                            style="font-size:12px; color:#FFFFFF;"
                        >
                            ${{ number_format((float) $producto->precio, 2) }}
                        </td>


                        {{-- STOCK --}}

                        <td
                            class="px-6 py-4 font-bold whitespace-nowrap"
                            style="font-size:12px; color:rgba(255,255,255,0.75);"
                        >
                            {{ $producto->stock }}
                        </td>


                        {{-- ESTADO --}}

                        <td class="px-6 py-4">

                            @if($producto->activo)

                                <span
                                    class="inline-flex font-black uppercase tracking-widest px-3 py-1 whitespace-nowrap"
                                    style="
                                        font-size:9px;
                                        background:rgba(169,144,69,0.15);
                                        color:#D8C17F;
                                        border:1px solid rgba(169,144,69,0.30);
                                        border-radius:3px;
                                    "
                                >
                                    ACTIVO
                                </span>

                            @else

                                <span
                                    class="inline-flex font-black uppercase tracking-widest px-3 py-1 whitespace-nowrap"
                                    style="
                                        font-size:9px;
                                        background:rgba(248,113,113,0.10);
                                        color:#f87171;
                                        border:1px solid rgba(248,113,113,0.20);
                                        border-radius:3px;
                                    "
                                >
                                    INACTIVO
                                </span>

                            @endif

                        </td>


                        {{-- =================================================
                             ACCIONES
                             ================================================= --}}

                        <td class="px-8 py-4">

                            <div class="flex items-center gap-2 whitespace-nowrap">

                                {{-- AGREGAR AL CARRITO --}}

                                @if(auth()->check() && $producto->activo)

                                    <form
                                        method="POST"
                                        action="{{ route('carrito.add', $producto->id) }}"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="cantidad"
                                            value="1"
                                        >

                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:opacity-80"
                                            style="
                                                font-size:9px;
                                                color:#111111;
                                                background:#A99045;
                                                border:1px solid #A99045;
                                                border-radius:4px;
                                                cursor:pointer;
                                            "
                                        >
                                            AGREGAR AL CARRITO
                                        </button>

                                    </form>

                                @endif


                                {{-- =================================================
                                     VER

                                     Público.
                                     NO necesita productos.ver.
                                     ================================================= --}}

                                <a
                                    href="{{ route('productos.show', $producto) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/10"
                                    style="
                                        min-width:60px;
                                        font-size:9px;
                                        color:rgba(255,255,255,0.70);
                                        background:#1D1D1D;
                                        border:1px solid rgba(255,255,255,0.12);
                                        border-radius:4px;
                                    "
                                >
                                    VER
                                </a>


                                {{-- =================================================
                                     EDITAR
                                     ================================================= --}}

                                @if(auth()->check() && auth()->user()->tienePermiso('productos.editar'))

                                    <a
                                        href="{{ route('productos.edit', $producto) }}"
                                        class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:opacity-80"
                                        style="
                                            min-width:60px;
                                            font-size:9px;
                                            color:#D8C17F;
                                            background:rgba(169,144,69,0.06);
                                            border:1px solid rgba(169,144,69,0.30);
                                            border-radius:4px;
                                        "
                                    >
                                        EDITAR
                                    </a>

                                @endif


                                {{-- =================================================
                                     ELIMINAR
                                     ================================================= --}}

                                @if(auth()->check() && auth()->user()->tienePermiso('productos.eliminar'))

                                    <form
                                        action="{{ route('productos.destroy', $producto) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar este producto?')"
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

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="px-6 py-10 text-center font-black uppercase tracking-widest"
                            style="
                                font-size:10px;
                                color:rgba(255,255,255,0.35);
                            "
                        >
                            NO HAY PRODUCTOS REGISTRADOS.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
