@extends('layouts.app')

@section('title', 'Detalle del Cliente')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- ENCABEZADO --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px; letter-spacing:0.15em;"
            >
                CLIENTE #{{ $cliente->id }}
            </h1>

            <p
                class="font-bold uppercase tracking-widest mt-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                INFORMACIÓN DEL CLIENTE
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


    {{-- MENSAJE DE ÉXITO --}}
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


    {{-- INFORMACIÓN --}}
    <div
        class="p-8"
        style="
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >

        {{-- NOMBRE --}}
        <div
            class="flex items-center justify-between py-5"
            style="border-bottom:1px solid rgba(255,255,255,0.07);"
        >

            <span
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                NOMBRE
            </span>

            <span
                class="font-bold text-white"
                style="font-size:13px;"
            >
                {{ $cliente->nombre }}
            </span>

        </div>


        {{-- EMPRESA --}}
        <div
            class="flex items-center justify-between py-5"
            style="border-bottom:1px solid rgba(255,255,255,0.07);"
        >

            <span
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                EMPRESA
            </span>

            <span
                class="font-bold"
                style="font-size:13px; color:#00c896;"
            >
                {{ $cliente->empresa }}
            </span>

        </div>


        {{-- LOGO --}}
        <div
            class="flex items-center justify-between py-5"
            style="border-bottom:1px solid rgba(255,255,255,0.07);"
        >

            <span
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                LOGO
            </span>

            <div>

                @if($cliente->logo_url)

                    <a
                        href="{{ $cliente->logo_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="font-bold"
                        style="font-size:11px; color:#00c896;"
                    >
                        VER LOGO ↗
                    </a>

                @else

                    <span
                        class="font-bold"
                        style="font-size:11px; color:rgba(255,255,255,0.3);"
                    >
                        SIN LOGO
                    </span>

                @endif

            </div>

        </div>


        {{-- ESTADO --}}
        <div
            class="flex items-center justify-between py-5"
        >

            <span
                class="font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                ESTADO
            </span>

            @if($cliente->activo)

                <span
                    class="font-black uppercase tracking-widest px-3 py-1"
                    style="
                        font-size:9px;
                        background:rgba(0,200,150,0.15);
                        color:#00c896;
                        border-radius:3px;
                    "
                >
                    ACTIVO
                </span>

            @else

                <span
                    class="font-black uppercase tracking-widest px-3 py-1"
                    style="
                        font-size:9px;
                        background:rgba(248,113,113,0.15);
                        color:#f87171;
                        border-radius:3px;
                    "
                >
                    INACTIVO
                </span>

            @endif

        </div>

    </div>


    {{-- ACCIONES --}}
    <div class="flex items-center justify-end gap-3 mt-6">

        {{-- EDITAR --}}
        <a
            href="{{ route('clientes.edit', $cliente) }}"
            class="px-5 py-3 font-black uppercase tracking-widest"
            style="
                font-size:10px;
                color:#00c896;
                border:1px solid rgba(0,200,150,0.25);
                border-radius:4px;
            "
        >
            EDITAR
        </a>


        {{-- ELIMINAR --}}
        <form
            action="{{ route('clientes.destroy', $cliente) }}"
            method="POST"
            onsubmit="return confirm('¿Estás seguro de eliminar este cliente?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="px-5 py-3 font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:#f87171;
                    border:1px solid rgba(248,113,113,0.25);
                    border-radius:4px;
                    background:transparent;
                    cursor:pointer;
                "
            >
                ELIMINAR
            </button>

        </form>

    </div>

</div>

@endsection
