@extends('layouts.app')

@section('title', 'Panel de gestión | Incógnito')

@section('content')
@php
    $modulos = [
        [
            'grupo' => 'Catálogo',
            'nombre' => 'Productos',
            'descripcion' => 'Administra productos, precios, existencias y estado.',
            'icono' => '▦',
            'rutas' => ['productos.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Catálogo',
            'nombre' => 'Categorías',
            'descripcion' => 'Organiza el catálogo por categorías.',
            'icono' => '◫',
            'rutas' => ['categorias.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Contenido',
            'nombre' => 'Contenidos',
            'descripcion' => 'Gestiona publicaciones y contenido del sitio.',
            'icono' => '▤',
            'rutas' => ['contenidos.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Contenido',
            'nombre' => 'Multimedia',
            'descripcion' => 'Administra imágenes y recursos multimedia.',
            'icono' => '▧',
            'rutas' => ['multimedias.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Pedidos',
            'descripcion' => 'Consulta pedidos, detalles, estados y cancelaciones.',
            'icono' => '▣',
            'rutas' => ['pedidos.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Carrito de compras',
            'descripcion' => 'Revisa el carrito y continúa el proceso de compra.',
            'icono' => '🛒',
            'rutas' => ['carrito.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Clientes',
            'descripcion' => 'Consulta y administra los clientes registrados.',
            'icono' => '♙',
            'rutas' => ['clientes.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Reseñas',
            'descripcion' => 'Consulta y modera las reseñas de productos.',
            'icono' => '☆',
            'rutas' => ['resenas.index', 'reseñas.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Operación',
            'nombre' => 'Proveedores',
            'descripcion' => 'Administra la información de los proveedores.',
            'icono' => '♧',
            'rutas' => ['proveedores.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Operación',
            'nombre' => 'Disponibilidad',
            'descripcion' => 'Gestiona tus fechas y horarios disponibles.',
            'icono' => '◷',
            'rutas' => ['mi-disponibilidad.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Usuarios',
            'descripcion' => 'Consulta y administra las cuentas de usuario.',
            'icono' => '♙',
            'rutas' => ['usuarios.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Seguridad de usuarios',
            'descripcion' => 'Gestiona la seguridad y los datos de acceso.',
            'icono' => '⌑',
            'rutas' => ['seguridad.usuarios.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Roles',
            'descripcion' => 'Configura los roles disponibles en el sistema.',
            'icono' => '⬡',
            'rutas' => ['roles.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Permisos',
            'descripcion' => 'Consulta y administra los permisos del sistema.',
            'icono' => '◈',
            'rutas' => ['permisos.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Estados generales',
            'descripcion' => 'Gestiona los estados usados por los módulos.',
            'icono' => '◉',
            'rutas' => ['estados.index', 'estados-generales.index'],
            'color' => '#A99045',
        ],
        [
            'grupo' => 'Mi espacio',
            'nombre' => 'Mi cuenta',
            'descripcion' => 'Consulta y actualiza la información de tu cuenta.',
            'icono' => '◎',
            'rutas' => ['mi-cuenta', 'mi-cuenta.index'],
            'color' => '#F5F3ED',
        ],
        [
            'grupo' => 'Mi espacio',
            'nombre' => 'Mis pedidos',
            'descripcion' => 'Consulta tus pedidos y su estado actual.',
            'icono' => '▣',
            'rutas' => ['mi-cuenta.pedidos'],
            'color' => '#A99045',
        ],
    ];

    $grupos = [
        'Catálogo',
        'Contenido',
        'Ventas',
        'Operación',
        'Administración',
        'Mi espacio',
    ];

    $modulosDisponibles = collect($modulos)->filter(
        fn ($modulo) => collect($modulo['rutas'])->contains(
            fn ($ruta) => Route::has($ruta)
        )
    )->count();
@endphp

<div class="relative min-h-screen overflow-hidden bg-[#151515] px-4 py-8 text-[#F5F3ED] sm:px-6 lg:px-10 lg:py-12">

    {{-- Fondo decorativo --}}
    <div aria-hidden="true"
         class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-[#A99045]/[0.09] blur-[110px]">
    </div>

    <div aria-hidden="true"
         class="pointer-events-none absolute -left-40 top-[700px] h-80 w-80 rounded-full bg-[#9E2428]/[0.07] blur-[110px]">
    </div>

    <div class="relative mx-auto max-w-7xl">

        {{-- ENCABEZADO --}}
        <header class="mb-12 border-b border-[#F5F3ED]/10 pb-8 lg:pb-10">
            <div class="flex flex-col gap-7 lg:flex-row lg:items-end lg:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-6 flex items-center gap-3">
                        <span class="h-px w-8 bg-[#A99045]"></span>

                        <p class="text-[10px] font-bold uppercase tracking-[0.32em] text-[#A99045]">
                            Incógnito · Group Design
                        </p>
                    </div>

                    <h1 class="text-3xl font-semibold leading-tight tracking-tight text-[#F5F3ED] sm:text-4xl lg:text-5xl">
                        Panel de gestión<span class="text-[#A99045]">.</span>
                    </h1>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-[#F5F3ED]/55 sm:text-base">
                        Accede desde un solo lugar a los módulos de tu sistema.
                        Selecciona una tarjeta para abrir la vista correspondiente.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">

                    <a
                        href="{{ url('/') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-[#F5F3ED]/15 px-5 py-3 text-xs font-semibold text-[#F5F3ED]/75 transition duration-200 hover:border-[#A99045]/60 hover:bg-[#F5F3ED]/[0.04] hover:text-[#F5F3ED]"
                    >
                        Ver sitio público
                        <span aria-hidden="true">↗</span>
                    </a>

                    @if(Route::has('mi-cuenta'))
                        <a
                            href="{{ route('mi-cuenta') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#A99045] px-5 py-3 text-xs font-bold text-[#151515] transition duration-200 hover:bg-[#c1a75a] focus:outline-none focus:ring-2 focus:ring-[#A99045] focus:ring-offset-2 focus:ring-offset-[#151515]"
                        >
                            Mi cuenta
                            <span aria-hidden="true">↗</span>
                        </a>
                    @endif

                </div>
            </div>
        </header>

        {{-- RESUMEN --}}
        <section aria-label="Resumen del panel"
                 class="mb-12 grid grid-cols-1 gap-4 md:grid-cols-3">

            {{-- Módulos --}}
            <article class="group rounded-xl border border-[#F5F3ED]/10 bg-[#1D1D1D] p-5 transition duration-300 hover:border-[#A99045]/40 sm:p-6">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#F5F3ED]/45">
                            Módulos disponibles
                        </p>

                        <div class="mt-5 flex items-baseline gap-2">
                            <p class="text-4xl font-semibold tracking-tight text-[#F5F3ED]">
                                {{ $modulosDisponibles }}
                            </p>

                            <span class="text-sm text-[#F5F3ED]/35">
                                / {{ count($modulos) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-[#A99045]/25 bg-[#A99045]/10 text-xl text-[#A99045]">
                        ▦
                    </div>
                </div>

                <p class="mt-3 text-xs text-[#F5F3ED]/40">
                    Según las rutas registradas en Laravel
                </p>

                <div class="mt-5 h-1 overflow-hidden rounded-full bg-[#F5F3ED]/10">
                    <div
                        class="h-full rounded-full bg-[#A99045] transition-all duration-500"
                        style="width: {{ count($modulos) > 0 ? min(100, ($modulosDisponibles / count($modulos)) * 100) : 0 }}%"
                    ></div>
                </div>
            </article>

            {{-- Sesión --}}
            <article class="rounded-xl border border-[#F5F3ED]/10 bg-[#1D1D1D] p-5 transition duration-300 hover:border-[#A99045]/30 sm:p-6">

                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#F5F3ED]/45">
                            Sesión actual
                        </p>

                        <p class="mt-5 truncate text-xl font-semibold text-[#F5F3ED]">
                            {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Usuario' }}
                        </p>

                        <p class="mt-2 truncate text-xs text-[#F5F3ED]/45">
                            {{ auth()->user()->email ?? '' }}
                        </p>
                    </div>

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg border border-[#A99045]/25 bg-[#A99045]/10 text-xl text-[#A99045]">
                        ◎
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-2 border-t border-[#F5F3ED]/[0.08] pt-4">
                    <span class="h-2 w-2 rounded-full bg-[#A99045]"></span>

                    <span class="text-xs text-[#F5F3ED]/55">
                        Sesión iniciada
                    </span>
                </div>
            </article>

            {{-- Fecha --}}
            <article class="rounded-xl border border-[#F5F3ED]/10 bg-[#1D1D1D] p-5 transition duration-300 hover:border-[#A99045]/30 sm:p-6">

                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-[#F5F3ED]/45">
                            Fecha
                        </p>

                        <p class="mt-5 text-2xl font-semibold tracking-tight text-[#F5F3ED]">
                            {{ now()->format('d/m/Y') }}
                        </p>

                        <p class="mt-2 text-xs text-[#F5F3ED]/45">
                            Panel central de administración
                        </p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg border border-[#9E2428]/30 bg-[#9E2428]/10 text-xl text-[#F5F3ED]">
                        ◷
                    </div>
                </div>

                <div class="mt-5 border-t border-[#F5F3ED]/[0.08] pt-4">
                    <span class="text-xs text-[#F5F3ED]/50">
                        Información del sistema
                    </span>
                </div>
            </article>

        </section>

        {{-- MÓDULOS AGRUPADOS --}}
        @foreach($grupos as $grupo)
            @php
                $elementosGrupo = collect($modulos)->where('grupo', $grupo);
            @endphp

            <section class="mb-12">

                {{-- Encabezado del grupo --}}
                <div class="mb-5 flex items-center gap-4">

                    <span class="h-5 w-1 rounded-full bg-[#A99045]"></span>

                    <h2 class="text-xs font-bold uppercase tracking-[0.22em] text-[#F5F3ED]/85">
                        {{ $grupo }}
                    </h2>

                    <span class="rounded-md border border-[#F5F3ED]/10 px-2 py-1 text-[10px] font-semibold text-[#F5F3ED]/45">
                        {{ $elementosGrupo->count() }}
                    </span>

                    <div class="h-px flex-1 bg-gradient-to-r from-[#F5F3ED]/15 to-transparent"></div>

                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                    @foreach($elementosGrupo as $modulo)
                        @php
                            $rutaDisponible = collect($modulo['rutas'])->first(
                                fn ($ruta) => Route::has($ruta)
                            );
                        @endphp

                        <article class="group relative flex min-h-[218px] flex-col overflow-hidden rounded-xl border border-[#F5F3ED]/10 bg-[#1B1B1B] p-5 transition duration-300 hover:-translate-y-1 hover:border-[#A99045]/45 hover:bg-[#20201E] sm:p-6">

                            {{-- Detalle decorativo superior --}}
                            <div
                                aria-hidden="true"
                                class="absolute inset-x-0 top-0 h-px opacity-0 transition duration-300 group-hover:opacity-100"
                                style="background: linear-gradient(90deg, transparent, {{ $modulo['color'] }}, transparent)"
                            ></div>

                            {{-- Icono y estado --}}
                            <div class="flex items-start justify-between gap-3">

                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-lg border border-[#F5F3ED]/10 bg-[#151515] text-2xl transition duration-300 group-hover:border-[#A99045]/35"
                                    style="color: {{ $modulo['color'] }}"
                                >
                                    {{ $modulo['icono'] }}
                                </div>

                                @if($rutaDisponible)
                                    <span class="inline-flex items-center gap-2 rounded-md border border-[#A99045]/25 bg-[#A99045]/[0.08] px-2.5 py-1.5 text-[9px] font-bold uppercase tracking-wider text-[#D8C17F]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#A99045]"></span>
                                        Disponible
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-md border border-[#9E2428]/40 bg-[#9E2428]/10 px-2.5 py-1.5 text-[9px] font-bold uppercase tracking-wider text-[#E7A5A6]">
                                        <span class="h-1.5 w-1.5 rounded-full bg-[#9E2428]"></span>
                                        Revisar ruta
                                    </span>
                                @endif

                            </div>

                            {{-- Información del módulo --}}
                            <div class="mt-5">
                                <h3 class="text-base font-semibold text-[#F5F3ED] transition-colors duration-200 group-hover:text-[#D8C17F]">
                                    {{ $modulo['nombre'] }}
                                </h3>

                                <p class="mt-2 text-xs leading-6 text-[#F5F3ED]/50">
                                    {{ $modulo['descripcion'] }}
                                </p>
                            </div>

                            {{-- Acción --}}
                            <div class="mt-auto pt-5">
                                <div class="border-t border-[#F5F3ED]/[0.08] pt-4">

                                    @if($rutaDisponible)
                                        <a
                                            href="{{ route($rutaDisponible) }}"
                                            class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.16em] text-[#F5F3ED]/60 transition duration-200 hover:text-[#D8C17F] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#A99045]"
                                        >
                                            Abrir módulo

                                            <span
                                                aria-hidden="true"
                                                class="inline-block transition-transform duration-200 group-hover:translate-x-1"
                                            >→</span>
                                        </a>
                                    @else
                                        <p class="text-[10px] leading-5 text-[#E7A5A6]">
                                            No se encontró una ruta nombrada para este módulo.
                                            Revisa routes/web.php.
                                        </p>
                                    @endif

                                </div>
                            </div>

                        </article>
                    @endforeach

                </div>
            </section>
        @endforeach

        {{-- PIE DE PÁGINA --}}
        <footer class="mt-14 border-t border-[#F5F3ED]/10 pt-6">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <p class="text-xs text-[#F5F3ED]/40">
                    <span class="font-semibold text-[#F5F3ED]/75">
                        Incógnito Group Design
                    </span>

                    <span class="mx-1 text-[#A99045]">·</span>

                    Panel interno.
                </p>

                <p class="text-xs leading-5 text-[#F5F3ED]/40">
                    La autorización de cada módulo debe mantenerse en las rutas y controladores.
                </p>

            </div>
        </footer>

    </div>
</div>
@endsection
