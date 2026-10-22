@extends('layouts.app')

@section('title', 'Gestión de pedidos')

@section('content')

<style>
    .orders-page {
        color: #FFFFFF;
    }

    .orders-panel {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 1rem;
        background: linear-gradient(145deg, #1D1D1D, #151515);
        box-shadow: 0 20px 45px rgba(0, 0, 0, .16);
    }

    .orders-heading-line {
        height: 1px;
        background: linear-gradient(90deg, #A99045, #D8C17F, transparent);
    }

    .orders-primary {
        background: linear-gradient(110deg, #A99045, #D8C17F);
        color: #111111;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .orders-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(169, 144, 69, .18);
    }

    .orders-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(169, 144, 69, .35);
        border-radius: .5rem;
        padding: .5rem .75rem;
        color: #D8C17F;
        font-size: 9px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .12em;
        transition: background .25s ease, border-color .25s ease;
    }

    .orders-action:hover {
        border-color: #A99045;
        background: rgba(169, 144, 69, .10);
    }

    .orders-table thead {
        background: #191919;
    }

    .orders-table th {
        color: rgba(255, 255, 255, .45);
        font-size: 9px;
        font-weight: 900;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .orders-table tbody tr {
        border-top: 1px solid rgba(255, 255, 255, .06);
        transition: background .2s ease;
    }

    .orders-table tbody tr:hover {
        background: rgba(169, 144, 69, .035);
    }

    .orders-table td {
        vertical-align: middle;
    }
</style>

<div class="orders-page">

    @if($modoMiCuenta ?? false)

        <div class="w-full max-w-7xl">

            {{-- ENCABEZADO DE MI CUENTA --}}
            <div class="mb-8">

                <a
                    href="{{ route('mi-cuenta') }}"
                    class="inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-[0.2em] text-white/40 transition hover:text-[#D8C17F]"
                >
                    <span aria-hidden="true">←</span>
                    MI CUENTA
                </a>

                <div class="mt-5 flex items-center gap-3">
                    <span class="orders-heading-line w-10"></span>

                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D8C17F]">
                        Historial personal
                    </p>
                </div>

                <h1 class="mt-3 text-3xl font-black uppercase tracking-[0.12em] text-white sm:text-4xl">
                    Mis pedidos
                </h1>

                <p class="mt-2 text-[10px] font-bold uppercase tracking-[0.16em] text-white/40">
                    Historial de pedidos de tu cuenta
                </p>

                <a
                    href="{{ route('productos.index') }}"
                    class="orders-primary mt-5 inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 text-[10px] font-black uppercase tracking-[0.15em]"
                >
                    <span aria-hidden="true">+</span>
                    Crear pedido
                </a>

            </div>

            {{-- MENSAJE DE ÉXITO --}}
            @if(session('success'))
                <div class="mb-6 rounded-xl border border-green-500/25 bg-green-500/[0.08] px-4 py-3 text-sm font-semibold text-green-300">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ERRORES --}}
            @if($errors->any())
                <div class="mb-6 rounded-xl border border-rose-500/25 bg-rose-500/[0.08] px-4 py-3 text-sm text-rose-200">
                    <ul class="list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TABLA DE PEDIDOS DEL CLIENTE --}}
            <div class="orders-panel">

                <div class="overflow-x-auto">
                    <table class="orders-table w-full text-left">

                        <thead>
                            <tr>
                                <th class="px-6 py-4">Pedido</th>
                                <th class="px-6 py-4">Fecha</th>
                                <th class="px-6 py-4">Estado</th>
                                <th class="px-6 py-4">Productos</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pedidos as $pedido)

                                <tr>

                                    <td class="whitespace-nowrap px-6 py-4 text-xs font-black text-white">
                                        #{{ $pedido->id_pedido }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-[11px] text-white/70">
                                        {{ $pedido->fecha_pedido?->format('d/m/Y H:i') ?? 'SIN FECHA' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4">
                                        <span class="inline-flex rounded-full border border-[#A99045]/30 bg-[#A99045]/[0.08] px-3 py-1.5 text-[9px] font-black uppercase tracking-wider text-[#D8C17F]">
                                            {{ $pedido->estado?->nombre ?? 'SIN ESTADO' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-[11px] text-white/70">
                                        {{ $pedido->detalles_count }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-4 text-xs font-black text-[#D8C17F]">
                                        ${{ number_format((float) $pedido->total, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap items-center gap-2">

                                            <a
                                                href="{{ route('mi-cuenta.pedidos.show', $pedido) }}"
                                                class="orders-action"
                                            >
                                                Ver detalle
                                            </a>

                                            @if(strtolower(trim($pedido->estado?->nombre ?? '')) === 'pendiente')

                                                <form
                                                    method="POST"
                                                    action="{{ route('mi-cuenta.pedidos.cancelar', $pedido) }}"
                                                    onsubmit="return confirm('¿Seguro que deseas cancelar el pedido #{{ $pedido->id_pedido }}? Se conservará su historial.');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex items-center justify-center rounded-lg border border-rose-400/30 px-3 py-2 text-[9px] font-black uppercase tracking-widest text-rose-300 transition hover:border-rose-400/60 hover:bg-rose-500/[0.08]"
                                                    >
                                                        Cancelar pedido
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
                                        class="px-6 py-12 text-center text-[10px] font-bold uppercase tracking-[0.15em] text-white/30"
                                    >
                                        Todavía no tienes pedidos
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>

        </div>

    @else

        <div class="space-y-6">

            {{-- ENCABEZADO --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="mb-3 flex items-center gap-3">
                        <span class="orders-heading-line w-8"></span>

                        <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#D8C17F]">
                            Administración
                        </p>
                    </div>

                    <h1 class="text-2xl font-black uppercase tracking-tight text-white sm:text-3xl">
                        Pedidos
                    </h1>

                    <p class="mt-2 text-sm text-white/45">
                        Administra los pedidos registrados en el sistema.
                    </p>
                </div>

                @if(auth()->check() && auth()->user()->tienePermiso('pedidos.crear'))

                    <a
                        href="{{ route('pedidos.create') }}"
                        class="orders-primary inline-flex items-center justify-center rounded-full px-5 py-3 text-[10px] font-black uppercase tracking-[0.15em]"
                    >
                        Nuevo pedido
                    </a>

                @endif

            </div>

            {{-- MENSAJE DE ÉXITO --}}
            @if(session('success'))

                <div class="rounded-xl border border-green-500/20 bg-green-500/[0.08] px-4 py-3 text-sm text-green-300">
                    {{ session('success') }}
                </div>

            @endif

            {{-- ERRORES --}}
            @if($errors->any())

                <div class="rounded-xl border border-rose-500/20 bg-rose-500/[0.08] px-4 py-3 text-sm text-rose-300">

                    <ul class="list-inside list-disc space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>

            @endif

            {{-- TABLA DE ADMINISTRACIÓN --}}
            <div class="orders-panel">

                <div class="overflow-x-auto">

                    <table class="orders-table min-w-full text-left text-sm text-white/70">

                        <thead>
                            <tr>
                                <th class="px-5 py-4">ID</th>
                                <th class="px-5 py-4">Cliente</th>
                                <th class="px-5 py-4">Usuario</th>
                                <th class="px-5 py-4">Estado</th>
                                <th class="px-5 py-4">Total</th>
                                <th class="px-5 py-4">Fecha</th>
                                <th class="px-5 py-4 text-right">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($pedidos as $pedido)

                                <tr>

                                    {{-- ID --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-xs font-bold text-white/40">
                                        {{ $pedido->id_pedido }}
                                    </td>

                                    {{-- CLIENTE --}}
                                    <td class="px-5 py-4 text-sm text-white">

                                        @if($pedido->cliente)

                                            {{ $pedido->cliente->nombre }}

                                        @else

                                            <span class="text-white/35">
                                                Sin cliente
                                            </span>

                                        @endif

                                    </td>

                                    {{-- USUARIO --}}
                                    <td class="px-5 py-4 text-sm">

                                        @if($pedido->usuario)

                                            {{ $pedido->usuario->nombre }}

                                        @else

                                            <span class="text-white/35">
                                                Sin usuario
                                            </span>

                                        @endif

                                    </td>

                                    {{-- ESTADO --}}
                                    <td class="px-5 py-4">

                                        @if($pedido->estado)

                                            <span class="inline-flex rounded-full border border-[#A99045]/30 bg-[#A99045]/[0.08] px-3 py-1.5 text-[9px] font-bold uppercase tracking-wider text-[#D8C17F]">
                                                {{ $pedido->estado->nombre }}
                                            </span>

                                        @else

                                            <span class="text-white/35">
                                                Sin estado
                                            </span>

                                        @endif

                                    </td>

                                    {{-- TOTAL --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-black text-[#D8C17F]">
                                        ${{ number_format($pedido->total ?? 0, 2) }}
                                    </td>

                                    {{-- FECHA --}}
                                    <td class="whitespace-nowrap px-5 py-4 text-xs text-white/55">

                                        @if($pedido->created_at)

                                            {{ $pedido->created_at->format('d/m/Y H:i') }}

                                        @else

                                            <span class="text-white/35">
                                                —
                                            </span>

                                        @endif

                                    </td>

                                    {{-- ACCIONES --}}
                                    <td class="px-5 py-4 text-right">

                                        <div class="flex flex-wrap items-center justify-end gap-3">

                                            @if(auth()->check() && auth()->user()->tienePermiso('pedidos.ver'))

                                                <a
                                                    href="{{ route('pedidos.show', $pedido) }}"
                                                    class="text-xs font-bold text-[#D8C17F] transition hover:text-white"
                                                >
                                                    Ver
                                                </a>

                                            @endif

                                            @if(auth()->check() && auth()->user()->tienePermiso('pedidos.editar'))

                                                <a
                                                    href="{{ route('pedidos.edit', $pedido) }}"
                                                    class="text-xs font-bold text-[#A99045] transition hover:text-[#D8C17F]"
                                                >
                                                    Editar
                                                </a>

                                            @endif

                                            @if(auth()->check() && auth()->user()->tienePermiso('pedidos.cancelar'))

                                                <form
                                                    method="POST"
                                                    action="{{ route('pedidos.destroy', $pedido) }}"
                                                    class="inline"
                                                >

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        onclick="return confirm('¿Eliminar este pedido?')"
                                                        class="text-xs font-bold text-rose-300 transition hover:text-rose-200"
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
                                        colspan="7"
                                        class="px-5 py-10 text-center text-sm text-white/35"
                                    >
                                        No hay pedidos registrados.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection