@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

<div class="relative isolate flex min-h-[calc(100vh-8rem)] items-center justify-center overflow-hidden bg-[#111111] px-4 py-12 text-[#F5F3ED] sm:px-6 sm:py-16">

    {{-- FONDO DECORATIVO --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">

        <div class="absolute -top-40 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-[#A99045]/10 blur-[120px]"></div>

        <div class="absolute -right-32 top-1/3 h-80 w-80 rounded-full bg-[#D8C17F]/[0.06] blur-[110px]"></div>

        <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-[#A99045]/[0.08] blur-[130px]"></div>

        <div class="absolute inset-0 opacity-[0.025] [background-image:linear-gradient(rgba(255,255,255,.7)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.7)_1px,transparent_1px)] [background-size:54px_54px]"></div>

    </div>


    <main class="relative w-full max-w-md">

        {{-- ENCABEZADO --}}
        <section class="mb-9 text-center">

            {{-- IDENTIDAD DE LA EMPRESA --}}
            <div class="mx-auto mb-7 inline-flex items-center gap-3 rounded-full border border-[#A99045]/30 bg-[#A99045]/[0.07] px-4 py-2">

                <span class="h-2 w-2 animate-pulse rounded-full bg-[#D8C17F] shadow-[0_0_14px_rgba(216,193,127,0.6)]"></span>

                <span class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D8C17F]">
                    Incognito Company
                </span>

            </div>


            {{-- ICONO --}}
            <div class="group relative mx-auto mb-7 flex h-20 w-20 items-center justify-center overflow-hidden rounded-[1.6rem] border border-[#A99045]/40 bg-[#1D1D1D] shadow-[0_0_55px_rgba(169,144,69,0.10)] transition duration-500 hover:border-[#D8C17F]/70 hover:shadow-[0_0_75px_rgba(169,144,69,0.20)]">

                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(169,144,69,0.18),transparent_70%)]"></div>

                <svg
                    class="relative transition duration-500 group-hover:scale-110"
                    width="36"
                    height="36"
                    viewBox="0 0 24 24"
                    fill="none"
                    aria-hidden="true"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        fill="#D8C17F"
                    />

                    <ellipse
                        cx="12"
                        cy="12"
                        rx="10"
                        ry="5"
                        stroke="#D8C17F"
                        stroke-width="1.5"
                        fill="none"
                    />

                    <line
                        x1="12"
                        y1="2"
                        x2="12"
                        y2="22"
                        stroke="#D8C17F"
                        stroke-width="1.5"
                    />
                </svg>

                <div class="absolute left-0 top-0 h-5 w-5 border-l border-t border-[#D8C17F]/60"></div>

                <div class="absolute bottom-0 right-0 h-5 w-5 border-b border-r border-[#A99045]/60"></div>

            </div>


            {{-- TÍTULO --}}
            <h1 class="mx-auto text-4xl font-black uppercase leading-[0.95] tracking-[-0.055em] sm:text-5xl">

                Iniciar

                <span class="mt-2 block text-[#D8C17F]">
                    sesión<span class="text-[#A99045]">.</span>
                </span>

            </h1>

            <p class="mx-auto mt-6 max-w-sm text-sm leading-7 text-gray-400 sm:text-base">
                Accede a tu cuenta de Incognito Company.
            </p>

            <div class="mx-auto mt-7 h-1 w-16 bg-[#A99045]"></div>

        </section>


        {{-- ERRORES GENERALES --}}
        @if($errors->any())

            <div class="mb-5 rounded-2xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm text-red-300">

                <div class="mb-3 flex items-center gap-3">

                    <span class="flex h-7 w-7 items-center justify-center rounded-lg border border-red-400/20 bg-red-400/10 font-bold">
                        !
                    </span>

                    <span class="font-bold uppercase tracking-wider">
                        Revisa los siguientes datos
                    </span>

                </div>

                <ul class="space-y-2">
                    @foreach($errors->all() as $error)
                        <li class="flex gap-2 leading-6">
                            <span class="text-red-400">•</span>
                            <span>{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>

            </div>

        @endif


        {{-- MENSAJE DE SESIÓN --}}
        @if(session('success'))

            <div class="mb-5 rounded-2xl border border-[#A99045]/30 bg-[#A99045]/10 px-5 py-4 text-sm leading-6 text-[#D8C17F]">

                <div class="flex items-center gap-3">

                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-[#A99045]/40 bg-[#A99045]/10">
                        ✓
                    </span>

                    <span>{{ session('success') }}</span>

                </div>

            </div>

        @endif


        {{-- FORMULARIO DE INICIO DE SESIÓN --}}
        <form
            method="POST"
            action="{{ route('login.authenticate') }}"
            class="group relative overflow-hidden rounded-2xl border border-white/10 bg-[#1D1D1D] p-6 shadow-2xl shadow-black/30 transition duration-500 hover:border-[#A99045]/40 sm:p-9"
        >

            @csrf

            {{-- BRILLO DECORATIVO --}}
            <div aria-hidden="true" class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-[#A99045]/[0.08] blur-[80px]"></div>

            <div class="relative">


                {{-- CORREO ELECTRÓNICO --}}
                <div class="mb-6">

                    <label
                        for="email"
                        class="mb-3 block text-[10px] font-bold uppercase tracking-[0.22em] text-[#D8C17F]"
                    >
                        Correo electrónico
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">

                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                aria-hidden="true"
                            >
                                <rect x="3" y="5" width="18" height="14" rx="2"></rect>
                                <path d="m3 7 9 6 9-6"></path>
                            </svg>

                        </div>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            autofocus
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#111111] py-3.5 pl-12 pr-4 text-sm text-[#F5F3ED] placeholder:text-gray-600 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                            placeholder="correo@ejemplo.com"
                        >

                    </div>

                    @error('email')
                        <p class="mt-2 flex items-start gap-2 text-sm leading-6 text-red-400">
                            <span>!</span>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror

                </div>


                {{-- CONTRASEÑA --}}
                <div class="mb-6">

                    <label
                        for="password"
                        class="mb-3 block text-[10px] font-bold uppercase tracking-[0.22em] text-[#D8C17F]"
                    >
                        Contraseña
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500">

                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                aria-hidden="true"
                            >
                                <rect x="4" y="10" width="16" height="11" rx="2"></rect>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"></path>
                                <path d="M12 14v3"></path>
                            </svg>

                        </div>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-xl border border-white/10 bg-[#111111] py-3.5 pl-12 pr-4 text-sm text-[#F5F3ED] placeholder:text-gray-600 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                            placeholder="Ingrese su contraseña"
                        >

                    </div>

                    @error('password')
                        <p class="mt-2 flex items-start gap-2 text-sm leading-6 text-red-400">
                            <span>!</span>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror

                </div>


                {{-- RECORDARME --}}
                <div class="mb-7 flex items-center">

                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        value="1"
                        class="h-4 w-4 cursor-pointer rounded border-white/20 bg-[#111111] accent-[#A99045] focus:ring-2 focus:ring-[#A99045]/30 focus:ring-offset-0"
                        {{ old('remember') ? 'checked' : '' }}
                    >

                    <label
                        for="remember"
                        class="ml-3 cursor-pointer text-sm text-gray-400 transition hover:text-[#D8C17F]"
                    >
                        Recordarme
                    </label>

                </div>


                {{-- BOTÓN DE INICIO DE SESIÓN --}}
                <button
                    type="submit"
                    class="group/button relative flex w-full items-center justify-center gap-3 overflow-hidden rounded-lg bg-[#A99045] px-5 py-4 text-xs font-extrabold uppercase tracking-[0.2em] text-black transition duration-300 hover:-translate-y-0.5 hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#D8C17F] focus:ring-offset-2 focus:ring-offset-[#1D1D1D]"
                >

                    <span>Iniciar sesión</span>

                    <svg
                        class="transition duration-300 group-hover/button:translate-x-1"
                        width="18"
                        height="18"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        aria-hidden="true"
                    >
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>

                </button>

                <p class="mt-5 text-center text-[10px] font-medium uppercase tracking-[0.18em] text-gray-500">
                    Acceso seguro a tu cuenta
                </p>

            </div>

        </form>


        {{-- NAVEGACIÓN INFERIOR --}}
        <div class="mt-8 text-center">

            <a
                href="{{ url('/') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-400 transition duration-300 hover:text-[#D8C17F]"
            >

                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                >
                    <path d="m15 18-6-6 6-6"></path>
                    <path d="M9 12h12"></path>
                </svg>

                Volver al inicio

            </a>

            <div class="mx-auto my-6 h-px w-16 bg-white/10"></div>

            <p class="text-sm text-gray-400">

                ¿No tienes una cuenta?

                <a
                    href="{{ route('registro') }}"
                    class="ml-1 font-bold text-[#D8C17F] transition duration-300 hover:text-white hover:underline"
                >
                    Regístrate aquí
                </a>

            </p>

        </div>

    </main>

</div>

@endsection
