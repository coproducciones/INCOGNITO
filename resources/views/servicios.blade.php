@extends('layouts.app')

@section('title', 'Servicios | Incógnito Group Design')

@section('content')

<style>
    .services-page {
        --gold: #A99045;
        --gold-light: #D8C17F;
        --cream: #F5F3ED;
        --panel: #1D1D1D;
        background: #151515;
        color: var(--cream);
        isolation: isolate;
    }

    .services-page .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .65rem;
        padding: .65rem 1rem;
        border: 1px solid rgba(169,144,69,.4);
        border-radius: 999px;
        background: rgba(169,144,69,.08);
        color: var(--gold-light);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .18em;
        text-transform: uppercase;
    }

    .services-page .section-label {
        color: var(--gold-light);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .2em;
        text-transform: uppercase;
    }

    .services-page .gold-text {
        color: var(--gold-light);
    }

    .services-page .service-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(169,144,69,.24);
        border-radius: 1.2rem;
        background: linear-gradient(
            145deg,
            rgba(255,255,255,.045),
            rgba(255,255,255,.012)
        );
        transition: transform .25s ease, border-color .25s ease,
                    box-shadow .25s ease;
    }

    .services-page .service-card::before {
        position: absolute;
        top: 0;
        left: 12%;
        right: 12%;
        height: 1px;
        background: linear-gradient(
            90deg, transparent, rgba(216,193,127,.8), transparent
        );
        content: "";
    }

    .services-page .service-card:hover {
        transform: translateY(-5px);
        border-color: rgba(216,193,127,.65);
        box-shadow: 0 18px 42px rgba(0,0,0,.28);
    }

    .services-page .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .75rem;
        padding: .85rem 1rem;
        border: 1px solid rgba(255,255,255,.09);
        border-radius: .85rem;
        background: rgba(255,255,255,.025);
        color: #d1d1d1;
        font-size: .875rem;
        transition: all .2s ease;
    }

    .services-page .category-link:hover,
    .services-page .category-link.active {
        border-color: rgba(216,193,127,.55);
        background: rgba(169,144,69,.12);
        color: var(--gold-light);
    }

    .services-page .gold-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        border: 1px solid rgba(216,193,127,.65);
        border-radius: 999px;
        background: var(--gold);
        padding: .75rem 1.25rem;
        color: #151515;
        font-size: .8rem;
        font-weight: 800;
        transition: all .25s ease;
    }

    .services-page .gold-button:hover {
        transform: translateY(-2px);
        background: var(--gold-light);
        box-shadow: 0 8px 24px rgba(169,144,69,.18);
    }

    .services-page .outline-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .4rem;
        border: 1px solid rgba(216,193,127,.35);
        border-radius: 999px;
        padding: .7rem 1rem;
        color: var(--gold-light);
        font-size: .8rem;
        font-weight: 700;
        transition: all .25s ease;
    }

    .services-page .outline-button:hover {
        border-color: var(--gold-light);
        background: rgba(169,144,69,.1);
    }

    .services-page a:focus-visible {
        outline: 2px solid var(--gold-light);
        outline-offset: 4px;
    }

    @media (prefers-reduced-motion: reduce) {
        .services-page *,
        .services-page *::before,
        .services-page *::after {
            transition-duration: .01ms !important;
        }
    }
</style>

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

        {{-- Categorías --}}
        <section class="mb-14" aria-labelledby="categorias-titulo">

            <div class="mb-6">
                <p class="section-label mb-2">Explora el catálogo</p>

                <h2 id="categorias-titulo" class="text-2xl font-bold sm:text-3xl">
                    Categorías
                </h2>

                <p class="mt-2 text-sm leading-6 text-gray-400">
                    Selecciona una categoría para filtrar los productos disponibles.
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
                        {{ $categorias->sum('productos_count') }}
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
                            {{ $categoria->productos_count }}
                        </span>
                    </a>
                @endforeach

            </div>
        </section>

        {{-- Catálogo de productos --}}
        <section aria-labelledby="productos-titulo">

            <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="section-label mb-2">Selección de la casa</p>

                    <h2 id="productos-titulo" class="text-2xl font-bold sm:text-3xl">
                        Nuestro catálogo
                    </h2>
                </div>

                <p class="text-sm text-gray-400">
                    {{ $productos->total() }}
                    {{ $productos->total() === 1 ? 'producto disponible' : 'productos disponibles' }}
                </p>

            </div>

            @if ($productos->count())

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    @foreach ($productos as $producto)

                        <article class="service-card flex h-full flex-col p-6">

                            @php
                                $portada = $producto->media->first();
                                $urlPortada = $portada?->url_publica;
                                $tipoPortada = strtolower((string) ($portada?->tipo ?? ''));
                            @endphp

                            {{-- Imagen o video cargado desde el panel de multimedia --}}
                            <div class="mb-5 overflow-hidden rounded-xl border border-white/10 bg-[#151515]">
                                @if ($portada && in_array($tipoPortada, ['imagen', 'image', 'img']))
                                    <img src="{{ $urlPortada }}"
                                         alt="{{ $producto->nombre }}"
                                         loading="lazy"
                                         class="h-52 w-full object-cover"
                                         onerror="this.style.display='none';">
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

                                @if ($producto->stock > 0)
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
                                        href="{{ route('servicios.detalle', $producto) }}"
                                        class="outline-button"
                                    >
                                        Ver detalles
                                        <span aria-hidden="true">↗</span>
                                    </a>

                                    <a
                                        href="https://wa.me/573114531914?text={{ rawurlencode('Hola, Incognito Group Design. Quiero información sobre: ' . $producto->nombre . '.') }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="gold-button"
                                    >
                                        Consultar
                                        <span aria-hidden="true">↗</span>
                                    </a>

                                </div>

                            </div>

                        </article>

                    @endforeach

                </div>

                {{-- Paginación --}}
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

        {{-- Contacto --}}
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
                href="https://wa.me/573114531914?text={{ rawurlencode('Hola, Incognito Group Design. Quiero información sobre sus productos y servicios.') }}"
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