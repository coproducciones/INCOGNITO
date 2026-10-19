@extends('layouts.app')

@section('title', 'Pedido #' . $pedido->id_pedido)

@section('content')

@if($modoMiCuenta ?? false)

<div class="w-full max-w-7xl">

    <div class="mb-8">
        <a href="{{ route('mi-cuenta.pedidos') }}"
           class="font-bold uppercase tracking-widest"
           style="font-size:9px;color:rgba(255,255,255,.4);">
            ← MIS PEDIDOS
        </a>

        <h1 class="mt-5 font-black uppercase tracking-widest text-white"
            style="font-size:22px;letter-spacing:.15em;">
            PEDIDO #{{ $pedido->id_pedido }}
        </h1>

        <p class="mt-1 font-bold uppercase tracking-widest"
           style="font-size:10px;color:rgba(255,255,255,.4);">
            DETALLE DE TU PEDIDO
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
             style="font-size:10px;background:rgba(0,200,150,.1);border:1px solid rgba(0,200,150,.3);border-radius:4px;color:#00c896;">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="p-5" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:5px;">
            <span class="font-black uppercase tracking-widest" style="font-size:9px;color:rgba(255,255,255,.35);">FECHA</span>
            <p class="mt-2 font-black text-white" style="font-size:13px;">
                {{ $pedido->fecha_pedido?->format('d/m/Y H:i') ?? 'SIN FECHA' }}
            </p>
        </div>

        <div class="p-5" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:5px;">
            <span class="font-black uppercase tracking-widest" style="font-size:9px;color:rgba(255,255,255,.35);">ESTADO</span>
            <p class="mt-2 font-black uppercase" style="font-size:13px;color:#fbbf24;">
                {{ $pedido->estado?->nombre ?? 'SIN ESTADO' }}
            </p>
        </div>

        <div class="p-5" style="background:rgba(0,200,150,.05);border:1px solid rgba(0,200,150,.15);border-radius:5px;">
            <span class="font-black uppercase tracking-widest" style="font-size:9px;color:rgba(255,255,255,.35);">TOTAL</span>
            <p class="mt-2 font-black" style="font-size:18px;color:#00c896;">
                ${{ number_format((float) $pedido->total, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div class="xl:col-span-2">
            <div class="mb-4">
                <h2 class="font-black uppercase tracking-widest text-white" style="font-size:12px;">
                    PRODUCTOS
                </h2>
            </div>

            <div class="overflow-hidden" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:6px;">
                @forelse($pedido->detalles as $detalle)
                    <div class="flex items-center justify-between gap-4 px-6 py-5"
                         style="border-bottom:1px solid rgba(255,255,255,.06);">
                        <div>
                            <p class="font-black uppercase text-white" style="font-size:11px;">
                                {{ $detalle->producto?->nombre ?? 'PRODUCTO NO DISPONIBLE' }}
                            </p>
                            <p class="mt-1 text-gray-500" style="font-size:10px;">
                                {{ $detalle->cantidad }} × ${{ number_format((float) $detalle->precio_unitario, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="font-black" style="font-size:12px;color:#00c896;">
                                ${{ number_format((float) $detalle->subtotal, 0, ',', '.') }}
                            </p>

                            @if(($modoMiCuenta ?? false) && ($pedido->estado?->nombre === 'Pendiente'))
                                <form method="POST"
                                      action="{{ route('mi-cuenta.pedidos.detalles.update', [$pedido->id_pedido, $detalle->id_detalle]) }}"
                                      class="mt-3 flex items-center justify-end gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="cantidad" min="1"
                                           value="{{ $detalle->cantidad }}"
                                           aria-label="Cantidad de {{ $detalle->producto?->nombre }}"
                                           class="w-16 rounded border border-white/10 bg-black px-2 py-1 text-center text-white">
                                    <button type="submit" class="text-xs font-bold text-[#00c896]">Guardar</button>
                                </form>
                                <form method="POST"
                                      action="{{ route('mi-cuenta.pedidos.detalles.destroy', [$pedido->id_pedido, $detalle->id_detalle]) }}"
                                      class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Eliminar este producto del pedido?')"
                                            class="text-xs text-red-300 hover:text-red-200">Eliminar producto</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center font-bold uppercase tracking-widest"
                         style="font-size:10px;color:rgba(255,255,255,.3);">
                        ESTE PEDIDO NO TIENE PRODUCTOS
                    </div>
                @endforelse
            </div>
        </div>

        <div>
            <h2 class="mb-4 font-black uppercase tracking-widest text-white" style="font-size:12px;">
                HISTORIAL
            </h2>

            <div class="overflow-hidden" style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:6px;">
                @forelse($pedido->eventos as $evento)
                    <div class="px-5 py-5" style="border-bottom:1px solid rgba(255,255,255,.06);">
                        <p class="font-black uppercase" style="font-size:10px;color:#00c896;">
                            {{ $evento->tipo_evento }}
                        </p>
                        <p class="mt-1 font-bold text-white" style="font-size:11px;">
                            {{ $evento->estado?->nombre ?? 'SIN ESTADO' }}
                        </p>
                        @if($evento->comentario)
                            <p class="mt-2 text-gray-400" style="font-size:10px;">
                                {{ $evento->comentario }}
                            </p>
                        @endif
                        <p class="mt-2 text-gray-600" style="font-size:9px;">
                            {{ $evento->fecha?->format('d/m/Y H:i') }}
                        </p>
                    </div>
                @empty
                    <div class="px-5 py-10 text-center font-bold uppercase tracking-widest"
                         style="font-size:9px;color:rgba(255,255,255,.3);">
                        SIN EVENTOS
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@else

<div class="w-full max-w-7xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

        <div>

            <a
                href="{{ route('pedidos.index') }}"
                class="font-bold uppercase tracking-widest transition-opacity hover:opacity-70"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.4);
                "
            >
                ← VOLVER A PEDIDOS
            </a>

            <h1
                class="mt-5 font-black uppercase tracking-widest text-white"
                style="
                    font-size:22px;
                    letter-spacing:0.15em;
                "
            >
                PEDIDO #{{ $pedido->id_pedido }}
            </h1>

            <p
                class="mt-1 font-bold uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.4);
                "
            >
                DETALLE Y SEGUIMIENTO DEL PEDIDO
            </p>

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
    {{-- ERRORES --}}
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

            @foreach($errors->all() as $error)

                <p
                    class="font-bold"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $error }}
                </p>

            @endforeach

        </div>

    @endif
{{-- ========================================================= --}}
{{-- NOTIFICAR PROVEEDORES POR WHATSAPP --}}
{{-- ========================================================= --}}

@if(auth()->check() && auth()->user()->tienePermiso('pedidos.ver'))

    @php
        /*
         * Obtenemos los proveedores de los productos del pedido.
         * Si un proveedor tiene varios productos, solo aparecerá una vez.
         */
        $proveedoresPedido = $pedido->detalles
            ->map(fn ($detalle) => $detalle->producto?->proveedor)
            ->filter()
            ->unique('id_proveedor')
            ->values();
    @endphp

    <div
        class="mb-8 p-6"
        style="
            background:rgba(37,211,102,0.04);
            border:1px solid rgba(37,211,102,0.2);
            border-radius:6px;
        "
    >

        <h2
            class="font-black uppercase tracking-widest text-white"
            style="font-size:12px;letter-spacing:0.12em;"
        >
            NOTIFICAR PROVEEDORES
        </h2>

        <p
            class="mt-2 mb-5"
            style="
                font-size:10px;
                line-height:1.7;
                color:rgba(255,255,255,0.5);
            "
        >
            Prepara un mensaje de WhatsApp con los productos
            correspondientes a cada proveedor.
            Podrás revisar el mensaje antes de enviarlo.
        </p>

        @forelse($proveedoresPedido as $proveedor)

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 py-4"
                style="border-top:1px solid rgba(255,255,255,0.08);"
            >

                <div>
                    <p
                        class="font-black uppercase text-white"
                        style="font-size:11px;"
                    >
                        {{ $proveedor->nombre ?? 'PROVEEDOR #' . $proveedor->id_proveedor }}
                    </p>

                    <p
                        class="mt-1"
                        style="font-size:10px;color:rgba(255,255,255,0.45);"
                    >
                        Productos asignados a este proveedor en el pedido.
                    </p>
                </div>

                <a
                    href="{{ route('pedidos.whatsapp.proveedor', [
                        'pedido' => $pedido->id_pedido,
                        'proveedor' => $proveedor->id_proveedor,
                    ]) }}"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 font-black uppercase tracking-widest transition-opacity hover:opacity-80"
                    style="
                        background:#25D366;
                        color:#111;
                        border-radius:4px;
                        font-size:9px;
                        text-decoration:none;
                    "
                >
                    <span>WHATSAPP</span>
                    <span aria-hidden="true">↗</span>
                </a>

            </div>

        @empty

            <p
                class="py-4 font-bold"
                style="font-size:10px;color:rgba(255,255,255,0.4);"
            >
                No hay proveedores asignados a los productos de este pedido.
                Revisa la asignación de proveedores en los productos.
            </p>

        @endforelse

    </div>

