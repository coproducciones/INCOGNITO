@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black uppercase tracking-widest text-white"
            style="font-size:22px; letter-spacing:0.15em;">EDITAR PRODUCTO</h1>
        <p class="font-bold uppercase tracking-widest mt-1"
            style="font-size:10px; color:rgba(255,255,255,0.4);">
            GESTIÓN DE PRODUCTOS
        </p>
    </div>
    <a href="{{ route('productos.index') }}"
        class="font-black uppercase tracking-widest px-5 py-2 text-white"
        style="font-size:11px; border:1px solid rgba(255,255,255,0.2); border-radius:4px; letter-spacing:0.1em;">
        ← VOLVER
    </a>
</div>

@if($errors->any())
    <div class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
        style="font-size:10px; background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.3); border-radius:4px; color:#f87171;">
        Por favor corrige los errores antes de continuar.
    </div>
@endif

<div style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08); border-radius:6px;" class="p-8">
    <form action="{{ route('productos.update', $producto) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Categoría --}}
        <div class="mb-5">
            <label class="block font-black uppercase tracking-widest mb-2"
                style="font-size:10px; color:rgba(255,255,255,0.4);">
                Categoría <span style="color:#00c896;">*</span>
            </label>
            <select name="categoria_id"
                class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px; background:#111; cursor:pointer;"
                onfocus="this.style.borderColor='#00c896'"
                onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
                <option value="">-- Selecciona una categoría --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <p class="mt-1 font-bold uppercase tracking-widest"
                    style="font-size:10px; color:#f87171;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nombre --}}
        <div class="mb-5">
            <label class="block font-black uppercase tracking-widest mb-2"
                style="font-size:10px; color:rgba(255,255,255,0.4);">
                Nombre <span style="color:#00c896;">*</span>
            </label>
            <input type="text" name="nombre"
                value="{{ old('nombre', $producto->nombre) }}"
                class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px;"
                placeholder="Nombre del producto"
                onfocus="this.style.borderColor='#00c896'"
                onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
            @error('nombre')
                <p class="mt-1 font-bold uppercase tracking-widest"
                    style="font-size:10px; color:#f87171;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div class="mb-5">
            <label class="block font-black uppercase tracking-widest mb-2"
                style="font-size:10px; color:rgba(255,255,255,0.4);">
                Descripción
            </label>
            <textarea name="descripcion" rows="3"
                class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px; resize:vertical;"
                placeholder="Descripción del producto"
                onfocus="this.style.borderColor='#00c896'"
                onblur="this.style.borderColor='rgba(255,255,255,0.15)'">{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion')
                <p class="mt-1 font-bold uppercase tracking-widest"
                    style="font-size:10px; color:#f87171;">{{ $message }}</p>
            @enderror
        </div>

        {{-- Precio y Stock --}}
        <div class="grid grid-cols-2 gap-5 mb-5">
            <div>
                <label class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.4);">
                    Precio <span style="color:#00c896;">*</span>
                </label>
                <input type="number" name="precio"
                    value="{{ old('precio', $producto->precio) }}"
                    step="0.01" min="0"
                    class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                    style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px;"
                    placeholder="0.00"
                    onfocus="this.style.borderColor='#00c896'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
                @error('precio')
                    <p class="mt-1 font-bold uppercase tracking-widest"
                        style="font-size:10px; color:#f87171;">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.4);">
                    Stock <span style="color:#00c896;">*</span>
                </label>
                <input type="number" name="stock"
                    value="{{ old('stock', $producto->stock) }}"
                    min="0"
                    class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                    style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px;"
                    placeholder="0"
                    onfocus="this.style.borderColor='#00c896'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
                @error('stock')
                    <p class="mt-1 font-bold uppercase tracking-widest"
                        style="font-size:10px; color:#f87171;">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Activo --}}
        <div class="mb-8 flex items-center gap-3">
            <input type="checkbox" name="activo" id="activo" value="1"
                {{ old('activo', $producto->activo) ? 'checked' : '' }}
                style="accent-color:#00c896; width:16px; height:16px; cursor:pointer;">
            <label for="activo" class="font-black uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4); cursor:pointer;">
                PRODUCTO ACTIVO
            </label>
        </div>

        {{-- Botones --}}
        <div class="flex items-center gap-4">
            <button type="submit"
                class="font-black uppercase tracking-widest px-6 py-2 text-black"
                style="font-size:11px; background:#00c896; border-radius:4px; letter-spacing:0.1em; cursor:pointer; border:none;">
                GUARDAR CAMBIOS
            </button>
            <a href="{{ route('productos.index') }}"
                class="font-black uppercase tracking-widest px-6 py-2 text-white"
                style="font-size:11px; border:1px solid rgba(255,255,255,0.2); border-radius:4px; letter-spacing:0.1em;">
                CANCELAR
            </a>
        </div>

    </form>
</div>

@endsection