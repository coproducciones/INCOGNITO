@extends('layouts.app')

@section('content')

<div class="p-6 max-w-lg">

    <div class="mb-6">
        <h1 class="text-white font-black text-xl uppercase tracking-widest">
            Editar categoría
        </h1>
        <p class="text-xs uppercase tracking-widest mt-1"
            style="color:rgba(255,255,255,0.4);">
            Modifica los datos de la categoría
        </p>
    </div>

    <div style="background-color:#1a1a1a; border:1px solid rgba(255,255,255,0.08); border-radius:4px; padding:24px;">

        <form action="{{ route('categorias.update', $categoria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="block font-black uppercase tracking-widest mb-2"
                    style="font-size:10px; color:rgba(255,255,255,0.4);">
                    Nombre
                </label>
                <input type="text" name="nombre"
                    value="{{ old('nombre', $categoria->nombre) }}"
                    class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                    style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px;"
                    placeholder="Nombre de la categoría"
                    onfocus="this.style.borderColor='#00c896'"
                    onblur="this.style.borderColor='rgba(255,255,255,0.15)'">

                @error('nombre')
                    <p class="mt-1 font-bold uppercase tracking-widest"
                        style="font-size:10px; color:#f87171;">
                        {{ $message }}
                    </p>
                @enderror
            </div>
<div>
    <label class="block mb-2 text-sm font-bold text-white">
        Descripción
    </label>

    <input
        type="text"
        name="descripcion"
        value="{{ old('descripcion', $categoria->descripcion) }}"
        class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
        style="border:1px solid rgba(255,255,255,0.15); border-radius:4px; font-size:13px;"
        placeholder="Descripción de la categoría"
        onfocus="this.style.borderColor='#00c896'"
        onblur="this.style.borderColor='rgba(255,255,255,0.15)'"
    >
</div>
            <div class="flex gap-3">
                <button type="submit"
                    class="px-6 py-2 font-black uppercase tracking-widest transition-colors"
                    style="background-color:#00c896; color:#000; border-radius:4px; font-size:11px;">
                    Actualizar
                </button>
                <a href="{{ route('categorias.index') }}"
                    class="px-6 py-2 font-black uppercase tracking-widest transition-colors"
                    style="border:1px solid rgba(255,255,255,0.15); color:rgba(255,255,255,0.6); border-radius:4px; font-size:11px;">
                    Cancelar
                </a>
            </div>

        </form>
    </div>

</div>

@endsection