@endif

    {{-- ========================================================= --}}
    {{-- RESUMEN --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        {{-- PEDIDO --}}

        <div
            class="px-5 py-5"
            style="
                background:rgba(255,255,255,0.03);
                border:1px solid rgba(255,255,255,0.08);
                border-radius:5px;
            "
        >

            <span
                class="font-black uppercase tracking-widest"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.35);
                "
            >
                PEDIDO
            </span>

            <p
                class="mt-2 font-black text-white"
                style="font-size:18px;"
            >
                #{{ $pedido->id_pedido }}
            </p>

        </div>


        {{-- USUARIO --}}

        <div
            class="px-5 py-5"
            style="
                background:rgba(255,255,255,0.03);
                border:1px solid rgba(255,255,255,0.08);
                border-radius:5px;
            "
        >

            <span
                class="font-black uppercase tracking-widest"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.35);
                "
            >
                USUARIO
            </span>

            <p
                class="mt-2 font-black text-white"
                style="font-size:13px;"
            >
                {{ $pedido->usuario?->nombre ?? 'SIN USUARIO' }}
            </p>

        </div>


        {{-- ESTADO --}}

        <div
            class="px-5 py-5"
            style="
                background:rgba(255,255,255,0.03);
                border:1px solid rgba(255,255,255,0.08);
                border-radius:5px;
            "
        >

            <span
                class="font-black uppercase tracking-widest"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.35);
                "
            >
                ESTADO
            </span>

            <p
                class="mt-2 font-black uppercase"
                style="
                    font-size:13px;
                    color:#fbbf24;
                "
            >
                {{ $pedido->estado?->nombre ?? 'SIN ESTADO' }}
            </p>

        </div>


        {{-- TOTAL --}}

        <div
            class="px-5 py-5"
            style="
                background:rgba(0,200,150,0.05);
                border:1px solid rgba(0,200,150,0.15);
                border-radius:5px;
            "
        >

            <span
                class="font-black uppercase tracking-widest"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.35);
                "
            >
                TOTAL
            </span>

            <p
                class="mt-2 font-black"
                style="
                    font-size:18px;
                    color:#00c896;
                "
            >
                ${{ number_format((float) $pedido->total, 0, ',', '.') }}
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CONTENIDO PRINCIPAL --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


        {{-- ===================================================== --}}
        {{-- PRODUCTOS --}}
        {{-- ===================================================== --}}

        <div class="xl:col-span-2">


            {{-- ================================================= --}}
            {{-- AGREGAR PRODUCTO --}}
            {{-- ================================================= --}}

            @if(auth()->check() && auth()->user()->tienePermiso('pedidos.editar'))

                <div
                    class="mb-6 p-6"
                    style="
                        background:rgba(0,200,150,0.04);
                        border:1px solid rgba(0,200,150,0.15);
                        border-radius:6px;
                    "
                >

                    <h2
                        class="font-black uppercase tracking-widest text-white"
                        style="
                            font-size:12px;
                            letter-spacing:0.12em;
                        "
                    >
                        AGREGAR PRODUCTO
                    </h2>

                    <p
                        class="mt-2 mb-6"
                        style="
                            font-size:10px;
                            line-height:1.6;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        Selecciona un producto para consultar su información y agregarlo al pedido.
                    </p>


                    <form
                        action="{{ route('pedidos.detalles.store', ['pedido' => $pedido->id_pedido]) }}"
                        method="POST"
                        id="formAgregarProducto"
                    >

                        @csrf


                        {{-- PRODUCTO --}}

                        <div class="mb-5">

                            <label
                                for="id_producto"
                                class="mb-2 block font-black uppercase tracking-widest"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.5);
                                "
                            >
                                PRODUCTO
                            </label>

                            <select
                                name="id_producto"
                                id="id_producto"
                                required
                                class="w-full px-4 py-3 text-white outline-none"
                                style="
                                    background:rgba(255,255,255,0.04);
                                    border:1px solid rgba(255,255,255,0.1);
                                    border-radius:4px;
                                    font-size:11px;
                                "
                            >

                                <option
                                    value=""
                                    style="background:#111;"
                                >
                                    SELECCIONAR PRODUCTO
                                </option>

                                @foreach($productos as $producto)

                                    <option
                                        value="{{ $producto->id }}"
                                        data-nombre="{{ $producto->nombre }}"
                                        data-categoria="{{ $producto->categoria?->nombre ?? 'SIN CATEGORÍA' }}"
                                        data-descripcion="{{ $producto->descripcion ?? 'SIN DESCRIPCIÓN' }}"
                                        data-precio="{{ $producto->precio }}"
                                        data-stock="{{ $producto->stock }}"
                                        style="background:#111;"
                                    >
                                        {{ strtoupper($producto->nombre) }}
                                        —
                                        ${{ number_format((float) $producto->precio, 0, ',', '.') }}
                                    </option>

                                @endforeach

                            </select>

                            @error('id_producto')

                                <p
                                    class="mt-2 font-bold"
                                    style="
                                        font-size:9px;
                                        color:#f87171;
                                    "
                                >
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- INFORMACIÓN DEL PRODUCTO --}}

                        <div
                            id="productoInfo"
                            class="hidden mb-5 p-5"
                            style="
                                background:rgba(255,255,255,0.03);
                                border:1px solid rgba(255,255,255,0.08);
                                border-radius:4px;
                            "
                        >

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <div>

                                    <span
                                        class="font-black uppercase tracking-widest"
                                        style="
                                            font-size:8px;
                                            color:rgba(255,255,255,0.35);
                                        "
                                    >
                                        PRODUCTO
                                    </span>

                                    <p
                                        id="productoNombre"
                                        class="mt-1 font-black text-white"
                                        style="font-size:12px;"
                                    ></p>

                                </div>


                                <div>

                                    <span
                                        class="font-black uppercase tracking-widest"
                                        style="
                                            font-size:8px;
                                            color:rgba(255,255,255,0.35);
                                        "
                                    >
                                        CATEGORÍA
                                    </span>

                                    <p
                                        id="productoCategoria"
                                        class="mt-1 font-black"
                                        style="
                                            font-size:12px;
                                            color:#00c896;
                                        "
                                    ></p>

                                </div>


                                <div>

                                    <span
                                        class="font-black uppercase tracking-widest"
                                        style="
                                            font-size:8px;
                                            color:rgba(255,255,255,0.35);
                                        "
                                    >
                                        PRECIO
                                    </span>

                                    <p
                                        id="productoPrecio"
                                        class="mt-1 font-black text-white"
                                        style="font-size:12px;"
                                    ></p>

                                </div>


                                <div>

                                    <span
                                        class="font-black uppercase tracking-widest"
                                        style="
                                            font-size:8px;
                                            color:rgba(255,255,255,0.35);
                                        "
                                    >
                                        STOCK DISPONIBLE
                                    </span>

                                    <p
                                        id="productoStock"
                                        class="mt-1 font-black text-white"
                                        style="font-size:12px;"
                                    ></p>

                                </div>


                                <div class="md:col-span-2">

                                    <span
                                        class="font-black uppercase tracking-widest"
                                        style="
                                            font-size:8px;
                                            color:rgba(255,255,255,0.35);
                                        "
                                    >
                                        DESCRIPCIÓN
                                    </span>

                                    <p
                                        id="productoDescripcion"
                                        class="mt-1"
                                        style="
                                            font-size:10px;
                                            line-height:1.6;
                                            color:rgba(255,255,255,0.55);
                                        "
                                    ></p>

                                </div>

                            </div>

                        </div>


                        {{-- CANTIDAD --}}

                        <div class="mb-5">

                            <label
                                for="cantidad"
                                class="mb-2 block font-black uppercase tracking-widest"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.5);
                                "
                            >
                                CANTIDAD
                            </label>

                            <input
                                type="number"
                                name="cantidad"
                                id="cantidad"
                                min="1"
                                value="{{ old('cantidad', 1) }}"
                                required
                                class="w-full px-4 py-3 text-white outline-none"
                                style="
                                    background:rgba(255,255,255,0.04);
                                    border:1px solid rgba(255,255,255,0.1);
                                    border-radius:4px;
                                    font-size:11px;
                                "
                            >

                            @error('cantidad')

                                <p
                                    class="mt-2 font-bold"
                                    style="
                                        font-size:9px;
                                        color:#f87171;
                                    "
                                >
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- SUBTOTAL PREVISUALIZADO --}}

                        <div
                            class="flex items-center justify-between mb-5 px-4 py-4"
                            style="
                                background:rgba(0,200,150,0.05);
                                border:1px solid rgba(0,200,150,0.12);
                                border-radius:4px;
                            "
                        >

                            <span
                                class="font-black uppercase tracking-widest"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.4);
                                "
                            >
                                SUBTOTAL
                            </span>

                            <span
                                id="productoSubtotal"
                                class="font-black"
                                style="
                                    font-size:15px;
                                    color:#00c896;
                                "
                            >
                                $0
                            </span>

                        </div>


                        <button
                            type="submit"
                            class="font-black uppercase tracking-widest px-5 py-3 text-black transition-all hover:opacity-80"
                            style="
                                font-size:10px;
                                background:#00c896;
                                border-radius:4px;
                            "
                        >
                            + AGREGAR PRODUCTO
                        </button>

                    </form>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- PRODUCTOS DEL PEDIDO --}}
            {{-- ================================================= --}}

            <div
                style="
                    background:rgba(255,255,255,0.03);
                    border:1px solid rgba(255,255,255,0.08);
                    border-radius:6px;
                "
            >

                <div
                    class="px-6 py-5"
                    style="
                        border-bottom:1px solid rgba(255,255,255,0.08);
                    "
                >

                    <h2
                        class="font-black uppercase tracking-widest text-white"
                        style="
                            font-size:12px;
                            letter-spacing:0.12em;
                        "
                    >
                        PRODUCTOS DEL PEDIDO
                    </h2>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead>

                            <tr
                                style="
                                    border-bottom:1px solid rgba(255,255,255,0.08);
                                "
                            >

                                <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="font-size:9px;color:rgba(255,255,255,0.4);">
                                    PRODUCTO
                                </th>

                                <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="font-size:9px;color:rgba(255,255,255,0.4);">
                                    CATEGORÍA
                                </th>

                                <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="font-size:9px;color:rgba(255,255,255,0.4);">
                                    CANTIDAD
                                </th>

                                <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="font-size:9px;color:rgba(255,255,255,0.4);">
                                    PRECIO
                                </th>

                                <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="font-size:9px;color:rgba(255,255,255,0.4);">
                                    SUBTOTAL
                                </th>

                                <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="font-size:9px;color:rgba(255,255,255,0.4);">
                                    ACCIÓN
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($pedido->detalles as $detalle)

                                <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">

                                    <td class="px-6 py-4">

                                        <p
                                            class="font-bold text-white"
                                            style="font-size:12px;"
                                        >
                                            {{ $detalle->producto?->nombre ?? 'PRODUCTO ELIMINADO' }}
                                        </p>

                                        @if($detalle->producto?->descripcion)

                                            <p
                                                class="mt-1"
                                                style="
                                                    font-size:9px;
                                                    color:rgba(255,255,255,0.4);
                                                "
                                            >
                                                {{ $detalle->producto->descripcion }}
                                            </p>

                                        @endif

                                    </td>


                                    <td class="px-6 py-4">

                                        <span
                                            class="font-bold uppercase"
                                            style="
                                                font-size:9px;
                                                color:#00c896;
                                            "
                                        >
                                            {{ $detalle->producto?->categoria?->nombre ?? 'SIN CATEGORÍA' }}
                                        </span>

                                    </td>


                                    <td
                                        class="px-6 py-4 font-bold text-white"
                                        style="font-size:12px;"
                                    >
                                        {{ $detalle->cantidad }}
                                    </td>


                                    <td
                                        class="px-6 py-4 font-bold"
                                        style="
                                            font-size:12px;
                                            color:rgba(255,255,255,0.6);
                                        "
                                    >
                                        ${{ number_format((float) $detalle->precio_unitario, 0, ',', '.') }}
                                    </td>


                                    <td
                                        class="px-6 py-4 font-black"
                                        style="
                                            font-size:12px;
                                            color:#00c896;
                                        "
                                    >
                                        ${{ number_format((float) $detalle->subtotal, 0, ',', '.') }}
                                    </td>


                                    <td class="px-6 py-4">

                                        @if(auth()->check() && auth()->user()->tienePermiso('pedidos.editar'))

                                            <form
                                                action="{{ route('pedidos.detalles.destroy', [
                                                    'pedido' => $pedido->id_pedido,
                                                    'detalle' => $detalle->id_detalle,
                                                ]) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    onclick="return confirm('¿Borrar este producto del pedido?')"
                                                    class="font-black uppercase tracking-widest transition-opacity hover:opacity-70"
                                                    style="
                                                        font-size:9px;
                                                        color:#f87171;
                                                    "
                                                >
                                                    BORRAR
                                                </button>

                                            </form>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6 py-10 text-center font-bold uppercase tracking-widest"
                                        style="
                                            font-size:10px;
                                            color:rgba(255,255,255,0.3);
                                        "
                                    >
                                        ESTE PEDIDO AÚN NO TIENE PRODUCTOS
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- TOTAL --}}

                <div
                    class="flex justify-end px-6 py-5"
                    style="
                        border-top:1px solid rgba(255,255,255,0.08);
                    "
                >

                    <div class="text-right">

                        <span
                            class="font-black uppercase tracking-widest"
                            style="
                                font-size:9px;
                                color:rgba(255,255,255,0.35);
                            "
                        >
                            TOTAL
                        </span>

                        <p
                            class="mt-1 font-black"
                            style="
                                font-size:20px;
                                color:#00c896;
                            "
                        >
                            ${{ number_format((float) $pedido->total, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- CAMBIAR ESTADO --}}
        {{-- ===================================================== --}}

        @if(auth()->check() && auth()->user()->tienePermiso('pedidos.editar'))

            <div>

                <div
                    class="p-6"
                    style="
                        background:rgba(255,255,255,0.03);
                        border:1px solid rgba(255,255,255,0.08);
                        border-radius:6px;
                    "
                >

                    <h2
                        class="font-black uppercase tracking-widest text-white"
                        style="
                            font-size:12px;
                            letter-spacing:0.12em;
                        "
                    >
                        ACTUALIZAR ESTADO
                    </h2>

                    <p
                        class="mt-2 mb-6"
                        style="
                            font-size:10px;
                            line-height:1.6;
                            color:rgba(255,255,255,0.4);
                        "
                    >
                        Cambia el estado del pedido y registra
                        un evento en su historial.
                    </p>


                    <form
                        action="{{ route('pedidos.estado.update', ['pedido' => $pedido->id_pedido]) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PATCH')


                        <div class="mb-5">

                            <label
                                for="id_estado"
                                class="mb-2 block font-black uppercase tracking-widest"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.5);
                                "
                            >
                                NUEVO ESTADO
                            </label>

                            <select
                                name="id_estado"
                                id="id_estado"
                                required
                                class="w-full px-4 py-3 text-white outline-none"
                                style="
                                    background:rgba(255,255,255,0.04);
                                    border:1px solid rgba(255,255,255,0.1);
                                    border-radius:4px;
                                    font-size:11px;
                                "
                            >

                                <option
                                    value=""
                                    style="background:#111;"
                                >
                                    SELECCIONAR ESTADO
                                </option>

                                @foreach($estados as $estado)

                                    <option
                                        value="{{ $estado->id_estado }}"
                                        style="background:#111;"
                                        {{ $pedido->id_estado == $estado->id_estado ? 'selected' : '' }}
                                    >
                                        {{ strtoupper($estado->nombre) }}
                                    </option>

                                @endforeach

                            </select>

                            @error('id_estado')

                                <p
                                    class="mt-2 font-bold"
                                    style="
                                        font-size:9px;
                                        color:#f87171;
                                    "
                                >
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        <div class="mb-5">

                            <label
                                for="comentario"
                                class="mb-2 block font-black uppercase tracking-widest"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.5);
                                "
                            >
                                COMENTARIO
                            </label>

                            <textarea
                                name="comentario"
                                id="comentario"
                                rows="4"
                                class="w-full px-4 py-3 text-white outline-none resize-none"
                                style="
                                    background:rgba(255,255,255,0.04);
                                    border:1px solid rgba(255,255,255,0.1);
                                    border-radius:4px;
                                    font-size:11px;
                                "
                                placeholder="COMENTARIO DEL CAMBIO..."
                            >{{ old('comentario') }}</textarea>

                        </div>


                        <button
                            type="submit"
                            class="w-full font-black uppercase tracking-widest px-5 py-3 text-black transition-all hover:opacity-80"
                            style="
                                font-size:10px;
                                background:#00c896;
                                border-radius:4px;
                            "
                        >
                            ACTUALIZAR ESTADO
                        </button>

                    </form>

                </div>

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- HISTORIAL --}}
    {{-- ========================================================= --}}

    <div class="mt-6">

        <div
            class="p-6"
            style="
                background:rgba(255,255,255,0.03);
                border:1px solid rgba(255,255,255,0.08);
                border-radius:6px;
            "
        >

            <h2
                class="font-black uppercase tracking-widest text-white mb-6"
                style="
                    font-size:12px;
                    letter-spacing:0.12em;
                "
            >
                HISTORIAL DEL PEDIDO
            </h2>


            <div class="space-y-5">

                @forelse($pedido->eventos as $evento)

                    <div class="flex gap-4">

                        {{-- PUNTO --}}

                        <div
                            class="flex-shrink-0 flex items-center justify-center"
                            style="
                                width:32px;
                                height:32px;
                                background:rgba(0,200,150,0.1);
                                border:1px solid rgba(0,200,150,0.2);
                                border-radius:50%;
                            "
                        >

                            <span
                                style="
                                    display:block;
                                    width:6px;
                                    height:6px;
                                    background:#00c896;
                                    border-radius:50%;
                                "
                            ></span>

                        </div>


                        {{-- INFORMACIÓN --}}

                        <div>

                            <div class="flex flex-wrap items-center gap-2">

                                <span
                                    class="font-black uppercase"
                                    style="
                                        font-size:10px;
                                        color:#00c896;
                                    "
                                >
                                    {{ $evento->tipo_evento }}
                                </span>

                                @if($evento->estado)

                                    <span
                                        class="font-bold uppercase"
                                        style="
                                            font-size:9px;
                                            color:rgba(255,255,255,0.4);
                                        "
                                    >
                                        — {{ $evento->estado->nombre }}
                                    </span>

                                @endif

                            </div>


                            @if($evento->comentario)

                                <p
                                    class="mt-1"
                                    style="
                                        font-size:11px;
                                        color:rgba(255,255,255,0.55);
                                    "
                                >
                                    {{ $evento->comentario }}
                                </p>

                            @endif


                            <p
                                class="mt-1 font-bold"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.3);
                                "
                            >
                                {{ $evento->fecha?->format('d/m/Y H:i') }}
                            </p>

                        </div>

                    </div>

                @empty

                    <p
                        class="text-center font-bold uppercase tracking-widest"
                        style="
                            font-size:10px;
                            color:rgba(255,255,255,0.3);
                        "
                    >
                        NO HAY EVENTOS REGISTRADOS
                    </p>

                @endforelse

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMACIÓN FINAL --}}
    {{-- ========================================================= --}}

    <div
        class="mt-6 flex flex-wrap items-center justify-between gap-4 pt-5"
        style="
            border-top:1px solid rgba(255,255,255,0.08);
        "
    >

        <div>

            <span
                class="font-black uppercase tracking-widest"
                style="
                    font-size:9px;
                    color:rgba(255,255,255,0.3);
                "
            >
                FECHA DEL PEDIDO
            </span>

            <p
                class="mt-1 font-bold text-white"
                style="font-size:11px;"
            >
                {{ $pedido->fecha_pedido?->format('d/m/Y H:i:s') }}
            </p>

        </div>


        <a
            href="{{ route('pedidos.index') }}"
            class="font-black uppercase tracking-widest px-5 py-3 transition-opacity hover:opacity-70"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.5);
                border:1px solid rgba(255,255,255,0.1);
                border-radius:4px;
            "
        >
            VOLVER A PEDIDOS
        </a>

    </div>

