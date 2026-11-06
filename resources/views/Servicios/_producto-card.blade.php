{{--
    Tarjeta de producto del catálogo (Servicios).

    Variables:
      $producto       Producto (con categoria, media y proveedor cargados).
      $esAdminGlobal  true si el usuario es administrador global.
      $miProveedorId  id_proveedor del usuario autenticado (o null).
      $modoProveedor  (opcional) true en "Mis productos": muestra estado y activar/desactivar.
--}}
@php
    $modoProveedor = $modoProveedor ?? false;

    $puedeEditarProducto = auth()->check()
        && auth()->user()->tienePermiso('productos.editar')
        && ($esAdminGlobal
            || ($miProveedorId !== null
                && (int) $miProveedorId === (int) $producto->id_proveedor));
@endphp
<article class="service-card flex h-full flex-col p-6">

    @php
        $portada = $producto->media->first();
        $urlPortada = $portada?->url_publica;
        $tipoPortada = strtolower((string) ($portada?->tipo ?? ''));
    @endphp

    {{-- Imagen o video del producto --}}
    <div class="mb-5 overflow-hidden rounded-xl border border-white/10 bg-[#151515]">

        @if ($portada && in_array($tipoPortada, ['imagen', 'image', 'img']))
            <img
                src="{{ $urlPortada }}"
                alt="{{ $producto->nombre }}"
                loading="lazy"
                class="h-52 w-full object-cover"
                onerror="this.style.display='none';"
            >

        @elseif ($portada && in_array($tipoPortada, ['video', 'mp4', 'webm', 'mov', 'video/mp4']))
            <video class="h-52 w-full object-cover" controls preload="metadata">
                <source src="{{ $urlPortada }}">
            </video>

        @else
            <div class="flex h-52 items-center justify-center bg-gradient-to-br from-[#A99045]/20 via-[#20201E] to-[#151515] text-4xl text-[#D8C17F]">
                ✦
            </div>
        @endif

    </div>

    <div class="mb-5 flex items-start justify-between gap-3">

        <span class="rounded-full border border-[#A99045]/30 bg-[#A99045]/10 px-3 py-1.5 text-xs font-semibold text-[#D8C17F]">
            {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
        </span>

        @if ($modoProveedor && ! $producto->activo)
            <span class="text-xs font-semibold text-red-300">
                Inactivo
            </span>
        @elseif ($producto->stock > 0)
            <span class="text-xs font-medium text-green-300">
                Disponible
            </span>
        @else
            <span class="text-xs font-medium text-amber-200">
                Bajo consulta
            </span>
        @endif

    </div>

    <div class="mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-[#A99045]/30 bg-[#A99045]/10 text-2xl text-[#D8C17F]">
        <span aria-hidden="true">✦</span>
    </div>

    <h3 class="text-xl font-bold leading-snug text-[#F5F3ED]">
        {{ $producto->nombre }}
    </h3>

    <p class="mt-3 flex-1 text-sm leading-7 text-gray-400">
        @if ($producto->descripcion)
            {{ \Illuminate\Support\Str::limit($producto->descripcion, 150) }}
        @else
            Consulta con nuestro equipo para conocer más detalles sobre este producto o servicio.
        @endif
    </p>

    <div class="mt-6 border-t border-white/10 pt-5">

        <p class="mb-5 text-2xl font-black text-[#D8C17F]">
            ${{ number_format((float) $producto->precio, 0, ',', '.') }}
            <span class="text-xs font-medium text-gray-500">COP</span>
        </p>

        <div class="flex flex-wrap gap-3">

            <a
                href="{{ $modoProveedor ? route('productos.show', $producto) : route('servicios.detalle', $producto) }}"
                class="outline-button"
            >
                Ver detalles
                <span aria-hidden="true">↗</span>
            </a>

            @unless ($modoProveedor)
                <a
                    href="{{ $producto->whatsappConsultaUrl() }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="gold-button"
                >
                    Consultar
                    <span aria-hidden="true">↗</span>
                </a>
            @endunless

        </div>

        {{-- Acciones solo para el proveedor dueño del producto (o el administrador) --}}
        @if ($puedeEditarProducto)
            <div class="mt-4 flex flex-wrap gap-3 border-t border-white/10 pt-4">

                <a href="{{ route('productos.edit', $producto) }}" class="outline-button">
                    Editar
                </a>

                @if ($modoProveedor)
                    <form method="POST" action="{{ route('productos.estado', $producto) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="outline-button">
                            {{ $producto->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                    </form>
                @endif

            </div>
        @endif

    </div>

</article>