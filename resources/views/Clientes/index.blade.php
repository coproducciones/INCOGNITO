@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

{{-- ENCABEZADO --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">

    <div>
        <h1
            class="font-black uppercase tracking-widest text-white"
            style="font-size:22px; letter-spacing:0.15em;"
        >
            CLIENTES
        </h1>

        <p
            class="font-bold uppercase tracking-widest mt-1"
            style="font-size:10px; color:rgba(255,255,255,0.4);"
        >
            GESTIÓN DE CLIENTES
        </p>
    </div>

    {{-- NUEVO CLIENTE --}}
    @if(auth()->check() && auth()->user()->tienePermiso('clientes.crear'))
        <a
            href="{{ route('clientes.create') }}"
            class="inline-flex items-center justify-center font-black uppercase tracking-widest px-5 py-3 transition-all duration-300 hover:opacity-90"
            style="
                font-size:11px;
                color:#111111;
                background:#A99045;
                border:1px solid #A99045;
                border-radius:4px;
                letter-spacing:0.1em;
            "
        >
            + NUEVO CLIENTE
        </a>
    @endif

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


{{-- TABLA DE CLIENTES --}}
<div
    class="overflow-x-auto"
    style="
        background:#1D1D1D;
        border:1px solid rgba(255,255,255,0.08);
        border-radius:6px;
    "
>
    <table class="w-full" style="min-width:850px;">

        {{-- ENCABEZADO --}}
        <thead>
            <tr style="
                background:#151515;
                border-bottom:1px solid rgba(169,144,69,0.3);
            ">

                <th
                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    ID
                </th>

                <th
                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    NOMBRE
                </th>

                <th
                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    EMPRESA
                </th>

                <th
                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    LOGO
                </th>

                <th
                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    ESTADO
                </th>

                <th
                    class="px-6 py-4 text-left font-black uppercase tracking-widest"
                    style="font-size:10px; color:#D8C17F;"
                >
                    ACCIONES
                </th>

            </tr>
        </thead>


        {{-- CUERPO --}}
        <tbody>

            @forelse($clientes as $cliente)

                <tr
                    class="transition-colors duration-200 hover:bg-white/[0.02]"
                    style="border-bottom:1px solid rgba(255,255,255,0.05);"
                >

                    {{-- ID --}}
                    <td
                        class="px-6 py-4 font-bold text-white"
                        style="font-size:12px;"
                    >
                        <span style="color:#D8C17F;">
                            #{{ $cliente->id }}
                        </span>
                    </td>

                    {{-- NOMBRE --}}
                    <td
                        class="px-6 py-4 font-bold text-white"
                        style="font-size:12px;"
                    >
                        {{ $cliente->nombre }}
                    </td>

                    {{-- EMPRESA --}}
                    <td
                        class="px-6 py-4 font-bold"
                        style="font-size:12px; color:#D8C17F;"
                    >
                        {{ $cliente->empresa }}
                    </td>

                    {{-- LOGO --}}
                    <td
                        class="px-6 py-4 font-bold text-white"
                        style="font-size:12px;"
                    >
                        @if($cliente->logo_url)

                            <a
                                href="{{ $cliente->logo_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center font-black uppercase tracking-widest transition-colors duration-200 hover:opacity-80"
                                style="
                                    font-size:10px;
                                    color:#D8C17F;
                                "
                            >
                                VER LOGO
                            </a>

                        @else

                            <span
                                class="font-bold uppercase tracking-widest"
                                style="
                                    font-size:9px;
                                    color:rgba(255,255,255,0.3);
                                "
                            >
                                SIN LOGO
                            </span>

                        @endif
                    </td>


                    {{-- ESTADO --}}
                    <td class="px-6 py-4">

                        @if($cliente->activo)

                            <span
                                class="inline-flex font-black uppercase tracking-widest px-3 py-1"
                                style="
                                    font-size:9px;
                                    background:rgba(0,200,150,0.12);
                                    color:#00c896;
                                    border:1px solid rgba(0,200,150,0.2);
                                    border-radius:3px;
                                "
                            >
                                ACTIVO
                            </span>

                        @else

                            <span
                                class="inline-flex font-black uppercase tracking-widest px-3 py-1"
                                style="
                                    font-size:9px;
                                    background:rgba(248,113,113,0.12);
                                    color:#f87171;
                                    border:1px solid rgba(248,113,113,0.2);
                                    border-radius:3px;
                                "
                            >
                                INACTIVO
                            </span>

                        @endif

                    </td>


                    {{-- ACCIONES --}}
                    <td class="px-6 py-4">

                        <div class="flex items-center gap-2">

                            {{-- VER --}}
                            @if(auth()->check() && auth()->user()->tienePermiso('clientes.ver'))
                                <a
                                    href="{{ route('clientes.show', $cliente) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-white/[0.08]"
                                    style="
                                        min-width:60px;
                                        font-size:9px;
                                        color:rgba(255,255,255,0.7);
                                        border:1px solid rgba(255,255,255,0.12);
                                        border-radius:4px;
                                    "
                                >
                                    VER
                                </a>
                            @endif


                            {{-- EDITAR --}}
                            @if(auth()->check() && auth()->user()->tienePermiso('clientes.editar'))
                                <a
                                    href="{{ route('clientes.edit', $cliente) }}"
                                    class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-[#A99045]/10"
                                    style="
                                        min-width:60px;
                                        font-size:9px;
                                        color:#D8C17F;
                                        border:1px solid rgba(169,144,69,0.4);
                                        border-radius:4px;
                                    "
                                >
                                    EDITAR
                                </a>
                            @endif


                            {{-- ELIMINAR --}}
                            @if(auth()->check() && auth()->user()->tienePermiso('clientes.eliminar'))
                                <form
                                    action="{{ route('clientes.destroy', $cliente) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar este cliente?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all duration-200 hover:bg-red-500/10"
                                        style="
                                            min-width:75px;
                                            font-size:9px;
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
                            @endif

                        </div>

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
                        NO HAY CLIENTES REGISTRADOS
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>
</div>

@endsection