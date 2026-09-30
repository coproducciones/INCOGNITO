```blade
@extends('layouts.app')

@section('title', 'Nueva Reseña')

@section('content')

<div class="max-w-3xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

        <a
            href="{{ route('reseñas.index') }}"
            class="font-bold uppercase tracking-widest"
            style="
                font-size:9px;
                color:rgba(255,255,255,0.4);
            "
        >
            ← VOLVER A RESEÑAS
        </a>

        <h1
            class="mt-5 font-black uppercase tracking-widest text-white"
            style="
                font-size:22px;
                letter-spacing:0.15em;
            "
        >
            NUEVA RESEÑA
        </h1>

        <p
            class="mt-1 font-bold uppercase tracking-widest"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.4);
            "
        >
            REGISTRAR UNA NUEVA RESEÑA
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- MENSAJE GENERAL DE ERRORES --}}
    {{-- ========================================================= --}}

    @if ($errors->any())

        <div
            class="mb-6 p-4"
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
                REVISA LOS SIGUIENTES CAMPOS
            </p>

            <ul class="mt-2 space-y-1">

                @foreach ($errors->all() as $error)

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
        action="{{ route('reseñas.store') }}"
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

                <option value="" style="background:#111;">
                    SELECCIONAR USUARIO
                </option>

                @foreach($usuarios as $usuario)

                    <option
                        value="{{ $usuario->id }}"
                        style="background:#111;"
                        {{ old('id_usuario') == $usuario->id ? 'selected' : '' }}
                    >
                        {{ $usuario->nombre }}
                        @if($usuario->email)
                            — {{ $usuario->email }}
                        @endif
                    </option>

                @endforeach

            </select>

            @error('id_usuario')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- PRODUCTO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="id_producto"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
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
                    font-size:12px;
                "
            >

                <option value="" style="background:#111;">
                    SELECCIONAR PRODUCTO
                </option>

                @foreach($productos as $producto)

                    <option
                        value="{{ $producto->id }}"
                        style="background:#111;"
                        {{ old('id_producto') == $producto->id ? 'selected' : '' }}
                    >
                        {{ $producto->nombre }}
                    </option>

                @endforeach

            </select>

            @error('id_producto')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- CLIENTE --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="id_cliente"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                CLIENTE
            </label>

            <select
                name="id_cliente"
                id="id_cliente"
                required
                class="w-full px-4 py-3 text-white outline-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
            >

                <option value="" style="background:#111;">
                    SELECCIONAR CLIENTE
                </option>

                @foreach($clientes as $cliente)

                    <option
                        value="{{ $cliente->id_cliente }}"
                        style="background:#111;"
                        {{ old('id_cliente') == $cliente->id_cliente ? 'selected' : '' }}
                    >
                        {{ $cliente->nombre }}

                        @if($cliente->empresa)
                            — {{ $cliente->empresa }}
                        @endif

                    </option>

                @endforeach

            </select>

            @error('id_cliente')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- CALIFICACIÓN --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="calificacion"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                CALIFICACIÓN
            </label>

            <select
                name="calificacion"
                id="calificacion"
                required
                class="w-full px-4 py-3 text-white outline-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
            >

                <option value="" style="background:#111;">
                    SELECCIONAR CALIFICACIÓN
                </option>

                @for($i = 5; $i >= 1; $i--)

                    <option
                        value="{{ $i }}"
                        style="background:#111;"
                        {{ old('calificacion') == $i ? 'selected' : '' }}
                    >
                        {{ $i }}
                        {{ $i == 1 ? 'ESTRELLA' : 'ESTRELLAS' }}
                    </option>

                @endfor

            </select>

            @error('calificacion')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ===================================================== --}}
        {{-- COMENTARIO --}}
        {{-- ===================================================== --}}

        <div>

            <label
                for="comentario"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                COMENTARIO
            </label>

            <textarea
                name="comentario"
                id="comentario"
                rows="6"
                required
                class="w-full px-4 py-3 text-white outline-none resize-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
                placeholder="ESCRIBE EL COMENTARIO DEL CLIENTE..."
            >{{ old('comentario') }}</textarea>

            @error('comentario')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

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
                class="font-black uppercase tracking-widest px-6 py-3 text-black"
                style="
                    font-size:10px;
                    background:#00c896;
                    border-radius:4px;
                "
            >
                GUARDAR RESEÑA
            </button>

            <a
                href="{{ route('reseñas.index') }}"
                class="font-black uppercase tracking-widest px-6 py-3"
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
```
