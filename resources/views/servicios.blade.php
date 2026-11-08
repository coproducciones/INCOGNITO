
@extends('layouts.app')

@section('title', 'Servicios | Incógnito Group Design')

@section('content')

@include('Servicios._estilos')

@php
    // Contexto del usuario para mostrar acciones de gestión en el catálogo.
    // Los visitantes sin sesión solo ven productos y datos de contacto.
    $usuarioCatalogo = auth()->user();

    $esAdminGlobal = $usuarioCatalogo?->esAdministradorGlobal() ?? false;

    $miProveedorId = ($usuarioCatalogo && $usuarioCatalogo->tienePermiso('productos.editar'))
        ? $usuarioCatalogo->proveedor()->value('id_proveedor')
        : null;

    $puedeCrearProducto = $usuarioCatalogo
        && $usuarioCatalogo->tienePermiso('productos.crear')
        && ($esAdminGlobal || $miProveedorId !== null);

    $enlaceGestion = null;
    if ($esAdminGlobal && Route::has('productos.index')) {
        $enlaceGestion = ['url' => route('productos.index'), 'texto' => 'Gestión de productos'];
    } elseif ($miProveedorId !== null && Route::has('mis-productos.index')
        && $usuarioCatalogo->tienePermiso('productos.ver')) {
        $enlaceGestion = ['url' => route('mis-productos.index'), 'texto' => 'Mis productos'];
    }
@endphp

