@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-xl font-black uppercase tracking-widest text-white">
            Nuevo producto
        </h1>
        <p class="mt-1 text-xs font-bold uppercase tracking-widest text-white/40">
            Gestión de productos
        </p>
        <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>
    </div>

    <a href="{{ route('productos.index') }}"
       class="inline-flex items-center justify-center rounded border border-[#A99045]/40 bg-[#1D1D1D] px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-[#D8C17F] transition hover:border-[#D8C17F] hover:bg-[#A99045]/10">
        ← Volver
    </a>
</div>

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-400/30 bg-red-400/10 px-4 py-3 text-sm text-red-300">
        Revisa los campos señalados antes de continuar.
    </div>
@endif

<div class="rounded-xl border border-[#A99045]/25 bg-[#111111] p-5 shadow-xl shadow-black/20 sm:p-8">
    <form action="{{ route('productos.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Categoría a la que pertenece el producto. --}}
        <div>
            <label for="categoria_id"
                   class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                Categoría *
            </label>

            <select id="categoria_id"
                    name="categoria_id"
                    required
                    class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]">
                <option value="" class="bg-[#1D1D1D] text-white/60">
                    Selecciona una categoría
                </option>

                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                            @selected(old('categoria_id') == $categoria->id)
                            class="bg-[#1D1D1D] text-white">
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>

            @error('categoria_id')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- El proveedor asociado define a quién se contactará por WhatsApp. --}}
        <div>
            <label for="id_proveedor"
                   class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                Proveedor *
            </label>

            <select id="id_proveedor"
                    name="id_proveedor"
                    required
                    class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]">
                <option value="" class="bg-[#1D1D1D] text-white/60">
                    Selecciona un proveedor
                </option>

                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}"
                            @selected(old('id_proveedor') == $proveedor->id_proveedor)
                            class="bg-[#1D1D1D] text-white">
                        {{ $proveedor->especialidad }} — {{ $proveedor->usuario->nombre ?? 'Proveedor #' . $proveedor->id_proveedor }}
                    </option>
                @endforeach
            </select>

            <p class="mt-2 text-xs leading-relaxed text-white/40">
                Registra el número de WhatsApp del proveedor con código de país, por ejemplo 573001234567.
            </p>

            @if ($proveedores->isEmpty())
                <p class="mt-2 rounded-lg border border-[#A99045]/30 bg-[#A99045]/10 px-3 py-2 text-xs text-[#D8C17F]">
                    No hay proveedores activos. Registra uno antes de crear el producto.
                </p>
            @endif

            @error('id_proveedor')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nombre"
                   class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                Nombre *
            </label>

            <input id="nombre"
                   name="nombre"
                   type="text"
                   maxlength="80"
                   required
                   value="{{ old('nombre') }}"
                   placeholder="Nombre del producto"
                   class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]">

            @error('nombre')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descripcion"
                   class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                Descripción
            </label>

            <textarea id="descripcion"
                      name="descripcion"
                      rows="3"
                      placeholder="Descripción del producto"
                      class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]">{{ old('descripcion') }}</textarea>

            @error('descripcion')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="precio"
                       class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                    Precio *
                </label>

                <input id="precio"
                       name="precio"
                       type="number"
                       min="0"
                       step="0.01"
                       required
                       value="{{ old('precio') }}"
                       class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]">

                @error('precio')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="stock"
                       class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                    Stock *
                </label>

                <input id="stock"
                       name="stock"
                       type="number"
                       min="0"
                       step="1"
                       required
                       value="{{ old('stock', 0) }}"
                       class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]">

                @error('stock')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Si se desmarca, el navegador no envía el checkbox. --}}
        <div class="rounded-lg border border-white/10 bg-[#1D1D1D] p-4">
            <label class="flex cursor-pointer items-center gap-3 text-xs font-bold uppercase tracking-wider text-white/70">
                <input type="checkbox"
                       name="activo"
                       value="1"
                       @checked(old('activo', true))
                       class="h-4 w-4 rounded border-white/20 bg-[#111111] accent-[#A99045] focus:ring-[#A99045]">

                <span>Producto activo</span>
            </label>
        </div>

        <div class="flex flex-wrap gap-3 border-t border-white/10 pt-6">
            @if (auth()->check() && auth()->user()->tienePermiso('productos.crear'))
                <button type="submit"
                        @disabled($proveedores->isEmpty())
                        class="rounded-lg bg-[#A99045] px-6 py-3 text-xs font-black uppercase tracking-widest text-[#111111] transition hover:bg-[#D8C17F] disabled:cursor-not-allowed disabled:opacity-50">
                    Guardar producto
                </button>
            @endif

            <a href="{{ route('productos.index') }}"
               class="rounded-lg border border-white/15 bg-[#1D1D1D] px-6 py-3 text-xs font-bold uppercase tracking-widest text-white/70 transition hover:border-[#A99045]/50 hover:text-[#D8C17F]">
                Cancelar
            </a>
        </div>
    </form>
</div>
@endsection
