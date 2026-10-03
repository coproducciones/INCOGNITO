@extends('layouts.app')

@section('title', 'Nuevo Pedido')

@section('content')

<div class="max-w-5xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

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
            NUEVO PEDIDO
        </h1>

        <p
            class="mt-1 font-bold uppercase tracking-widest"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.4);
            "
        >
            CREAR UN NUEVO PEDIDO
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- MENSAJES DE ERROR --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div
            class="mb-6 px-5 py-4"
            style="
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-radius:5px;
            "
        >

            <p
                class="font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:#f87171;
                "
            >
                NO SE PUDO CREAR EL PEDIDO
            </p>

            <ul class="mt-2 space-y-1">

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
    {{-- INFORMACIÓN --}}
    {{-- ========================================================= --}}

    <div
        class="mb-6 px-5 py-4"
        style="
            background:rgba(0,200,150,0.05);
            border:1px solid rgba(0,200,150,0.15);
            border-radius:5px;
        "
    >

        <p
            class="font-black uppercase tracking-widest"
            style="
                font-size:10px;
                color:#00c896;
            "
        >
            INFORMACIÓN DEL PEDIDO
        </p>

        <p
            class="mt-2"
            style="
                font-size:11px;
                color:rgba(255,255,255,0.5);
                line-height:1.7;
            "
        >
            El pedido será creado automáticamente con estado
            <strong style="color:#fbbf24;">
                PENDIENTE
            </strong>.
            Puedes seleccionar los productos y cantidades antes de guardar.
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- FORMULARIO PRINCIPAL --}}
    {{-- ========================================================= --}}

    <form
        action="{{ route('pedidos.store') }}"
        method="POST"
        class="space-y-6"
        id="pedidoForm"
    >

        @csrf


        {{-- ===================================================== --}}
        {{-- USUARIO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="id_usuario"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                USUARIO
            </label>

            <select
                name="id_usuario"
                id="id_usuario"
                required
                class="w-full px-4 py-3 text-white outline-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
            >

                <option
                    value=""
                    style="background:#111;"
                >
                    SELECCIONAR USUARIO
                </option>

                @forelse($usuarios as $usuario)

                    <option
                        value="{{ $usuario->id }}"
                        style="background:#111;"
                        {{ old('id_usuario') == $usuario->id ? 'selected' : '' }}
                    >
                        {{ $usuario->nombre }}
                        — {{ $usuario->email }}
                    </option>

                @empty

                    <option
                        value=""
                        disabled
                        style="background:#111;"
                    >
                        NO HAY USUARIOS DISPONIBLES
                    </option>

                @endforelse

            </select>

            @error('id_usuario')

                <p
                    class="mt-2 font-bold uppercase"
                    style="
                        font-size:9px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- INFORMACIÓN AUTOMÁTICA --}}
        {{-- ===================================================== --}}

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">


            {{-- ESTADO --}}

            <div
                class="px-4 py-4"
                style="
                    background:rgba(255,255,255,0.03);
                    border:1px solid rgba(255,255,255,0.08);
                    border-radius:4px;
                "
            >

                <span
                    class="font-black uppercase tracking-widest"
                    style="
                        font-size:9px;
                        color:rgba(255,255,255,0.35);
                    "
                >
                    ESTADO INICIAL
                </span>

                <p
                    class="mt-2 font-black uppercase"
                    style="
                        font-size:12px;
                        color:#fbbf24;
                    "
                >
                    PENDIENTE
                </p>

            </div>


            {{-- TOTAL --}}

            <div
                class="px-4 py-4"
                style="
                    background:rgba(255,255,255,0.03);
                    border:1px solid rgba(255,255,255,0.08);
                    border-radius:4px;
                "
            >

                <span
                    class="font-black uppercase tracking-widest"
                    style="
                        font-size:9px;
                        color:rgba(255,255,255,0.35);
                    "
                >
                    TOTAL DEL PEDIDO
                </span>

                <p
                    id="totalPedido"
                    class="mt-2 font-black"
                    style="
                        font-size:12px;
                        color:#00c896;
                    "
                >
                    $0.00
                </p>

            </div>


            {{-- FECHA --}}

            <div
                class="px-4 py-4"
                style="
                    background:rgba(255,255,255,0.03);
                    border:1px solid rgba(255,255,255,0.08);
                    border-radius:4px;
                "
            >

                <span
                    class="font-black uppercase tracking-widest"
                    style="
                        font-size:9px;
                        color:rgba(255,255,255,0.35);
                    "
                >
                    FECHA
                </span>

                <p
                    class="mt-2 font-black uppercase text-white"
                    style="font-size:12px;"
                >
                    AUTOMÁTICA
                </p>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- PRODUCTOS --}}
        {{-- ===================================================== --}}

        <div
            class="px-5 py-5"
            style="
                background:rgba(255,255,255,0.03);
                border:1px solid rgba(255,255,255,0.08);
                border-radius:5px;
            "
        >

            {{-- ENCABEZADO --}}

            <div class="mb-5">

                <p
                    class="font-black uppercase tracking-widest"
                    style="
                        font-size:11px;
                        color:#00c896;
                    "
                >
                    PRODUCTOS DEL PEDIDO
                </p>

                <p
                    class="mt-1"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.4);
                    "
                >
                    Selecciona los productos y la cantidad que deseas agregar.
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- PRODUCTOS DINÁMICOS --}}
            {{-- ================================================= --}}

            <div
                id="productosContainer"
                class="space-y-4"
            >

                {{-- PRIMER PRODUCTO --}}

                <div
                    class="producto-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end"
                >

                    {{-- PRODUCTO --}}

                    <div class="md:col-span-6">

                        <label
                            class="mb-2 block font-black uppercase tracking-widest"
                            style="
                                font-size:9px;
                                color:rgba(255,255,255,0.4);
                            "
                        >
                            PRODUCTO
                        </label>

                        <select
                            name="productos[0][id_producto]"
                            class="producto-select w-full px-4 py-3 text-white outline-none"
                            required
                            style="
                                background:#111;
                                border:1px solid rgba(255,255,255,0.1);
                                border-radius:4px;
                                font-size:11px;
                            "
                        >

                            <option
                                value=""
                                data-precio="0"
                                style="background:#111;"
                            >
                                SELECCIONAR PRODUCTO
                            </option>

                            @foreach($productos as $producto)

                                <option
                                    value="{{ $producto->id }}"
                                    data-precio="{{ $producto->precio }}"
                                    data-stock="{{ $producto->stock }}"
                                    style="background:#111;"
                                    {{ old('productos.0.id_producto') == $producto->id ? 'selected' : '' }}
                                >
                                    {{ $producto->nombre }}
                                    —
                                    {{ $producto->categoria?->nombre ?? 'SIN CATEGORÍA' }}
                                    —
                                    ${{ number_format((float) $producto->precio, 2) }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- CANTIDAD --}}

                    <div class="md:col-span-3">

                        <label
                            class="mb-2 block font-black uppercase tracking-widest"
                            style="
                                font-size:9px;
                                color:rgba(255,255,255,0.4);
                            "
                        >
                            CANTIDAD
                        </label>

                        <input
                            type="number"
                            name="productos[0][cantidad]"
                            value="{{ old('productos.0.cantidad', 1) }}"
                            min="1"
                            class="cantidad-input w-full px-4 py-3 text-white outline-none"
                            required
                            style="
                                background:rgba(255,255,255,0.04);
                                border:1px solid rgba(255,255,255,0.1);
                                border-radius:4px;
                                font-size:11px;
                            "
                        >

                    </div>


                    {{-- SUBTOTAL --}}

                    <div class="md:col-span-2">

                        <label
                            class="mb-2 block font-black uppercase tracking-widest"
                            style="
                                font-size:9px;
                                color:rgba(255,255,255,0.4);
                            "
                        >
                            SUBTOTAL
                        </label>

                        <div
                            class="subtotal-producto px-4 py-3 font-black"
                            style="
                                background:rgba(0,200,150,0.05);
                                border:1px solid rgba(0,200,150,0.15);
                                border-radius:4px;
                                font-size:11px;
                                color:#00c896;
                            "
                        >
                            $0.00
                        </div>

                    </div>


                    {{-- ELIMINAR --}}

                    <div class="md:col-span-1">

                        <button
                            type="button"
                            class="remove-producto w-full px-3 py-3 font-black transition-opacity hover:opacity-70"
                            style="
                                background:rgba(248,113,113,0.08);
                                border:1px solid rgba(248,113,113,0.2);
                                border-radius:4px;
                                font-size:10px;
                                color:#f87171;
                            "
                        >
                            ×
                        </button>

                    </div>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- AGREGAR OTRO PRODUCTO --}}
            {{-- ================================================= --}}

            <div class="mt-5">

                <button
                    type="button"
                    id="addProducto"
                    class="font-black uppercase tracking-widest px-5 py-3 transition-opacity hover:opacity-80"
                    style="
                        background:rgba(0,200,150,0.08);
                        border:1px solid rgba(0,200,150,0.2);
                        border-radius:4px;
                        font-size:9px;
                        color:#00c896;
                    "
                >
                    + AGREGAR PRODUCTO
                </button>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- BOTONES --}}
        {{-- ===================================================== --}}

        <div
            class="flex items-center gap-3 pt-4"
            style="
                border-top:1px solid rgba(255,255,255,0.08);
            "
        >

            <button
                type="submit"
                class="font-black uppercase tracking-widest px-6 py-3 text-black transition-all hover:opacity-80"
                style="
                    font-size:10px;
                    background:#00c896;
                    border-radius:4px;
                "
            >
                CREAR PEDIDO
            </button>

            <a
                href="{{ route('pedidos.index') }}"
                class="font-black uppercase tracking-widest px-6 py-3 transition-opacity hover:opacity-70"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                "
            >
                CANCELAR
            </a>

        </div>

    </form>

