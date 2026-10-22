@extends('layouts.app')

@section('title', 'Incógnito | Group Design')

@section('content')

<div class="studio-shell relative isolate overflow-x-clip bg-[#151515] text-[#F5F3ED]">

    {{-- =========================================================

         ESTILOS GENERALES

    ========================================================== --}}

    <style>

        .studio-shell {

            --studio-bg: #151515;

            --studio-panel: #1D1D1D;

            --studio-gold: #A99045;

            --studio-gold-light: #D8C17F;

            --studio-cream: #F5F3ED;

            --studio-red: #9E2428;

            --studio-border: rgba(245, 243, 237, .10);

            --studio-muted: rgba(245, 243, 237, .55);

        }

        .studio-shell [x-cloak] {

            display: none !important;

        }

        .studio-shell section[id] {

            scroll-margin-top: 6rem;

        }

        .studio-shell h1,

        .studio-shell h2,

        .studio-shell h3 {

            text-wrap: balance;

        }

        .studio-logo-mark {

            background: rgba(169, 144, 69, .10);

            border: 1px solid rgba(169, 144, 69, .30);

            box-shadow: inset 0 0 20px rgba(169, 144, 69, .04);

        }

        .studio-primary {

            background: #A99045;

            color: #151515;

            box-shadow: 0 5px 20px rgba(169, 144, 69, .10);

            transition:

                transform .3s ease,

                background .3s ease,

                box-shadow .3s ease;

        }

        .studio-primary:hover {

            background: #c1a75a;

            box-shadow: 0 8px 28px rgba(169, 144, 69, .20);

        }

        .studio-section-dark {

            background:

                radial-gradient(

                    ellipse at 10% 15%,

                    rgba(169, 144, 69, .08),

                    transparent 36%

                ),

                radial-gradient(

                    ellipse at 90% 80%,

                    rgba(158, 36, 40, .05),

                    transparent 35%

                ),

                #1D1D1D;

        }

        .studio-section-black {

            background:

                radial-gradient(

                    ellipse at 50% 0%,

                    rgba(169, 144, 69, .07),

                    transparent 45%

                ),

                #151515;

        }

        .studio-contact {

            background:

                radial-gradient(

                    ellipse at 85% 15%,

                    rgba(169, 144, 69, .10),

                    transparent 35%

                ),

                radial-gradient(

                    ellipse at 10% 85%,

                    rgba(158, 36, 40, .08),

                    transparent 40%

                ),

                #1D1D1D;

        }

        .studio-history {

            background-color: #F5F3ED;

            background-image: radial-gradient(

                rgba(169, 144, 69, .17) .7px,

                transparent .7px

            );

            background-size: 18px 18px;

        }

        /* Tarjetas de categorías */

        .studio-category-card {

            position: relative;

            isolation: isolate;

            display: block;

            min-width: 0;

            min-height: 390px;

            overflow: hidden;

            border: 1px solid var(--studio-border);

            border-radius: 1rem;

            background: #1B1B1B;

            transform: translateZ(0);

            transition:

                transform .35s ease,

                border-color .35s ease,

                background .35s ease,

                box-shadow .35s ease;

        }

        .studio-category-card:hover {

            transform: translateY(-5px);

            border-color: rgba(169, 144, 69, .45);

            background: #20201E;

            box-shadow:

                0 15px 45px rgba(0, 0, 0, .22),

                0 0 25px rgba(169, 144, 69, .05);

        }

        /* Tarjetas de productos */

        .studio-product-card {

            position: relative;

            isolation: isolate;

            min-width: 0;

            min-height: 390px;

            overflow: hidden;

            border: 1px solid var(--studio-border);

            border-radius: 1rem;

            background: #1B1B1B;

            transform: translateZ(0);

            transition:

                transform .35s ease,

                border-color .35s ease,

                background .35s ease,

                box-shadow .35s ease;

        }

        .studio-product-card:hover {

            transform: translateY(-5px);

            border-color: rgba(169, 144, 69, .45);

            background: #20201E;

            box-shadow:

                0 15px 45px rgba(0, 0, 0, .22),

                0 0 25px rgba(169, 144, 69, .05);

        }

        .studio-card-grid {

            background-image:

                linear-gradient(

                    rgba(245, 243, 237, .10) 1px,

                    transparent 1px

                ),

                linear-gradient(

                    90deg,

                    rgba(245, 243, 237, .10) 1px,

                    transparent 1px

                );

            background-size: 36px 36px;

        }

        .studio-eyebrow {

            display: inline-flex;

            align-items: center;

            gap: .7rem;

            color: #D8C17F;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: .25em;

            text-transform: uppercase;

        }

        .studio-eyebrow::before {

            content: "";

            display: block;

            width: 25px;

            height: 1px;

            background: currentColor;

        }

        .studio-section-title {

            font-size: clamp(2.5rem, 6vw, 5rem);

            font-weight: 800;

            line-height: .95;

            letter-spacing: -.055em;

            text-transform: uppercase;

        }

        .studio-shell a:focus-visible,

        .studio-shell button:focus-visible {

            outline: 2px solid var(--studio-gold);

            outline-offset: 4px;

        }

        @media (min-width: 1024px) {

            .studio-category-card {

                min-height: 440px;

            }

            .studio-product-card {

                min-height: 420px;

            }

        }

        @media (prefers-reduced-motion: reduce) {

            .studio-shell *,

            .studio-shell *::before,

            .studio-shell *::after {

                scroll-behavior: auto !important;

                animation-duration: .01ms !important;

                animation-iteration-count: 1 !important;

                transition-duration: .01ms !important;

            }

            .studio-category-card:hover,

            .studio-product-card:hover {

                transform: none;

            }

        }

    </style>

    {{-- =========================================================

         NAVBAR

    ========================================================== --}}

    <header class="fixed inset-x-0 top-0 z-50 border-b border-[#F5F3ED]/10 bg-[#151515]/90 shadow-[0_8px_40px_rgba(0,0,0,0.25)] backdrop-blur-2xl">

        <nav

            class="mx-auto flex h-20 max-w-7xl items-center justify-between gap-4 px-5 sm:px-6 lg:px-10"

            aria-label="Navegación principal"

        >

            {{-- LOGO --}}

            <a href="{{ url('/') }}" class="group flex shrink-0 items-center gap-3">

                <div class="studio-logo-mark flex h-11 w-11 items-center justify-center rounded-lg text-xl font-black text-[#D8C17F] transition duration-300 group-hover:border-[#A99045]/70 sm:h-12 sm:w-12">

                    O

                </div>

                <div class="hidden leading-none sm:block">

                    <span class="block text-xs font-black uppercase tracking-[0.16em] text-[#F5F3ED]">

                        Incógnito

                    </span>

                    <span class="mt-1.5 block text-[9px] uppercase tracking-[0.22em] text-[#F5F3ED]/45">

                        Group Design

                    </span>

                </div>

            </a>

            {{-- MENÚ DE ESCRITORIO --}}

            <div class="hidden items-center gap-6 md:flex lg:gap-8">

                <a

                    href="{{ url('/') }}"

                    class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#F5F3ED]/65 transition hover:text-[#D8C17F]"

                >

                    Home

                </a>

                <a

                    href="{{ url('nuestro-trabajo') }}"

                    class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#F5F3ED]/65 transition hover:text-[#D8C17F]"

                >

                    Nuestro trabajo

                </a>

                <a

                    href="{{ url('nuestra-historia') }}"

                    class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#F5F3ED]/65 transition hover:text-[#D8C17F]"

                >

                    Nuestra historia

                </a>

                <a

                    href="{{ url('servicios') }}"

                    class="text-[10px] font-bold uppercase tracking-[0.16em] text-[#F5F3ED]/65 transition hover:text-[#D8C17F]"

                >

                    Servicios

                </a>

            </div>

            {{-- ACCIONES DEL USUARIO --}}

            <div class="flex shrink-0 items-center gap-2 sm:gap-3">

                @guest

                    {{-- INICIAR SESIÓN --}}

                    <a

                        href="{{ route('login') }}"

                        class="hidden rounded-lg border border-[#F5F3ED]/15 bg-[#F5F3ED]/[0.03] px-4 py-2.5 text-[9px] font-black uppercase tracking-wider text-[#F5F3ED] transition hover:border-[#A99045]/50 hover:bg-[#A99045]/[0.07] sm:inline-flex"

                    >

                        Iniciar sesión

                    </a>

                    {{-- REGISTRO --}}

                    <a

                        href="{{ route('usuarios.create') }}"

                        class="studio-primary hidden rounded-lg px-5 py-2.5 text-[9px] font-black uppercase tracking-wider sm:inline-flex"

                    >

                        Registrarse

                    </a>

                @endguest

                @auth

                    {{-- MENÚ DE CUENTA --}}

                    <div

                        x-data="{ open: false }"

                        class="relative"

                    >

                        <button

                            type="button"

                            @click="open = !open"

                            @click.outside="open = false"

                            @keydown.escape.window="open = false"

                            class="flex max-w-[190px] items-center gap-2 rounded-lg border border-[#F5F3ED]/10 bg-[#F5F3ED]/[0.04] px-2.5 py-2 text-[#F5F3ED] transition hover:border-[#A99045]/40 hover:bg-[#F5F3ED]/[0.07] sm:gap-3 sm:px-3"

                            aria-haspopup="true"

                            :aria-expanded="open.toString()"

                        >

                            <img

                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre ?? (auth()->user()->name ?? 'Usuario')) }}&background=A99045&color=151515"

                                alt="Avatar de {{ auth()->user()->nombre ?? (auth()->user()->name ?? 'Usuario') }}"

                                class="h-7 w-7 shrink-0 rounded-lg ring-1 ring-[#A99045]/50"

                            >

                            <span class="hidden max-w-[110px] truncate text-[9px] font-black uppercase tracking-wider sm:block">

                                {{ auth()->user()->nombre ?? (auth()->user()->name ?? 'Usuario') }}

                            </span>

                            <svg

                                class="h-3 w-3 shrink-0 text-[#D8C17F] transition"

                                :class="{ 'rotate-180': open }"

                                viewBox="0 0 24 24"

                                fill="none"

                                stroke="currentColor"

                                stroke-width="2"

                                aria-hidden="true"

                            >

                                <path stroke-linecap="round" stroke-linejoin="round" d="m7 10 5 5 5-5"/>

                            </svg>

                        </button>

                    {{-- DESPLEGABLE --}}
    <div
    x-show="open"
    x-cloak
    x-transition.opacity.duration.150ms
    @click.outside="open = false"
    class="absolute right-0 mt-3 w-64 overflow-hidden rounded-xl border border-[#F5F3ED]/10 bg-[#1D1D1D] shadow-[0_20px_80px_rgba(0,0,0,0.5)]"
