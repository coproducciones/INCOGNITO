@extends('layouts.app')

@section('title', 'Editar Categoría')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>
        <h1
            class="font-black uppercase tracking-widest text-white"
            style="font-size:22px; letter-spacing:0.15em;"
        >
            EDITAR CATEGORÍA
        </h1>

        <p
            class="font-bold uppercase tracking-widest mt-1"
            style="font-size:10px; color:rgba(255,255,255,0.4);"
        >
            MODIFICAR DATOS DE LA CATEGORÍA
        </p>
    </div>

    <a
        href="{{ route('categorias.index') }}"
        class="font-black uppercase tracking-widest px-5 py-2 text-white"
        style="
            font-size:11px;
            border:1px solid rgba(255,255,255,0.2);
            border-radius:4px;
            letter-spacing:0.1em;
        "
    >
        ← VOLVER
    </a>

</div>


{{-- ERRORES GENERALES --}}
@if ($errors->any())

    <div
        class="mb-6 px-4 py-3 font-bold uppercase tracking-widest"
        style="
            font-size:10px;
            background:rgba(248,113,113,0.1);
            border:1px solid rgba(248,113,113,0.3);
            border-radius:4px;
            color:#f87171;
        "
    >
        Por favor corrige los errores antes de continuar.
    </div>

@endif


{{-- FORMULARIO --}}
<div
    class="p-8"
    style="
        background:rgba(255,255,255,0.03);
        border:1px solid rgba(255,255,255,0.08);
        border-radius:6px;
    "
>

    <form
        action="{{ route('categorias.update', $categoria) }}"
        method="POST"
    >

        @csrf
        @method('PUT')


        {{-- NOMBRE --}}
        <div class="mb-5">

            <label
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.4);
                "
            >
                Nombre <span style="color:#00c896;">*</span>
            </label>

            <input
                type="text"
                name="nombre"
                value="{{ old('nombre', $categoria->nombre) }}"
                maxlength="40"
                class="w-full px-4 py-2 font-bold text-white bg-transparent outline-none"
                style="
                    border:1px solid rgba(255,255,255,0.15);
                    border-radius:4px;
                    font-size:13px;
                "
                placeholder="Nombre de la categoría"
                onfocus="this.style.borderColor='#00c896'"
                onblur="this.style.borderColor='rgba(255,255,255,0.15)'"
            >

            @error('nombre')
                <p
                    class="mt-1 font-bold uppercase tracking-widest"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- DESCRIPCIÓN --}}
        <div class="mb-8">

            <label
                class="block font-black uppercase tracking-widest mb-2"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.4);
                "
            >
                Descripción
            </label>

            <textarea
                name="descripcion"
                rows="4"
                maxlength="100"
                class="w-full px-4 py-3 font-bold text-white bg-transparent outline-none resize-none"
                style="
                    border:1px solid rgba(255,255,255,0.15);
                    border-radius:4px;
                    font-size:13px;
                "
                placeholder="Descripción de la categoría"
                onfocus="this.style.borderColor='#00c896'"
                onblur="this.style.borderColor='rgba(255,255,255,0.15)'"
            >{{ old('descripcion', $categoria->descripcion) }}</textarea>

            @error('descripcion')
                <p
                    class="mt-1 font-bold uppercase tracking-widest"
                    style="
                        font-size:10px;
                        color:#f87171;
                    "
                >
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- BOTONES --}}
        <div class="flex items-center gap-4">

            <button
                type="submit"
                class="font-black uppercase tracking-widest px-6 py-2 text-black"
                style="
                    font-size:11px;
                    background:#00c896;
                    border-radius:4px;
                    letter-spacing:0.1em;
                    cursor:pointer;
                    border:none;
                "
            >
                ACTUALIZAR CATEGORÍA
            </button>

            <a
                href="{{ route('categorias.index') }}"
                class="font-black uppercase tracking-widest px-6 py-2 text-white"
                style="
                    font-size:11px;
                    border:1px solid rgba(255,255,255,0.2);
                    border-radius:4px;
                    letter-spacing:0.1em;
                "
            >
                CANCELAR
            </a>

        </div>

    </form>

</div>

@endsection