@extends('layouts.app')

@section('title', 'Pedidos de mi proveedor')

@section('content')
<div class="mx-auto w-full max-w-7xl px-4 py-8">
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-amber-400">Panel del proveedor</p>
        <h1 class="mt-2 text-2xl font-black uppercase tracking-wider text-white">Pedidos recibidos</h1>
        <p class="mt-2 text-sm text-gray-400">Aquí aparecen únicamente los pedidos que contienen productos de tu catálogo.</p>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300" role="status">{{ session('success') }}</div>
    @endif

    <div class="overflow-hidden rounded-lg border border-white/10 bg-neutral-900">
        @forelse($pedidos as $pedido)
            <a href="{{ route('proveedor.pedidos.show', $pedido->id_pedido) }}" class="block border-b border-white/10 p-5 transition hover:bg-white/5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="font-black text-white">Pedido #{{ $pedido->id_pedido }}</p>
                        <p class="mt-1 text-xs text-gray-400">Cliente: {{ $pedido->usuario?->nombre ?? 'No disponible' }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $pedido->fecha_pedido?->format('d/m/Y H:i') ?? 'Fecha no disponible' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs uppercase tracking-wider text-gray-500">Estado general</p>
                        <p class="mt-1 text-sm font-bold text-amber-300">{{ $pedido->estado?->nombre ?? 'Sin estado' }}</p>
                        <p class="mt-2 text-xs text-amber-400">Ver mis productos y actualizar estado →</p>
                    </div>
                </div>
            </a>
        @empty
            <div class="p-10 text-center text-sm text-gray-400">Todavía no tienes pedidos asociados a tus productos.</div>
        @endforelse
    </div>

    <div class="mt-6">{{ $pedidos->links() }}</div>
</div>
@endsection