>
    {{-- INFORMACIÓN DEL USUARIO --}}
    <div class="border-b border-[#F5F3ED]/[0.08] px-5 py-4">
        <p class="truncate text-xs font-black uppercase tracking-wider text-[#F5F3ED]">
            {{ auth()->user()->nombre ?? (auth()->user()->name ?? 'Usuario') }}
        </p>

        <p class="mt-1.5 truncate text-[10px] text-[#F5F3ED]/40">
            {{ auth()->user()->email }}
        </p>

        @if (auth()->user()->rol)
            <p class="mt-2 text-[9px] font-bold uppercase tracking-widest text-[#D8C17F]">
                {{ auth()->user()->rol->nombre }}
            </p>
        @endif
    </div>

    {{-- MI CUENTA --}}
    @if (Route::has('mi-cuenta'))
        <a
            href="{{ route('mi-cuenta') }}"
            class="block px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/65 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"
        >
            Mi cuenta
        </a>
    @endif

    {{-- MI PERFIL --}}
    @if (Route::has('mi-cuenta.perfil'))
        <a
            href="{{ route('mi-cuenta.perfil') }}"
            class="block px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/65 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"
        >
            Mi perfil
        </a>
    @endif

    {{-- EDITAR PERFIL --}}
    @if (Route::has('mi-cuenta.perfil'))
        <a
            href="{{ route('mi-cuenta.perfil') }}"
            class="block px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/65 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"
        >
            Editar perfil
        </a>
    @endif

    {{-- MIS PEDIDOS --}}
    @if (Route::has('mi-cuenta.pedidos'))
        <a
            href="{{ route('mi-cuenta.pedidos') }}"
            class="block px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/65 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"
        >
            Mis pedidos
        </a>
    @endif

    {{-- MIS RESEÑAS --}}
    @if (Route::has('mi-cuenta.resenas'))
        <a
            href="{{ route('mi-cuenta.resenas') }}"
            class="block px-5 py-3.5 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/65 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"
        >
            Mis reseñas
        </a>
    @endif

    {{-- PANEL --}}
    @if (Route::has('dashboard.gestion'))
        <div class="border-t border-[#F5F3ED]/10"></div>

        <a
            href="{{ route('dashboard.gestion') }}"
            class="block px-5 py-3.5 text-[10px] font-black uppercase tracking-wider text-[#D8C17F] transition hover:bg-[#A99045]/[0.10]"
        >
            Panel
        </a>
    @endif

    {{-- CERRAR SESIÓN --}}
    <div class="border-t border-[#F5F3ED]/10"></div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button
            type="submit"
            class="w-full px-5 py-3.5 text-left text-[10px] font-bold uppercase tracking-wider text-[#E7A5A6] transition hover:bg-[#9E2428]/[0.10]"
        >
            Cerrar sesión
        </button>
    </form>
