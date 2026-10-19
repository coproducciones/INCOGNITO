@extends('layouts.app')

@section('title', 'Incógnito | Group Design')

@section('content')

<div class="studio-shell text-white">

    {{-- Estilos visuales del Creative Studio + Futurista Glow --}}
    <style>
        .studio-shell{--glow-cyan:rgba(34,211,238,.24);--glow-violet:rgba(139,92,246,.24);background:#070711;overflow:hidden}
        .studio-shell [x-cloak]{display:none!important}
        .studio-logo-mark{position:relative;border-radius:16px;background:linear-gradient(145deg,rgba(34,211,238,.15),rgba(139,92,246,.12));box-shadow:0 0 28px rgba(34,211,238,.12),inset 0 0 18px rgba(255,255,255,.04)}
        .studio-primary{background:linear-gradient(110deg,#67e8f9 0%,#a78bfa 100%);box-shadow:0 0 24px rgba(34,211,238,.2),0 0 48px rgba(139,92,246,.12)}
        .studio-primary:hover{box-shadow:0 0 30px rgba(34,211,238,.35),0 0 58px rgba(139,92,246,.22)}
        .studio-section-dark{position:relative;background:radial-gradient(ellipse at 12% 20%,rgba(124,58,237,.13),transparent 38%),radial-gradient(ellipse at 88% 78%,rgba(6,182,212,.09),transparent 35%),#0b0b15}
        .studio-section-black{position:relative;background:radial-gradient(ellipse at 50% 0%,rgba(124,58,237,.12),transparent 48%),#070711}
        .studio-contact{position:relative;background:radial-gradient(ellipse at 80% 20%,rgba(34,211,238,.12),transparent 35%),radial-gradient(ellipse at 15% 80%,rgba(139,92,246,.16),transparent 40%),#0b0b15}
        .studio-history{position:relative;background-image:radial-gradient(rgba(99,102,241,.13) .7px,transparent .7px);background-size:18px 18px}
        .studio-shell header{border-color:rgba(165,243,252,.13);}
        .studio-shell section[id]{scroll-margin-top:6rem}
        .studio-shell section h1,.studio-shell section h2{ text-wrap:balance }
        .studio-shell #servicios a.group{border:1px solid rgba(255,255,255,.08);border-radius:1.1rem;background-color:#11111e;transition:transform .5s,border-color .5s,box-shadow .5s}
        .studio-shell #servicios a.group:hover{transform:translateY(-5px);border-color:rgba(103,232,249,.42);box-shadow:0 0 35px rgba(34,211,238,.09),0 20px 50px rgba(0,0,0,.28)}
        .studio-shell #trabajos article{border:1px solid rgba(255,255,255,.08);border-radius:1rem;background:linear-gradient(145deg,#151525,#090910);box-shadow:0 12px 40px rgba(0,0,0,.18);transition:border-color .4s,box-shadow .4s}
        .studio-shell #trabajos article:hover{border-color:rgba(167,139,250,.48);box-shadow:0 0 35px rgba(139,92,246,.14)}
        .studio-shell #trabajos article>div:first-child{background:radial-gradient(ellipse at 50% 25%,rgba(139,92,246,.18),transparent 55%),linear-gradient(145deg,#1b1b2c,#0a0a12)}
        .studio-shell .studio-contact a{border-radius:999px}
        @media(prefers-reduced-motion:reduce){.studio-shell *{scroll-behavior:auto!important;transition-duration:.01ms!important;animation-duration:.01ms!important}}
    </style>

    {{-- ========================================================= --}}
    {{-- NAVBAR --}}
    {{-- ========================================================= --}}

    <header class="fixed left-0 top-0 z-50 w-full border-b border-white/10 bg-[#070711]/80 backdrop-blur-2xl shadow-[0_8px_40px_rgba(0,0,0,0.25)]">

        <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-10">

            {{-- =================================================
                 LOGO
                 ================================================= --}}

            <a
                href="{{ url('/') }}"
                class="group flex items-center gap-3"
            >

                <div
                    class="flex h-12 w-12 items-center justify-center studio-logo-mark border border-cyan-300/50 text-xl font-black text-cyan-200 transition duration-500 group-hover:border-cyan-200"
                >
                    O
                </div>

                <div class="hidden leading-none sm:block">

                    <span class="block text-xs font-black uppercase tracking-[0.15em]">
                        Incógnito
                    </span>

                    <span class="block text-[9px] uppercase tracking-[0.2em] text-white/50">
                        Group Design
                    </span>

                </div>

            </a>


            {{-- =================================================
                 MENÚ PRINCIPAL
                 ================================================= --}}

            <div class="hidden items-center gap-8 md:flex">

                <a
                    href="{{ url('/') }}"
                    class="text-xs font-bold uppercase tracking-wider text-white/75 transition duration-300 hover:text-cyan-200"
                >
                    Home
                </a>

                <a
                    href="{{ url('nuestro-trabajo') }}"
                    class="text-xs font-bold uppercase tracking-wider text-white/75 transition duration-300 hover:text-cyan-200"
                >
                    Nuestro trabajo
                </a>

                <a
                    href="{{ url('nuestra-historia') }}"
                    class="text-xs font-bold uppercase tracking-wider text-white/75 transition duration-300 hover:text-cyan-200"
                >
                    Nuestra historia
                </a>

                <a
                    href="{{ url('servicios') }}"
                    class="text-xs font-bold uppercase tracking-wider text-white/75 transition duration-300 hover:text-cyan-200"
                >
                    Servicios
                </a>

            </div>


            {{-- =================================================
                 ACCIONES DEL USUARIO
                 ================================================= --}}

            <div class="flex items-center gap-2 sm:gap-3">

                {{-- =================================================
                     USUARIO NO AUTENTICADO
                     ================================================= --}}

                @guest

                    {{-- INICIAR SESIÓN --}}

                    <a
                        href="{{ route('login') }}"
                        class= hidden rounded-full border border-white/20 bg-white/[0.03] px-5 py-2.5 text-[10px] font-black uppercase tracking-wider text-white transition duration-300 hover:border-cyan-300/70 hover:bg-cyan-300/10 hover:shadow-[0_0_24px_rgba(34,211,238,0.18)] sm:inline-flex"
                    >
                        Iniciar sesión
                    </a>


                    {{-- REGISTRARSE --}}

                    <a
                        href="{{ route('usuarios.create') }}"
                        class="hidden studio-primary rounded-full px-5 py-2.5 text-[10px] font-black uppercase tracking-wider text-[#070711] transition duration-300 hover:-translate-y-0.5 sm:inline-flex"
                    >
                        Registrarse
                    </a>

                @endguest


                {{-- =================================================
                     USUARIO AUTENTICADO
                     ================================================= --}}

                @auth

                    <div
                        x-data="{ open: false }"
                        class="relative"
                    >

                        {{-- =================================================
                             BOTÓN DEL USUARIO
                             ================================================= --}}

                        <button
                            type="button"
                            @click="open = !open"
                            @click.outside="open = false"
                            class= flex items-center gap-3 rounded-full border border-white/15 bg-white/[0.08] px-4 py-2 text-white backdrop-blur-xl transition hover:bg-white/15"
                            aria-haspopup="true"
                            :aria-expanded="open.toString()"
                        >

                            {{-- Avatar --}}

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->nombre ?? auth()->user()->name ?? 'Usuario') }}&background=61C174&color=000000"
                                alt="Avatar de {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Usuario' }}"
                                class="h-7 w-7 rounded-full ring-2 ring-cyan-300/40"
                            >


                            {{-- Nombre --}}

                            <span
                                class= hidden max-w-[140px] truncate text-[10px] font-black uppercase tracking-wider text-white sm:block
                            >
                                {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Usuario' }}
                            </span>


                            {{-- Flecha --}}

                            <svg
                                class="h-3 w-3 text-cyan-200"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="3"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </button>


                        {{-- =================================================
                             DROPDOWN DEL USUARIO
                             ================================================= --}}

                        <div
                            x-show="open"
                            x-cloak
                            x-transition
                            class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-white/10 bg-[#10101c]/95 shadow-[0_20px_80px_rgba(0,0,0,0.55)] backdrop-blur-2xl"
                        >

                            {{-- =================================================
                                 INFORMACIÓN DEL USUARIO
                                 ================================================= --}}

                            <div class="border-b border-white/10 px-5 py-4">

                                <p class="truncate text-xs font-black uppercase tracking-wider text-white">
                                    {{ auth()->user()->nombre ?? auth()->user()->name ?? 'Usuario' }}
                                </p>

                                <p class="mt-1 truncate text-[10px] text-white/40">
                                    {{ auth()->user()->email }}
                                </p>

                                @if(auth()->user()->rol)

                                    <p class="mt-2 text-[9px] font-bold uppercase tracking-widest text-cyan-300">
                                        {{ auth()->user()->rol->nombre }}
                                    </p>

                                @endif

                            </div>


                            {{-- =================================================
                                 MI CUENTA
                                 ================================================= --}}

                            @if(Route::has('mi-cuenta'))

                                <a
                                    href="{{ route('mi-cuenta') }}"
                                    class="block px-5 py-3 text-[10px] font-black uppercase tracking-widest text-white/70 transition hover:bg-cyan-300/10 hover:text-cyan-200"
                                >
                                    Mi cuenta
                                </a>

                            @endif


                            {{-- =================================================
                                 MI PERFIL
                                 ================================================= --}}

                            @if(Route::has('mi-cuenta.perfil'))

                                <a
                                    href="{{ route('mi-cuenta.perfil') }}"
                                    class="block px-5 py-3 text-[10px] font-black uppercase tracking-widest text-white/70 transition hover:bg-cyan-300/10 hover:text-cyan-200"
                                >
                                    Mi perfil
                                </a>

                            @endif


                            {{-- =================================================
                                 EDITAR PERFIL
                                 ================================================= --}}

                            @if(Route::has('mi-cuenta.perfil.edit'))

                                <a
                                    href="{{ route('mi-cuenta.perfil.edit') }}"
                                    class="block px-5 py-3 text-[10px] font-black uppercase tracking-widest text-white/70 transition hover:bg-cyan-300/10 hover:text-cyan-200"
                                >
                                    Editar perfil
                                </a>

                            @endif


                            {{-- =================================================
                                 SEPARADOR
                                 ================================================= --}}

                            <div class="border-t border-white/10"></div>


                            {{-- =================================================
                                 CERRAR SESIÓN
                                 ================================================= --}}

                            <form
                                method="POST"
                                action="{{ route('logout') }}"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full px-5 py-3 text-left text-[10px] font-black uppercase tracking-widest text-rose-300 transition hover:bg-rose-500/10"
                                >
                                    Cerrar sesión
                                </button>

                            </form>

                        </div>

                    </div>

                @endauth


                {{-- =================================================
                     MENÚ MÓVIL
                     ================================================= --}}

                <div
                    x-data="{ open: false }"
                    class="relative md:hidden"
                >

                    <button
                        type="button"
                        @click="open = !open"
                        class="flex items-center justify-center p-2 text-white"
                        aria-label="Abrir menú"
                        :aria-expanded="open.toString()"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />

                        </svg>

                    </button>


                    {{-- MENÚ MÓVIL --}}

                    <div
                        x-show="open"
                        x-cloak
                        x-transition
                        @click.outside="open = false"
                        class="absolute right-0 mt-3 w-64 overflow-hidden rounded-2xl border border-white/10 bg-[#10101c]/95 shadow-[0_20px_80px_rgba(0,0,0,0.55)] backdrop-blur-2xl"
                    >

                        <a
                            href="{{ url('/') }}"
                            @click="open = false"
                            class="block border-b border-white/5 px-5 py-4 text-xs font-bold uppercase tracking-wider text-white hover:bg-cyan-300/10"
                        >
                            Home
                        </a>

                        <a
                            href="{{ route('nuestro.trabajo') }}"
                            @click="open = false"
                            class="block border-b border-white/5 px-5 py-4 text-xs font-bold uppercase tracking-wider text-white hover:bg-cyan-300/10"
                        >
                            Nuestro trabajo
                        </a>

                        <a
                            href="{{ route('nuestra.historia') }}"
                            @click="open = false"
                            class="block border-b border-white/5 px-5 py-4 text-xs font-bold uppercase tracking-wider text-white hover:bg-cyan-300/10"
                        >
                            Nuestra historia
                        </a>

                        <a
                            href="#servicios"
                            @click="open = false"
                            class="block px-5 py-4 text-xs font-bold uppercase tracking-wider text-white hover:bg-cyan-300/10"
                        >
                            Servicios
                        </a>


                        @guest

                            <div class="border-t border-white/10 p-4">

                                <a
                                    href="{{ route('login') }}"
                                    class="mb-2 block rounded-full border border-white/20 px-5 py-3 text-center text-[10px] font-black uppercase tracking-wider text-white hover:bg-cyan-300/10"
                                >
                                    Iniciar sesión
                                </a>

                                <a
                                    href="{{ route('usuarios.create') }}"
                                    class="block rounded-full studio-primary px-5 py-3 text-center text-[10px] font-black uppercase tracking-wider text-[#070711]"
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



    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden">

{{-- IMAGEN DE FONDO --}}

<div class="absolute inset-0">
    <div
        class="h-full w-full bg-cover bg-center"
        style="background-image: url('{{ Vite::asset('resources/img/preview-incognito-group.jpg') }}');">
    </div>
</div>


        {{-- OVERLAY --}}

        <div class="absolute inset-0 bg-[#070711]/75"></div>

        <div class= absolute inset-0 bg-gradient-to-b from-[#070711]/85 via-[#080817]/35 to-[#070711]></div>


        {{-- CONTENIDO --}}

        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 pt-24 text-center lg:px-10">

            <span class="mb-8 block text-xs font-medium uppercase tracking-[0.5em] text-white/50">
                Grupo de diseño
            </span>

            <h1 class="text-[18vw] font-thin uppercase leading-[0.65] tracking-[-0.09em] text-white sm:text-[15vw] lg:text-[12rem]">
                INCOGNITO
            </h1>

            <h2 class="mt-10 text-2xl font-bold uppercase tracking-tight sm:text-4xl">

                GROUP DESIGN

                <span class="font-light text-white/50">
                    AND MUCH
                </span>

            </h2>

            <p class="mx-auto mt-5 max-w-xl text-sm leading-6 text-white/65 sm:text-base">

                Grupo de diseño y mucho más.
                Creación de contenido, producción,
                manufactura y estrategia digital.

            </p>

            <div class="mt-10 flex justify-center">

                <a
                    href="{{ route('nuestra.historia') }}"
                    class="studio-primary rounded-full px-8 py-4 text-xs font-black uppercase tracking-[0.15em] text-[#070711] transition duration-300 hover:scale-105"
                >
                    ¿Qué hacemos?
                </a>

            </div>

        </div>

    </section>

    {{-- ========================================================= --}}
    {{-- ¿QUÉ HACEMOS? --}}
    {{-- ========================================================= --}}

    <section id="servicios" class="studio-section-dark py-24 lg:py-32">

        <div class="mx-auto max-w-7xl px-6 lg:px-10">

            <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">

                <div>

                    <h2 class="mt-4 text-5xl font-black uppercase leading-[0.85] tracking-tight sm:text-7xl">

                        ¿Qué<br>
                        hacemos?

                    </h2>

                </div>

                <div class="flex items-end">

                    <p class="max-w-lg text-sm leading-7 text-white/40">

                        Potenciamos tu presencia digital con
                        contenido de alta calidad, destacando
                        en redes sociales y asegurando la
                        expansión viral de tu mensaje.

                    </p>

                </div>

            </div>


 
{{-- CATEGORÍAS --}}

<div class="mt-20 grid h-auto grid-cols-1 gap-3 sm:grid-cols-2 lg:h-[650px] lg:grid-cols-4">

    @forelse($categorias as $categoria)

        <a
            href="{{ route('categorias.index') }}"
            class="group relative isolate min-h-[380px] overflow-hidden rounded-2xl border border-white/[0.08] bg-[#0b0b16] transition-all duration-500 hover:-translate-y-2 hover:border-violet-400/50 hover:shadow-[0_20px_60px_rgba(139,92,246,0.18)] lg:min-h-0"
        >

            {{-- FONDO Y LUCES --}}

            <div class="absolute inset-0 -z-10 overflow-hidden">

                <div class="absolute inset-0 bg-gradient-to-br from-violet-500/15 via-[#11111f] to-[#070711]"></div>

                <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-violet-600/15 blur-[90px] transition-all duration-700 group-hover:bg-violet-500/30"></div>

                <div class="absolute -bottom-24 -left-20 h-64 w-64 rounded-full bg-cyan-500/10 blur-[90px] transition-all duration-700 group-hover:bg-cyan-400/20"></div>

                {{-- CUADRÍCULA DECORATIVA --}}

                <div
                    class="absolute inset-0 opacity-[0.07]"
                    style="background-image: linear-gradient(rgba(255,255,255,0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 35px 35px;"
                ></div>

                {{-- OSCURECIMIENTO INFERIOR --}}

                <div class="absolute inset-0 bg-gradient-to-t from-[#070711] via-[#070711]/50 to-transparent"></div>

            </div>

            {{-- BORDE SUPERIOR ILUMINADO --}}

            <div class="absolute left-0 top-0 h-[2px] w-0 bg-gradient-to-r from-violet-500 to-cyan-300 transition-all duration-700 group-hover:w-full"></div>

            {{-- CONTENIDO SUPERIOR --}}

            <div class="absolute inset-x-0 top-0 flex items-center justify-between p-6">

                <span class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/[0.04] text-[10px] font-bold tracking-widest text-white/60 transition-all duration-500 group-hover:border-violet-400/40 group-hover:bg-violet-400/10 group-hover:text-violet-200">
                    {{ sprintf('%02d', $loop->iteration) }}
                </span>

                <span class="rounded-full border border-white/10 bg-black/20 px-3 py-1.5 text-[10px] font-medium tracking-wider text-white/50 backdrop-blur-md transition-colors duration-300 group-hover:border-cyan-300/30 group-hover:text-cyan-200">
                    {{ $categoria->productos_count }} PRODUCTOS
                </span>

            </div>

            {{-- DETALLE DECORATIVO --}}

            <div class="absolute right-7 top-24 h-12 w-12 rotate-45 border border-white/[0.07] transition-all duration-700 group-hover:rotate-90 group-hover:scale-125 group-hover:border-violet-300/30"></div>

            {{-- CONTENIDO INFERIOR --}}

            <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">

                <div class="mb-4 h-px w-10 bg-gradient-to-r from-violet-400 to-cyan-300 transition-all duration-500 group-hover:w-20"></div>

                <h3 class="break-words text-3xl font-black uppercase leading-[0.95] tracking-[-0.04em] text-white transition-all duration-500 group-hover:-translate-y-1 group-hover:text-cyan-200 sm:text-4xl">
                    {{ $categoria->nombre }}
                </h3>

                @if($categoria->descripcion)

                    <p class="mt-4 line-clamp-3 text-xs leading-6 text-white/50 transition-colors duration-300 group-hover:text-white/75">
                        {{ $categoria->descripcion }}
                    </p>

                @endif

                {{-- LLAMADA A LA ACCIÓN --}}

                <div class="mt-7 flex items-center justify-between">

                    <span class="text-[10px] font-bold uppercase tracking-[0.22em] text-white/50 transition-colors duration-300 group-hover:text-white">
                        Conoce más
                    </span>

                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/[0.03] text-white/60 transition-all duration-500 group-hover:translate-x-1 group-hover:border-cyan-300/40 group-hover:bg-cyan-300 group-hover:text-[#070711]">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9" />
                        </svg>
                    </span>

                </div>

            </div>

            {{-- BRILLO AL PASAR EL CURSOR --}}

            <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/0 transition-all duration-500 group-hover:ring-white/10"></div>

        </a>

    @empty

        <div class="col-span-full flex min-h-[350px] items-center justify-center rounded-2xl border border-white/10 bg-white/[0.02]">

            <div class="text-center">

                <h3 class="text-2xl font-bold uppercase tracking-tight text-white">
                    Aún no hay categorías
                </h3>

                <p class="mt-3 text-sm text-white/40">
                    Las categorías aparecerán aquí.
                </p>

            </div>

        </div>

    @endforelse

</div>





{{-- ========================================================= --}}
{{-- NUESTROS TRABAJOS --}}
{{-- ========================================================= --}}

<section id="trabajos" class="studio-section-black py-24 lg:py-32">

    <div class="mx-auto max-w-7xl px-6 lg:px-10">

        {{-- ENCABEZADO --}}

        <div class="mb-16 text-center">

            <span class="inline-flex items-center gap-3 rounded-full border border-violet-400/20 bg-violet-400/[0.05] px-5 py-2 text-[10px] font-bold uppercase tracking-[0.3em] text-violet-200/80">
                <span class="h-1.5 w-1.5 rounded-full bg-cyan-300 shadow-[0_0_10px_rgba(103,232,249,0.8)]"></span>
                Creatividad sin límites
            </span>

            <h2 class="mt-6 text-5xl font-black uppercase tracking-[-0.05em] text-white sm:text-7xl">
                Nuestros
                <span class="bg-gradient-to-r from-violet-300 via-white to-cyan-200 bg-clip-text text-transparent">
                    trabajos
                </span>
            </h2>

            <div class="mx-auto mt-6 h-px w-24 bg-gradient-to-r from-transparent via-violet-400 to-transparent"></div>

        </div>


        {{-- GRID DE PRODUCTOS --}}

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

            @forelse($productos as $producto)

                <article
                    class="group relative isolate aspect-[3/4] min-h-[360px] overflow-hidden rounded-2xl border border-white/[0.08] bg-[#0b0b16] transition-all duration-500 hover:-translate-y-2 hover:border-violet-400/50 hover:shadow-[0_20px_60px_rgba(139,92,246,0.18)]"
                >

                    {{-- FONDO Y EFECTOS DE LUZ --}}

                    <div class="absolute inset-0 -z-10 overflow-hidden">

                        <div class="absolute inset-0 bg-gradient-to-br from-violet-500/15 via-[#11111f] to-[#070711]"></div>

                        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-violet-600/15 blur-[90px] transition-all duration-700 group-hover:bg-violet-500/30"></div>

                        <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-cyan-500/10 blur-[90px] transition-all duration-700 group-hover:bg-cyan-400/20"></div>

                        {{-- CUADRÍCULA DECORATIVA --}}

                        <div
                            class="absolute inset-0 opacity-[0.07]"
                            style="background-image: linear-gradient(rgba(255,255,255,0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.2) 1px, transparent 1px); background-size: 35px 35px;"
                        ></div>

                        {{-- DEGRADADO PARA LEGIBILIDAD --}}

                        <div class="absolute inset-0 bg-gradient-to-t from-[#070711] via-[#070711]/65 to-[#070711]/10"></div>

                    </div>


                    {{-- BORDE SUPERIOR ILUMINADO --}}

                    <div class="absolute left-0 top-0 z-20 h-[2px] w-0 bg-gradient-to-r from-violet-500 to-cyan-300 transition-all duration-700 group-hover:w-full"></div>


                    {{-- INFORMACIÓN SUPERIOR --}}

                    <div class="absolute inset-x-0 top-0 z-10 flex items-center justify-between gap-3 p-5">

                        <span class="max-w-[75%] truncate rounded-full border border-white/10 bg-black/30 px-3 py-2 text-[9px] font-bold uppercase tracking-[0.18em] text-white/60 backdrop-blur-md transition-colors duration-300 group-hover:border-violet-400/30 group-hover:text-violet-200">
                            {{ $producto->categoria->nombre ?? 'Producto' }}
                        </span>

                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/[0.04] text-white/60 transition-all duration-500 group-hover:border-cyan-300/40 group-hover:bg-cyan-300 group-hover:text-[#070711]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 transition-transform duration-500 group-hover:rotate-45"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9" />
                            </svg>

                        </span>

                    </div>


                    {{-- DETALLE DECORATIVO --}}

                    <div class="absolute right-8 top-24 h-16 w-16 rotate-45 border border-white/[0.07] transition-all duration-700 group-hover:rotate-90 group-hover:scale-125 group-hover:border-violet-300/30"></div>


                    {{-- CONTENIDO INFERIOR --}}

                    <div class="absolute inset-x-0 bottom-0 z-10 p-6">

                        <div class="mb-4 h-px w-10 bg-gradient-to-r from-violet-400 to-cyan-300 transition-all duration-500 group-hover:w-20"></div>

                        <h3 class="break-words text-2xl font-black uppercase leading-tight tracking-[-0.035em] text-white transition-all duration-500 group-hover:-translate-y-1 group-hover:text-cyan-200 sm:text-3xl">
                            {{ $producto->nombre }}
                        </h3>

                        @if($producto->descripcion)

                            <p class="mt-3 line-clamp-3 text-xs leading-6 text-white/50 transition-colors duration-300 group-hover:text-white/75">
                                {{ $producto->descripcion }}
                            </p>

                        @endif


                        {{-- PRECIO Y ACCIÓN --}}

                        <div class="mt-6 flex items-end justify-between gap-3 border-t border-white/10 pt-5">

                            <div class="min-w-0">

                                <span class="mb-1 block text-[9px] font-bold uppercase tracking-[0.2em] text-white/35">
                                    Precio
                                </span>

                                <strong class="block break-words text-xl font-black tracking-tight text-white transition-colors duration-300 group-hover:text-cyan-200">
                                    ${{ number_format($producto->precio, 0, ',', '.') }}
                                </strong>

                            </div>

                            <span class="flex shrink-0 items-center gap-2 pb-1 text-[9px] font-bold uppercase tracking-[0.15em] text-white/40 transition-all duration-300 group-hover:translate-x-1 group-hover:text-white">
                                Ver proyecto
                                <span class="text-cyan-300">→</span>
                            </span>

                        </div>

                    </div>


                    {{-- CONTORNO INTERACTIVO --}}

                    <div class="pointer-events-none absolute inset-0 rounded-2xl ring-1 ring-inset ring-white/0 transition-all duration-500 group-hover:ring-white/10"></div>

                </article>

            @empty

                {{-- ESTADO VACÍO --}}

                <div class="col-span-full flex min-h-[350px] items-center justify-center rounded-2xl border border-white/10 bg-white/[0.02]">

                    <div class="text-center">

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-violet-400/20 bg-violet-400/[0.06]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-7 w-7 text-violet-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7.5A2.5 2.5 0 0 1 6.5 5h11A2.5 2.5 0 0 1 20 7.5v9a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 16.5v-9Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 17 5-5 3 3 2-2 5 4" />
                            </svg>

                        </div>

                        <h3 class="mt-6 text-2xl font-black uppercase tracking-tight text-white">
                            Próximamente
                        </h3>

                        <p class="mt-3 text-sm text-white/40">
                            Estamos preparando nuestros trabajos.
                        </p>

                        <div class="mx-auto mt-6 h-px w-12 bg-gradient-to-r from-violet-400 to-cyan-300"></div>

                    </div>

                </div>

            @endforelse

        </div>

    </div>

</section>

    {{-- ========================================================= --}}
    {{-- EXPERIENCIA --}}
    {{-- ========================================================= --}}

    <section class="relative min-h-[80vh] overflow-hidden">

        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=2200&q=85')] bg-cover bg-center">
        </div>

        <div class="absolute inset-0 bg-[#070711]/75"></div>

        <div class="relative z-10 flex min-h-[80vh] items-center">

            <div class="mx-auto w-full max-w-7xl px-6 lg:px-10">

                <div class="max-w-5xl">

                    <h2 class="mt-8 text-5xl font-black uppercase leading-[0.85] sm:text-7xl lg:text-9xl">

                        Contenido<br>
                        que conecta<br>
                        personas.

                    </h2>

                    <p class="mt-10 max-w-xl text-sm leading-7 text-white/50">

                        Generamos contenido viral,
                        fusionando creatividad, tendencias
                        y emociones para conectar de manera
                        profunda con la audiencia.

                    </p>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- NUESTRA HISTORIA --}}
    {{-- ========================================================= --}}

    <section id="historia" class="studio-history bg-[#f7f7fb] py-24 text-[#10101b] lg:py-32">

        <div class="mx-auto max-w-7xl px-6 lg:px-10">

            <div class="grid grid-cols-1 gap-16 lg:grid-cols-2">

                <div>

                    <h2 class="mt-8 text-6xl font-black uppercase leading-[0.8] tracking-[-0.05em] sm:text-8xl">

                        Somos una<br>
                        empresa<br>
                        malagueña.

                    </h2>

                </div>

                <div class="flex items-end">

                    <div class="max-w-xl">

                        <p class="text-xl leading-8 text-black/70">

                            Incógnito Group es un grupo de diseño
                            enfocado en la creación de contenido,
                            estrategia digital, producción y
                            desarrollo creativo.

                        </p>

                        <p class="mt-8 text-xl leading-8 text-black/50">

                            Nuestro objetivo es convertir ideas
                            en experiencias que conecten con
                            las personas.

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- CONTACTO --}}
    {{-- ========================================================= --}}

    <section class="studio-contact py-32 lg:py-48">

        <div class="mx-auto max-w-7xl px-6 lg:px-10">

            <div class="max-w-6xl">

                <h2 class="mt-8 text-7xl font-black uppercase leading-[0.75] tracking-[-0.06em] sm:text-9xl">

                    ¿Tienes<br>
                    una idea?

                </h2>

                <p class="mt-10 max-w-xl text-lg text-white/40">

                    Hablemos sobre tu próximo proyecto.

                </p>

                <a
                    href="#"
                    class="mt-10 inline-flex rounded-full studio-primary px-8 py-4 text-xs font-black uppercase tracking-wider text-[#070711] transition hover:scale-105"
                >
                    Contáctanos
                </a>

            </div>

        </div>

    </section>

@endsection