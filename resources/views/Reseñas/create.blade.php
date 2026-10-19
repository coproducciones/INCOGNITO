@extends('layouts.app')

@section(
    'title',
    ($modoMiCuenta ?? false)
        ? 'Escribir reseña'
        : 'Nueva reseña'
)

@section('content')

{{-- ========================================================= --}}
{{-- MODO CLIENTE: CREAR UNA RESEÑA DESDE MI CUENTA            --}}
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
                ESCRIBIR RESEÑA
            </h1>

            <p
                class="mt-1 font-bold uppercase tracking-widest"
                style="font-size: 10px; color: rgba(255,255,255,.4);"
            >
                COMPARTE TU EXPERIENCIA CON UN PRODUCTO COMPRADO
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

                <p
                    class="mb-2 font-black uppercase tracking-widest"
                    style="font-size: 10px; color: #f87171;"
                >
                    REVISA LOS SIGUIENTES CAMPOS
                </p>

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

        {{-- ================================================= --}}
        {{-- COMPROBAR SI EXISTEN PRODUCTOS DISPONIBLES         --}}
        {{-- ================================================= --}}

        @if(
            !isset($productos)
            || $productos->isEmpty()
        )

            <div
                class="p-6"
                style="
                    background: rgba(255,255,255,.03);
                    border: 1px solid rgba(255,255,255,.08);
                    border-radius: 6px;
                "
            >

                <p
                    class="font-black uppercase tracking-widest text-white"
                    style="font-size: 11px;"
                >
                    NO HAY PRODUCTOS DISPONIBLES PARA RESEÑAR
                </p>

                <p
                    class="mt-3 text-gray-400"
                    style="font-size: 11px; line-height: 1.8;"
                >
                    Aquí aparecerán los productos de tus pedidos
                    completados que todavía no hayas reseñado.
                </p>

                <p
                    class="mt-2 text-gray-500"
                    style="font-size: 10px; line-height: 1.8;"
                >
                    Si tienes un pedido completado y no aparece
                    ningún producto, comprueba el estado del pedido
                    y que el producto todavía no tenga una reseña
                    tuya.
                </p>

                {{-- Acciones de navegación --}}
                <div class="flex flex-wrap items-center gap-3 mt-6">

                    <a
                        href="{{ route('mi-cuenta.resenas') }}"
                        class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest"
                        style="
                            font-size: 10px;
                            color: rgba(255,255,255,.6);
                            border: 1px solid rgba(255,255,255,.1);
                            border-radius: 4px;
                        "
                    >
                        VOLVER A MIS RESEÑAS
                    </a>

                </div>

            </div>

        @else

            {{-- ============================================= --}}
            {{-- FORMULARIO DEL CLIENTE                         --}}
            {{-- ============================================= --}}

            <form
                action="{{ route('mi-cuenta.resenas.store') }}"
                method="POST"
                class="space-y-6"
            >

                @csrf

                {{-- Seleccionar un producto comprado --}}
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

                        <option
                            value=""
                            style="background: #111;"
                        >
                            SELECCIONAR PRODUCTO
                        </option>

                        @foreach($productos as $producto)

                            <option
                                value="{{ $producto->id }}"
                                style="background: #111;"
                                {{ (string) old('id_producto') === (string) $producto->id ? 'selected' : '' }}
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

                {{-- Seleccionar la calificación --}}
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

                        <option
                            value=""
                            style="background: #111;"
                        >
                            SELECCIONAR CALIFICACIÓN
                        </option>

                        @for($i = 5; $i >= 1; $i--)

                            <option
                                value="{{ $i }}"
                                style="background: #111;"
                                {{ (string) old('calificacion') === (string) $i ? 'selected' : '' }}
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

                {{-- Escribir el comentario --}}
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
                    >{{ old('comentario') }}</textarea>

                    @error('comentario')

                        <p
                            class="mt-2 font-bold"
                            style="font-size: 9px; color: #f87171;"
                        >
                            {{ $message }}
                        </p>

                    @enderror

                </div>

                {{-- Botones del formulario --}}
                <div
                    class="flex flex-wrap items-center gap-3 pt-4"
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
                        PUBLICAR RESEÑA
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

        @endif

    </div>

