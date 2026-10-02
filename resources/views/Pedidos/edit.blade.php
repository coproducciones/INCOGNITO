@extends('layouts.app')

@section('title', 'Editar Pedido')

@section('content')

<div class="w-full max-w-3xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

        <h1
            class="font-black uppercase tracking-widest text-white"
            style="
                font-size:22px;
                letter-spacing:0.15em;
            "
        >
            EDITAR PEDIDO
        </h1>

        <p
            class="font-bold uppercase tracking-widest mt-1"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.4);
            "
        >
            MODIFICAR INFORMACIÓN DEL PEDIDO #{{ $pedido->id_pedido }}
        </p>

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
    {{-- FORMULARIO --}}
    {{-- ========================================================= --}}

    <form
        action="{{ route('pedidos.update', ['pedido' => $pedido->id_pedido]) }}"
        method="POST"
        class="space-y-6"
    >

        @csrf
        @method('PUT')


        {{-- ===================================================== --}}
        {{-- USUARIO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="id_usuario"
                class="block font-black uppercase tracking-widest text-white mb-2"
                style="font-size:10px;"
            >
                USUARIO
            </label>

            <select
                name="id_usuario"
                id="id_usuario"
                class="w-full px-4 py-3 text-white"
                style="
                    background:rgba(255,255,255,0.05);
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                "
                required
            >

                <option value=""
                style="background:#111;">
                    SELECCIONA UN USUARIO
                </option>

                @foreach($usuarios as $usuario)

                    <option
                        value="{{ $usuario->id }}"
                        style="background:#111;"
                        {{ old('id_usuario', $pedido->id_usuario) == $usuario->id ? 'selected' : '' }}
                    >
                        {{ $usuario->nombre }}
                    </option>

                @endforeach

            </select>

            @error('id_usuario')

                <p
                    class="mt-1"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- ESTADO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="id_estado"
                class="block font-black uppercase tracking-widest text-white mb-2"
                style="font-size:10px;"
            >
                ESTADO
            </label>

            <select
                name="id_estado"
                id="id_estado"
                class="w-full px-4 py-3 text-white"
                style="
                    background:rgba(255,255,255,0.05);
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                "
                required
            >

                <option value=""
                style="background:#111;"
                >
                    SELECCIONA UN ESTADO
                </option>

                @foreach($estados as $estado)

                    <option
                        value="{{ $estado->id_estado }}"
                        style="background:#111;"
                        {{ old('id_estado', $pedido->id_estado) == $estado->id_estado ? 'selected' : '' }}
                    >
                        {{ $estado->nombre }}
                    </option>

                @endforeach

            </select>

            @error('id_estado')

                <p
                    class="mt-1"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- FECHA DEL PEDIDO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="fecha_pedido"
                class="block font-black uppercase tracking-widest text-white mb-2"
                style="font-size:10px;"
            >
                FECHA DEL PEDIDO
            </label>

            <input
                type="datetime-local"
                name="fecha_pedido"
                id="fecha_pedido"
                value="{{ old('fecha_pedido', $pedido->fecha_pedido?->format('Y-m-d\TH:i')) }}"
                class="w-full px-4 py-3 text-white"
                style="
                    background:rgba(255,255,255,0.05);
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                "
                required
            >

            @error('fecha_pedido')

                <p
                    class="mt-1"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- TOTAL --}}
        {{-- ===================================================== --}}

        <div>

            <label
                class="block font-black uppercase tracking-widest text-white mb-2"
                style="font-size:10px;"
            >
                TOTAL DEL PEDIDO
            </label>

            <div
                class="w-full px-4 py-3 font-black"
                style="
                    background:rgba(255,255,255,0.03);
                    border:1px solid rgba(255,255,255,0.08);
                    border-radius:4px;
                    font-size:12px;
                    color:#00c896;
                "
            >
                ${{ number_format((float) $pedido->total, 0, ',', '.') }}
            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- BOTONES --}}
        {{-- ===================================================== --}}

        <div class="flex items-center gap-3">

            <button
                type="submit"
                class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 text-black transition-all hover:opacity-80"
                style="
                    font-size:10px;
                    background:#00c896;
                    border-radius:4px;
                    letter-spacing:0.1em;
                "
            >
                GUARDAR CAMBIOS
            </button>


            <a
                href="{{ route('pedidos.index') }}"
                class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:bg-white/10"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.6);
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    letter-spacing:0.1em;
                "
            >
                CANCELAR
            </a>

        </div>

    </form>

</div>

@endsection