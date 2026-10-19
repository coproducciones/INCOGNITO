@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-xl font-black uppercase tracking-widest text-white">Nuevo producto</h1>
        <p class="mt-1 text-xs font-bold uppercase tracking-widest text-white/40">Gestión de productos</p>
    </div>
    <a href="{{ route('productos.index') }}" class="rounded border border-white/20 px-5 py-2 text-xs font-bold uppercase text-white">
        ← Volver
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded border border-red-400/30 bg-red-400/10 px-4 py-3 text-sm text-red-300">
        Revisa los campos señalados antes de continuar.
    </div>
@endif

<div class="rounded-lg border border-white/10 bg-white/[0.03] p-5 sm:p-8">
    <form action="{{ route('productos.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Categoría a la que pertenece el producto. --}}
        <div>
            <label for="categoria_id" class="mb-2 block text-xs font-bold uppercase text-white/60">Categoría *</label>
            <select id="categoria_id" name="categoria_id" required class="w-full rounded border border-white/15 bg-[#111] px-4 py-3 text-sm text-white">
                <option value="">Selecciona una categoría</option>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id') == $categoria->id)>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>

        {{-- El proveedor asociado define a quién se contactará por WhatsApp. --}}
        <div>
            <label for="id_proveedor" class="mb-2 block text-xs font-bold uppercase text-white/60">Proveedor *</label>
            <select id="id_proveedor" name="id_proveedor" required class="w-full rounded border border-white/15 bg-[#111] px-4 py-3 text-sm text-white">
                <option value="">Selecciona un proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}" @selected(old('id_proveedor') == $proveedor->id_proveedor)>
                        {{ $proveedor->especialidad }} — {{ $proveedor->usuario->nombre ?? 'Proveedor #' . $proveedor->id_proveedor }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-white/40">Registra el número de WhatsApp del proveedor con código de país, por ejemplo 573001234567.</p>
            @if ($proveedores->isEmpty())
                <p class="mt-2 text-xs text-amber-300">No hay proveedores activos. Registra uno antes de crear el producto.</p>
            @endif
            @error('id_proveedor') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="nombre" class="mb-2 block text-xs font-bold uppercase text-white/60">Nombre *</label>
            <input id="nombre" name="nombre" type="text" maxlength="80" required value="{{ old('nombre') }}" placeholder="Nombre del producto" class="w-full rounded border border-white/15 bg-transparent px-4 py-3 text-sm text-white">
            @error('nombre') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="descripcion" class="mb-2 block text-xs font-bold uppercase text-white/60">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" class="w-full rounded border border-white/15 bg-transparent px-4 py-3 text-sm text-white" placeholder="Descripción del producto">{{ old('descripcion') }}</textarea>
            @error('descripcion') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="precio" class="mb-2 block text-xs font-bold uppercase text-white/60">Precio *</label>
                <input id="precio" name="precio" type="number" min="0" step="0.01" required value="{{ old('precio') }}" class="w-full rounded border border-white/15 bg-transparent px-4 py-3 text-sm text-white">
                @error('precio') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="stock" class="mb-2 block text-xs font-bold uppercase text-white/60">Stock *</label>
                <input id="stock" name="stock" type="number" min="0" step="1" required value="{{ old('stock', 0) }}" class="w-full rounded border border-white/15 bg-transparent px-4 py-3 text-sm text-white">
                @error('stock') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Si se desmarca, el navegador no envía el checkbox. --}}
        <label class="flex items-center gap-3 text-xs font-bold uppercase text-white/60">
            <input type="checkbox" name="activo" value="1" @checked(old('activo', true)) class="accent-[#00c896]">
            Producto activo
        </label>

        <div class="flex flex-wrap gap-3 pt-2">
            @if (auth()->check() && auth()->user()->tienePermiso('productos.crear'))
                <button type="submit" @disabled($proveedores->isEmpty()) class="rounded bg-[#00c896] px-6 py-3 text-xs font-black uppercase tracking-widest text-black disabled:cursor-not-allowed disabled:opacity-50">
                    Guardar producto
                </button>
            @endif
            <a href="{{ route('productos.index') }}" class="rounded border border-white/20 px-6 py-3 text-xs font-bold uppercase text-white">Cancelar</a>
        </div>
    </form>
</div>
@endsection
