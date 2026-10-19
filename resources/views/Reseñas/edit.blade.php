@extends('layouts.app')

@section('title', 'Editar Reseña')

@section('content')

{{-- ========================================================= --}}
{{-- EDICIÓN PERSONAL: MI CUENTA                               --}}
{{-- ========================================================= --}}

@if($modoMiCuenta ?? false)

    <div class="max-w-3xl">

        {{-- Encabezado de la página --}}
        <div class="mb-8">

            <a
                href="{{ route('mi-cuenta.resenas') }}"
                class="font-bold uppercase tracking-widest"
                style="font-size: 9px; color: rgba(255,255,255,.4);"
            >
                ← MIS RESEÑAS
            </a>

            <h1
                class="mt-5 font-black uppercase tracking-widest text-white"
                style="font-size: 22px; letter-spacing: .15em;"
            >
                EDITAR RESEÑA
            </h1>

            <p
                class="mt-1 font-bold uppercase tracking-widest"
                style="font-size: 10px; color: rgba(255,255,255,.4);"
            >
                {{ $reseña->producto?->nombre ?? 'PRODUCTO' }}
            </p>

        </div>

        {{-- Mensajes de validación --}}
        @if($errors->any())

            <div
                class="mb-6 p-4"
                style="
                    background: rgba(248,113,113,.08);
                    border: 1px solid rgba(248,113,113,.25);
                    border-radius: 4px;
                "
            >
                @foreach($errors->all() as $error)

                    <p
                        class="font-bold"
                        style="font-size: 10px; color: #f87171;"
                    >
                        {{ $error }}
                    </p>

                @endforeach
            </div>

        @endif

        {{-- Formulario para editar la reseña del usuario autenticado --}}
        <form
            action="{{ route('mi-cuenta.resenas.update', $reseña) }}"
            method="POST"
            class="space-y-6"
        >

            @csrf
            @method('PUT')

            {{-- Calificación --}}
            <div>

                <label
                    for="calificacion"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    CALIFICACIÓN
                </label>

                <select
                    name="calificacion"
                    id="calificacion"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                >

                    @for($i = 5; $i >= 1; $i--)

                        <option
                            value="{{ $i }}"
                            style="background: #111;"
                            {{ old('calificacion', $reseña->calificacion) == $i ? 'selected' : '' }}
                        >
                            {{ $i }}
                            {{ $i === 1 ? 'ESTRELLA' : 'ESTRELLAS' }}
                        </option>

                    @endfor

                </select>

                @error('calificacion')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Comentario --}}
            <div>

                <label
                    for="comentario"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    COMENTARIO
                </label>

                <textarea
                    name="comentario"
                    id="comentario"
                    rows="6"
                    class="w-full px-4 py-3 text-white outline-none resize-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                    placeholder="CUÉNTANOS TU EXPERIENCIA..."
                >{{ old('comentario', $reseña->comentario) }}</textarea>

                @error('comentario')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Mostrar la respuesta de la empresa, si existe --}}
            @if($reseña->respuesta)

                <div
                    class="p-4"
                    style="
                        background: rgba(0,200,150,.04);
                        border-left: 2px solid #00c896;
                    "
                >

                    <p
                        class="font-black uppercase tracking-widest"
                        style="font-size: 9px; color: #00c896;"
                    >
                        RESPUESTA DE LA EMPRESA
                    </p>

                    <p
                        class="mt-2 text-gray-300"
                        style="font-size: 11px;"
                    >
                        {{ $reseña->respuesta }}
                    </p>

                </div>

            @endif

            {{-- Botones de acción --}}
            <div
                class="flex items-center gap-3 pt-4"
                style="border-top: 1px solid rgba(255,255,255,.08);"
            >

                <button
                    type="submit"
                    class="px-6 py-3 font-black uppercase tracking-widest text-black"
                    style="
                        font-size: 10px;
                        background: #00c896;
                        border-radius: 4px;
                    "
                >
                    GUARDAR CAMBIOS
                </button>

                <a
                    href="{{ route('mi-cuenta.resenas') }}"
                    class="px-6 py-3 font-black uppercase tracking-widest"
                    style="
                        font-size: 10px;
                        color: rgba(255,255,255,.5);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                    "
                >
                    CANCELAR
                </a>

            </div>

        </form>

    </div>

