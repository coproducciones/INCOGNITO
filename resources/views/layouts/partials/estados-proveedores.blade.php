@if(($modoMiCuenta ?? false) && ($proveedores ?? collect())->isNotEmpty())
    <section class="mb-8 rounded-lg border border-white/10 bg-[#1D1D1D] p-5">
        <h2 class="text-xs font-black uppercase tracking-widest text-white">Avance por proveedor</h2>
        <p class="mb-4 mt-2 text-xs leading-relaxed text-gray-400">Cada proveedor actualiza únicamente los productos que le corresponden. El estado general del pedido se conserva por separado.</p>

        @foreach($proveedores as $proveedor)
            @php
                $registroEstado = ($estadosProveedores ?? collect())->get($proveedor->id_proveedor);
                $nombreEstado = $registroEstado?->estado?->nombre ?? 'Pendiente';
                $eventosProveedor = ($historialEstadosProveedores ?? collect())
                    ->where('id_proveedor', $proveedor->id_proveedor);
            @endphp
            <div class="border-t border-white/10 py-4 first:border-0 first:pt-0 last:pb-0">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <p class="text-sm font-bold text-white">{{ $proveedor->usuario?->nombre ?? ('Proveedor #' . $proveedor->id_proveedor) }}</p>
                    <span class="rounded bg-amber-400/10 px-3 py-1 text-xs font-bold text-amber-300">{{ $nombreEstado }}</span>
                </div>
                @if($registroEstado?->updated_at)
                    <p class="mt-1 text-[11px] text-gray-500">Última actualización: {{ $registroEstado->updated_at->format('d/m/Y H:i') }}</p>
                @endif
                @if($eventosProveedor->isNotEmpty())
                    <div class="mt-3 space-y-2">
                        @foreach($eventosProveedor as $evento)
                            <div class="border-l-2 border-amber-400/40 pl-3">
                                <p class="text-xs font-semibold text-gray-300">{{ $evento->estado?->nombre ?? 'Actualización' }}</p>
                                @if($evento->comentario)<p class="mt-1 text-xs text-gray-400">{{ $evento->comentario }}</p>@endif
                                <p class="mt-1 text-[10px] text-gray-600">{{ $evento->fecha?->format('d/m/Y H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </section>
@endif
