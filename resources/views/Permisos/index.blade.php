@extends('layouts.app')

@section('title', 'Permisos')

@section('content')

<div class="space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-5">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="
                    font-size:22px;
                    letter-spacing:0.15em;
                "
            >
                Permisos
            </h1>

            <p
                class="mt-2 font-bold"
                style="
                    font-size:11px;
                    color:rgba(255,255,255,0.45);
                    line-height:1.7;
                "
            >
                Gestiona los permisos disponibles para los roles.
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


        {{-- Crear permiso --}}

        @if (auth()->check() && auth()->user()->tienePermiso('permisos.crear'))

            <a
                href="{{ route('permisos.create') }}"
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
                + Nuevo permiso
            </a>

        @endif

    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ÉXITO --}}
    {{-- ===================================================== --}}

    @if (session('success'))

        <div
            class="p-4 font-bold"
            style="
                background:rgba(169,144,69,0.10);
                border:1px solid rgba(169,144,69,0.35);
                border-left:3px solid #A99045;
                border-radius:4px;
                color:#D8C17F;
                font-size:12px;
            "
        >
            {{ session('success') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR --}}
    {{-- ===================================================== --}}

    @if (session('error'))

        <div
            class="p-4 font-bold"
            style="
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-left:3px solid #f87171;
                border-radius:4px;
                color:#f87171;
                font-size:12px;
            "
        >
            {{ session('error') }}
        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- TABLA DE PERMISOS --}}
    {{-- ===================================================== --}}

    <div
        class="overflow-x-auto"
        style="
            background:#111111;
            border:1px solid rgba(169,144,69,0.25);
            border-radius:6px;
            box-shadow:0 10px 30px rgba(0,0,0,0.20);
        "
    >

        <table class="w-full text-sm">

            {{-- ENCABEZADOS --}}

            <thead>

                <tr
                    style="
                        background:#1D1D1D;
                        border-bottom:1px solid rgba(169,144,69,0.30);
                    "
                >

                    <th
                        class="p-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="
                            font-size:10px;
                            color:#D8C17F;
                            letter-spacing:0.12em;
                        "
                    >
                        Nombre
                    </th>

                    <th
                        class="p-4 text-left font-black uppercase tracking-widest whitespace-nowrap"
                        style="
                            font-size:10px;
                            color:#D8C17F;
                            letter-spacing:0.12em;
                        "
                    >
                        Módulo
                    </th>

                    <th
                        class="p-4 text-center font-black uppercase tracking-widest whitespace-nowrap"
                        style="
                            font-size:10px;
                            color:#D8C17F;
                            letter-spacing:0.12em;
                        "
                    >
                        Roles
                    </th>

                    <th
                        class="p-4 text-center font-black uppercase tracking-widest whitespace-nowrap"
                        style="
                            font-size:10px;
                            color:#D8C17F;
                            letter-spacing:0.12em;
                        "
                    >
                        Acciones
                    </th>

                </tr>

            </thead>


            {{-- CONTENIDO --}}

            <tbody>

                @forelse ($permisos as $permiso)

                    <tr
                        style="
                            border-bottom:1px solid rgba(255,255,255,0.06);
                            transition:background 0.2s ease;
                        "
                        onmouseover="this.style.background='#1D1D1D'"
                        onmouseout="this.style.background='transparent'"
                    >

                        {{-- Nombre --}}

                        <td
                            class="p-4 font-bold"
                            style="
                                color:rgba(255,255,255,0.9);
                                font-size:12px;
                            "
                        >
                            {{ $permiso->nombre }}
                        </td>


                        {{-- Módulo --}}

                        <td
                            class="p-4"
                            style="
                                color:rgba(255,255,255,0.55);
                                font-size:12px;
                            "
                        >
                            {{ $permiso->modulo }}
                        </td>


                        {{-- Cantidad de roles --}}

                        <td class="p-4 text-center">

                            <span
                                class="inline-flex items-center justify-center min-w-8 px-3 py-1 font-black"
                                style="
                                    background:rgba(169,144,69,0.10);
                                    border:1px solid rgba(169,144,69,0.30);
                                    border-radius:4px;
                                    color:#D8C17F;
                                    font-size:11px;
                                "
                            >
                                {{ $permiso->roles_count ?? 0 }}
                            </span>

                        </td>


                        {{-- Acciones --}}

                        <td class="p-4">

                            <div class="flex flex-wrap gap-4 justify-center items-center">

                                {{-- Editar --}}

                                @if (auth()->check() && auth()->user()->tienePermiso('permisos.editar'))

                                    <a
                                        href="{{ route('permisos.edit', ['permiso' => $permiso->id_permiso]) }}"
                                        class="font-black uppercase tracking-widest transition-colors"
                                        style="
                                            color:#D8C17F;
                                            font-size:10px;
                                            letter-spacing:0.08em;
                                        "
                                        onmouseover="this.style.color='#FFFFFF'"
                                        onmouseout="this.style.color='#D8C17F'"
                                    >
                                        Editar
                                    </a>

                                @endif


                                {{-- Eliminar --}}

                                @if (auth()->check() && auth()->user()->tienePermiso('permisos.eliminar'))

                                    <form
                                        method="POST"
                                        action="{{ route('permisos.destroy', ['permiso' => $permiso->id_permiso]) }}"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar este permiso?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="font-black uppercase tracking-widest transition-colors"
                                            style="
                                                color:#f87171;
                                                background:transparent;
                                                border:none;
                                                cursor:pointer;
                                                font-size:10px;
                                                letter-spacing:0.08em;
                                            "
                                            onmouseover="this.style.color='#fca5a5'"
                                            onmouseout="this.style.color='#f87171'"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="4"
                            class="p-10 text-center"
                            style="
                                color:rgba(255,255,255,0.40);
                                font-size:12px;
                            "
                        >

                            <div class="flex flex-col items-center gap-3">

                                <span
                                    class="font-black uppercase tracking-widest"
                                    style="
                                        color:#D8C17F;
                                        font-size:11px;
                                    "
                                >
                                    Sin registros
                                </span>

                                <span>
                                    No hay permisos registrados.
                                </span>

                            </div>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
