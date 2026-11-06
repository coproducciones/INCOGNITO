@extends('layouts.app')

@section('title', 'Pedido #' . $pedido->id_pedido . ' - Proveedor')

@section('content')
<div class="mx-auto w-full max-w-5xl px-4 py-8">
    <a href="{{ route('proveedor.pedidos.index') }}" class="text-xs font-bold uppercase tracking-widest text-amber-400">← Volver a mis pedidos</a>

    <div class="mb-8 mt-5">
        <p class="text-xs font-bold uppercase tracking-widest text-amber-400">Gestión del proveedor</p>
        <h1 class="mt-2 text-2xl font-black uppercase tracking-wider text-white">Pedido #{{ $pedido->id_pedido }}</h1>
        <p class="mt-2 text-sm text-gray-400">Cliente: {{ $pedido->usuario?->nombre ?? 'No disponible' }}</p>
        <p class="mt-1 text-xs text-gray-500">{{ $pedido->fecha_pedido?->format('d/m/Y H:i') ?? 'Fecha no disponible' }}</p>
    </div>

    @if(session('success'))
        <div class="mb-5 rounded border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm text-green-300" role="status">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-5 rounded border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300" role="alert">
            <ul class="list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <section class="mb-8 rounded-lg border border-white/10 bg-neutral-900 p-5">
        <h2 class="mb-4 text-sm font-black uppercase tracking-wider text-white">Tus productos en este pedido</h2>
        <div class="divide-y divide-white/10">
            @foreach($pedido->detalles as $detalle)
                <div class="flex items-center justify-between gap-4 py-3">
                    <div>
                        <p class="text-sm font-bold text-white">{{ $detalle->producto?->nombre ?? 'Producto no disponible' }}</p>
                        <p class="mt-1 text-xs text-gray-400">Cantidad: {{ $detalle->cantidad }}</p>
                    </div>
                    <p class="text-sm font-semibold text-amber-300">${{ number_format((float) $detalle->subtotal, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="mb-8 rounded-lg border border-amber-400/20 bg-neutral-900 p-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-sm font-black uppercase tracking-wider text-white">Estado de tus productos</h2>
                <p class="mt-2 text-lg font-black text-amber-300">{{ $estadoActualNombre }}</p>
            </div>
            <p class="text-xs text-gray-400">El estado general del pedido del cliente no se modifica desde aquí.</p>
        </div>

        @if($estadoSiguiente && mb_strtolower((string) $pedido->estado?->nombre) !== 'cancelado')
            <form method="POST" action="{{ route('proveedor.pedidos.estado.update', $pedido->id_pedido) }}" class="mt-5 space-y-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id_estado" value="{{ $estadoSiguiente->id_estado }}">
                <div>
                    <label for="comentario" class="mb-2 block text-xs font-bold uppercase tracking-wider text-gray-400">Comentario para el cliente (opcional)</label>
                    <textarea id="comentario" name="comentario" rows="3" maxlength="1000" class="w-full rounded border border-white/10 bg-black/30 p-3 text-sm text-white" placeholder="Ej.: Estamos preparando tu pedido.">{{ old('comentario') }}</textarea>
                </div>
                <button type="submit" class="rounded bg-amber-400 px-5 py-3 text-xs font-black uppercase tracking-wider text-black transition hover:bg-amber-300">
                    Actualizar a: {{ $estadoSiguiente->nombre }}
                </button>
            </form>
        @else
            <p class="mt-5 rounded bg-white/5 p-4 text-sm text-gray-400">No hay más cambios de estado disponibles para este proveedor.</p>
        @endif
    </section>

    <section class="rounded-lg border border-white/10 bg-neutral-900 p-5">
        <h2 class="mb-4 text-sm font-black uppercase tracking-wider text-white">Historial de este proveedor</h2>
        @forelse($pedido->historialProveedor as $evento)
            <div class="border-b border-white/10 py-4 last:border-0">
                <p class="text-xs font-black uppercase tracking-wider text-amber-300">{{ $evento->estado?->nombre ?? 'Estado actualizado' }}</p>
                <p class="mt-1 text-xs text-gray-400">Actualizado por {{ $evento->usuario?->nombre ?? 'Proveedor' }}</p>
                @if($evento->comentario)<p class="mt-2 text-sm text-gray-300">{{ $evento->comentario }}</p>@endif
                <p class="mt-2 text-[11px] text-gray-500">{{ $evento->fecha?->format('d/m/Y H:i') }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-400">Todavía no se han registrado cambios de estado.</p>
        @endforelse
    </section>
</div>
@endsection
