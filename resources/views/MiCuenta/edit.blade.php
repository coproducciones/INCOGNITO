@extends('layouts.app')

@section('title', 'Editar mi perfil')

@section('content')

<div class="mx-auto max-w-3xl px-4 py-10 text-white sm:px-6 lg:py-14">

    {{-- ESTILOS VISUALES --}}
    <style>
        .profile-edit-panel {
            background: linear-gradient(145deg, #1D1D1D, #151515);
            border: 1px solid rgba(255, 255, 255, .08);
            box-shadow: 0 20px 55px rgba(0, 0, 0, .2);
        }

        .profile-edit-field {
            background: #111111;
            border: 1px solid rgba(255, 255, 255, .10);
            color: #FFFFFF;
            transition: border-color .3s ease, box-shadow .3s ease;
        }

        .profile-edit-field::placeholder {
            color: rgba(255, 255, 255, .30);
        }

        .profile-edit-field:focus {
            border-color: #A99045;
            box-shadow: 0 0 0 2px rgba(169, 144, 69, .18);
            outline: none;
        }

        .profile-edit-primary {
            background: linear-gradient(110deg, #A99045 0%, #D8C17F 100%);
            color: #111111;
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .profile-edit-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(169, 144, 69, .18);
        }

        .profile-edit-secondary {
            border: 1px solid rgba(255, 255, 255, .12);
            color: rgba(255, 255, 255, .70);
            transition: border-color .3s ease, background .3s ease, color .3s ease;
        }

        .profile-edit-secondary:hover {
            border-color: rgba(169, 144, 69, .45);
            background: rgba(169, 144, 69, .06);
            color: #FFFFFF;
        }
    </style>

    {{-- ENCABEZADO --}}
    <div class="mb-8">

        <a
            href="{{ route('mi-cuenta.perfil') }}"
            class="inline-flex items-center gap-2 text-sm text-white/45 transition hover:text-[#D8C17F]"
        >
            <span aria-hidden="true">←</span>
            Volver a mi perfil
        </a>

        <p class="mt-5 text-xs font-bold uppercase tracking-[0.28em] text-[#D8C17F]">
            Mi cuenta
        </p>

        <h1 class="mt-3 text-3xl font-black uppercase tracking-tight text-white sm:text-4xl">
            Editar mi perfil
        </h1>

        <p class="mt-2 text-sm leading-6 text-white/45">
            Actualiza tus datos personales. Los datos de rol y permisos no se pueden modificar desde aquí.
        </p>

    </div>

    {{-- ERRORES DE VALIDACIÓN --}}
    @if ($errors->any())
        <div
            role="alert"
            class="mb-6 rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-200"
        >
            <p class="font-semibold">
                Revisa los siguientes datos:
            </p>

            <ul class="mt-2 list-inside list-disc space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <form
        action="{{ route('mi-cuenta.perfil.update') }}"
        method="POST"
        class="profile-edit-panel space-y-8 rounded-2xl p-5 sm:p-8"
    >
        @csrf
        @method('PUT')

        {{-- DATOS PERSONALES --}}
        <section aria-labelledby="datos-personales">

            <div class="mb-6">
                <h2
                    id="datos-personales"
                    class="text-lg font-bold text-white"
                >
                    Información personal
                </h2>

                <p class="mt-1 text-sm text-white/45">
                    Mantén tus datos de contacto actualizados.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- NOMBRE --}}
                <div class="sm:col-span-2">
                    <label
                        for="nombre"
                        class="mb-2 block text-sm font-medium text-white/80"
                    >
                        Nombre
                    </label>

                    <input
                        id="nombre"
                        type="text"
                        name="nombre"
                        value="{{ old('nombre', $usuario->nombre) }}"
                        required
                        maxlength="255"
                        autocomplete="name"
                        class="profile-edit-field w-full rounded-xl px-4 py-3"
                    >

                    @error('nombre')
                        <p class="mt-1 text-sm text-rose-300">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- CORREO ELECTRÓNICO --}}
                <div>
                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-white/80"
                    >
                        Correo electrónico
                    </label>

                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $usuario->email) }}"
                        required
                        maxlength="255"
                        autocomplete="email"
                        class="profile-edit-field w-full rounded-xl px-4 py-3"
                    >

                    @error('email')
                        <p class="mt-1 text-sm text-rose-300">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- TELÉFONO --}}
                <div>
                    <label
                        for="telefono"
                        class="mb-2 block text-sm font-medium text-white/80"
                    >
                        Teléfono
                    </label>

                    <input
                        id="telefono"
                        type="text"
                        name="telefono"
                        value="{{ old('telefono', $usuario->telefono) }}"
                        maxlength="20"
                        autocomplete="tel"
                        placeholder="Ingrese su teléfono"
                        class="profile-edit-field w-full rounded-xl px-4 py-3"
                    >

                    @error('telefono')
                        <p class="mt-1 text-sm text-rose-300">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </section>

        {{-- CAMBIO DE CONTRASEÑA --}}
        <section
            aria-labelledby="cambiar-contrasena"
            class="border-t border-white/[0.08] pt-7"
        >
            <div class="mb-6">
                <h2
                    id="cambiar-contrasena"
                    class="text-lg font-bold text-white"
                >
                    Cambiar contraseña
                </h2>

                <p class="mt-1 text-sm leading-6 text-white/45">
                    Déjala vacía si quieres conservar tu contraseña actual.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- NUEVA CONTRASEÑA --}}
                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-white/80"
                    >
                        Nueva contraseña
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Mínimo 8 caracteres"
                        class="profile-edit-field w-full rounded-xl px-4 py-3"
                    >

                    @error('password')
                        <p class="mt-1 text-sm text-rose-300">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- CONFIRMACIÓN DE CONTRASEÑA --}}
                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-medium text-white/80"
                    >
                        Confirmar nueva contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Repita la contraseña"
                        class="profile-edit-field w-full rounded-xl px-4 py-3"
                    >
                </div>

            </div>
        </section>

        {{-- ACCIONES --}}
        <div class="flex flex-col-reverse gap-3 border-t border-white/[0.08] pt-6 sm:flex-row sm:justify-end">

            <a
                href="{{ route('mi-cuenta.perfil') }}"
                class="profile-edit-secondary inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-[#A99045]/50"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="profile-edit-primary inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#A99045] focus:ring-offset-2 focus:ring-offset-[#151515]"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection