@extends('layouts.app')

@section('title', 'Gestión de pedidos')

@section('content')

@if($modoMiCuenta ?? false)

<div class="w-full max-w-7xl">

    <div class="mb-8">
        <a href="{{ route('mi-cuenta') }}"
           class="font-bold uppercase tracking-widest"
           style="font-size:9px;color:rgba(255,255,255,.4);">
            ← MI CUENTA
        </a>

        <h1 class="mt-5 font-black uppercase tracking-widest text-white"
            style="font-size:22px;letter-spacing:.15em;">
            MIS PEDIDOS
        </h1>

        <p class="mt-1 font-bold uppercase tracking-widest"
           style="font-size:10px;color:rgba(255,255,255,.4);">
            HISTORIAL DE PEDIDOS DE TU CUENTA
        </p>
        <a href="{{ route('productos.index') }}"
           class="mt-4 inline-flex items-center rounded px-5 py-3 font-black uppercase tracking-widest"
           style="font-size:10px;background:#00c896;color:#050505;">
            + CREAR PEDIDO
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
             style="font-size:10px;background:rgba(0,200,150,.1);border:1px solid rgba(0,200,150,.3);border-radius:4px;color:#00c896;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 px-4 py-3 font-bold"
             style="font-size:11px;background:rgba(248,113,113,.08);border:1px solid rgba(248,113,113,.25);border-radius:4px;color:#fca5a5;">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden"
         style="background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:6px;">

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead style="background:rgba(255,255,255,.03);">
                    <tr>
                        <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="font-size:9px;color:rgba(255,255,255,.4);">PEDIDO</th>
                        <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="font-size:9px;color:rgba(255,255,255,.4);">FECHA</th>
                        <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="font-size:9px;color:rgba(255,255,255,.4);">ESTADO</th>
                        <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="font-size:9px;color:rgba(255,255,255,.4);">PRODUCTOS</th>
                        <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="font-size:9px;color:rgba(255,255,255,.4);">TOTAL</th>
                        <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                            style="font-size:9px;color:rgba(255,255,255,.4);">ACCIÓN</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr style="border-top:1px solid rgba(255,255,255,.06);">
                            <td class="px-6 py-4 font-black text-white" style="font-size:12px;">
                                #{{ $pedido->id_pedido }}
                            </td>

                            <td class="px-6 py-4 text-white" style="font-size:11px;">
                                {{ $pedido->fecha_pedido?->format('d/m/Y H:i') ?? 'SIN FECHA' }}
                            </td>

                            <td class="px-6 py-4 font-black uppercase" style="font-size:10px;color:#fbbf24;">
                                {{ $pedido->estado?->nombre ?? 'SIN ESTADO' }}
                            </td>

                            <td class="px-6 py-4 text-white" style="font-size:11px;">
                                {{ $pedido->detalles_count }}
                            </td>

                            <td class="px-6 py-4 font-black" style="font-size:12px;color:#00c896;">
                                ${{ number_format((float) $pedido->total, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex flex-wrap items-center gap-2">
                                    <a href="{{ route('mi-cuenta.pedidos.show', $pedido) }}"
                                       class="inline-flex px-3 py-2 font-black uppercase tracking-widest"
                                       style="font-size:9px;color:#00c896;border:1px solid rgba(0,200,150,.25);border-radius:4px;">
                                        VER DETALLE
                                    </a>

                                    @if(strtolower(trim($pedido->estado?->nombre ?? '')) === 'pendiente')
                                        <form method="POST"
                                              action="{{ route('mi-cuenta.pedidos.cancelar', $pedido) }}"
                                              onsubmit="return confirm('¿Seguro que deseas cancelar el pedido #{{ $pedido->id_pedido }}? Se conservará su historial.');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex px-3 py-2 font-black uppercase tracking-widest"
                                                    style="font-size:9px;color:#fca5a5;border:1px solid rgba(248,113,113,.3);border-radius:4px;">
                                                CANCELAR PEDIDO
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center font-bold uppercase tracking-widest"
                                style="font-size:10px;color:rgba(255,255,255,.3);">
                                TODAVÍA NO TIENES PEDIDOS
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

    {{-- ============================================================
         ENCABEZADO
    ============================================================ --}}

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-white">
                Pedidos
            </h1>

            <p class="text-sm text-gray-400">
                Administra los pedidos registrados en el sistema.
            </p>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('pedidos.crear'))

            <a
                href="{{ route('pedidos.create') }}"
                class="rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:bg-[#00b085]"
            >
                Nuevo pedido
            </a>

        @endif

    </div>


    {{-- ============================================================
         MENSAJE DE ÉXITO
    ============================================================ --}}

    @if(session('success'))

        <div class="rounded-lg border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>

    @endif


    {{-- ============================================================
         ERRORES
    ============================================================ --}}

    @if($errors->any())

        <div class="rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">

            <ul class="list-inside list-disc">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- ============================================================
         TABLA
    ============================================================ --}}

    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">

        <div class="overflow-x-auto">

            <table class="min-w-full text-left text-sm text-gray-300">

                <thead class="border-b border-white/10 bg-[#1a1a1a] text-xs uppercase tracking-wider text-gray-400">

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

                <tbody class="divide-y divide-white/5">

                    @forelse($pedidos as $pedido)

                        <tr class=hover:bg-white/[0.02]>

                            {{-- ID --}}
                            <td class="px-5 py-4 text-gray-500">
                                {{ $pedido->id_pedido }}
                            </td>


                            {{-- CLIENTE --}}
                            <td class="px-5 py-4 text-white">

                                @if($pedido->cliente)

                                    {{ $pedido->cliente->nombre }}

                                @else

                                    <span class="text-gray-500">
                                        Sin cliente
                                    </span>

                                @endif

                            </td>


                            {{-- USUARIO --}}
                            <td class="px-5 py-4">

                                @if($pedido->usuario)

                                    {{ $pedido->usuario->nombre }}

                                @else

                                    <span class="text-gray-500">
                                        Sin usuario
                                    </span>

                                @endif

                            </td>


                            {{-- ESTADO --}}
                            <td class="px-5 py-4">

                                @if($pedido->estado)

                                    {{ $pedido->estado->nombre }}

                                @else

                                    <span class="text-gray-500">
                                        Sin estado
                                    </span>

                                @endif

                            </td>


                            {{-- TOTAL --}}
                            <td class="px-5 py-4 font-medium text-white">
                                ${{ number_format($pedido->total ?? 0, 2) }}
                            </td>


                            {{-- FECHA --}}
                            <td class="px-5 py-4">

                                @if($pedido->created_at)

                                    {{ $pedido->created_at->format('d/m/Y H:i') }}

                                @else

                                    <span class="text-gray-500">
                                        —
                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}
                            <td class="px-5 py-4 text-right">

                                @if(auth()->check() && auth()->user()->tienePermiso('pedidos.ver'))

                                    <a
                                        href="{{ route('pedidos.show', $pedido) }}"
                                        class="mr-3 text-blue-400 hover:text-blue-300"
                                    >
                                        Ver
                                    </a>

                                @endif


                                @if(auth()->check() && auth()->user()->tienePermiso('pedidos.editar'))

                                    <a
                                        href="{{ route('pedidos.edit', $pedido) }}"
                                        class="mr-3 text-[#00c896] hover:text-[#00b085]"
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
                                            class="text-red-400 hover:text-red-300"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-5 py-8 text-center text-gray-500"
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

@endsection
