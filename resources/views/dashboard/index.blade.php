@extends('layouts.app')

@section('title', 'Incógnito | Group Design')

@section('content')

<div class="bg-black text-white">


    {{-- ========================================================= --}}
    {{-- NAVBAR --}}
    {{-- ========================================================= --}}

    <header class="fixed left-0 top-0 z-50 w-full border-b border-white/10 bg-black/80 backdrop-blur-md">

        <nav class="mx-auto flex h-20 max-w-7xl items-center justify-between px-6 lg:px-10">


            {{-- LOGO --}}

            <a href="{{ route('dashboard') }}" class="group flex items-center gap-3">

                <div class="flex h-12 w-12 items-center justify-center border border-white/30 text-xl font-black transition duration-300 group-hover:border-white">

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


            {{-- MENÚ --}}

            <div class="hidden items-center gap-8 md:flex">

                <a
                    href="{{ route('dashboard') }}"
                    class="text-xs font-bold uppercase tracking-wider text-white transition hover:text-white/50"
                >
                    Home
                </a>

                <a
                    href="#trabajos"
                    class="text-xs font-bold uppercase tracking-wider text-white transition hover:text-white/50"
                >
                    Nuestro trabajo
                </a>

                <a
                    href="#historia"
                    class="text-xs font-bold uppercase tracking-wider text-white transition hover:text-white/50"
                >
                    Nuestra historia
                </a>

                <a
                    href="#servicios"
                    class="text-xs font-bold uppercase tracking-wider text-white transition hover:text-white/50"
                >
                    Servicios
                </a>

            </div>


            {{-- ACCIONES --}}

            <div class="hidden items-center gap-2 sm:flex">

                <a
                    href="#"
                    class="rounded-full bg-white px-5 py-2.5 text-[10px] font-black uppercase tracking-wider text-black transition hover:bg-white/80"
                >
                    Iniciar sesión
                </a>

                <a
                    href="#"
                    class="rounded-full bg-[#61C174] px-5 py-2.5 text-[10px] font-black uppercase tracking-wider text-black transition hover:bg-[#78d48a]"
                >
                    Registrarse
                </a>

            </div>


            {{-- MOBILE MENU --}}

            <button class="text-white md:hidden">

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

        </nav>

    </header>



    {{-- HERO --}}

    <section class="relative flex min-h-screen items-center justify-center overflow-hidden">


        {{-- IMAGEN DE FONDO --}}

        <div class="absolute inset-0">

            <div class="h-full w-full bg-[url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2200&q=85')] bg-cover bg-center">
            </div>

        </div>


        {{-- OVERLAY --}}

        <div class="absolute inset-0 bg-black/70"></div>

        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/30 to-black"></div>


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


            <p class="mx-auto mt-5 max-w-xl text-sm leading-6 text-white/50 sm:text-base">

                Grupo de diseño y mucho más.
                Creación de contenido, producción,
                manufactura y estrategia digital.

            </p>


            <div class="mt-10 flex justify-center">

                <a
                    href="#servicios"
                    class="rounded-full bg-white px-8 py-4 text-xs font-black uppercase tracking-[0.15em] text-black transition hover:scale-105"
                >

                    ¿Qué hacemos?

                </a>

            </div>

        </div>


        {{-- SCROLL --}}

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2">

            <span class="text-[9px] uppercase tracking-[0.4em] text-white/40">
                Scroll
            </span>

        </div>

    </section>




    {{-- ¿QUÉ HACEMOS? --}}
   
    <section id="servicios" class="bg-[#111] py-24 lg:py-32">


        <div class="mx-auto max-w-7xl px-6 lg:px-10">


            {{-- HEADER --}}

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

            <div class="mt-20 grid h-[650px] grid-cols-1 gap-1 md:grid-cols-2 lg:grid-cols-4">

                @forelse($categorias as $categoria)

                    <a
                        href="{{ route('categorias.index') }}"
                        class="group relative overflow-hidden bg-[#222]"
                    >


                        {{-- IMAGEN --}}

                        <div class="absolute inset-0">

                            <div class="h-full w-full bg-gradient-to-b from-white/5 to-black/90">
                            </div>

                        </div>


                        {{-- OVERLAY --}}

                        <div class="absolute inset-0 bg-black/20 transition duration-500 group-hover:bg-black/50">
                        </div>


                        {{-- CONTENIDO --}}

                        <div class="absolute inset-0 flex flex-col justify-between p-6">


                            <div class="flex justify-between">

                                <span class="text-[10px] font-bold tracking-widest text-white/40">
                                    {{ sprintf('%02d', $loop->iteration) }}
                                </span>

                                <span class="text-[10px] text-white/40">
                                    {{ $categoria->productos_count }}
                                </span>

                            </div>


                            <div>

                                <h3 class="text-3xl font-black uppercase leading-none tracking-tight transition duration-500 group-hover:translate-y-[-8px] sm:text-4xl">

                                    {{ $categoria->nombre }}

                                </h3>


                                @if($categoria->descripcion)

                                    <p class="mt-4 max-h-0 overflow-hidden text-xs leading-5 text-white/60 opacity-0 transition-all duration-500 group-hover:max-h-32 group-hover:opacity-100">

                                        {{ $categoria->descripcion }}

                                    </p>

                                @endif


                                <span class="mt-6 inline-block text-[10px] font-bold uppercase tracking-[0.2em] opacity-0 transition duration-500 group-hover:opacity-100">

                                    Conoce más →

                                </span>

                            </div>

                        </div>

                    </a>

                @empty

                    <div class="col-span-full flex items-center justify-center border border-white/10">

                        <div class="text-center">

                            <h3 class="text-2xl font-bold uppercase">
                                Aún no hay categorías
                            </h3>

                            <p class="mt-3 text-sm text-white/40">
                                Las categorías aparecerán aquí.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

        </div>

    </section>




    {{-- NUESTROS TRABAJOS --}}
    {{-- ========================================================= --}}

    <section id="trabajos" class="bg-black py-24 lg:py-32">


        <div class="mx-auto max-w-7xl px-6 lg:px-10">


            <div class="mb-16 text-center">

                <span class="text-xs font-bold uppercase tracking-[0.3em] text-white/40">
                    Portafolio
                </span>

                <h2 class="mt-5 text-5xl font-black uppercase tracking-tight sm:text-7xl">

                    Nuestros trabajos

                </h2>

            </div>


            {{-- PRODUCTOS --}}

            <div class="grid grid-cols-1 gap-1 sm:grid-cols-2 lg:grid-cols-4">

                @forelse($productos as $producto)

                    <article class="group relative aspect-[3/4] overflow-hidden bg-white">


                        {{-- PLACEHOLDER --}}

                        <div class="absolute inset-0 bg-[#222] transition duration-700 group-hover:scale-105">

                        </div>


                        {{-- OVERLAY --}}

                        <div class="absolute inset-0 bg-black/40 transition group-hover:bg-black/70">
                        </div>


                        {{-- CONTENIDO --}}

                        <div class="absolute inset-0 flex flex-col justify-end p-6 text-white">


                            <span class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/50">

                                {{ $producto->categoria->nombre ?? 'Producto' }}

                            </span>


                            <h3 class="mt-3 text-2xl font-black uppercase leading-none">

                                {{ $producto->nombre }}

                            </h3>


                            @if($producto->descripcion)

                                <p class="mt-3 text-xs leading-5 text-white/50">

                                    {{ $producto->descripcion }}

                                </p>

                            @endif


                            <div class="mt-5 flex items-center justify-between">

                                <strong class="text-lg">

                                    ${{ number_format($producto->precio, 0, ',', '.') }}

                                </strong>


                                <span class="text-[9px] uppercase tracking-wider text-white/40">

                                    Ver proyecto →

                                </span>

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="col-span-full py-20 text-center">

                        <h3 class="text-2xl font-bold uppercase">
                            Próximamente
                        </h3>

                        <p class="mt-3 text-sm text-white/40">
                            Estamos preparando nuestros trabajos.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>



    {{-- EXPERIENCIA --}}
    {{-- ========================================================= --}}

    <section class="relative min-h-[80vh] overflow-hidden">


        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=2200&q=85')] bg-cover bg-center">
        </div>


        <div class="absolute inset-0 bg-black/70"></div>


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

    <section id="historia" class="bg-white py-24 text-black lg:py-32">


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

    {{-- CONTACTO --}}
    {{-- ========================================================= --}}

    <section class="bg-[#111] py-32 lg:py-48">


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
                    class="mt-10 inline-flex rounded-full bg-[#E60012] px-8 py-4 text-xs font-black uppercase tracking-wider text-white transition hover:scale-105"
                >

                    Contáctanos

                </a>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

    <footer class="border-t border-white/10 bg-black py-12">

        <div class="mx-auto flex max-w-7xl flex-col justify-between gap-8 px-6 sm:flex-row sm:items-center lg:px-10">


            <div>

                <span class="text-lg font-black uppercase">
                    Incógnito
                </span>

                <p class="mt-2 text-[10px] uppercase tracking-[0.2em] text-white/30">
                    Group Design And Much
                </p>

            </div>


            <div class="text-[10px] uppercase tracking-widest text-white/30">

                © {{ date('Y') }} Incógnito Group

            </div>

        </div>

    </footer>


</div>

@endsection