@extends('layouts.app')

@section('title', 'Ver Producto')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
         ENCABEZADO
         ========================================================= --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5 mb-8">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px; letter-spacing:0.15em;"
            >
                DETALLE DEL PRODUCTO
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-2"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                INFORMACIÓN DEL PRODUCTO
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


        <div class="flex flex-wrap items-center gap-3">

            {{-- =========================================================
                 EDITAR
                 Solo usuarios con permiso
                 ========================================================= --}}

            @if(auth()->check() && auth()->user()->tienePermiso('productos.editar'))

                <a
                    href="{{ route('productos.edit', $producto) }}"
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
                    EDITAR
                </a>

            @endif


            {{-- VOLVER --}}

            <a
                href="{{ route('productos.index') }}"
                class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:bg-white/10"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.75);
                    background:#1D1D1D;
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    letter-spacing:0.1em;
                "
            >
                ← VOLVER
            </a>

        </div>

    </div>


    {{-- =============================================================
         INFORMACIÓN DEL PRODUCTO
         Pública
         ============================================================= --}}

    <div
        class="p-6 md:p-8"
        style="
            background:#111111;
            border:1px solid rgba(169,144,69,0.25);
            border-radius:6px;
            box-shadow:0 10px 30px rgba(0,0,0,0.20);
        "
    >

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-8">


            {{-- CATEGORÍA --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-2"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    CATEGORÍA
                </p>

                <p
                    class="font-bold"
                    style="font-size:14px; color:#D8C17F;"
                >
                    {{ $producto->categoria?->nombre ?? 'SIN CATEGORÍA' }}
                </p>

            </div>


            {{-- ESTADO --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-3"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    ESTADO
                </p>

                @if($producto->activo)

                    <span
                        class="inline-flex font-black uppercase tracking-widest px-3 py-1"
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
                        class="inline-flex font-black uppercase tracking-widest px-3 py-1"
                        style="
                            font-size:9px;
                            background:rgba(248,113,113,0.10);
                            color:#f87171;
                            border:1px solid rgba(248,113,113,0.25);
                            border-radius:3px;
                        "
                    >
                        INACTIVO
                    </span>

                @endif

            </div>


            {{-- ID --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-2"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    ID
                </p>

                <p
                    class="font-bold text-white"
                    style="font-size:14px;"
                >
                    {{ $producto->id }}
                </p>

            </div>


            {{-- NOMBRE --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-2"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    NOMBRE
                </p>

                <p
                    class="font-bold text-white"
                    style="font-size:14px;"
                >
                    {{ $producto->nombre }}
                </p>

            </div>


            {{-- PRECIO --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-2"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    PRECIO
                </p>

                <p
                    class="font-bold"
                    style="font-size:14px; color:#D8C17F;"
                >
                    ${{ number_format((float) $producto->precio, 2) }}
                </p>

            </div>


            {{-- STOCK --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-2"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    STOCK
                </p>

                <p
                    class="font-bold text-white"
                    style="font-size:14px;"
                >
                    {{ $producto->stock }} unidades
                </p>

            </div>


            {{-- FECHA --}}

            <div>

                <p
                    class="font-black uppercase tracking-widest mb-2"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                        letter-spacing:0.12em;
                    "
                >
                    CREADO
                </p>

                <p
                    class="font-bold text-white"
                    style="font-size:14px;"
                >
                    {{ $producto->created_at?->format('d/m/Y H:i') ?? 'NO DISPONIBLE' }}
                </p>

            </div>


            {{-- DESCRIPCIÓN --}}

            @if($producto->descripcion)

                <div
                    class="sm:col-span-2 pt-6"
                    style="border-top:1px solid rgba(255,255,255,0.08);"
                >

                    <p
                        class="font-black uppercase tracking-widest mb-3"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.4);
                            letter-spacing:0.12em;
                        "
                    >
                        DESCRIPCIÓN
                    </p>

                    <p
                        class="font-bold text-white"
                        style="
                            font-size:13px;
                            line-height:1.8;
                            white-space:pre-line;
                        "
                    >
                        {{ $producto->descripcion }}
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