</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
     * Contenedor donde estarán las filas de productos.
     */
    const container = document.getElementById('productosContainer');

    /*
     * Botón para agregar una nueva fila.
     */
    const addButton = document.getElementById('addProducto');

    /*
     * Elemento donde mostramos el total general.
     */
    const totalElement = document.getElementById('totalPedido');

    /*
     * Índice utilizado para crear correctamente
     * los nombres productos[0], productos[1], etc.
     */
    let productIndex = 1;


    /*
     * =========================================================
     * ACTUALIZAR TOTALES
     * =========================================================
     */

    function actualizarTotales() {

        let total = 0;

        const rows = container.querySelectorAll('.producto-row');

        rows.forEach(function (row) {

            const select = row.querySelector('.producto-select');

            const cantidadInput =
                row.querySelector('.cantidad-input');

            const subtotalElement =
                row.querySelector('.subtotal-producto');


            /*
             * Precio obtenido del option seleccionado.
             */
            const option =
                select.options[select.selectedIndex];

            const precio =
                parseFloat(
                    option?.dataset.precio || 0
                );


            /*
             * Cantidad seleccionada.
             */
            const cantidad =
                parseInt(
                    cantidadInput.value || 0
                );


            /*
             * Calculamos el subtotal.
             */
            const subtotal =
                precio * cantidad;


            /*
             * Mostramos el subtotal.
             */
            subtotalElement.textContent =
                '$' + subtotal.toFixed(2);


            /*
             * Sumamos al total general.
             */
            total += subtotal;

        });


        /*
         * Mostramos el total del pedido.
         */
        totalElement.textContent =
            '$' + total.toFixed(2);
    }


    /*
     * =========================================================
     * AGREGAR PRODUCTO
     * =========================================================
     */

    addButton.addEventListener('click', function () {

        /*
         * Tomamos la primera fila como plantilla.
         */
        const original =
            container.querySelector('.producto-row');

        /*
         * Clonamos la fila.
         */
        const clone =
            original.cloneNode(true);


        /*
         * Cambiamos los nombres de los campos.
         *
         * Ejemplo:
         *
         * productos[0][id_producto]
         *
         * pasa a:
         *
         * productos[1][id_producto]
         */
        const select =
            clone.querySelector('.producto-select');

        const cantidad =
            clone.querySelector('.cantidad-input');


        select.name =
            `productos[${productIndex}][id_producto]`;

        cantidad.name =
            `productos[${productIndex}][cantidad]`;


        /*
         * Limpiamos los valores.
         */
        select.value = '';

        cantidad.value = 1;


        /*
         * Reiniciamos subtotal.
         */
        clone.querySelector(
            '.subtotal-producto'
        ).textContent = '$0.00';


        /*
         * Agregamos la nueva fila.
         */
        container.appendChild(clone);


        /*
         * Incrementamos el índice.
         */
        productIndex++;

    });


    /*
     * =========================================================
     * CAMBIOS EN PRODUCTOS Y CANTIDADES
     * =========================================================
     */

    container.addEventListener('change', function (event) {

        if (
            event.target.classList.contains('producto-select') ||
            event.target.classList.contains('cantidad-input')
        ) {

            actualizarTotales();

        }

    });


    container.addEventListener('input', function (event) {

        if (
            event.target.classList.contains('cantidad-input')
        ) {

            actualizarTotales();

        }

    });


    /*
     * =========================================================
     * ELIMINAR PRODUCTO
     * =========================================================
     */

    container.addEventListener('click', function (event) {

        if (
            event.target.classList.contains('remove-producto')
        ) {

            const rows =
                container.querySelectorAll('.producto-row');


            /*
             * Siempre dejamos al menos una fila.
             */
            if (rows.length === 1) {

                const row = rows[0];

                row.querySelector(
                    '.producto-select'
                ).value = '';

                row.querySelector(
                    '.cantidad-input'
                ).value = 1;

                actualizarTotales();

                return;
            }


            /*
             * Eliminamos la fila.
             */
            event.target
                .closest('.producto-row')
                .remove();


            actualizarTotales();

        }

    });


    /*
     * Calculamos el total inicialmente.
     */
    actualizarTotales();

});

</script>

@endsection