</div>

                    </div>

                @endauth

                {{-- BOTÓN DEL MENÚ MÓVIL --}}

                <div

                    x-data="{ open: false }"

                    class="relative md:hidden"

                >

                    <button

                        type="button"

                        @click="open = !open"

                        @click.outside="open = false"

                        @keydown.escape.window="open = false"

                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-[#F5F3ED]/10 bg-[#F5F3ED]/[0.04] text-[#F5F3ED] transition hover:border-[#A99045]/40 hover:text-[#D8C17F]"

                        aria-label="Abrir menú"

                        :aria-expanded="open.toString()"

                    >

                        <svg

                            x-show="!open"

                            class="h-5 w-5"

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="1.7"

                            aria-hidden="true"

                        >

                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/>

                        </svg>

                        <svg

                            x-show="open"

                            x-cloak

                            class="h-5 w-5"

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="1.7"

                            aria-hidden="true"

                        >

                            <path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/>

                        </svg>

                    </button>

                    {{-- MENÚ MÓVIL --}}

                    <div

                        x-show="open"

                        x-cloak

                        x-transition.opacity.duration.150ms

                        class="absolute right-0 mt-3 w-[min(18rem,calc(100vw-2rem))] overflow-hidden rounded-xl border border-[#F5F3ED]/10 bg-[#1D1D1D] shadow-[0_20px_80px_rgba(0,0,0,0.55)]"

                    >

                        <div class="border-b border-[#F5F3ED]/[0.08] px-5 py-4">

                            <p class="text-[9px] font-bold uppercase tracking-[0.25em] text-[#D8C17F]">

                                Navegación

                            </p>

                        </div>

                        <a

                            href="{{ url('/') }}"

                            @click="open = false"

                            class="block border-b border-[#F5F3ED]/[0.05] px-5 py-4 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/75 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"

                        >

                            Home

                        </a>

                        <a

                            href="{{ route('nuestro.trabajo') }}"

                            @click="open = false"

                            class="block border-b border-[#F5F3ED]/[0.05] px-5 py-4 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/75 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"

                        >

                            Nuestro trabajo

                        </a>

                        <a

                            href="{{ route('nuestra.historia') }}"

                            @click="open = false"

                            class="block border-b border-[#F5F3ED]/[0.05] px-5 py-4 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/75 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"

                        >

                            Nuestra historia

                        </a>

                        <a

                            href="{{ url('servicios') }}"

                            @click="open = false"

                            class="block px-5 py-4 text-[10px] font-bold uppercase tracking-wider text-[#F5F3ED]/75 transition hover:bg-[#A99045]/[0.08] hover:text-[#D8C17F]"

                        >

                            Servicios

                        </a>

                        @guest

                            <div class="grid gap-2 border-t border-[#F5F3ED]/10 p-4">

                                <a

                                    href="{{ route('login') }}"

                                    class="rounded-lg border border-[#F5F3ED]/15 px-5 py-3 text-center text-[10px] font-black uppercase tracking-wider text-[#F5F3ED] transition hover:border-[#A99045]/40 hover:bg-[#F5F3ED]/[0.05]"

                                >

                                    Iniciar sesión

                                </a>

                                <a

                                    href="{{ route('usuarios.create') }}"

                                    class="studio-primary rounded-lg px-5 py-3 text-center text-[10px] font-black uppercase tracking-wider"

                                >

                                    Registrarse

                                </a>

                            </div>

                        @endguest

                    </div>

                </div>

            </div>

        </nav>

    </header>

    <main>

        {{-- =========================================================

             HERO

        ========================================================== --}}

        <section

            id="inicio"

            class="relative flex min-h-[720px] items-center justify-center overflow-hidden bg-[#151515] sm:min-h-screen"

        >

{{-- IMAGEN DE FONDO --}}

<div class="absolute inset-0">

    <div

        class="h-full w-full bg-cover bg-center"

        style="background-image: url('/img/preview-incognito-group.jpg');"

        role="img"

        aria-label="Presentación de Incógnito Group Design"

    ></div>

</div>

            {{-- CAPAS DE OSCURECIMIENTO --}}

            <div class="absolute inset-0 bg-[#151515]/70"></div>

            <div class="absolute inset-0 bg-gradient-to-b from-[#151515]/85 via-transparent to-[#151515]"></div>

            <div class="absolute inset-0 bg-gradient-to-r from-[#151515]/55 via-transparent to-[#151515]/45"></div>

            {{-- BRILLO DECORATIVO --}}

            <div class="pointer-events-none absolute left-1/2 top-1/2 h-96 w-96 -translate-x-1/2 -translate-y-1/2 rounded-full bg-[#A99045]/[0.08] blur-[120px]"></div>

            {{-- CONTENIDO --}}

            <div class="relative z-10 mx-auto w-full max-w-7xl px-5 pb-16 pt-32 text-center sm:px-6 lg:px-10">

                <div class="mb-8 inline-flex items-center gap-3 rounded-lg border border-[#F5F3ED]/15 bg-[#151515]/40 px-4 py-2 backdrop-blur-xl">

                    <span class="h-1.5 w-1.5 rounded-full bg-[#A99045]"></span>

                    <span class="text-[9px] font-bold uppercase tracking-[0.28em] text-[#F5F3ED]/70 sm:text-[10px]">

                        Grupo de diseño

                    </span>

                </div>

                <h1 class="text-[16vw] font-black uppercase leading-[0.8] tracking-[-0.09em] text-[#F5F3ED] sm:text-[13vw] lg:text-[11rem]">

                    INCOGNITO<span class="text-[#A99045]">.</span>

                </h1>

                <h2 class="mt-8 text-lg font-bold uppercase tracking-[0.12em] text-[#F5F3ED] sm:mt-10 sm:text-3xl lg:text-4xl">

                    GROUP DESIGN

                    <span class="mt-2 block text-base font-light tracking-[0.2em] text-[#F5F3ED]/50 sm:mt-3 sm:inline sm:text-2xl">

                        AND MUCH

                    </span>

                </h2>

                <p class="mx-auto mt-7 max-w-xl text-sm leading-7 text-[#F5F3ED]/60 sm:text-base sm:leading-8">

                    Grupo de diseño y mucho más.

                    Creación de contenido, producción,

                    manufactura y estrategia digital.

                </p>

                <div class="mt-9 flex flex-wrap items-center justify-center gap-4 sm:mt-11">

                    <a

                        href="{{ route('nuestra.historia') }}"

                        class="studio-primary inline-flex items-center gap-3 rounded-lg px-7 py-4 text-[10px] font-black uppercase tracking-[0.18em] hover:-translate-y-0.5 sm:px-8"

                    >

                        ¿Qué hacemos?

                        <svg

                            class="h-4 w-4"

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="2"

                            aria-hidden="true"

                        >

                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9"/>

                        </svg>

                    </a>

                </div>

                <div class="mx-auto mt-14 h-px w-20 bg-gradient-to-r from-transparent via-[#A99045] to-transparent sm:mt-20"></div>

            </div>

        </section>

        {{-- =========================================================

             SERVICIOS Y CATEGORÍAS

        ========================================================== --}}

        <section id="servicios" class="studio-section-dark py-24 lg:py-32">

            <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-10">

                {{-- ENCABEZADO --}}

                <div class="grid grid-cols-1 items-end gap-7 lg:grid-cols-2 lg:gap-12">

                    <div>

                        <span class="studio-eyebrow">

                            Lo que hacemos

                        </span>

                        <h2 class="studio-section-title mt-6 text-[#F5F3ED]">

                            ¿Qué<br>

                            hacemos<span class="text-[#A99045]">?</span>

                        </h2>

                    </div>

                    <div class="max-w-xl lg:justify-self-end">

                        <p class="text-sm leading-7 text-[#F5F3ED]/55 sm:text-base sm:leading-8">

                            Potenciamos tu presencia digital con

                            contenido de alta calidad, destacando

                            en redes sociales y asegurando la

                            expansión viral de tu mensaje.

                        </p>

                    </div>

                </div>

                {{-- CUADRÍCULA DE CATEGORÍAS --}}

                <div class="mt-14 grid grid-cols-1 items-stretch gap-5 sm:grid-cols-2 lg:mt-20 lg:grid-cols-4">

                    @forelse($categorias as $categoria)

                        <a

                            href="{{ route('categorias.index') }}"

                            class="studio-category-card group"

                        >

                            {{-- FONDO DE LA TARJETA --}}

                            <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">

                                <div class="absolute inset-0 bg-gradient-to-br from-[#A99045]/[0.12] via-[#20201E] to-[#151515]"></div>

                                <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#A99045]/[0.12] blur-[90px] transition duration-700 group-hover:bg-[#A99045]/[0.22]"></div>

                                <div class="absolute -bottom-24 -left-20 h-64 w-64 rounded-full bg-[#9E2428]/[0.06] blur-[90px] transition duration-700 group-hover:bg-[#9E2428]/[0.12]"></div>

                                <div class="studio-card-grid absolute inset-0 opacity-[0.06]"></div>

                                <div class="absolute inset-0 bg-gradient-to-t from-[#151515] via-[#151515]/55 to-transparent"></div>

                            </div>

                            {{-- BORDE SUPERIOR --}}

                            <div class="absolute left-0 top-0 h-[2px] w-0 bg-gradient-to-r from-[#A99045] to-[#D8C17F] transition-all duration-700 group-hover:w-full"></div>

                            {{-- METADATOS --}}

                            <div class="absolute inset-x-0 top-0 flex items-center justify-between gap-2 p-5 sm:p-6">

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-[#F5F3ED]/10 bg-[#151515]/50 text-[10px] font-bold tracking-widest text-[#D8C17F] transition group-hover:border-[#A99045]/40">

                                    {{ sprintf('%02d', $loop->iteration) }}

                                </span>

                                <span class="max-w-[70%] truncate rounded-lg border border-[#F5F3ED]/10 bg-[#151515]/40 px-3 py-2 text-[9px] font-bold tracking-wider text-[#F5F3ED]/55 backdrop-blur-md transition group-hover:border-[#A99045]/30 group-hover:text-[#D8C17F]">

                                    {{ $categoria->productos_count }} PRODUCTOS

                                </span>

                            </div>

                            {{-- DETALLE GEOMÉTRICO --}}

                            <div class="pointer-events-none absolute right-8 top-24 h-12 w-12 rotate-45 border border-[#F5F3ED]/[0.08] transition duration-700 group-hover:rotate-90 group-hover:scale-110 group-hover:border-[#A99045]/40"></div>

                            {{-- CONTENIDO --}}

                            <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">

                                <div class="mb-5 h-px w-10 bg-gradient-to-r from-[#A99045] to-[#D8C17F] transition-all duration-500 group-hover:w-20"></div>

                                <h3 class="break-words text-2xl font-bold uppercase leading-tight tracking-[-0.04em] text-[#F5F3ED] transition-colors duration-300 group-hover:text-[#D8C17F] sm:text-3xl">

                                    {{ $categoria->nombre }}

                                </h3>

                                @if($categoria->descripcion)

                                    <p class="mt-4 line-clamp-3 break-words text-xs leading-6 text-[#F5F3ED]/50 transition-colors group-hover:text-[#F5F3ED]/75">

                                        {{ $categoria->descripcion }}

                                    </p>

                                @endif

                                <div class="mt-7 flex items-center justify-between gap-3">

                                    <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-[#F5F3ED]/50 transition-colors group-hover:text-[#F5F3ED]">

                                        Conoce más

                                    </span>

                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-[#F5F3ED]/10 bg-[#151515]/40 text-[#F5F3ED]/60 transition duration-300 group-hover:translate-x-1 group-hover:border-[#A99045]/50 group-hover:bg-[#A99045] group-hover:text-[#151515]">

                                        <svg

                                            class="h-4 w-4"

                                            viewBox="0 0 24 24"

                                            fill="none"

                                            stroke="currentColor"

                                            stroke-width="1.8"

                                            aria-hidden="true"

                                        >

                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9"/>

                                        </svg>

                                    </span>

                                </div>

                            </div>

                            {{-- CONTORNO --}}

                            <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-inset ring-[#F5F3ED]/0 transition duration-500 group-hover:ring-[#A99045]/10"></div>

                        </a>

                    @empty

                        <div class="col-span-full flex min-h-[300px] items-center justify-center rounded-xl border border-[#F5F3ED]/10 bg-[#151515]/40 p-8">

                            <div class="text-center">

                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-xl border border-[#A99045]/25 bg-[#A99045]/[0.08] text-2xl text-[#D8C17F]">

                                    +

                                </div>

                                <h3 class="mt-6 text-xl font-bold uppercase tracking-tight text-[#F5F3ED]">

                                    Aún no hay categorías

                                </h3>

                                <p class="mt-3 text-sm text-[#F5F3ED]/45">

                                    Las categorías aparecerán aquí.

                                </p>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </section>

        {{-- =========================================================

             NUESTROS TRABAJOS

        ========================================================== --}}

        <section id="trabajos" class="studio-section-black py-24 lg:py-32">

            <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-10">

                {{-- ENCABEZADO --}}

                <div class="mb-14 text-center sm:mb-16">

                    <span class="inline-flex items-center gap-3 rounded-lg border border-[#A99045]/25 bg-[#A99045]/[0.06] px-4 py-2 text-[9px] font-bold uppercase tracking-[0.25em] text-[#D8C17F] sm:text-[10px]">

                        <span class="h-1.5 w-1.5 rounded-full bg-[#A99045]"></span>

                        Creatividad sin límites

                    </span>

                    <h2 class="mt-7 text-4xl font-black uppercase leading-tight tracking-[-0.055em] text-[#F5F3ED] sm:text-6xl lg:text-7xl">

                        Nuestros

                        <span class="block text-[#D8C17F] sm:inline">

                            trabajos<span class="text-[#A99045]">.</span>

                        </span>

                    </h2>

                    <div class="mx-auto mt-6 h-px w-24 bg-gradient-to-r from-transparent via-[#A99045] to-transparent"></div>

                </div>

                {{-- CUADRÍCULA DE PRODUCTOS --}}

                <div class="grid grid-cols-1 items-stretch gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    @forelse($productos as $producto)

                        <article class="studio-product-card group">

                            {{-- FONDO --}}

                            <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">

                                <div class="absolute inset-0 bg-gradient-to-br from-[#A99045]/[0.10] via-[#20201E] to-[#151515]"></div>

                                <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-[#A99045]/[0.12] blur-[90px] transition duration-700 group-hover:bg-[#A99045]/[0.22]"></div>

                                <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-[#9E2428]/[0.06] blur-[90px] transition duration-700 group-hover:bg-[#9E2428]/[0.12]"></div>

                                <div class="studio-card-grid absolute inset-0 opacity-[0.06]"></div>

                                <div class="absolute inset-0 bg-gradient-to-t from-[#151515] via-[#151515]/65 to-[#151515]/10"></div>

                            </div>

                            {{-- BORDE ILUMINADO --}}

                            <div class="absolute left-0 top-0 z-20 h-[2px] w-0 bg-gradient-to-r from-[#A99045] to-[#D8C17F] transition-all duration-700 group-hover:w-full"></div>

                            {{-- CATEGORÍA --}}

                            <div class="absolute inset-x-0 top-0 z-10 flex items-center justify-between gap-3 p-5">

                                <span class="max-w-[75%] truncate rounded-lg border border-[#F5F3ED]/10 bg-[#151515]/50 px-3 py-2 text-[9px] font-bold uppercase tracking-[0.15em] text-[#F5F3ED]/60 backdrop-blur-md transition group-hover:border-[#A99045]/35 group-hover:text-[#D8C17F]">

                                    {{ $producto->categoria->nombre ?? 'Producto' }}

                                </span>

                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg border border-[#F5F3ED]/10 bg-[#151515]/40 text-[#F5F3ED]/60 transition duration-300 group-hover:border-[#A99045]/50 group-hover:bg-[#A99045] group-hover:text-[#151515]">

                                    <svg

                                        class="h-4 w-4 transition-transform duration-500 group-hover:rotate-45"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="1.8"

                                        aria-hidden="true"

                                    >

                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9"/>

                                    </svg>

                                </span>

                            </div>

                            {{-- DETALLE DECORATIVO --}}

                            <div class="pointer-events-none absolute right-8 top-24 h-14 w-14 rotate-45 border border-[#F5F3ED]/[0.08] transition duration-700 group-hover:rotate-90 group-hover:scale-110 group-hover:border-[#A99045]/35"></div>

                            {{-- INFORMACIÓN DEL PRODUCTO --}}

                            <div class="absolute inset-x-0 bottom-0 z-10 p-5 sm:p-6">

                                <div class="mb-4 h-px w-10 bg-gradient-to-r from-[#A99045] to-[#D8C17F] transition-all duration-500 group-hover:w-20"></div>

                                <h3 class="break-words text-2xl font-bold uppercase leading-tight tracking-[-0.035em] text-[#F5F3ED] transition-colors duration-300 group-hover:text-[#D8C17F] sm:text-3xl">

                                    {{ $producto->nombre }}

                                </h3>

                                @if($producto->descripcion)

                                    <p class="mt-3 line-clamp-3 break-words text-xs leading-6 text-[#F5F3ED]/50 transition-colors group-hover:text-[#F5F3ED]/75">

                                        {{ $producto->descripcion }}

                                    </p>

                                @endif

                                {{-- PRECIO Y ETIQUETA --}}

                                <div class="mt-6 flex items-end justify-between gap-3 border-t border-[#F5F3ED]/10 pt-5">

                                    <div class="min-w-0">

                                        <span class="mb-1 block text-[9px] font-bold uppercase tracking-[0.2em] text-[#F5F3ED]/40">

                                            Precio

                                        </span>

                                        <strong class="block break-words text-xl font-bold tracking-tight text-[#F5F3ED] transition-colors group-hover:text-[#D8C17F]">

                                            ${{ number_format($producto->precio, 0, ',', '.') }}

                                        </strong>

                                    </div>

                                    <span class="flex shrink-0 items-center gap-2 pb-1 text-[9px] font-bold uppercase tracking-[0.12em] text-[#F5F3ED]/45 transition group-hover:translate-x-1 group-hover:text-[#F5F3ED]">

                                        Ver proyecto

                                        <span class="text-[#A99045]">→</span>

                                    </span>

                                </div>

                            </div>

                            {{-- CONTORNO --}}

                            <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-inset ring-[#F5F3ED]/0 transition duration-500 group-hover:ring-[#A99045]/10"></div>

                        </article>

                    @empty

                        <div class="col-span-full flex min-h-[320px] items-center justify-center rounded-xl border border-[#F5F3ED]/10 bg-[#1D1D1D] p-8">

                            <div class="text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-xl border border-[#A99045]/25 bg-[#A99045]/[0.06]">

                                    <svg

                                        class="h-7 w-7 text-[#D8C17F]"

                                        viewBox="0 0 24 24"

                                        fill="none"

                                        stroke="currentColor"

                                        stroke-width="1.5"

                                        aria-hidden="true"

                                    >

                                        <rect x="4" y="5" width="16" height="14" rx="2"/>

                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 17 5-5 3 3 2-2 5 4"/>

                                    </svg>

                                </div>

                                <h3 class="mt-6 text-2xl font-bold uppercase tracking-tight text-[#F5F3ED]">

                                    Próximamente

                                </h3>

                                <p class="mt-3 text-sm text-[#F5F3ED]/45">

                                    Estamos preparando nuestros trabajos.

                                </p>

                                <div class="mx-auto mt-6 h-px w-12 bg-gradient-to-r from-[#A99045] to-[#D8C17F]"></div>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>

        </section>

        {{-- =========================================================

             EXPERIENCIA

        ========================================================== --}}

        <section id="experiencia" class="relative flex min-h-[650px] items-center overflow-hidden bg-[#151515] sm:min-h-[750px]">

            {{-- IMAGEN --}}

            <div

                class="absolute inset-0 bg-cover bg-center"

                style="background-image: url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=2200&q=85');"

                role="img"

                aria-label="Espacio creativo de trabajo"

            ></div>

            {{-- OVERLAYS --}}

            <div class="absolute inset-0 bg-[#151515]/80"></div>

            <div class="absolute inset-0 bg-gradient-to-r from-[#151515]/75 via-[#151515]/45 to-[#151515]/25"></div>

            <div class="absolute inset-0 bg-gradient-to-t from-[#151515] via-transparent to-[#151515]/55"></div>

            {{-- CONTENIDO --}}

            <div class="relative z-10 mx-auto w-full max-w-7xl px-5 py-24 sm:px-6 lg:px-10 lg:py-32">

                <div class="max-w-5xl">

                    <span class="studio-eyebrow">

                        Ideas que generan impacto

                    </span>

                    <h2 class="mt-8 text-5xl font-black uppercase leading-[0.88] tracking-[-0.06em] text-[#F5F3ED] sm:text-7xl lg:text-9xl">

                        Contenido<br>

                        que conecta<br>

                        personas<span class="text-[#A99045]">.</span>

                    </h2>

                    <p class="mt-8 max-w-xl text-sm leading-7 text-[#F5F3ED]/60 sm:mt-10 sm:text-base sm:leading-8">

                        Generamos contenido viral,

                        fusionando creatividad, tendencias

                        y emociones para conectar de manera

                        profunda con la audiencia.

                    </p>

                </div>

            </div>

        </section>

        {{-- =========================================================

             NUESTRA HISTORIA

        ========================================================== --}}

        <section id="historia" class="studio-history py-24 text-[#151515] lg:py-32">

            <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-10">

                <div class="grid grid-cols-1 items-end gap-10 lg:grid-cols-2 lg:gap-16">

                    {{-- TÍTULO --}}

                    <div>

                        <span class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-[0.25em] text-[#8A7130]">

                            <span class="h-px w-7 bg-[#A99045]"></span>

                            Nuestras raíces

                        </span>

                        <h2 class="mt-8 text-5xl font-black uppercase leading-[0.85] tracking-[-0.06em] text-[#151515] sm:text-7xl lg:text-8xl">

                            Somos una<br>

                            empresa<br>

                            malagueña<span class="text-[#A99045]">.</span>

                        </h2>

                    </div>

                    {{-- DESCRIPCIÓN --}}

                    <div class="max-w-xl lg:justify-self-end">

                        <p class="text-lg leading-8 text-[#151515]/75 sm:text-xl sm:leading-9">

                            Incógnito Group es un grupo de diseño

                            enfocado en la creación de contenido,

                            estrategia digital, producción y

                            desarrollo creativo.

                        </p>

                        <p class="mt-7 text-base leading-8 text-[#151515]/55 sm:mt-8 sm:text-lg">

                            Nuestro objetivo es convertir ideas

                            en experiencias que conecten con

                            las personas.

                        </p>

                        <a

                            href="{{ route('nuestra.historia') }}"

                            class="mt-8 inline-flex items-center gap-3 border-b border-[#A99045]/40 pb-2 text-[10px] font-black uppercase tracking-[0.18em] text-[#8A7130] transition hover:border-[#A99045] hover:text-[#151515]"

                        >

                            Conoce nuestra historia

                            <span aria-hidden="true">→</span>

                        </a>

                    </div>

                </div>

            </div>

        </section>

        {{-- =========================================================

             CONTACTO

        ========================================================== --}}

        <section id="contacto" class="studio-contact relative overflow-hidden py-28 sm:py-36 lg:py-48">

            {{-- LUCES DECORATIVAS --}}

            <div class="pointer-events-none absolute -right-24 top-10 h-72 w-72 rounded-full bg-[#A99045]/[0.08] blur-[100px]"></div>

            <div class="pointer-events-none absolute -bottom-24 left-0 h-80 w-80 rounded-full bg-[#9E2428]/[0.08] blur-[110px]"></div>

            <div class="relative mx-auto max-w-7xl px-5 sm:px-6 lg:px-10">

                <div class="max-w-6xl">

                    <span class="studio-eyebrow">

                        Hagamos algo extraordinario

                    </span>

                    <h2 class="mt-8 text-6xl font-black uppercase leading-[0.8] tracking-[-0.07em] text-[#F5F3ED] sm:text-8xl lg:text-[9rem]">

                        ¿Tienes<br>

                        una idea<span class="text-[#A99045]">?</span>

                    </h2>

                    <p class="mt-8 max-w-xl text-base leading-7 text-[#F5F3ED]/55 sm:mt-10 sm:text-lg sm:leading-8">

                        Hablemos sobre tu próximo proyecto.

                    </p>

                    <a

                        href="#"

                        class="studio-primary mt-9 inline-flex items-center gap-3 rounded-lg px-8 py-4 text-[10px] font-black uppercase tracking-[0.18em] hover:-translate-y-0.5"

                    >

                        Contáctanos

                        <svg

                            class="h-4 w-4"

                            viewBox="0 0 24 24"

                            fill="none"

                            stroke="currentColor"

                            stroke-width="2"

                            aria-hidden="true"

                        >

                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9"/>

                        </svg>

                    </a>

                </div>

            </div>

        </section>

    </main>

</div>

@endsection
