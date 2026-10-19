@extends('layouts.app')

@section('title', 'Editar mi perfil')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-8">
        <a
            href="{{ route('mi-cuenta.perfil') }}"
            class="text-sm text-gray-500 transition hover:text-brand-500"
        >
            ← Volver a mi perfil
        </a>

        <p class="mt-5 text-brand-500 text-xs font-black uppercase tracking-[0.25em]">
            Mi cuenta
        </p>

        <h1 class="mt-2 text-3xl sm:text-4xl font-black text-white">
            Editar mi perfil
        </h1>

        <p class="mt-2 text-gray-400">
            Actualiza tus datos personales. Los datos de rol y permisos no se pueden modificar desde aquí.
        </p>
    </div>

    @if($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm text-red-400">
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('mi-cuenta.perfil.update') }}"
        method="POST"
        class="rounded-2xl border border-white/10 bg-dark-800 p-6 sm:p-8 shadow-xl"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nombre --}}
            <div class="md:col-span-2">
                <label
                    for="nombre"
                    class="mb-2 block text-sm font-semibold text-white"
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
                    class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                >

                @error('nombre')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label
                    for="email"
                    class="mb-2 block text-sm font-semibold text-white"
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
                    class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Teléfono --}}
            <div>
                <label
                    for="telefono"
                    class="mb-2 block text-sm font-semibold text-white"
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
                    class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                    placeholder="Ingrese su teléfono"
                >

                @error('telefono')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

        <div class="mt-8 pt-8 border-t border-white/10">

            <h2 class="text-lg font-black text-white">
                Cambiar contraseña
            </h2>

            <p class="mt-1 text-sm text-gray-500">
                Déjala vacía si quieres conservar tu contraseña actual.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">

                {{-- Nueva contraseña --}}
                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-semibold text-white"
                    >
                        Nueva contraseña
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        minlength="8"
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                        placeholder="Mínimo 8 caracteres"
                    >

                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmación --}}
                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-semibold text-white"
                    >
                        Confirmar nueva contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        minlength="8"
                        autocomplete="new-password"
                        class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                        placeholder="Repita la contraseña"
                    >
                </div>

            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-end gap-3 mt-8 pt-6 border-t border-white/10">

            <a
                href="{{ route('mi-cuenta.perfil') }}"
                class="inline-flex justify-center rounded-lg border border-white/10 px-5 py-3 text-sm font-black uppercase tracking-wider text-gray-300 transition hover:bg-white/5"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="inline-flex justify-center rounded-lg bg-brand-500 px-5 py-3 text-sm font-black uppercase tracking-wider text-black transition hover:bg-brand-600"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection
