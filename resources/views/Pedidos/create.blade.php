@extends('layouts.app')

@section('title', 'Nuevo Pedido')

@section('content')

<div class="max-w-3xl">

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
            Los productos y cantidades podrán agregarse posteriormente.
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- FORMULARIO --}}
    {{-- ========================================================= --}}

    <form
        action="{{ route('pedidos.store') }}"
        method="POST"
        class="space-y-6"
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
                    TOTAL INICIAL
                </span>

                <p
                    class="mt-2 font-black"
                    style="
                        font-size:12px;
                        color:#00c896;
                    "
                >
                    $0
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

@endsection