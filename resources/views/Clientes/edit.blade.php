@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- ENCABEZADO --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px; letter-spacing:0.15em;"
            >
                EDITAR CLIENTE
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                MODIFICAR INFORMACIÓN DEL CLIENTE
            </p>
        </div>

        <a
            href="{{ route('clientes.index') }}"
            class="font-black uppercase tracking-widest px-5 py-2"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.6);
                border:1px solid rgba(255,255,255,0.12);
                border-radius:4px;
            "
        >
            ← VOLVER
        </a>

    </div>


    {{-- ERRORES --}}
    @if($errors->any())
        <div
            class="mb-6 px-4 py-4"
            style="
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-radius:4px;
            "
        >

            <p
                class="font-black uppercase tracking-widest mb-2"
                style="font-size:10px; color:#f87171;"
            >
                REVISA LOS SIGUIENTES ERRORES:
            </p>

            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li
                        class="font-bold"
                        style="font-size:11px; color:#fca5a5;"
                    >
                        • {{ $error }}
                    </li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- FORMULARIO --}}
    <div
        class="p-8"
        style="
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >

        <form
            action="{{ route('clientes.update', $cliente) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- NOMBRE --}}
            <div class="mb-6">

                <label
                    for="nombre"
                    class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.5);"
                >
                    NOMBRE
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $cliente->nombre) }}"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background:rgba(255,255,255,0.04);
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                        font-size:12px;
                    "
                >

                @error('nombre')
                    <p
                        class="mt-2 font-bold"
                        style="font-size:10px; color:#f87171;"
                    >
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- EMPRESA --}}
            <div class="mb-6">

                <label
                    for="empresa"
                    class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.5);"
                >
                    EMPRESA
                </label>

                <input
                    type="text"
                    id="empresa"
                    name="empresa"
                    value="{{ old('empresa', $cliente->empresa) }}"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background:rgba(255,255,255,0.04);
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                        font-size:12px;
                    "
                >

                @error('empresa')
                    <p
                        class="mt-2 font-bold"
                        style="font-size:10px; color:#f87171;"
                    >
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- LOGO --}}
            <div class="mb-6">

                <label
                    for="logo_url"
                    class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.5);"
                >
                    URL DEL LOGO
                </label>

                <input
                    type="url"
                    id="logo_url"
                    name="logo_url"
                    value="{{ old('logo_url', $cliente->logo_url) }}"
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background:rgba(255,255,255,0.04);
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                        font-size:12px;
                    "
                    placeholder="https://ejemplo.com/logo.png"
                >

                @error('logo_url')
                    <p
                        class="mt-2 font-bold"
                        style="font-size:10px; color:#f87171;"
                    >
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- ESTADO --}}
            <div class="mb-8">

                <label
                    for="activo"
                    class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.5);"
                >
                    ESTADO
                </label>

                <select
                    id="activo"
                    name="activo"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background:#171717;
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                        font-size:12px;
                    "
                >

                    <option
                        value="1"
                        {{ old('activo', $cliente->activo) == '1' ? 'selected' : '' }}
                    >
                        ACTIVO
                    </option>

                    <option
                        value="0"
                        {{ old('activo', $cliente->activo) == '0' ? 'selected' : '' }}
                    >
                        INACTIVO
                    </option>

                </select>

                @error('activo')
                    <p
                        class="mt-2 font-bold"
                        style="font-size:10px; color:#f87171;"
                    >
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- BOTONES --}}
            <div class="flex items-center justify-end gap-3">

                <a
                    href="{{ route('clientes.show', $cliente) }}"
                    class="px-5 py-3 font-black uppercase tracking-widest"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.5);
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                    "
                >
                    CANCELAR
                </a>

                <button
                    type="submit"
                    class="px-5 py-3 font-black uppercase tracking-widest text-black"
                    style="
                        font-size:10px;
                        background:#00c896;
                        border-radius:4px;
                        cursor:pointer;
                    "
                >
                    GUARDAR CAMBIOS
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
