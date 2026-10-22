@extends('layouts.app')

@section('title', 'Crear permiso')

@section('content')

<div class="w-full max-w-xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="mb-8">

        <h1
            class="font-black uppercase tracking-widest text-white"
            style="
                font-size:22px;
                letter-spacing:0.15em;
            "
        >
            CREAR PERMISO
        </h1>

        <p
            class="mt-2 font-bold"
            style="
                font-size:11px;
                color:rgba(255,255,255,0.45);
                line-height:1.7;
            "
        >
            Registra un nuevo permiso para utilizarlo en los roles del sistema.
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


    {{-- ===================================================== --}}
    {{-- ERRORES DE VALIDACIÓN --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div
            class="mb-6 p-4"
            style="
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-radius:5px;
            "
        >

            <p
                class="font-black uppercase tracking-widest mb-2"
                style="
                    font-size:10px;
                    color:#f87171;
                "
            >
                No se pudo crear el permiso.
            </p>

            <ul
                class="list-disc list-inside space-y-1"
                style="
                    font-size:11px;
                    color:rgba(255,255,255,0.7);
                "
            >

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- FORMULARIO --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('permisos.store') }}"
        class="space-y-6 p-6 md:p-8"
        style="
            background:#111111;
            border:1px solid rgba(169,144,69,0.25);
            border-radius:6px;
            box-shadow:0 10px 30px rgba(0,0,0,0.20);
        "
    >

        @csrf


        {{-- ================================================= --}}
        {{-- NOMBRE DEL PERMISO --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="nombre"
                class="block mb-2 font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.75);
                    letter-spacing:0.12em;
                "
            >
                Nombre
            </label>

            <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Ejemplo: productos.crear"
                value="{{ old('nombre') }}"
                class="w-full px-4 py-3 text-white outline-none transition-all"
                style="
                    background:#1D1D1D;
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                "
                onfocus="this.style.borderColor='#A99045'"
                onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                required
            >

            @error('nombre')

                <p
                    class="mt-2 font-bold"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ================================================= --}}
        {{-- MÓDULO --}}
        {{-- ================================================= --}}

        <div>

            <label
                for="modulo"
                class="block mb-2 font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.75);
                    letter-spacing:0.12em;
                "
            >
                Módulo
            </label>

            <input
                type="text"
                id="modulo"
                name="modulo"
                placeholder="Ejemplo: productos"
                value="{{ old('modulo') }}"
                class="w-full px-4 py-3 text-white outline-none transition-all"
                style="
                    background:#1D1D1D;
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                    font-size:12px;
                "
                onfocus="this.style.borderColor='#A99045'"
                onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                required
            >

            @error('modulo')

                <p
                    class="mt-2 font-bold"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ================================================= --}}
        {{-- BOTONES --}}
        {{-- ================================================= --}}

        <div
            class="flex flex-wrap items-center gap-3 pt-5"
            style="
                border-top:1px solid rgba(255,255,255,0.08);
            "
        >

            @if (auth()->check() && auth()->user()->tienePermiso('permisos.crear'))

                <button
                    type="submit"
                    class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all hover:opacity-80"
                    style="
                        font-size:10px;
                        color:#111111;
                        background:#A99045;
                        border:1px solid #A99045;
                        border-radius:4px;
                        letter-spacing:0.1em;
                    "
                >
                    GUARDAR
                </button>

            @endif

            <a
                href="{{ route('permisos.index') }}"
                class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all hover:bg-white/10"
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
