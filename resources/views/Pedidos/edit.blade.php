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


    {{-- ========================================================= --}}
    {{-- MENSAJE DE ÉXITO --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div
            class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
            style="
                font-size:10px;
                background:rgba(169,144,69,0.10);
                border:1px solid rgba(169,144,69,0.35);
                border-radius:4px;
                color:#D8C17F;
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
        class="space-y-6 p-6 md:p-8"
        style="
            background:#111111;
            border:1px solid rgba(169,144,69,0.25);
            border-radius:6px;
            box-shadow:0 10px 30px rgba(0,0,0,0.20);
        "
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
                style="
                    font-size:10px;
                    letter-spacing:0.12em;
                "
            >
                USUARIO
            </label>

            <select
                name="id_usuario"
                id="id_usuario"
                class="w-full px-4 py-3 text-white outline-none transition-all"
                style="
                    background:#1D1D1D;
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                    color-scheme:dark;
                "
                onfocus="this.style.borderColor='#A99045'"
                onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                required
            >

                <option
                    value=""
                    style="background:#111111;"
                >
                    SELECCIONA UN USUARIO
                </option>

                @foreach($usuarios as $usuario)

                    <option
                        value="{{ $usuario->id }}"
                        style="background:#111111;"
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
                style="
                    font-size:10px;
                    letter-spacing:0.12em;
                "
            >
                ESTADO
            </label>

            <select
                name="id_estado"
                id="id_estado"
                class="w-full px-4 py-3 text-white outline-none transition-all"
                style="
                    background:#1D1D1D;
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                    color-scheme:dark;
                "
                onfocus="this.style.borderColor='#A99045'"
                onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                required
            >

                <option
                    value=""
                    style="background:#111111;"
                >
                    SELECCIONA UN ESTADO
                </option>

                @foreach($estados as $estado)

                    <option
                        value="{{ $estado->id_estado }}"
                        style="background:#111111;"
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
                style="
                    font-size:10px;
                    letter-spacing:0.12em;
                "
            >
                FECHA DEL PEDIDO
            </label>

            <input
                type="datetime-local"
                name="fecha_pedido"
                id="fecha_pedido"
                value="{{ old('fecha_pedido', $pedido->fecha_pedido?->format('Y-m-d\TH:i')) }}"
                class="w-full px-4 py-3 text-white outline-none transition-all"
                style="
                    background:#1D1D1D;
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                    color-scheme:dark;
                "
                onfocus="this.style.borderColor='#A99045'"
                onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
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
                style="
                    font-size:10px;
                    letter-spacing:0.12em;
                "
            >
                TOTAL DEL PEDIDO
            </label>

            <div
                class="w-full px-4 py-3 font-black"
                style="
                    background:#1D1D1D;
                    border:1px solid rgba(169,144,69,0.30);
                    border-radius:4px;
                    font-size:16px;
                    color:#D8C17F;
                "
            >
                ${{ number_format((float) $pedido->total, 0, ',', '.') }}
            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- BOTONES --}}
        {{-- ===================================================== --}}

        <div
            class="flex flex-wrap items-center gap-3 pt-5"
            style="
                border-top:1px solid rgba(255,255,255,0.08);
            "
        >

            @if(auth()->check() && auth()->user()->tienePermiso('pedidos.editar'))

                <button
                    type="submit"
                    class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:opacity-80"
                    style="
                        font-size:10px;
                        background:#A99045;
                        color:#111111;
                        border:1px solid #A99045;
                        border-radius:4px;
                        letter-spacing:0.1em;
                    "
                >
                    GUARDAR CAMBIOS
                </button>

            @endif

            <a
                href="{{ route('pedidos.index') }}"
                class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all hover:bg-white/10"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.65);
                    background:#1D1D1D;
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
