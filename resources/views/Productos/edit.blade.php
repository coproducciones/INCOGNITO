@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')

<div class="w-full">

    {{-- =========================================================
         ENCABEZADO
         ========================================================= --}}

    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">

        <div>

            <h1
                class="font-black uppercase tracking-widest text-white"
                style="font-size:22px; letter-spacing:0.15em;"
            >
                EDITAR PRODUCTO
            </h1>

            <p
                class="mt-2 font-bold uppercase tracking-widest"
                style="font-size:10px; color:rgba(255,255,255,0.4);"
            >
                GESTIÓN DE PRODUCTOS
            </p>

            <div
                class="mt-4"
                style="
                    width:60px;
                    height:3px;
                    background:#A99045;
                    border-radius:2px;
                "
            ></div>

        </div>

        <a
            href="{{ route('productos.index') }}"
            class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all hover:bg-white/10"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.75);
                background:#1D1D1D;
                border:1px solid rgba(255,255,255,0.12);
                border-radius:4px;
                letter-spacing:0.1em;
            "
        >
            ← VOLVER
        </a>

    </div>


    {{-- =========================================================
         ERRORES DE VALIDACIÓN
         ========================================================= --}}

    @if ($errors->any())

        <div
            class="mb-6 px-4 py-4"
            style="
                background:rgba(248,113,113,0.08);
                border:1px solid rgba(248,113,113,0.25);
                border-left:3px solid #f87171;
                border-radius:4px;
            "
        >

            <p
                class="font-black uppercase tracking-widest mb-2"
                style="font-size:10px; color:#f87171;"
            >
                Revisa los campos señalados antes de continuar.
            </p>

            <ul
                class="list-disc list-inside space-y-1"
                style="font-size:11px; color:rgba(255,255,255,0.75);"
            >
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- =========================================================
         FORMULARIO DE EDICIÓN
         ========================================================= --}}

    <div
        class="p-5 sm:p-8"
        style="
            background:#111111;
            border:1px solid rgba(169,144,69,0.25);
            border-radius:6px;
            box-shadow:0 10px 30px rgba(0,0,0,0.20);
        "
    >

        <form
            action="{{ route('productos.update', $producto) }}"
            method="POST"
            class="space-y-6"
        >

            @csrf
            @method('PUT')


            {{-- =================================================
                 CATEGORÍA
                 ================================================= --}}

            <div>

                <label
                    for="categoria_id"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size:10px; color:rgba(255,255,255,0.65);"
                >
                    Categoría *
                </label>

                <select
                    id="categoria_id"
                    name="categoria_id"
                    required
                    class="w-full px-4 py-3 text-sm text-white outline-none transition-all"
                    style="
                        background:#1D1D1D;
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                    "
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                >

                    <option value="" style="background:#1D1D1D;">
                        Selecciona una categoría
                    </option>

                    @foreach ($categorias as $categoria)

                        <option
                            value="{{ $categoria->id }}"
                            @selected(old('categoria_id', $producto->categoria_id) == $categoria->id)
                            style="background:#1D1D1D;"
                        >
                            {{ $categoria->nombre }}
                        </option>

                    @endforeach

                </select>

                @error('categoria_id')
                    <p class="mt-2 font-bold" style="font-size:10px; color:#f87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- =================================================
                 PROVEEDOR
                 ================================================= --}}

            <div>

                <label
                    for="id_proveedor"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size:10px; color:rgba(255,255,255,0.65);"
                >
                    Proveedor *
                </label>

                <select
                    id="id_proveedor"
                    name="id_proveedor"
                    required
                    class="w-full px-4 py-3 text-sm text-white outline-none transition-all"
                    style="
                        background:#1D1D1D;
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                    "
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                >

                    <option value="" style="background:#1D1D1D;">
                        Selecciona un proveedor
                    </option>

                    @foreach ($proveedores as $proveedor)

                        <option
                            value="{{ $proveedor->id_proveedor }}"
                            @selected(old('id_proveedor', $producto->id_proveedor) == $proveedor->id_proveedor)
                            style="background:#1D1D1D;"
                        >
                            {{ $proveedor->especialidad }} — {{ $proveedor->usuario->nombre ?? 'Proveedor #' . $proveedor->id_proveedor }}
                        </option>

                    @endforeach

                </select>

                <p
                    class="mt-2"
                    style="font-size:10px; line-height:1.7; color:rgba(255,255,255,0.4);"
                >
                    El proveedor debe tener WhatsApp con código de país para poder contactarlo.
                </p>

                @if ($proveedores->isEmpty())

                    <p
                        class="mt-2 font-bold"
                        style="font-size:10px; color:#D8C17F;"
                    >
                        No hay proveedores activos disponibles.
                    </p>

                @endif

                @error('id_proveedor')
                    <p class="mt-2 font-bold" style="font-size:10px; color:#f87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- =================================================
                 NOMBRE
                 ================================================= --}}

            <div>

                <label
                    for="nombre"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size:10px; color:rgba(255,255,255,0.65);"
                >
                    Nombre *
                </label>

                <input
                    id="nombre"
                    name="nombre"
                    type="text"
                    maxlength="80"
                    required
                    value="{{ old('nombre', $producto->nombre) }}"
                    class="w-full px-4 py-3 text-sm text-white outline-none transition-all"
                    style="
                        background:#1D1D1D;
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                    "
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                >

                @error('nombre')
                    <p class="mt-2 font-bold" style="font-size:10px; color:#f87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- =================================================
                 DESCRIPCIÓN
                 ================================================= --}}

            <div>

                <label
                    for="descripcion"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size:10px; color:rgba(255,255,255,0.65);"
                >
                    Descripción
                </label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                    rows="3"
                    class="w-full px-4 py-3 text-sm text-white outline-none transition-all"
                    style="
                        background:#1D1D1D;
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                        resize:vertical;
                    "
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                >{{ old('descripcion', $producto->descripcion) }}</textarea>

                @error('descripcion')
                    <p class="mt-2 font-bold" style="font-size:10px; color:#f87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- =================================================
                 PRECIO Y STOCK
                 ================================================= --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                {{-- PRECIO --}}

                <div>

                    <label
                        for="precio"
                        class="mb-2 block font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.65);"
                    >
                        Precio *
                    </label>

                    <input
                        id="precio"
                        name="precio"
                        type="number"
                        min="0"
                        step="0.01"
                        required
                        value="{{ old('precio', $producto->precio) }}"
                        class="w-full px-4 py-3 text-sm text-white outline-none transition-all"
                        style="
                            background:#1D1D1D;
                            border:1px solid rgba(255,255,255,0.12);
                            border-radius:4px;
                        "
                        onfocus="this.style.borderColor='#A99045'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                    >

                    @error('precio')
                        <p class="mt-2 font-bold" style="font-size:10px; color:#f87171;">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- STOCK --}}

                <div>

                    <label
                        for="stock"
                        class="mb-2 block font-black uppercase tracking-widest"
                        style="font-size:10px; color:rgba(255,255,255,0.65);"
                    >
                        Stock *
                    </label>

                    <input
                        id="stock"
                        name="stock"
                        type="number"
                        min="0"
                        step="1"
                        required
                        value="{{ old('stock', $producto->stock) }}"
                        class="w-full px-4 py-3 text-sm text-white outline-none transition-all"
                        style="
                            background:#1D1D1D;
                            border:1px solid rgba(255,255,255,0.12);
                            border-radius:4px;
                        "
                        onfocus="this.style.borderColor='#A99045'"
                        onblur="this.style.borderColor='rgba(255,255,255,0.12)'"
                    >

                    @error('stock')
                        <p class="mt-2 font-bold" style="font-size:10px; color:#f87171;">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- =================================================
                 ESTADO DEL PRODUCTO
                 ================================================= --}}

            <div
                class="pt-4"
                style="border-top:1px solid rgba(255,255,255,0.08);"
            >

                <label
                    class="flex items-center gap-3 font-black uppercase tracking-widest cursor-pointer"
                    style="font-size:10px; color:rgba(255,255,255,0.65);"
                >

                    <input
                        type="checkbox"
                        name="activo"
                        value="1"
                        @checked(old('activo', $producto->activo))
                        class="accent-[#A99045]"
                    >

                    Producto activo

                </label>

            </div>


            {{-- =================================================
                 BOTONES
                 ================================================= --}}

            <div
                class="flex flex-wrap gap-3 pt-5"
                style="border-top:1px solid rgba(255,255,255,0.08);"
            >

                @if (auth()->check() && auth()->user()->tienePermiso('productos.editar'))

                    <button
                        type="submit"
                        @disabled($proveedores->isEmpty())
                        class="inline-flex items-center justify-center px-6 py-3 font-black uppercase tracking-widest transition-all hover:opacity-80 disabled:cursor-not-allowed disabled:opacity-50"
                        style="
                            font-size:10px;
                            color:#111111;
                            background:#A99045;
                            border:1px solid #A99045;
                            border-radius:4px;
                            letter-spacing:0.1em;
                        "
                    >
                        GUARDAR CAMBIOS
                    </button>

                @endif

                <a
                    href="{{ route('productos.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 font-black uppercase tracking-widest transition-all hover:bg-white/10"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.65);
                        background:#1D1D1D;
                        border:1px solid rgba(255,255,255,0.12);
                        border-radius:4px;
                        letter-spacing:0.1em;
                    "
                >
                    CANCELAR
                </a>

            </div>

        </form>

    </div>

</div>

@endsection
