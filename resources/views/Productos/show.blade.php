@extends('layouts.app')

@section('title', 'Ver Producto')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black uppercase tracking-widest text-white"
            style="font-size:22px; letter-spacing:0.15em;">DETALLE DEL PRODUCTO</h1>
        <p class="font-bold uppercase tracking-widest mt-1"
            style="font-size:10px; color:rgba(255,255,255,0.4);">
            GESTIÓN DE PRODUCTOS
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('productos.edit', $producto) }}"
            class="font-black uppercase tracking-widest px-5 py-2 text-black"
            style="font-size:11px; background:#00c896; border-radius:4px; letter-spacing:0.1em;">
            EDITAR
        </a>
        <a href="{{ route('productos.index') }}"
            class="font-black uppercase tracking-widest px-5 py-2 text-white"
            style="font-size:11px; border:1px solid rgba(255,255,255,0.2); border-radius:4px; letter-spacing:0.1em;">
            ← VOLVER
        </a>
    </div>
</div>

<div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:6px;" class="p-8">

    <div class="grid grid-cols-2 gap-8">

        <div>
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">CATEGORÍA</p>
            <p class="font-bold" style="font-size:14px; color:#00c896;">
                {{ $producto->categoria->nombre }}
            </p>
        </div>

        <div>
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">ESTADO</p>
            @if($producto->activo)
                <span class="font-black uppercase tracking-widest px-3 py-1"
                    style="font-size:9px; background:rgba(0,200,150,0.15); color:#00c896; border-radius:3px;">
                    ACTIVO
                </span>
            @else
                <span class="font-black uppercase tracking-widest px-3 py-1"
                    style="font-size:9px; background:rgba(248,113,113,0.15); color:#f87171; border-radius:3px;">
                    INACTIVO
                </span>
            @endif
        </div>

        <div>
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">NOMBRE</p>
            <p class="font-bold text-white" style="font-size:14px;">
                {{ $producto->nombre }}
            </p>
        </div>

        <div>
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">PRECIO</p>
            <p class="font-bold text-white" style="font-size:14px;">
                ${{ number_format($producto->precio, 2) }}
            </p>
        </div>

        <div>
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">STOCK</p>
            <p class="font-bold text-white" style="font-size:14px;">
                {{ $producto->stock }} unidades
            </p>
        </div>

        <div>
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">CREADO</p>
            <p class="font-bold text-white" style="font-size:14px;">
                {{ $producto->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

        @if($producto->descripcion)
        <div class="col-span-2">
            <p class="font-black uppercase tracking-widest mb-1"
                style="font-size:10px; color:rgba(255,255,255,0.4);">DESCRIPCIÓN</p>
            <p class="font-bold text-white" style="font-size:13px; line-height:1.6;">
                {{ $producto->descripcion }}
            </p>
        </div>
        @endif

    </div>
</div>

@endsection