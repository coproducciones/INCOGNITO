@extends('layouts.app')

@section('title', 'Mi cuenta')

@section('content')

<div class="max-w-6xl mx-auto">

    <div class="mb-8">
        <p class="text-brand-500 text-xs font-black uppercase tracking-[0.25em]">
            Cuenta personal
        </p>

        <h1 class="mt-2 text-3xl sm:text-4xl font-black text-white">
            Mi cuenta
        </h1>

        <p class="mt-2 text-gray-400">
            Bienvenido, {{ $usuario->nombre }}. Desde aquí puedes consultar y administrar tu información.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Perfil --}}
        <div class="lg:col-span-2 rounded-2xl border border-white/10 bg-dark-800 p-6 shadow-xl">

            <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre) }}&background=00c896&color=000&size=160"
                    alt="Avatar de {{ $usuario->nombre }}"
                    class="w-24 h-24 rounded-2xl object-cover border border-white/10"
                >

                <div class="flex-1">
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                        Usuario registrado
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-white">
                        {{ $usuario->nombre }}
                    </h2>

                    <p class="mt-1 text-gray-400">
                        {{ $usuario->email }}
                    </p>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ $usuario->telefono ?: 'Teléfono no registrado' }}
                    </p>
                </div>

                <a
                    href="{{ route('mi-cuenta.perfil.edit') }}"
                    class="inline-flex justify-center rounded-lg bg-brand-500 px-5 py-3 text-sm font-black uppercase tracking-wider text-black transition hover:bg-brand-600"
                >
                    Editar perfil
                </a>
            </div>
        </div>

        {{-- Sesión --}}
        <div class="rounded-2xl border border-white/10 bg-dark-800 p-6 shadow-xl">
            <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                Sesión
            </p>

            <h2 class="mt-2 text-xl font-black text-white">
                Cuenta activa
            </h2>

            <p class="mt-2 text-sm text-gray-400">
                Tu sesión está iniciada correctamente.
            </p>

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="mt-5"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full rounded-lg border border-red-500/30 px-4 py-3 text-sm font-black uppercase tracking-wider text-red-400 transition hover:bg-red-500/10"
                >
                    Cerrar sesión
                </button>
            </form>
        </div>

    </div>

    {{-- Accesos --}}
    <div class="mt-8">

        <h2 class="text-xl font-black text-white">
            Accesos de mi cuenta
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Estos accesos se conectarán con tus pedidos y reseñas en el siguiente paso.
        </p>

        <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4">

            <a
                href="{{ route('mi-cuenta.perfil') }}"
                class="group rounded-2xl border border-white/10 bg-dark-800 p-5 transition hover:border-brand-500/40 hover:bg-dark-700"
            >
                <span class="text-brand-500 text-xs font-black uppercase tracking-widest">
                    01
                </span>

                <h3 class="mt-3 text-lg font-black text-white group-hover:text-brand-500">
                    Mi perfil
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Consulta tus datos personales y actualízalos cuando lo necesites.
                </p>
            </a>

            <a
                href="{{ route('mi-cuenta.pedidos') }}"
                class="group rounded-2xl border border-white/10 bg-dark-800 p-5 transition hover:border-brand-500/40 hover:bg-dark-700"
            >
                <span class="text-brand-500 text-xs font-black uppercase tracking-widest">
                    02
                </span>

                <h3 class="mt-3 text-lg font-black text-white group-hover:text-brand-500">
                    Mis pedidos
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Consulta el historial, estado, productos y detalle de tus pedidos.
                </p>
            </a>

            <a
                href="{{ route('mi-cuenta.resenas') }}"
                class="group rounded-2xl border border-white/10 bg-dark-800 p-5 transition hover:border-brand-500/40 hover:bg-dark-700"
            >
                <span class="text-brand-500 text-xs font-black uppercase tracking-widest">
                    03
                </span>

                <h3 class="mt-3 text-lg font-black text-white group-hover:text-brand-500">
                    Mis reseñas
                </h3>

                <p class="mt-2 text-sm text-gray-500">
                    Consulta, crea, edita y elimina tus reseñas.
                </p>
            </a>

        </div>
    </div>

</div>

@endsection
