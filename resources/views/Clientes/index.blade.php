@extends('layouts.app')

@section('title', 'Clientes')

@section('content')

<div class="flex items-center justify-between mb-8"> <div> <h1 class="font-black uppercase tracking-widest text-white" style="font-size:22px; letter-spacing:0.15em;" > CLIENTES </h1>
    <p
        class="font-bold uppercase tracking-widest mt-1"
        style="font-size:10px; color:rgba(255,255,255,0.4);"
    >
        GESTIÓN DE CLIENTES
    </p>
</div>

{{-- NUEVO CLIENTE --}}
<a
    href="{{ route('clientes.create') }}"
    class="font-black uppercase tracking-widest px-5 py-2 text-black"
    style="
        font-size:11px;
        background:#00c896;
        border-radius:4px;
        letter-spacing:0.1em;
    "
>
    + NUEVO CLIENTE
</a>

</div>

{{-- MENSAJE DE ÉXITO --}}
@if(session('success'))
<div class="mb-6 px-4 py-3 font-bold uppercase tracking-widest" style=" font-size:10px; background:rgba(0,200,150,0.1); border:1px solid rgba(0,200,150,0.3); border-radius:4px; color:#00c896; " >
{{ session('success') }}
</div>
@endif

{{-- TABLA --}}

<div class="overflow-x-auto" style=" background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:6px; " > <table class="w-full">
    {{-- ENCABEZADO --}}
    <thead>
        <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">

            <th
                class="px-6 py-4 text-left font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                ID
            </th>

            <th
                class="px-6 py-4 text-left font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                NOMBRE
            </th>

            <th
                class="px-6 py-4 text-left font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                EMPRESA
            </th>

            <th
                class="px-6 py-4 text-left font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                LOGO
            </th>

            <th
                class="px-6 py-4 text-left font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                ESTADO
            </th>

            <th
                class="px-6 py-4 text-left font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                ACCIONES
            </th>

        </tr>
    </thead>


    {{-- CUERPO --}}
    <tbody>

        @forelse($clientes as $cliente)

            <tr style="border-bottom:1px solid rgba(255,255,255,0.05);">

                {{-- ID --}}
                <td
                    class="px-6 py-4 font-bold text-white"
                    style="font-size:12px;"
                >
                    {{ $cliente->id }}
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
                    style="font-size:12px; color:#00c896;"
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
                            class="hover:text-emerald-400 transition-colors"
                            style="color:#00c896;"
                        >
                            VER LOGO
                        </a>

                    @else

                        <span style="color:rgba(255,255,255,0.3);">
                            SIN LOGO
                        </span>

                    @endif
                </td>


                {{-- ESTADO --}}
                <td class="px-6 py-4">

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

                </td>


                {{-- ACCIONES --}}
                <td class="px-6 py-4">

                    <div class="flex items-center gap-2">

                        {{-- VER --}}
                        <a
                            href="{{ route('clientes.show', $cliente) }}"
                            class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/10"
                            style="
                                min-width:60px;
                                font-size:9px;
                                color:rgba(255,255,255,0.6);
                                border:1px solid rgba(255,255,255,0.12);
                                border-radius:4px;
                            "
                        >
                            VER
                        </a>


                        {{-- EDITAR --}}
                        <a
                            href="{{ route('clientes.edit', $cliente) }}"
                            class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest transition-all hover:bg-emerald-500/10"
                            style="
                                min-width:60px;
                                font-size:9px;
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
                            onsubmit="return confirm('¿Eliminar este cliente?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center px-3 py-2 font-black uppercase tracking-widest"
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