@extends('layouts.app')

@section('title', 'Editar usuario')

@section('content')

<div class="mx-auto max-w-2xl space-y-6">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="mb-8">

        <h1 class="text-2xl font-black uppercase tracking-widest text-white"
            style="letter-spacing: .15em;">
            Seguridad del usuario
        </h1>

        <div class="mt-3 h-[3px] w-[60px] rounded-full"
             style="background-color: #A99045;"></div>

        <p class="mt-3 text-sm text-gray-400">
            Actualiza el rol y el estado del usuario.
        </p>

    </div>


    {{-- ===================================================== --}}
    {{-- MENSAJE DE ERROR GENERAL --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div
            class="mb-6 rounded-xl border p-4"
            style="background-color: rgba(127, 29, 29, 0.18); border-color: rgba(248, 113, 113, 0.3);"
        >

            <p class="mb-2 font-bold text-red-300">
                Se encontraron algunos errores:
            </p>

            <ul class="list-inside list-disc space-y-1 text-sm text-red-300">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- FORMULARIO --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('seguridad.usuarios.update', $usuario) }}"
        class="space-y-5"
    >

        @csrf
        @method('PUT')


        {{-- ================================================= --}}
        {{-- PANEL DE INFORMACIÓN DEL USUARIO --}}
        {{-- ================================================= --}}

        <div
            class="space-y-5 rounded-2xl border p-6 shadow-lg"
            style="background-color: #111111; border-color: rgba(169, 144, 69, 0.3);"
        >

            <h2 class="mb-5 text-sm font-black uppercase tracking-widest text-white"
                style="letter-spacing: .12em;">
                Información del usuario
            </h2>


            {{-- NOMBRE --}}
            <div>

                <label
                    for="nombre"
                    class="mb-2 block text-xs font-bold uppercase tracking-widest"
                    style="color: #D8C17F;"
                >
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $usuario->nombre) }}"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-white outline-none transition focus:ring-2"
                    style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.12); --tw-ring-color: #A99045;"
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.12)'"
                    required
                >

            </div>


            {{-- APELLIDO --}}
            <div>

                <label
                    for="apellido"
                    class="mb-2 block text-xs font-bold uppercase tracking-widest"
                    style="color: #D8C17F;"
                >
                    Apellido
                </label>

                <input
                    type="text"
                    id="apellido"
                    name="apellido"
                    value="{{ old('apellido', $usuario->apellido ?? '') }}"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-white outline-none transition focus:ring-2"
                    style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.12); --tw-ring-color: #A99045;"
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.12)'"
                >

            </div>


            {{-- CORREO --}}
            <div>

                <label
                    for="email"
                    class="mb-2 block text-xs font-bold uppercase tracking-widest"
                    style="color: #D8C17F;"
                >
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $usuario->email) }}"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-white outline-none transition focus:ring-2"
                    style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.12); --tw-ring-color: #A99045;"
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.12)'"
                    required
                >

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PANEL DE SEGURIDAD --}}
        {{-- ================================================= --}}

        <div
            class="space-y-5 rounded-2xl border p-6 shadow-lg"
            style="background-color: #111111; border-color: rgba(169, 144, 69, 0.3);"
        >

            <h2 class="mb-5 text-sm font-black uppercase tracking-widest text-white"
                style="letter-spacing: .12em;">
                Roles y estados
            </h2>


            {{-- ROL --}}
            <div>

                <label
                    for="id_rol"
                    class="mb-2 block text-xs font-bold uppercase tracking-widest"
                    style="color: #D8C17F;"
                >
                    Rol
                </label>

                <select
                    id="id_rol"
                    name="id_rol"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-white outline-none transition focus:ring-2"
                    style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.12); --tw-ring-color: #A99045;"
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.12)'"
                >

                    <option value="" style="background-color: #1D1D1D;">
                        Sin rol
                    </option>

                    @foreach ($roles as $rol)

                        <option
                            value="{{ $rol->id_rol }}"
                            @selected(
                                old('id_rol', $usuario->id_rol) == $rol->id_rol
                            )
                            style="background-color: #1D1D1D;"
                        >
                            {{ $rol->nombre }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- ESTADO DEL USUARIO --}}
            <div>

                <label
                    for="id_estado"
                    class="mb-2 block text-xs font-bold uppercase tracking-widest"
                    style="color: #D8C17F;"
                >
                    Estado del usuario
                </label>

                <select
                    id="id_estado"
                    name="id_estado"
                    class="w-full rounded-xl border px-4 py-3 text-sm text-white outline-none transition focus:ring-2"
                    style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.12); --tw-ring-color: #A99045;"
                    onfocus="this.style.borderColor='#A99045'"
                    onblur="this.style.borderColor='rgba(255, 255, 255, 0.12)'"
                    required
                >

                    @forelse ($estados as $estado)

                        <option
                            value="{{ $estado->id_estado }}"
                            @selected(
                                (string) old('id_estado', $usuario->id_estado)
                                === (string) $estado->id_estado
                            )
                            style="background-color: #1D1D1D;"
                        >
                            {{ $estado->nombre }}
                        </option>

                    @empty

                        <option value="" disabled selected>
                            No hay estados de usuario registrados
                        </option>

                    @endforelse

                </select>

                @if ($estados->isEmpty())

                    <p
                        class="mt-3 rounded-lg border p-3 text-sm"
                        style="background-color: rgba(169, 144, 69, 0.1); border-color: rgba(169, 144, 69, 0.3); color: #D8C17F;"
                    >
                        Debes registrar los estados Activo e Inactivo
                        para el tipo USUARIO.
                    </p>

                @endif

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- BOTONES --}}
        {{-- ================================================= --}}

        <div class="flex flex-wrap gap-3 pt-2">

            {{-- Guardar --}}
            <button
                type="submit"
                class="rounded-xl px-6 py-3 text-sm font-black uppercase tracking-widest transition hover:brightness-110"
                style="background-color: #A99045; color: #111111; letter-spacing: .08em;"
            >
                Guardar cambios
            </button>

            {{-- Cancelar --}}
            <a
                href="{{ route('seguridad.usuarios.index') }}"
                class="rounded-xl border px-6 py-3 text-sm font-semibold text-gray-300 transition hover:bg-white/5"
                style="border-color: rgba(255, 255, 255, 0.15);"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection
