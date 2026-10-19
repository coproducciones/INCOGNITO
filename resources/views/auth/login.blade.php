@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-md">

        {{-- Encabezado --}}
        <div class="text-center mb-8">

            <div
                class="mx-auto mb-5 flex items-center justify-center"
                style="
                    width:64px;
                    height:64px;
                    border:2px solid #fff;
                    background:#111;
                "
            >
                <svg
                    width="30"
                    height="30"
                    viewBox="0 0 24 24"
                    fill="none"
                    aria-hidden="true"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        fill="white"
                    />

                    <ellipse
                        cx="12"
                        cy="12"
                        rx="10"
                        ry="5"
                        stroke="white"
                        stroke-width="1.5"
                        fill="none"
                    />

                    <line
                        x1="12"
                        y1="2"
                        x2="12"
                        y2="22"
                        stroke="white"
                        stroke-width="1.5"
                    />
                </svg>
            </div>

            <h1 class="text-3xl font-black text-white uppercase tracking-widest">
                Iniciar sesión
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                Accede a tu cuenta de Incognito Company.
            </p>

        </div>

        {{-- Errores generales --}}
        @if($errors->any())

            <div
                class="mb-5 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400"
            >

                <ul class="space-y-1">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Mensaje de sesión --}}
        @if(session('success'))

            <div
                class="mb-5 rounded-lg border border-brand-500/30 bg-brand-500/10 px-4 py-3 text-sm text-brand-400"
            >
                {{ session('success') }}
            </div>

        @endif

        {{-- Formulario de inicio de sesión --}}
        <form
            method="POST"
            action="{{ route('login.authenticate') }}"
            class="rounded-xl border border-white/10 bg-dark-800 p-6 shadow-2xl"
        >

            @csrf

            {{-- Email --}}
            <div class="mb-5">

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
                    value="{{ old('email') }}"
                    autocomplete="email"
                    autofocus
                    required
                    class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                    placeholder="correo@ejemplo.com"
                >

                @error('email')

                    <p class="mt-1 text-sm text-red-400">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Contraseña --}}
            <div class="mb-5">

                <label
                    for="password"
                    class="mb-2 block text-sm font-semibold text-white"
                >
                    Contraseña
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                    class="w-full rounded-lg border border-white/10 bg-dark-700 px-4 py-3 text-white placeholder-gray-500 outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20"
                    placeholder="Ingrese su contraseña"
                >

                @error('password')

                    <p class="mt-1 text-sm text-red-400">
                        {{ $message }}
                    </p>

                @enderror

            </div>

            {{-- Recordarme --}}
            <div class="mb-6 flex items-center">

                <input
                    id="remember"
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="h-4 w-4 rounded border-gray-600 bg-gray-700 text-brand-500 focus:ring-brand-500"
                    {{ old('remember') ? 'checked' : '' }}
                >

                <label
                    for="remember"
                    class="ml-2 text-sm text-gray-400"
                >
                    Recordarme
                </label>

            </div>

            {{-- Botón --}}
            <button
                type="submit"
                class="w-full rounded-lg bg-brand-500 px-5 py-3 text-sm font-black uppercase tracking-widest text-black transition hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500/40"
            >
                Iniciar sesión
            </button>

        </form>

        {{-- Regresar --}}
        <div class="mt-6 text-center">

            <a
                href="{{ url('/') }}"
                class="text-sm text-gray-400 transition hover:text-white"
            >
                ← Volver al inicio
            </a>

            <p class="mt-4 text-center text-sm text-gray-400">
    ¿No tienes una cuenta?
    <a href="{{ route('registro') }}" class="font-semibold text-[#00c896] hover:underline">
        Regístrate aquí
    </a>
</p>

        </div>

    </div>
    

</div>

@endsection