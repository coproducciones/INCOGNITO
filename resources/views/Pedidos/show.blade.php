@extends('layouts.app')

@section('title', 'Pedido #' . $pedido->id_pedido)

@section('content')

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
    {{-- RESUMEN --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">


        {{-- ID --}}

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

                                <th
                                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="
                                        font-size:9px;
                                        color:rgba(255,255,255,0.4);
                                    "
                                >
                                    PRODUCTO
                                </th>

                                <th
                                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="
                                        font-size:9px;
                                        color:rgba(255,255,255,0.4);
                                    "
                                >
                                    CANTIDAD
                                </th>

                                <th
                                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="
                                        font-size:9px;
                                        color:rgba(255,255,255,0.4);
                                    "
                                >
                                    PRECIO
                                </th>

                                <th
                                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                                    style="
                                        font-size:9px;
                                        color:rgba(255,255,255,0.4);
                                    "
                                >
                                    SUBTOTAL
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($pedido->detalles as $detalle)

                                <tr
                                    style="
                                        border-bottom:1px solid rgba(255,255,255,0.05);
                                    "
                                >

                                    <td
                                        class="px-6 py-4 font-bold text-white"
                                        style="font-size:12px;"
                                    >
                                        {{ $detalle->producto?->nombre ?? 'PRODUCTO ELIMINADO' }}
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

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
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

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- CAMBIAR ESTADO --}}
        {{-- ===================================================== --}}

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


                {{-- CORREGIDO:
                     pedidos.update-estado NO EXISTE.
                     La ruta correcta es pedidos.estado.update.
                --}}

                <form
                    action="{{ route('pedidos.estado.update', ['pedido' => $pedido->id_pedido]) }}"
                    method="POST"
                >

                    @csrf

                    @method('PATCH')


                    {{-- ESTADO --}}

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


                    {{-- COMENTARIO --}}

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

                        {{-- PUNTO DEL HISTORIAL --}}

                        <div
                            class= flex-shrink-0 flex items-center justify-center
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
                                    width:6px;
                                    height:6px;
                                    background:#00c896;
                                    border-radius:50%;
                                "
                            ></span>

                        </div>


                        {{-- INFORMACIÓN DEL EVENTO --}}

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

@endsection
