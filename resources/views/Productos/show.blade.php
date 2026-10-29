
@extends('layouts.app')

@section('title', 'Detalle del Producto | Incógnito Group Design')

@section('content')

<div class="productos-page min-h-screen px-4 py-8 sm:px-6 lg:px-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.3em] text-amber-400">
                Incógnito | Grupo de Diseño
            </p>

            <h1 class="text-3xl font-bold uppercase tracking-widest text-white sm:text-4xl">
                Detalle del producto
            </h1>

            <p class="mt-2 text-sm uppercase tracking-wider text-gray-400">
                Información completa del producto
            </p>

            <div class="mt-4 h-[3px] w-[60px] rounded-full bg-amber-400"></div>
        </div>

        <div class="flex flex-wrap items-center gap-3">

            {{-- EDITAR: requiere permiso --}}
            @if(auth()->check() && auth()->user()->tienePermiso('productos.editar'))
                <a href="{{ route('productos.edit', $producto) }}"
                   class="inline-flex items-center justify-center rounded-lg bg-amber-400 px-5 py-3 text-xs font-bold uppercase tracking-widest text-black transition hover:bg-amber-300">
                    <span class="mr-2">✎</span>
                    Editar producto
                </a>
            @endif

            {{-- VOLVER AL CATÁLOGO --}}
            <a href="{{ route('productos.index') }}"
               class="inline-flex items-center justify-center rounded-lg border border-white/10 bg-[#202020] px-5 py-3 text-xs font-bold uppercase tracking-widest text-gray-200 transition hover:border-amber-400/40 hover:bg-white/10">
                <span class="mr-2">←</span>
                Volver
            </a>

        </div>
    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- INFORMACIÓN PRINCIPAL --}}
    <div class="overflow-hidden rounded-xl border border-amber-400/20 bg-[#171717] shadow-xl">

        {{-- CABECERA DE LA TARJETA --}}
        <div class="flex flex-col gap-3 border-b border-white/10 bg-[#202020] px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">

            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">
                    Producto registrado
                </p>

                <h2 class="mt-2 text-xl font-bold text-white sm:text-2xl">
                    {{ $producto->nombre }}
                </h2>
            </div>

            <div>
                @if($producto->activo)
                    <span class="inline-flex rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-2 text-xs font-bold uppercase tracking-wider text-emerald-300">
                        <span class="mr-2">●</span>
                        Activo
                    </span>
                @else
                    <span class="inline-flex rounded-full border border-red-500/30 bg-red-500/10 px-4 py-2 text-xs font-bold uppercase tracking-wider text-red-300">
                        <span class="mr-2">●</span>
                        Inactivo
                    </span>
                @endif
            </div>

        </div>

        {{-- DATOS DEL PRODUCTO --}}
        <div class="p-5 sm:p-8">

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

                {{-- ID --}}
                <div class="rounded-lg border border-white/10 bg-[#202020] p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        ID del producto
                    </p>

                    <p class="text-lg font-semibold text-white">
                        #{{ $producto->id }}
                    </p>
                </div>

                {{-- NOMBRE --}}
                <div class="rounded-lg border border-white/10 bg-[#202020] p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        Nombre
                    </p>

                    <p class="break-words text-base font-semibold text-white">
                        {{ $producto->nombre }}
                    </p>
                </div>

                {{-- CATEGORÍA --}}
                <div class="rounded-lg border border-white/10 bg-[#202020] p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        Categoría
                    </p>

                    <p class="text-base font-semibold text-amber-300">
                        {{ $producto->categoria?->nombre ?? 'Sin categoría' }}
                    </p>
                </div>

                {{-- PRECIO --}}
                <div class="rounded-lg border border-amber-400/20 bg-[#202020] p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        Precio
                    </p>

                    <p class="text-2xl font-bold text-amber-400">
                        ${{ number_format((float) $producto->precio, 2, ',', '.') }}
                    </p>
                </div>

                {{-- STOCK --}}
                <div class="rounded-lg border border-white/10 bg-[#202020] p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        Stock disponible
                    </p>

                    <p class="text-2xl font-bold text-white">
                        {{ $producto->stock }}
                        <span class="text-sm font-normal text-gray-400">
                            unidades
                        </span>
                    </p>

                    @if($producto->stock <= 0)
                        <p class="mt-2 text-xs font-medium text-red-300">
                            Sin existencias
                        </p>
                    @elseif($producto->stock <= 5)
                        <p class="mt-2 text-xs font-medium text-amber-300">
                            Stock bajo
                        </p>
                    @else
                        <p class="mt-2 text-xs font-medium text-emerald-300">
                            Existencias disponibles
                        </p>
                    @endif
                </div>

                {{-- ESTADO --}}
                <div class="rounded-lg border border-white/10 bg-[#202020] p-5">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        Estado
                    </p>

                    @if($producto->activo)
                        <span class="inline-flex rounded-md border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-xs font-bold uppercase tracking-wider text-emerald-300">
                            Disponible
                        </span>
                    @else
                        <span class="inline-flex rounded-md border border-red-500/30 bg-red-500/10 px-3 py-2 text-xs font-bold uppercase tracking-wider text-red-300">
                            No disponible
                        </span>
                    @endif
                </div>

                {{-- FECHA DE CREACIÓN --}}
                <div class="rounded-lg border border-white/10 bg-[#202020] p-5 sm:col-span-2 xl:col-span-3">
                    <p class="mb-3 text-xs font-bold uppercase tracking-widest text-gray-500">
                        Fecha de creación
                    </p>

                    <p class="text-sm font-medium text-gray-200">
                        {{ $producto->created_at?->format('d/m/Y H:i') ?? 'No disponible' }}
                    </p>
                </div>

            </div>

            {{-- DESCRIPCIÓN --}}
            <div class="mt-6 rounded-lg border border-white/10 bg-[#202020] p-5 sm:p-6">

                <div class="mb-4 flex items-center gap-3">
                    <div class="h-8 w-1 rounded-full bg-amber-400"></div>

                    <h3 class="text-sm font-bold uppercase tracking-widest text-white">
                        Descripción del producto
                    </h3>
                </div>

                @if(filled($producto->descripcion))
                    <p class="whitespace-pre-line break-words text-sm leading-7 text-gray-300">{{ $producto->descripcion }}</p>
                @else
                    <p class="text-sm italic text-gray-500">
                        Este producto no tiene una descripción registrada.
                    </p>
                @endif

            </div>

        </div>

        {{-- PIE DE LA TARJETA --}}
        <div class="flex flex-col gap-3 border-t border-white/10 bg-[#202020] px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-8">

            <p class="text-xs text-gray-500">
                Información del catálogo de Incógnito Group Design.
            </p>

            <a href="{{ route('productos.index') }}"
               class="text-xs font-bold uppercase tracking-widest text-amber-400 transition hover:text-amber-300">
                Volver al catálogo →
            </a>

        </div>

    </div>

</div>

@endsection
