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
            'color' => '#00c896',
        ],
        [
            'grupo' => 'Catálogo',
            'nombre' => 'Categorías',
            'descripcion' => 'Organiza el catálogo por categorías.',
            'icono' => '◫',
            'rutas' => ['categorias.index'],
            'color' => '#7dd3fc',
        ],
        [
            'grupo' => 'Contenido',
            'nombre' => 'Contenidos',
            'descripcion' => 'Gestiona publicaciones y contenido del sitio.',
            'icono' => '▤',
            'rutas' => ['contenidos.index'],
            'color' => '#c4b5fd',
        ],
        [
            'grupo' => 'Contenido',
            'nombre' => 'Multimedia',
            'descripcion' => 'Administra imágenes y recursos multimedia.',
            'icono' => '▧',
            'rutas' => ['multimedias.index'],
            'color' => '#f9a8d4',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Pedidos',
            'descripcion' => 'Consulta pedidos, detalles, estados y cancelaciones.',
            'icono' => '▣',
            'rutas' => ['pedidos.index'],
            'color' => '#fdba74',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Carrito de compras',
            'descripcion' => 'Revisa el carrito y continúa el proceso de compra.',
            'icono' => '🛒',
            'rutas' => ['carrito.index'],
            'color' => '#00c896',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Clientes',
            'descripcion' => 'Consulta y administra los clientes registrados.',
            'icono' => '♙',
            'rutas' => ['clientes.index'],
            'color' => '#93c5fd',
        ],
        [
            'grupo' => 'Ventas',
            'nombre' => 'Reseñas',
            'descripcion' => 'Consulta y modera las reseñas de productos.',
            'icono' => '☆',
            'rutas' => ['resenas.index', 'reseñas.index'],
            'color' => '#fde68a',
        ],
        [
            'grupo' => 'Operación',
            'nombre' => 'Proveedores',
            'descripcion' => 'Administra la información de los proveedores.',
            'icono' => '♧',
            'rutas' => ['proveedores.index'],
            'color' => '#a7f3d0',
        ],
        [
            'grupo' => 'Operación',
            'nombre' => 'Disponibilidad',
            'descripcion' => 'Gestiona tus fechas y horarios disponibles.',
            'icono' => '◷',
            'rutas' => ['mi-disponibilidad.index'],
            'color' => '#fca5a5',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Usuarios',
            'descripcion' => 'Consulta y administra las cuentas de usuario.',
            'icono' => '♙',
            'rutas' => ['usuarios.index'],
            'color' => '#93c5fd',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Seguridad de usuarios',
            'descripcion' => 'Gestiona la seguridad y los datos de acceso.',
            'icono' => '⌑',
            'rutas' => ['seguridad.usuarios.index'],
            'color' => '#fca5a5',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Roles',
            'descripcion' => 'Configura los roles disponibles en el sistema.',
            'icono' => '⬡',
            'rutas' => ['roles.index'],
            'color' => '#c4b5fd',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Permisos',
            'descripcion' => 'Consulta y administra los permisos del sistema.',
            'icono' => '◈',
            'rutas' => ['permisos.index'],
            'color' => '#fdba74',
        ],
        [
            'grupo' => 'Administración',
            'nombre' => 'Estados generales',
            'descripcion' => 'Gestiona los estados usados por los módulos.',
            'icono' => '◉',
            'rutas' => ['estados.index', 'estados-generales.index'],
            'color' => '#a7f3d0',
        ],
        [
            'grupo' => 'Mi espacio',
            'nombre' => 'Mi cuenta',
            'descripcion' => 'Consulta y actualiza la información de tu cuenta.',
            'icono' => '◎',
            'rutas' => ['mi-cuenta', 'mi-cuenta.index'],
            'color' => '#f9a8d4',
        ],
        [
            'grupo' => 'Mi espacio',
            'nombre' => 'Mis pedidos',
            'descripcion' => 'Consulta tus pedidos y su estado actual.',
            'icono' => '▣',
            'rutas' => ['mi-cuenta.pedidos'],
            'color' => '#fdba74',
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

    // Contar únicamente los módulos que tienen una ruta registrada.
    $modulosDisponibles = collect($modulos)->filter(
        fn ($modulo) => collect($modulo['rutas'])->contains(
            fn ($ruta) => Route::has($ruta)
        )
    )->count();
@endphp

<div class="min-h-screen bg-[#080808] px-4 py-8 text-white sm:px-6 lg:px-10">
    <div class="mx-auto max-w-7xl">

        {{-- ENCABEZADO --}}
        <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-3 text-[10px] font-black uppercase tracking-[0.35em] text-[#00c896]">
                    Incógnito · Group Design
                </p>

                <h1 class="text-3xl font-black uppercase tracking-[0.12em] sm:text-4xl">
                    Panel de gestión
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/50">
                    Accede desde un solo lugar a los módulos de tu sistema.
                    Selecciona una tarjeta para abrir la vista correspondiente.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center rounded-lg border border-white/15 px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white/70 transition hover:bg-white/5 hover:text-white"
                >
                    Ver sitio público
                </a>

                @if(Route::has('mi-cuenta'))
                    <a
                        href="{{ route('mi-cuenta') }}"
                        class="inline-flex items-center rounded-lg bg-[#00c896] px-4 py-2.5 text-xs font-black uppercase tracking-wider text-black transition hover:brightness-110"
                    >
                        Mi cuenta ↗
                    </a>
                @endif
            </div>
        </div>

        {{-- TARJETAS DE RESUMEN --}}
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-white/10 bg-white/[0.035] p-5">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/40">
                    Módulos disponibles
                </p>

                <p class="mt-3 text-3xl font-black">
                    {{ $modulosDisponibles }}
                    <span class="ml-2 text-sm font-medium text-white/30">
                        / {{ count($modulos) }}
                    </span>
                </p>

                <p class="mt-2 text-xs text-white/40">
                    Según las rutas registradas en Laravel
                </p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.035] p-5">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/40">
                    Sesión actual
                </p>

                <p class="mt-3 truncate text-xl font-bold">
                    {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Usuario' }}
                </p>

                <p class="mt-2 truncate text-xs text-white/40">
                    {{ auth()->user()->email ?? '' }}
                </p>
            </div>

            <div class="rounded-2xl border border-white/10 bg-white/[0.035] p-5">
                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/40">
                    Fecha
                </p>

                <p class="mt-3 text-xl font-bold">
                    {{ now()->format('d/m/Y') }}
                </p>

                <p class="mt-2 text-xs text-white/40">
                    Panel central de administración
                </p>
            </div>

        </div>

        {{-- MÓDULOS AGRUPADOS --}}
        @foreach($grupos as $grupo)
            @php
                $elementosGrupo = collect($modulos)->where('grupo', $grupo);
            @endphp

            <section class="mb-9">
                <div class="mb-4 flex items-center gap-3">
                    <h2 class="text-xs font-black uppercase tracking-[0.25em] text-white/65">
                        {{ $grupo }}
                    </h2>

                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach($elementosGrupo as $modulo)
                        @php
                            $rutaDisponible = collect($modulo['rutas'])->first(
                                fn ($ruta) => Route::has($ruta)
                            );
                        @endphp

                        <article class="group flex min-h-[176px] flex-col rounded-2xl border border-white/10 bg-white/[0.025] p-5 transition duration-200 hover:-translate-y-0.5 hover:border-white/20 hover:bg-white/[0.045]">

                            <div class="flex items-start justify-between gap-4">
                                <div
                                    class="flex h-11 w-11 items-center justify-center rounded-xl border border-white/10 bg-black text-xl"
                                    style="color: {{ $modulo['color'] }}"
                                >
                                    {{ $modulo['icono'] }}
                                </div>

                                @if($rutaDisponible)
                                    <span class="rounded-full border border-[#00c896]/20 bg-[#00c896]/10 px-2.5 py-1 text-[9px] font-black uppercase tracking-wider text-[#00c896]">
                                        Disponible
                                    </span>
                                @else
                                    <span class="rounded-full border border-amber-400/20 bg-amber-400/10 px-2.5 py-1 text-[9px] font-black uppercase tracking-wider text-amber-200">
                                        Revisar ruta
                                    </span>
                                @endif
                            </div>

                            <h3 class="mt-5 text-base font-bold text-white">
                                {{ $modulo['nombre'] }}
                            </h3>

                            <p class="mt-2 flex-1 text-xs leading-5 text-white/45">
                                {{ $modulo['descripcion'] }}
                            </p>

                            <div class="mt-5 border-t border-white/[0.07] pt-4">
                                @if($rutaDisponible)
                                    <a
                                        href="{{ route($rutaDisponible) }}"
                                        class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.18em] text-white/70 transition group-hover:text-[#00c896]"
                                    >
                                        Abrir módulo
                                        <span aria-hidden="true">↗</span>
                                    </a>
                                @else
                                    <p class="text-[10px] leading-4 text-amber-100/70">
                                        No se encontró una ruta nombrada para este módulo.
                                        Revisa routes/web.php.
                                    </p>
                                @endif
                            </div>

                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach

        {{-- PIE DE PÁGINA --}}
        <footer class="border-t border-white/10 pt-5 text-xs text-white/30">
            Incógnito Group Design · Panel interno.
            La autorización de cada módulo debe mantenerse en las rutas y controladores.
        </footer>

    </div>
</div>
@endsection