<div class="services-page relative min-h-screen overflow-hidden">

    {{-- Fondo decorativo --}}
    <div
        class="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
        aria-hidden="true"
    >
        <div class="absolute -top-40 left-1/2 h-[28rem] w-[48rem] -translate-x-1/2 rounded-full bg-[#A99045]/10 blur-[120px]"></div>
        <div class="absolute top-[35rem] -left-40 h-96 w-96 rounded-full bg-[#9E2428]/10 blur-[110px]"></div>
        <div class="absolute right-[-8rem] top-[65rem] h-96 w-96 rounded-full bg-[#A99045]/10 blur-[110px]"></div>
        <div class="absolute inset-0 opacity-[0.035] [background-image:linear-gradient(rgba(216,193,127,0.5)_1px,transparent_1px),linear-gradient(90deg,rgba(216,193,127,0.5)_1px,transparent_1px)] [background-size:44px_44px]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#151515]/10 via-[#151515]/50 to-[#151515]"></div>
    </div>

    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-8">

        {{-- Encabezado --}}
        <header class="mx-auto mb-16 max-w-4xl text-center">

            <span class="eyebrow">
                <span class="h-2 w-2 rounded-full bg-[#D8C17F]"></span>
                Incognito Group Design and Much
            </span>

            <p class="section-label mt-8 mb-4">
                Creatividad · Calidad · Identidad
            </p>

            <h1 class="text-4xl font-black uppercase leading-tight tracking-tight sm:text-5xl lg:text-7xl">
                Nuestros
                <span class="gold-text">Servicios</span>
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-300 sm:text-lg">
                Explora nuestro catálogo de productos y servicios.
                Encuentra lo que necesitas y contáctanos para recibir
                más información.
            </p>

            <div class="mx-auto mt-8 h-px w-32 bg-gradient-to-r from-transparent via-[#A99045] to-transparent"></div>

        </header>

        {{-- ======================================================
             CATEGORÍAS
        ======================================================= --}}
        <section class="mb-14" aria-labelledby="categorias-titulo">

            <div class="mb-6">
                <p class="section-label mb-2">Explora el catálogo</p>

                <h2 id="categorias-titulo" class="text-2xl font-bold sm:text-3xl">
                    Categorías
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-400">
                    Selecciona una categoría para filtrar productos y proveedores disponibles.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">

                <a
                    href="{{ route('servicios') }}"
                    @class([
                        'category-link',
                        'active' => !$categoriaId,
                    ])
                    @if (!$categoriaId) aria-current="page" @endif
                >
                    <span>Todas las categorías</span>

                    <span class="rounded-full bg-white/10 px-2.5 py-1 text-xs">
                        {{ $categorias->sum('productos_count') + $categorias->sum('proveedores_count') }}
                    </span>
                </a>

                @foreach ($categorias as $categoria)
                    <a
                        href="{{ route('servicios', ['categoria' => $categoria->id]) }}"
                        @class([
                            'category-link',
                            'active' => (string) $categoriaId === (string) $categoria->id,
                        ])
                        @if ((string) $categoriaId === (string) $categoria->id)
                            aria-current="page"
                        @endif
                    >
                        <span class="min-w-0">
                            <span class="block truncate font-semibold">
                                {{ $categoria->nombre }}
                            </span>

                            @if ($categoria->descripcion)
                                <span class="mt-1 block truncate text-xs text-gray-500">
                                    {{ $categoria->descripcion }}
                                </span>
                            @endif
                        </span>

                        <span class="shrink-0 rounded-full bg-white/10 px-2.5 py-1 text-xs">
                            {{ $categoria->productos_count + $categoria->proveedores_count }}
                        </span>
                    </a>
                @endforeach

            </div>
        </section>

        {{-- ======================================================
             PROVEEDORES
             Ahora aparecen antes de los productos.
        ======================================================= --}}
        <section class="mt-20" aria-labelledby="proveedores-titulo">

            <div class="mb-7 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">

                <div>
                    <p class="section-label mb-2">Talento y profesionales</p>

                    <h2 id="proveedores-titulo" class="text-2xl font-bold sm:text-3xl">
                        Nuestros proveedores
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-400">
                        Encuentra profesionales por su nombre, especialidad o categoría.
                    </p>
                </div>

                <form
                    method="GET"
                    action="{{ route('servicios') }}"
                    class="flex w-full flex-col gap-2 sm:flex-row lg:max-w-xl"
                >
                    @if($categoriaId)
                        <input type="hidden" name="categoria" value="{{ $categoriaId }}">
                    @endif

                    <label for="buscar-proveedor" class="sr-only">
                        Buscar proveedores
                    </label>

                    <input
                        id="buscar-proveedor"
                        type="search"
                        name="q"
                        value="{{ $busqueda }}"
                        maxlength="100"
                        placeholder="Nombre, especialidad o servicio..."
                        class="min-w-0 flex-1 rounded-full border border-white/15 bg-[#1D1D1D] px-5 py-3 text-sm text-white placeholder:text-gray-500 focus:border-[#D8C17F] focus:outline-none"
                    >

                    <button type="submit" class="gold-button">
                        Buscar
                    </button>

                    @if($busqueda !== '')
                        <a
                            href="{{ route('servicios', $categoriaId ? ['categoria' => $categoriaId] : []) }}"
                            class="outline-button"
                        >
                            Limpiar
                        </a>
                    @endif
                </form>

            </div>

            @if($proveedores->count())

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

                    @foreach($proveedores as $proveedor)

                        <article class="service-card flex h-full flex-col p-6">

                            <div class="mb-5 flex items-start gap-4">

                                @if($proveedor->foto_url)
                                    <img
                                        src="{{ $proveedor->foto_url }}"
                                        alt="Imagen del proveedor"
                                        loading="lazy"
                                        class="h-16 w-16 shrink-0 rounded-xl border border-[#A99045]/30 object-cover"
                                    >
                                @else
                                    <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#A99045]/10 text-2xl text-[#D8C17F]">
                                        ✦
                                    </div>
                                @endif

                                <div class="min-w-0">
                                    <h3 class="text-lg font-bold text-[#F5F3ED]">
                                        {{ $proveedor->usuario?->nombre ?: 'Proveedor independiente' }}
                                    </h3>

                                    <p class="mt-1 text-sm text-[#D8C17F]">
                                        {{ $proveedor->especialidad }}
                                    </p>
                                </div>

                            </div>

                            <p class="mb-5 flex-1 text-sm leading-7 text-gray-400">
                                {{ $proveedor->descripcion
                                    ? \Illuminate\Support\Str::limit($proveedor->descripcion, 160)
                                    : 'Consulta el perfil para conocer más sobre sus servicios.' }}
                            </p>

                            <div class="mb-5 flex flex-wrap gap-2">
                                @foreach($proveedor->categorias as $categoriaProveedor)
                                    <a
                                        href="{{ route('servicios', ['categoria' => $categoriaProveedor->id]) }}"
                                        class="rounded-full border border-[#A99045]/30 bg-[#A99045]/10 px-3 py-1.5 text-xs font-semibold text-[#D8C17F] transition hover:bg-[#A99045]/20"
                                    >
                                        {{ $categoriaProveedor->nombre }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-auto flex flex-wrap gap-3 border-t border-white/10 pt-5">

                                <a
                                    href="{{ route('servicios.proveedor', $proveedor->id_proveedor) }}"
                                    class="outline-button"
                                >
                                    Ver perfil
                                </a>

                                @if($proveedor->whatsapp_url)
                                    <a
                                        href="{{ $proveedor->whatsapp_url }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="gold-button"
                                    >
                                        WhatsApp
                                    </a>
                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

                {{-- Paginación de proveedores --}}
                <div class="mt-8">
                    {{ $proveedores->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-[#A99045]/25 bg-[#1D1D1D] px-6 py-12 text-center">
                    <h3 class="text-lg font-bold text-[#F5F3ED]">
                        No encontramos proveedores
                    </h3>

                    <p class="mx-auto mt-2 max-w-lg text-sm leading-7 text-gray-400">
                        Prueba con otra categoría o modifica el texto de búsqueda.
                    </p>
                </div>

            @endif

        </section>

        {{-- ======================================================
             CATÁLOGO DE PRODUCTOS
        ======================================================= --}}
        <section class="mt-20" aria-labelledby="productos-titulo">

            <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="section-label mb-2">Selección de la casa</p>

                    <h2 id="productos-titulo" class="text-2xl font-bold sm:text-3xl">
                        Nuestro catálogo
                    </h2>
                </div>

                <div class="flex flex-wrap items-center gap-3">

                    <p class="text-sm text-gray-400">
                        {{ $productos->total() }}
                        {{ $productos->total() === 1 ? 'producto disponible' : 'productos disponibles' }}
                    </p>

                    @if ($enlaceGestion)
                        <a href="{{ $enlaceGestion['url'] }}" class="outline-button">
                            {{ $enlaceGestion['texto'] }}
                        </a>
                    @endif

                    @if ($puedeCrearProducto)
                        <a href="{{ route('productos.create') }}" class="gold-button">
                            <span aria-hidden="true">+</span>
                            Crear producto
                        </a>
                    @endif

                </div>

            </div>

            @if ($productos->count())

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($productos as $producto)

                    @include('Servicios._producto-card', [
                        'producto' => $producto,
                        'esAdminGlobal' => $esAdminGlobal,
                        'miProveedorId' => $miProveedorId,
                    ])

                    @endforeach

                </div>

                {{-- Paginación de productos --}}
                <div class="mt-10">
                    {{ $productos->links() }}
                </div>

            @else

                <div class="rounded-2xl border border-[#A99045]/25 bg-[#1D1D1D] px-6 py-14 text-center">

                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-[#A99045]/30 bg-[#A99045]/10 text-3xl text-[#D8C17F]">
                        ✦
                    </div>

                    <h3 class="text-xl font-bold text-[#F5F3ED]">
                        No hay productos para mostrar
                    </h3>

                    <p class="mx-auto mt-3 max-w-lg text-sm leading-7 text-gray-400">
                        En este momento no encontramos productos activos en esta categoría.
                        Puedes explorar las demás categorías del catálogo.
                    </p>

                    <a href="{{ route('servicios') }}" class="gold-button mt-6">
                        Ver todos los productos
                    </a>

                </div>

            @endif

        </section>

        {{-- ======================================================
             CONTACTO
        ======================================================= --}}
        <section class="relative mt-20 overflow-hidden rounded-3xl border border-[#A99045]/30 bg-[#1D1D1D] px-6 py-12 text-center sm:px-12">

            <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full bg-[#A99045]/10 blur-[90px]"></div>

            <p class="section-label mb-4">
                Atención personalizada
            </p>

            <h2 class="relative text-2xl font-black uppercase sm:text-3xl">
                ¿Tienes un proyecto en mente?
            </h2>

            <p class="relative mx-auto mt-4 max-w-xl text-sm leading-7 text-gray-400">
                Cuéntanos qué necesitas. Nuestro equipo te ayudará a encontrar
                una solución adecuada para tu proyecto.
            </p>

            <a
                href="https://wa.me/{{ config('services.whatsapp.empresa_numero') }}?text={{ rawurlencode('Hola, Incognito Group Design. Quiero información sobre sus productos y servicios.') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="gold-button relative mt-8"
            >
                Hablemos por WhatsApp
                <span aria-hidden="true">↗</span>
            </a>

        </section>

    </div>
</div>

@endsection
