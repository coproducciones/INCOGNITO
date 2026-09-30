@extends('layouts.app')

@section('title', 'Editar Reseña')

@section('content')

<div class="max-w-3xl">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="mb-8">

        <a
            href="{{ route('reseñas.index') }}"
            class="font-bold uppercase tracking-widest"
            style="
                font-size:9px;
                color:rgba(255,255,255,0.4);
            "
        >
            ← VOLVER A RESEÑAS
        </a>


        <h1
            class="mt-5 font-black uppercase tracking-widest text-white"
            style="
                font-size:22px;
                letter-spacing:0.15em;
            "
        >
            EDITAR RESEÑA
        </h1>


        <p
            class="mt-1 font-bold uppercase tracking-widest"
            style="
                font-size:10px;
                color:rgba(255,255,255,0.4);
            "
        >
            ACTUALIZAR INFORMACIÓN DE LA RESEÑA
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- FORMULARIO --}}
    {{-- ========================================================= --}}

    <form
        action="{{ route('reseñas.update', $reseña) }}"
        method="POST"
        class="space-y-6"
    >

        @csrf

        @method('PUT')


        {{-- CLIENTE --}}

        <div>

            <label
                for="cliente_id"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                CLIENTE
            </label>


            <select
                name="cliente_id"
                id="cliente_id"
                required
                class="w-full px-4 py-3 text-white outline-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
            >

                @foreach($clientes as $cliente)

                    <option
                        value="{{ $cliente->id }}"
                        style="background:#111;"
                        {{ old('cliente_id', $reseña->cliente_id) == $cliente->id ? 'selected' : '' }}
                    >
                        {{ $cliente->nombre }}
                    </option>

                @endforeach

            </select>


            @error('cliente_id')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- CALIFICACIÓN --}}

        <div>

            <label
                for="calificacion"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                CALIFICACIÓN
            </label>


            <select
                name="calificacion"
                id="calificacion"
                required
                class="w-full px-4 py-3 text-white outline-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
            >

                @for($i = 5; $i >= 1; $i--)

                    <option
                        value="{{ $i }}"
                        style="background:#111;"
                        {{ old('calificacion', $reseña->calificacion) == $i ? 'selected' : '' }}
                    >
                        {{ $i }} {{ $i == 1 ? 'ESTRELLA' : 'ESTRELLAS' }}
                    </option>

                @endfor

            </select>


            @error('calificacion')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- COMENTARIO --}}

        <div>

            <label
                for="comentario"
                class="mb-2 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                COMENTARIO
            </label>


            <textarea
                name="comentario"
                id="comentario"
                rows="6"
                required
                class="w-full px-4 py-3 text-white outline-none resize-none"
                style="
                    background:rgba(255,255,255,0.04);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                    font-size:12px;
                "
            >{{ old('comentario', $reseña->comentario) }}</textarea>


            @error('comentario')

                <p
                    class="mt-2 font-bold uppercase"
                    style="font-size:9px; color:#f87171;"
                >
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- ESTADO --}}

        <div>

            <label
                class="mb-3 block font-black uppercase tracking-widest"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                "
            >
                ESTADO
            </label>


            <label class="inline-flex items-center gap-3 cursor-pointer">

                <input
                    type="checkbox"
                    name="activo"
                    value="1"
                    class="h-4 w-4 accent-emerald-500"
                    {{ old('activo', $reseña->activo) ? 'checked' : '' }}
                >

                <span
                    class="font-bold uppercase tracking-widest text-white"
                    style="font-size:10px;"
                >
                    RESEÑA ACTIVA
                </span>

            </label>

        </div>


        {{-- BOTONES --}}

        <div
            class="flex items-center gap-3 pt-4"
            style="border-top:1px solid rgba(255,255,255,0.08);"
        >

            <button
                type="submit"
                class="font-black uppercase tracking-widest px-6 py-3 text-black"
                style="
                    font-size:10px;
                    background:#00c896;
                    border-radius:4px;
                "
            >
                ACTUALIZAR RESEÑA
            </button>


            <a
                href="{{ route('reseñas.index') }}"
                class="font-black uppercase tracking-widest px-6 py-3"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.5);
                    border:1px solid rgba(255,255,255,0.1);
                    border-radius:4px;
                "
            >
                CANCELAR
            </a>

        </div>

    </form>

</div>

@endsection