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

    <div class="mx-auto max-w-3xl px-4 py-8">

        {{-- Encabezado de la página --}}
        <div class="mb-8">

            <a
                href="{{ route('mi-cuenta.resenas') }}"
                class="font-bold uppercase tracking-widest transition hover:text-[#D8C17F]"
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

            <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>

            <p
                class="mt-3 font-bold uppercase tracking-widest"
                style="font-size: 10px; color: rgba(255,255,255,.4);"
            >
                COMPARTE TU EXPERIENCIA CON UN PRODUCTO COMPRADO
            </p>

        </div>

        {{-- Mensajes de validación --}}
        @if($errors->any())

            <div
                class="mb-6 rounded-xl p-4"
                style="
                    background: rgba(248,113,113,.08);
                    border: 1px solid rgba(248,113,113,.25);
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
                class="rounded-2xl p-6 sm:p-8"
                style="
                    background: #111111;
                    border: 1px solid rgba(169,144,69,.3);
                "
            >

                <p
                    class="font-black uppercase tracking-widest text-white"
                    style="font-size: 11px;"
                >
                    NO HAY PRODUCTOS DISPONIBLES PARA RESEÑAR
                </p>

                <div class="mt-3 h-[2px] w-10 rounded-full bg-[#A99045]"></div>

                <p
                    class="mt-4 text-white/60"
                    style="font-size: 11px; line-height: 1.8;"
                >
                    Aquí aparecerán los productos de tus pedidos
                    completados que todavía no hayas reseñado.
                </p>

                <p
                    class="mt-2 text-white/40"
                    style="font-size: 10px; line-height: 1.8;"
                >
                    Si tienes un pedido completado y no aparece
                    ningún producto, comprueba el estado del pedido
                    y que el producto todavía no tenga una reseña
                    tuya.
                </p>

                {{-- Acciones de navegación --}}
                <div class="mt-6 flex flex-wrap items-center gap-3">

                    <a
                        href="{{ route('mi-cuenta.resenas') }}"
                        class="inline-flex items-center justify-center rounded-lg px-5 py-3 font-black uppercase tracking-widest transition hover:border-[#A99045] hover:text-[#D8C17F]"
                        style="
                            font-size: 10px;
                            color: rgba(255,255,255,.6);
                            border: 1px solid rgba(255,255,255,.1);
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
                class="space-y-6 rounded-2xl border border-[#A99045]/30 bg-[#111111] p-6 shadow-xl shadow-black/30 sm:p-8"
            >

                @csrf

                {{-- Seleccionar un producto comprado --}}
                <div>

                    <label
                        for="id_producto"
                        class="mb-2 block font-black uppercase tracking-widest"
                        style="font-size: 10px; color: rgba(255,255,255,.65);"
                    >
                        PRODUCTO
                    </label>

                    <select
                        name="id_producto"
                        id="id_producto"
                        required
                        class="w-full rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                        style="
                            background: #1D1D1D;
                            border: 1px solid rgba(255,255,255,.1);
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
                        style="font-size: 10px; color: rgba(255,255,255,.65);"
                    >
                        CALIFICACIÓN
                    </label>

                    <select
                        name="calificacion"
                        id="calificacion"
                        required
                        class="w-full rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                        style="
                            background: #1D1D1D;
                            border: 1px solid rgba(255,255,255,.1);
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
                        style="font-size: 10px; color: rgba(255,255,255,.65);"
                    >
                        COMENTARIO
                    </label>

                    <textarea
                        name="comentario"
                        id="comentario"
                        rows="6"
                        class="w-full resize-none rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                        style="
                            background: #1D1D1D;
                            border: 1px solid rgba(255,255,255,.1);
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
                    class="flex flex-wrap items-center gap-3 border-t border-white/10 pt-6"
                >

                    <button
                        type="submit"
                        class="rounded-lg border border-[#D8C17F] px-6 py-3 font-black uppercase tracking-widest text-[#111111] transition hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#A99045]/50"
                        style="
                            font-size: 10px;
                            background: #A99045;
                        "
                    >
                        PUBLICAR RESEÑA
                    </button>

                    <a
                        href="{{ route('mi-cuenta.resenas') }}"
                        class="rounded-lg px-6 py-3 font-black uppercase tracking-widest transition hover:border-[#A99045] hover:text-[#D8C17F]"
                        style="
                            font-size: 10px;
                            color: rgba(255,255,255,.6);
                            border: 1px solid rgba(255,255,255,.1);
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

    <div class="mx-auto max-w-3xl px-4 py-8">

        {{-- Encabezado --}}
        <div class="mb-8">

            <a
                href="{{ route('reseñas.index') }}"
                class="font-bold uppercase tracking-widest transition hover:text-[#D8C17F]"
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

            <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>

            <p
                class="mt-3 font-bold uppercase tracking-widest"
                style="font-size: 10px; color: rgba(255,255,255,.4);"
            >
                REGISTRAR UNA NUEVA RESEÑA
            </p>

        </div>

        {{-- Errores de validación --}}
        @if($errors->any())

            <div
                class="mb-6 rounded-xl p-4"
                style="
                    background: rgba(248,113,113,.08);
                    border: 1px solid rgba(248,113,113,.25);
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
            class="space-y-6 rounded-2xl border border-[#A99045]/30 bg-[#111111] p-6 shadow-xl shadow-black/30 sm:p-8"
        >

            @csrf

            {{-- Seleccionar usuario --}}
            <div>

                <label
                    for="id_usuario"
                    class="mb-2 block font-black uppercase tracking-widest"
                    style="font-size: 10px; color: rgba(255,255,255,.65);"
                >
                    USUARIO
                </label>

                <select
                    name="id_usuario"
                    id="id_usuario"
                    required
                    class="w-full rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                    style="
                        background: #1D1D1D;
                        border: 1px solid rgba(255,255,255,.1);
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
                    style="font-size: 10px; color: rgba(255,255,255,.65);"
                >
                    PRODUCTO
                </label>

                <select
                    name="id_producto"
                    id="id_producto_admin"
                    required
                    class="w-full rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                    style="
                        background: #1D1D1D;
                        border: 1px solid rgba(255,255,255,.1);
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
                    style="font-size: 10px; color: rgba(255,255,255,.65);"
                >
                    CALIFICACIÓN
                </label>

                <select
                    name="calificacion"
                    id="calificacion_admin"
                    required
                    class="w-full rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                    style="
                        background: #1D1D1D;
                        border: 1px solid rgba(255,255,255,.1);
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
                    style="font-size: 10px; color: rgba(255,255,255,.65);"
                >
                    COMENTARIO
                </label>

                <textarea
                    name="comentario"
                    id="comentario_admin"
                    rows="6"
                    class="w-full resize-none rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                    style="
                        background: #1D1D1D;
                        border: 1px solid rgba(255,255,255,.1);
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
                    style="font-size: 10px; color: rgba(255,255,255,.65);"
                >
                    RESPUESTA DE LA EMPRESA
                </label>

                <textarea
                    name="respuesta"
                    id="respuesta"
                    rows="4"
                    class="w-full resize-none rounded-lg px-4 py-3 text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                    style="
                        background: #1D1D1D;
                        border: 1px solid rgba(255,255,255,.1);
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
                class="flex flex-wrap items-center gap-3 border-t border-white/10 pt-6"
            >

                <button
                    type="submit"
                    class="rounded-lg border border-[#D8C17F] px-6 py-3 font-black uppercase tracking-widest text-[#111111] transition hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#A99045]/50"
                    style="
                        font-size: 10px;
                        background: #A99045;
                    "
                >
                    GUARDAR RESEÑA
                </button>

                <a
                    href="{{ route('reseñas.index') }}"
                    class="rounded-lg px-6 py-3 font-black uppercase tracking-widest transition hover:border-[#A99045] hover:text-[#D8C17F]"
                    style="
                        font-size: 10px;
                        color: rgba(255,255,255,.6);
                        border: 1px solid rgba(255,255,255,.1);
                    "
                >
                    CANCELAR
                </a>

            </div>

        </form>

    </div>

@endif

@endsection