{{-- ========================================================= --}}
{{-- MODO ADMINISTRATIVO: CREAR UNA RESEÑA                     --}}
{{-- ========================================================= --}}

@else

    <div class="max-w-3xl">

        {{-- Encabezado --}}
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
                NUEVA RESEÑA
            </h1>

            <p
                class="mt-1 font-bold uppercase tracking-widest"
                style="font-size: 10px; color: rgba(255,255,255,.4);"
            >
                REGISTRAR UNA NUEVA RESEÑA
            </p>

        </div>

        {{-- Errores de validación --}}
        @if($errors->any())

            <div
                class="mb-6 p-4"
                style="
                    background: rgba(248,113,113,.08);
                    border: 1px solid rgba(248,113,113,.25);
                    border-radius: 4px;
                "
            >

                <p
                    class="font-black uppercase tracking-widest"
                    style="font-size: 10px; color: #f87171;"
                >
                    REVISA LOS SIGUIENTES CAMPOS
                </p>

                <ul class="mt-2 space-y-1">

                    @foreach($errors->all() as $error)

                        <li
                            class="font-bold"
                            style="font-size: 10px; color: rgba(255,255,255,.6);"
                        >
                            • {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Formulario administrativo --}}
        <form
            action="{{ route('reseñas.store') }}"
            method="POST"
            class="space-y-6"
        >

            @csrf

            {{-- Seleccionar usuario --}}
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

                    <option
                        value=""
                        style="background: #111;"
                    >
                        SELECCIONAR USUARIO
                    </option>

                    @foreach($usuarios as $usuario)

                        <option
                            value="{{ $usuario->id }}"
                            style="background: #111;"
                            {{ (string) old('id_usuario') === (string) $usuario->id ? 'selected' : '' }}
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

            {{-- Seleccionar producto --}}
            <div>

                <label
                    for="id_producto_admin"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    PRODUCTO
                </label>

                <select
                    name="id_producto"
                    id="id_producto_admin"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                >

                    <option
                        value=""
                        style="background: #111;"
                    >
                        SELECCIONAR PRODUCTO
                    </option>

                    @foreach($productos as $producto)

                        <option
                            value="{{ $producto->id }}"
                            style="background: #111;"
                            {{ (string) old('id_producto') === (string) $producto->id ? 'selected' : '' }}
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

            {{-- Calificación --}}
            <div>

                <label
                    for="calificacion_admin"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    CALIFICACIÓN
                </label>

                <select
                    name="calificacion"
                    id="calificacion_admin"
                    required
                    class="w-full px-4 py-3 text-white outline-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                >

                    <option
                        value=""
                        style="background: #111;"
                    >
                        SELECCIONAR CALIFICACIÓN
                    </option>

                    @for($i = 5; $i >= 1; $i--)

                        <option
                            value="{{ $i }}"
                            style="background: #111;"
                            {{ (string) old('calificacion') === (string) $i ? 'selected' : '' }}
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
                    for="comentario_admin"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.5);"
                >
                    COMENTARIO
                </label>

                <textarea
                    name="comentario"
                    id="comentario_admin"
                    rows="6"
                    class="w-full px-4 py-3 text-white outline-none resize-none"
                    style="
                        background: rgba(255,255,255,.04);
                        border: 1px solid rgba(255,255,255,.1);
                        border-radius: 4px;
                        font-size: 12px;
                    "
                    placeholder="ESCRIBE EL COMENTARIO DEL CLIENTE..."
                >{{ old('comentario') }}</textarea>

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
                    placeholder="RESPUESTA OPCIONAL DE LA EMPRESA..."
                >{{ old('respuesta') }}</textarea>

                @error('respuesta')

                    <p
                        class="mt-2 font-bold"
                        style="font-size: 9px; color: #f87171;"
                    >
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Botones --}}
            <div
                class="flex flex-wrap items-center gap-3 pt-4"
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
                    GUARDAR RESEÑA
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