</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const productoSelect =
        document.getElementById('id_producto');

    const cantidadInput =
        document.getElementById('cantidad');

    const productoInfo =
        document.getElementById('productoInfo');

    const productoNombre =
        document.getElementById('productoNombre');

    const productoCategoria =
        document.getElementById('productoCategoria');

    const productoDescripcion =
        document.getElementById('productoDescripcion');

    const productoPrecio =
        document.getElementById('productoPrecio');

    const productoStock =
        document.getElementById('productoStock');

    const productoSubtotal =
        document.getElementById('productoSubtotal');


    /*
     * La sección de agregar producto solo existe
     * cuando el usuario tiene pedidos.editar.
     *
     * Evitamos ejecutar JavaScript sobre elementos
     * que no existen.
     */

    if (!productoSelect || !cantidadInput) {
        return;
    }


    function formatoPrecio(valor)
    {
        return new Intl.NumberFormat(
            'es-CO',
            {
                maximumFractionDigits: 0
            }
        ).format(valor);
    }


    function actualizarProducto()
    {
        const option =
            productoSelect.options[
                productoSelect.selectedIndex
            ];


        if (!productoSelect.value) {

            productoInfo.classList.add('hidden');

            productoNombre.textContent = '';
            productoCategoria.textContent = '';
            productoDescripcion.textContent = '';
            productoPrecio.textContent = '';
            productoStock.textContent = '';
            productoSubtotal.textContent = '$0';

            return;
        }


        const nombre =
            option.dataset.nombre || '';

        const categoria =
            option.dataset.categoria || '';

        const descripcion =
            option.dataset.descripcion || '';

        const precio =
            parseFloat(option.dataset.precio) || 0;

        const stock =
            parseInt(option.dataset.stock) || 0;

        const cantidad =
            parseInt(cantidadInput.value) || 1;


        productoNombre.textContent =
            nombre;

        productoCategoria.textContent =
            categoria;

        productoDescripcion.textContent =
            descripcion;

        productoPrecio.textContent =
            '$' + formatoPrecio(precio);

        productoStock.textContent =
            stock;


        cantidadInput.max = stock;


        productoSubtotal.textContent =
            '$' +
            formatoPrecio(
                precio * cantidad
            );


        productoInfo.classList.remove(
            'hidden'
        );
    }


    productoSelect.addEventListener(
        'change',
        actualizarProducto
    );


    cantidadInput.addEventListener(
        'input',
        actualizarProducto
    );

});

</script>

@endif

@endsection
