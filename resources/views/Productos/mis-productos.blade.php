@extends('layouts.app')

@section('title', 'Mis productos | Incógnito Group Design')

@section('content')

@include('Servicios._estilos')

@php
    $esAdminGlobal = auth()->user()?->esAdministradorGlobal() ?? false;
    $miProveedorId = $proveedor->id_proveedor;

    $totalProductos = $productos->count();
    $totalActivos = $productos->where('activo', true)->count();
    $totalInactivos = $totalProductos - $totalActivos;

    $puedeCrearProducto = auth()->user()->tienePermiso('productos.crear');
@endphp

<div class="services-page relative min-h-screen overflow-hidden">

    {{-- Fondo decorativo --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-40 left-1/2 h-[28rem] w-[48rem] -translate-x-1/2 rounded-full bg-[#A99045]/10 blur-[120px]"></div>
        <div class="absolute top-[35rem] -left-40 h-96 w-96 rounded-full bg-[#9E2428]/10 blur-[110px]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#151515]/10 via-[#151515]/50 to-[#151515]"></div>
    </div>

    <div class="mx-auto max-w-7xl px-5 py-16 sm:px-6 sm:py-20 lg:px-8">

        {{-- Encabezado --}}
        <header class="mb-12 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="section-label mb-3">Incógnito | Grupo de Diseño</p>

                <h1 class="text-4xl font-black uppercase leading-tight tracking-tight sm:text-5xl">
                    Mis <span class="gold-text">productos</span>
                </h1>

                <p class="mt-4 max-w-2xl text-base leading-8 text-gray-300">
                    Crea y administra los productos y servicios que ofreces
                    en el catálogo. Los visitantes los ven en
                    <a href="{{ route('servicios') }}" class="gold-text underline underline-offset-4">Servicios</a>.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('servicios') }}" class="outline-button">
                    Ver catálogo público
                    <span aria-hidden="true">↗</span>
                </a>

                @if ($puedeCrearProducto)
                    <a href="{{ route('productos.create') }}" class="gold-button">
                        <span aria-hidden="true">+</span>
                        Crear producto
                    </a>
                @endif
            </div>
        </header>

        {{-- Mensajes --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
                <p class="mb-2 font-semibold">No se pudo completar la operación:</p>

                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Resumen --}}
        <section class="mb-10 grid grid-cols-1 gap-4 sm:grid-cols-3" aria-label="Resumen de productos">
            <div class="service-card p-5">
                <p class="text-sm text-gray-400">Total de productos</p>
                <p class="mt-2 text-3xl font-black text-[#F5F3ED]">{{ $totalProductos }}</p>
            </div>

            <div class="service-card p-5">
                <p class="text-sm text-gray-400">Activos (visibles al público)</p>
                <p class="mt-2 text-3xl font-black text-green-300">{{ $totalActivos }}</p>
            </div>

            <div class="service-card p-5">
                <p class="text-sm text-gray-400">Inactivos</p>
                <p class="mt-2 text-3xl font-black text-amber-200">{{ $totalInactivos }}</p>
            </div>
        </section>

        {{-- Productos --}}
        @if ($productos->isNotEmpty())
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($productos as $producto)
                    @include('servicios._producto-card', [
                        'producto' => $producto,
                        'esAdminGlobal' => $esAdminGlobal,
                        'miProveedorId' => $miProveedorId,
                        'modoProveedor' => true,
                    ])
                @endforeach
            </div>
        @else
            <div class="service-card mx-auto max-w-2xl p-10 text-center">
                <p class="text-xl font-bold text-[#F5F3ED]">Aún no tienes productos</p>

                <p class="mt-3 text-sm leading-7 text-gray-400">
                    Crea tu primer producto para que aparezca en el catálogo.
                </p>

                @if ($puedeCrearProducto)
                    <a href="{{ route('productos.create') }}" class="gold-button mt-6">
                        <span aria-hidden="true">+</span>
                        Crear producto
                    </a>
                @endif
            </div>
        @endif

    </div>
</div>

@endsection
