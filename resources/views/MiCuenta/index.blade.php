@extends('layouts.app')

@section('title', 'Mi cuenta')

@section('content')

<div class="studio-account relative isolate min-h-[75vh] overflow-hidden px-4 py-12 text-white sm:px-6 lg:px-10 lg:py-16">

    {{-- ESTILOS VISUALES --}}
    <style>
        .studio-account {
            background:
                radial-gradient(ellipse at 10% 10%, rgba(169, 144, 69, .12), transparent 38%),
                radial-gradient(ellipse at 90% 80%, rgba(216, 193, 127, .07), transparent 35%),
                #111111;
        }

        .studio-account .account-panel {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 1.25rem;
            background: linear-gradient(145deg, #1D1D1D, #151515);
            box-shadow: 0 20px 55px rgba(0, 0, 0, .2);
        }

        .studio-account .account-panel::before {
            position: absolute;
            inset: 0 0 auto;
            z-index: -1;
            height: 2px;
            background: linear-gradient(90deg, #A99045, #D8C17F, transparent);
            content: "";
            opacity: .8;
        }

        .studio-account .account-link {
            border: 1px solid rgba(255, 255, 255, .08);
            background: linear-gradient(145deg, #1D1D1D, #151515);
            transition: transform .35s ease, border-color .35s ease, box-shadow .35s ease;
        }

        .studio-account .account-link:hover {
            transform: translateY(-4px);
            border-color: rgba(169, 144, 69, .55);
            box-shadow: 0 15px 40px rgba(169, 144, 69, .08);
        }

        .studio-account .account-primary {
            background: linear-gradient(110deg, #A99045 0%, #D8C17F 100%);
            box-shadow: 0 0 24px rgba(169, 144, 69, .14);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .studio-account .account-primary:hover {
            transform: translateY(-2px);
            background: #D8C17F;
            box-shadow: 0 0 30px rgba(169, 144, 69, .22);
        }

        .studio-account .account-avatar {
            background: linear-gradient(145deg, rgba(169, 144, 69, .16), rgba(216, 193, 127, .08));
            box-shadow: 0 0 30px rgba(169, 144, 69, .06);
        }

        .studio-account .account-label {
            color: rgba(255, 255, 255, .45);
        }

        @media (prefers-reduced-motion: reduce) {
            .studio-account *,
            .studio-account *::before,
            .studio-account *::after {
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
            }
        }
    </style>

    <div class="relative mx-auto w-full max-w-6xl">

        {{-- ENCABEZADO --}}
        <div class="mb-10">

            <div class="flex items-center gap-3">
                <span class="h-px w-10 bg-gradient-to-r from-[#A99045] to-[#D8C17F]"></span>

                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#D8C17F]">
                    Cuenta personal
                </p>
            </div>

            <h1 class="mt-4 text-4xl font-black uppercase leading-tight tracking-[-0.045em] sm:text-6xl">
                Mi
                <span class="bg-gradient-to-r from-[#A99045] via-[#D8C17F] to-white bg-clip-text text-transparent">
                    cuenta
                </span>
            </h1>

            <p class="mt-4 max-w-2xl text-sm leading-7 text-white/45">
                Bienvenido, {{ $usuario->nombre }}. Desde aquí puedes consultar y administrar tu información.
            </p>

        </div>

        {{-- PERFIL Y SESIÓN --}}
        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

            {{-- PERFIL --}}
            <section class="account-panel p-5 sm:p-7 lg:col-span-2">

                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">

                    {{-- AVATAR --}}
                    <div class="account-avatar flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-[#A99045]/40 p-1 sm:h-28 sm:w-28">

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre) }}&background=151515&color=D8C17F&size=160"
                            alt="Avatar de {{ $usuario->nombre }}"
                            class="h-full w-full rounded-xl object-cover"
                        >

                    </div>

                    {{-- INFORMACIÓN --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            <span class="rounded-full border border-[#A99045]/30 bg-[#A99045]/[0.08] px-3 py-1.5 text-[9px] font-bold uppercase tracking-[0.18em] text-[#D8C17F]">
                                Usuario registrado
                            </span>

                        </div>

                        <h2 class="mt-4 break-words text-2xl font-black uppercase tracking-tight text-white sm:text-3xl">
                            {{ $usuario->nombre }}
                        </h2>

                        <p class="mt-2 break-all text-sm text-white/50">
                            {{ $usuario->email }}
                        </p>

                        <p class="mt-2 text-sm text-white/35">
                            {{ $usuario->telefono ?: 'Teléfono no registrado' }}
                        </p>

                    </div>

                    {{-- EDITAR PERFIL --}}
                    <a
                        href="{{ route('mi-cuenta.perfil.edit') }}"
                        class="account-primary inline-flex shrink-0 items-center justify-center gap-3 rounded-full px-6 py-3 text-[10px] font-black uppercase tracking-[0.15em] text-[#111111]"
                    >
                        Editar perfil

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9" />
                        </svg>
                    </a>

                </div>

            </section>

            {{-- SESIÓN --}}
            <section class="account-panel flex flex-col p-6 sm:p-7">

                <div class="flex items-center justify-between gap-3">

                    <p class="account-label text-[10px] font-bold uppercase tracking-[0.22em]">
                        Sesión
                    </p>

                    <span class="flex h-9 w-9 items-center justify-center rounded-full border border-[#A99045]/30 bg-[#A99045]/[0.08] text-[#D8C17F]">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>

                    </span>

                </div>

                <h2 class="mt-5 text-xl font-black uppercase tracking-tight text-white">
                    Cuenta activa
                </h2>

                <p class="mt-3 flex-1 text-sm leading-6 text-white/45">
                    Tu sesión está iniciada correctamente.
                </p>

                <div class="my-5 h-px bg-white/[0.08]"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="w-full rounded-full border border-rose-400/25 bg-rose-400/[0.04] px-4 py-3 text-[10px] font-black uppercase tracking-[0.15em] text-rose-300 transition duration-300 hover:border-rose-400/50 hover:bg-rose-500/10"
                    >
                        Cerrar sesión
                    </button>
                </form>

            </section>

        </div>

        {{-- ACCESOS --}}
        <section class="mt-12">

            <div class="mb-7">

                <div class="flex items-center gap-3">
                    <span class="h-px w-8 bg-gradient-to-r from-[#A99045] to-[#D8C17F]"></span>

                    <p class="text-[10px] font-bold uppercase tracking-[0.28em] text-[#D8C17F]">
                        Tu espacio personal
                    </p>
                </div>

                <h2 class="mt-4 text-2xl font-black uppercase tracking-tight text-white sm:text-3xl">
                    Accesos de mi cuenta
                </h2>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-white/40">
                    Estos accesos se conectarán con tus pedidos y reseñas en el siguiente paso.
                </p>

            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

                {{-- MI PERFIL --}}
                <a
                    href="{{ route('mi-cuenta.perfil') }}"
                    class="account-link group relative isolate overflow-hidden rounded-2xl p-6"
                >

                    <div class="pointer-events-none absolute -right-12 -top-12 -z-10 h-36 w-36 rounded-full bg-[#A99045]/[0.08] blur-3xl transition duration-500 group-hover:bg-[#A99045]/20"></div>

                    <div class="flex items-center justify-between">

                        <span class="text-[10px] font-black uppercase tracking-[0.22em] text-[#D8C17F]">
                            01
                        </span>

                        <span class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/[0.03] text-white/45 transition duration-300 group-hover:border-[#A99045]/50 group-hover:bg-[#A99045] group-hover:text-[#111111]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </span>

                    </div>

                    <h3 class="mt-6 text-xl font-black uppercase tracking-tight text-white transition-colors duration-300 group-hover:text-[#D8C17F]">
                        Mi perfil
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/40 transition-colors duration-300 group-hover:text-white/65">
                        Consulta tus datos personales y actualízalos cuando lo necesites.
                    </p>

                    <div class="mt-6 flex items-center gap-2 text-[9px] font-bold uppercase tracking-[0.2em] text-white/35 transition-colors group-hover:text-[#D8C17F]">
                        Ver perfil
                        <span aria-hidden="true">→</span>
                    </div>

                </a>

                {{-- MIS PEDIDOS --}}
                <a
                    href="{{ route('mi-cuenta.pedidos') }}"
                    class="account-link group relative isolate overflow-hidden rounded-2xl p-6"
                >

                    <div class="pointer-events-none absolute -right-12 -top-12 -z-10 h-36 w-36 rounded-full bg-[#A99045]/[0.07] blur-3xl transition duration-500 group-hover:bg-[#A99045]/20"></div>

                    <div class="flex items-center justify-between">

                        <span class="text-[10px] font-black uppercase tracking-[0.22em] text-[#D8C17F]">
                            02
                        </span>

                        <span class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/[0.03] text-white/45 transition duration-300 group-hover:border-[#A99045]/50 group-hover:bg-[#A99045] group-hover:text-[#111111]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l2.4 12.1a2 2 0 0 0 2 1.6h7.8a2 2 0 0 0 2-1.6L21 8H6" />
                                <circle cx="10" cy="21" r="1" />
                                <circle cx="18" cy="21" r="1" />
                            </svg>
                        </span>

                    </div>

                    <h3 class="mt-6 text-xl font-black uppercase tracking-tight text-white transition-colors duration-300 group-hover:text-[#D8C17F]">
                        Mis pedidos
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/40 transition-colors duration-300 group-hover:text-white/65">
                        Consulta el historial, estado, productos y detalle de tus pedidos.
                    </p>

                    <div class="mt-6 flex items-center gap-2 text-[9px] font-bold uppercase tracking-[0.2em] text-white/35 transition-colors group-hover:text-[#D8C17F]">
                        Ver pedidos
                        <span aria-hidden="true">→</span>
                    </div>

                </a>

                {{-- MIS RESEÑAS --}}
                <a
                    href="{{ route('mi-cuenta.resenas') }}"
                    class="account-link group relative isolate overflow-hidden rounded-2xl p-6"
                >

                    <div class="pointer-events-none absolute -right-12 -top-12 -z-10 h-36 w-36 rounded-full bg-[#A99045]/[0.08] blur-3xl transition duration-500 group-hover:bg-[#A99045]/20"></div>

                    <div class="flex items-center justify-between">

                        <span class="text-[10px] font-black uppercase tracking-[0.22em] text-[#D8C17F]">
                            03
                        </span>

                        <span class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/[0.03] text-white/45 transition duration-300 group-hover:border-[#A99045]/50 group-hover:bg-[#A99045] group-hover:text-[#111111]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2-5.6-3-5.6 3 1.1-6.2L3 9.6l6.2-.9L12 3Z" />
                            </svg>
                        </span>

                    </div>

                    <h3 class="mt-6 text-xl font-black uppercase tracking-tight text-white transition-colors duration-300 group-hover:text-[#D8C17F]">
                        Mis reseñas
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-white/40 transition-colors duration-300 group-hover:text-white/65">
                        Consulta, crea, edita y elimina tus reseñas.
                    </p>

                    <div class="mt-6 flex items-center gap-2 text-[9px] font-bold uppercase tracking-[0.2em] text-white/35 transition-colors group-hover:text-[#D8C17F]">
                        Ver reseñas
                        <span aria-hidden="true">→</span>
                    </div>

                </a>

            </div>

        </section>

        {{-- PIE DECORATIVO --}}
        <div class="mt-10 flex items-center justify-center gap-3">

            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-white/[0.08]"></span>

            <span class="text-[9px] font-medium uppercase tracking-[0.25em] text-white/20">
                Incógnito · Group Design
            </span>

            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-white/[0.08]"></span>

        </div>

    </div>

</div>

@endsection
