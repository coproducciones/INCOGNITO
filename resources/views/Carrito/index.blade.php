@extends('layouts.app')

@section('title', 'Mi carrito')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <p class="text-xs font-semibold tracking-[0.25em] text-[#00c896] uppercase">Mi compra</p>
            <h1 class="text-3xl font-bold text-white mt-2">Carrito de compras</h1>
            <p class="text-gray-400 mt-2">Revisa los productos antes de confirmar tu pedido.</p>
        </div>

        <a href="{{ route('productos.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition">
            ← Seguir comprando
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-xl border border-[#00c896]/30 bg-[#00c896]/10 px-4 py-3 text-sm text-[#8ff0d3]">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-200">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($items->isEmpty())
        <div class="rounded-2xl border border-white/10 bg-white/[0.03] p-10 text-center">
            <div class="text-5xl mb-4">🛒</div>
            <h2 class="text-xl font-semibold text-white">Tu carrito está vacío</h2>
            <p class="text-gray-400 mt-2 mb-6">Agrega productos para comenzar a crear tu pedido.</p>
            <a href="{{ route('productos.index') }}"
               class="inline-flex items-center justify-center rounded-xl bg-[#00c896] px-6 py-3 text-sm font-bold text-slate-950 hover:brightness-110 transition">
                Ver productos
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-6">
            <div class="space-y-4">
                @foreach($items as $item)
                    <article class="rounded-2xl border border-white/10 bg-white/[0.03] p-5">
                        <div class="flex flex-col md:flex-row md:items-center gap-5">
                            <div class="min-w-0 flex-1">
                                <h2 class="text-lg font-semibold text-white">{{ $item['producto']->nombre }}</h2>
                                <p class="text-sm text-gray-400 mt-1">
                                    Precio unitario: ${{ number_format($item['precio'], 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Stock disponible: {{ $item['producto']->stock }}
                                </p>
                            </div>

                            <form method="POST" action="{{ route('carrito.update', $item['producto']->id) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <label class="sr-only" for="cantidad-{{ $item['producto']->id }}">Cantidad</label>
                                <input
                                    id="cantidad-{{ $item['producto']->id }}"
                                    name="cantidad"
                                    type="number"
                                    min="1"
                                    max="{{ $item['producto']->stock }}"
                                    value="{{ $item['cantidad'] }}"
                                    class="w-20 rounded-lg border border-white/10 bg-slate-900 px-3 py-2 text-center text-white focus:border-[#00c896] focus:ring-[#00c896]"
                                >
                                <button class="rounded-lg border border-white/10 px-3 py-2 text-sm font-semibold text-white hover:bg-white/10 transition">
                                    Actualizar
                                </button>
                            </form>

                            <div class="md:text-right min-w-[130px]">
                                <p class="text-lg font-bold text-white">${{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                <form method="POST" action="{{ route('carrito.remove', $item['producto']->id) }}" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-sm text-red-300 hover:text-red-200 transition">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach

                <form method="POST" action="{{ route('carrito.clear') }}" class="pt-2">
                    @csrf
                    @method('DELETE')
                    <button class="text-sm text-gray-400 hover:text-white transition">Vaciar carrito</button>
                </form>
            </div>

            <aside class="lg:sticky lg:top-6 h-fit rounded-2xl border border-white/10 bg-white/[0.03] p-6">
                <h2 class="text-lg font-semibold text-white">Resumen</h2>

                <div class="mt-6 space-y-3 text-sm">
                    <div class="flex justify-between text-gray-400">
                        <span>Productos</span>
                        <span>{{ $cantidadProductos }}</span>
                    </div>
                    <div class="flex justify-between text-gray-400">
                        <span>Subtotal</span>
                        <span>${{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="my-6 border-t border-white/10"></div>

                <div class="flex justify-between items-end gap-4">
                    <span class="text-gray-300">Total</span>
                    <span class="text-2xl font-bold text-[#00c896]">${{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <div class="mt-6 rounded-xl bg-white/5 p-4 text-xs leading-5 text-gray-400">
                    Al confirmar, el sistema volverá a validar productos y stock antes de crear el pedido.
                </div>

                <form method="POST" action="{{ route('carrito.confirmar') }}" class="mt-6">
                    @csrf
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center rounded-xl bg-[#00c896] px-5 py-3 text-sm font-bold text-slate-950 hover:brightness-110 transition">
                        Confirmar pedido
                    </button>
                </form>
            </aside>
        </div>
    @endif
</div>
@endsection