@else

    {{-- ===================================================== --}}
    {{-- EDICIÓN ADMINISTRATIVA                                --}}
    {{-- ===================================================== --}}

    <div class="max-w-3xl">

        {{-- Encabezado de la página --}}
        <div class="mb-8">

            <a
                href="{{ route('reseñas.index') }}"
                class="font-bold uppercase tracking-widest"
                style="font-size: 9px; color: rgba(255,255,255,.4);"
            >
                ← VOLVER A RESEÑAS
            </a>

            <h1
                class="mt-5 font-black uppercase tracking-widest text-white"
                style="font-size: 22px; letter-spacing: .15em;"
            >
                EDITAR RESEÑA
            </h1>

            <p
                class="mt-1 font-bold uppercase tracking-widest"
                style="font-size: 10px; color: rgba(255,255,255,.4);"
            >
                ACTUALIZAR INFORMACIÓN DE LA RESEÑA
            </p>

        </div>

        {{-- Mensajes generales de validación --}}
        @if($errors->any())

            <div
                class="mb-6 px-4 py-3 rounded border border-red-500/20 bg-red-500/10 text-sm text-red-300"
            >

                <p class="mb-2 font-bold uppercase tracking-widest">
                    REVISA LOS SIGUIENTES CAMPOS
                </p>

                <ul class="list-disc list-inside">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Formulario administrativo --}}
        <form
            action="{{ route('reseñas.update', $reseña) }}"
            method="POST"
            class="space-y-6"
        >

            @csrf
            @method('PUT')

            {{-- Usuario que registra la reseña --}}
            <div>

                <label
                    for="id_usuario"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    USUARIO
                </label>

                <select
                    name="id_usuario"
                    id="id_usuario"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                >

                    @foreach($usuarios as $usuario)

                        <option
                            value="{{ $usuario->id }}"
                            style="background: #111;"
                            {{ old('id_usuario', $reseña->id_usuario) == $usuario->id ? 'selected' : '' }}
                        >
                            {{ $usuario->nombre }}
                            @if($usuario->email)
                                — {{ $usuario->email }}
                            @endif
                        </option>

                    @endforeach

                </select>

                @error('id_usuario')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Producto reseñado --}}
            <div>

                <label
                    for="id_producto"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    PRODUCTO
                </label>

                <select
                    name="id_producto"
                    id="id_producto"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                >

                    @foreach($productos as $producto)

                        <option
                            value="{{ $producto->id }}"
                            style="background: #111;"
                            {{ old('id_producto', $reseña->id_producto) == $producto->id ? 'selected' : '' }}
                        >
                            {{ $producto->nombre }}
                        </option>

                    @endforeach

                </select>

                @error('id_producto')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- El cliente se conserva en la reseña existente.
                 No se solicita una selección manual porque la
                 asociación corresponde al registro original. --}}

            {{-- Calificación --}}
            <div>

                <label
                    for="calificacion"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    CALIFICACIÓN
                </label>

                <select
                    name="calificacion"
                    id="calificacion"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                >

                    @for($i = 5; $i >= 1; $i--)

                        <option
                            value="{{ $i }}"
                            style="background: #111;"
                            {{ old('calificacion', $reseña->calificacion) == $i ? 'selected' : '' }}
                        >
                            {{ $i }}
                            {{ $i === 1 ? 'ESTRELLA' : 'ESTRELLAS' }}
                        </option>

                    @endfor

                </select>

                @error('calificacion')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Comentario de la reseña --}}
            <div>

                <label
                    for="comentario"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    COMENTARIO
                </label>

                <textarea
                    name="comentario"
                    id="comentario"
                    rows="6"
                    class="w-full px-4 py-3 text-white outline-none resize-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                    placeholder="ESCRIBE EL COMENTARIO DEL CLIENTE..."
                >{{ old('comentario', $reseña->comentario) }}</textarea>

                @error('comentario')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Respuesta de la empresa --}}
            <div>

                <label
                    for="respuesta"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    RESPUESTA DE LA EMPRESA
                </label>

                <textarea
                    name="respuesta"
                    id="respuesta"
                    rows="4"
                    class="w-full px-4 py-3 text-white outline-none resize-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                    placeholder="ESCRIBE LA RESPUESTA DE LA EMPRESA..."
                >{{ old('respuesta', $reseña->respuesta) }}</textarea>

                @error('respuesta')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Botones de acción --}}
            <div
                class="flex items-center gap-3 pt-4"
                style="border-top: 1px solid rgba(255,255,255,.08);"
            >

                <button
                    type="submit"
                    class="px-6 py-3 font-black uppercase tracking-widest text-black"
                    style="
                        font-size: 10px;
                        background: #00c896;
                        border-radius: 4px;
                    "
                >
                    ACTUALIZAR RESEÑA
                </button>

                <a
                    href="{{ route('reseñas.index') }}"
                    class="px-6 py-3 font-black uppercase tracking-widest"
                    style="
                        font-size: 10px;
                        color: rgba(255,255,255,.5);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                    "
                >
                    CANCELAR
                </a>

            </div>

        </form>

    </div>

@endif

@endsection