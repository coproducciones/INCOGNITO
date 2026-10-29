
@extends('layouts.app')

@section('title', 'Productos | Incógnito Group Design')

@section('content')
@php
    $cantidadProductos = $productos->count();

    $esAdministrador = auth()->check()
        && auth()->user()->tienePermiso('productos.crear');

    $puedeEditar = auth()->check()
        && auth()->user()->tienePermiso('productos.editar');

    $puedeEliminar = auth()->check()
        && auth()->user()->tienePermiso('productos.eliminar');

    $tienePaginacion = method_exists($productos, 'links');
@endphp

<div class="productos-page min-h-screen px-4 py-8 sm:px-6 lg:px-8">

    {{-- Encabezado --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-amber-400">
                Incógnito | Grupo de Diseño
            </p>

            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Gestión de productos
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                Administra y consulta el catálogo de productos.
            </p>
        </div>

        @if($esAdministrador)
            <a href="{{ route('productos.create') }}"
               class="inline-flex items-center justify-center rounded-lg bg-amber-400 px-5 py-3 text-sm font-bold text-black transition hover:bg-amber-300">
                <span class="mr-2 text-lg">+</span>
                Nuevo producto
            </a>
        @endif
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errores --}}
    @if($errors->any())
        <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            <p class="mb-2 font-semibold">No se pudo completar la operación:</p>

            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Resumen --}}
    <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="rounded-xl border border-white/10 bg-[#171717] p-5">
            <p class="text-sm text-gray-400">Productos en esta página</p>

            <p class="mt-2 text-3xl font-bold text-white">
                {{ $cantidadProductos }}
            </p>
        </div>

        <div class="rounded-xl border border-white/10 bg-[#171717] p-5">
            <p class="text-sm text-gray-400">Estado del catálogo</p>

            <p class="mt-2 text-lg font-semibold text-amber-400">
                {{ $cantidadProductos > 0 ? 'Catálogo disponible' : 'Sin productos' }}
            </p>
        </div>
    </div>

    {{-- Catálogo --}}
    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#171717]">

        <div class="flex flex-col gap-2 border-b border-white/10 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-lg font-semibold text-white">
                Catálogo de productos
            </h2>

            <span class="text-sm text-gray-400">
                {{ $cantidadProductos }} producto(s) en esta página
            </span>
        </div>

        @if($productos->isEmpty())
            <div class="px-5 py-16 text-center">
                <div class="mb-4 text-4xl">📦</div>

                <h3 class="text-lg font-semibold text-white">
                    No hay productos registrados
                </h3>

                <p class="mt-2 text-sm text-gray-400">
                    Cuando se registren productos, aparecerán en esta sección.
                </p>

                @if($esAdministrador)
                    <a href="{{ route('productos.create') }}"
                       class="mt-5 inline-flex rounded-lg bg-amber-400 px-5 py-3 text-sm font-bold text-black transition hover:bg-amber-300">
                        Registrar primer producto
                    </a>
                @endif
            </div>
        @else

            {{-- Vista de tarjetas para móviles --}}
            <div class="grid grid-cols-1 gap-4 p-4 sm:grid-cols-2 lg:hidden">
                @foreach($productos as $producto)
                    <article class="rounded-lg border border-white/10 bg-[#202020] p-4">

                        <div class="mb-3 flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs text-gray-500">
                                    Producto #{{ $producto->id }}
                                </p>

                                <h3 class="mt-1 text-base font-semibold text-white">
                                    {{ $producto->nombre }}
                                </h3>
                            </div>

                            @if($producto->activo)
                                <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-300">
                                    Activo
                                </span>
                            @else
                                <span class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-medium text-red-300">
                                    Inactivo
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2 text-sm">
                            <p class="text-gray-400">
                                Categoría:
                                <span class="text-gray-200">
                                    {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
                                </span>
                            </p>

                            <p class="text-gray-400">
                                Precio:
                                <span class="font-semibold text-amber-400">
                                    ${{ number_format((float) $producto->precio, 2, ',', '.') }}
                                </span>
                            </p>

                            <p class="text-gray-400">
                                Stock:
                                <span class="text-gray-200">{{ $producto->stock }}</span>
                            </p>
                        </div>

                        <div class="mt-4 flex flex-wrap gap-2 border-t border-white/10 pt-4">
                            <a href="{{ route('productos.show', $producto) }}"
                               class="rounded-md border border-white/20 px-3 py-2 text-xs font-medium text-white transition hover:bg-white/10">
                                Ver detalles
                            </a>

                            @if($puedeEditar)
                                <a href="{{ route('productos.edit', $producto) }}"
                                   class="rounded-md bg-amber-400 px-3 py-2 text-xs font-bold text-black transition hover:bg-amber-300">
                                    Editar
                                </a>
                            @endif

                            @if($puedeEliminar)
                                <form action="{{ route('productos.destroy', $producto) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-md border border-red-500/40 px-3 py-2 text-xs font-medium text-red-300 transition hover:bg-red-500/10">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Tabla para pantallas grandes --}}
            <div class="hidden overflow-x-auto lg:block">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#202020] text-xs uppercase tracking-wider text-gray-400">
                        <tr>
                            <th class="px-5 py-4">ID</th>
                            <th class="px-5 py-4">Producto</th>
                            <th class="px-5 py-4">Categoría</th>
                            <th class="px-5 py-4">Precio</th>
                            <th class="px-5 py-4">Stock</th>
                            <th class="px-5 py-4">Estado</th>
                            <th class="px-5 py-4">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-white/10">
                        @foreach($productos as $producto)
                            <tr class="transition hover:bg-white/[0.03]">
                                <td class="px-5 py-4 text-gray-400">
                                    {{ $producto->id }}
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-white">
                                        {{ $producto->nombre }}
                                    </p>

                                    <p class="mt-1 max-w-xs truncate text-xs text-gray-500">
                                        {{ $producto->descripcion ?? 'Sin descripción' }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 text-gray-300">
                                    {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
                                </td>

                                <td class="px-5 py-4 font-semibold text-amber-400">
                                    ${{ number_format((float) $producto->precio, 2, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-gray-300">
                                    {{ $producto->stock }}
                                </td>

                                <td class="px-5 py-4">
                                    @if($producto->activo)
                                        <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-300">
                                            Activo
                                        </span>
                                    @else
                                        <span class="rounded-full bg-red-500/10 px-3 py-1 text-xs font-medium text-red-300">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <a href="{{ route('productos.show', $producto) }}"
                                           class="text-xs font-medium text-gray-300 transition hover:text-white">
                                            Ver
                                        </a>

                                        @if($puedeEditar)
                                            <a href="{{ route('productos.edit', $producto) }}"
                                               class="text-xs font-semibold text-amber-400 transition hover:text-amber-300">
                                                Editar
                                            </a>
                                        @endif

                                        @if($puedeEliminar)
                                            <form action="{{ route('productos.destroy', $producto) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-xs font-medium text-red-300 transition hover:text-red-200">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>

    {{-- Paginación --}}
    @if($tienePaginacion)
        <div class="mt-6">
            {{ $productos->links() }}
        </div>
    @endif

</div>
@endsection
