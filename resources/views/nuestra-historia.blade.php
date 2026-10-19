@extends('layouts.app')

@section('title', 'Nuestra Historia')

@section('content')

<div class="relative isolate min-h-screen overflow-hidden bg-[#07070b] text-white">

    {{-- FONDO DECORATIVO GLOW --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -top-40 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute right-[-8rem] top-[35rem] h-80 w-80 rounded-full bg-violet-600/10 blur-[110px]"></div>
        <div class="absolute bottom-0 left-[-8rem] h-96 w-96 rounded-full bg-emerald-400/10 blur-[130px]"></div>
        <div class="absolute inset-0 opacity-[0.035] [background-image:linear-gradient(rgba(255,255,255,.7)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.7)_1px,transparent_1px)] [background-size:54px_54px]"></div>
    </div>

    <main class="mx-auto max-w-7xl px-6 pb-24 pt-32 sm:pt-36 lg:px-10 lg:pb-32">

        {{-- HERO --}}
        <section class="relative mb-20 text-center sm:mb-28">
            <div class="mx-auto mb-7 inline-flex items-center gap-3 rounded-full border border-cyan-300/20 bg-cyan-300/[0.06] px-4 py-2 backdrop-blur-xl">
                <span class="h-2 w-2 animate-pulse rounded-full bg-cyan-300 shadow-[0_0_14px_rgba(103,232,249,0.9)]"></span>
                <span class="text-[10px] font-bold uppercase tracking-[0.28em] text-cyan-100/80">Incognito Group Design and Much</span>
            </div>

            <h1 class="mx-auto max-w-5xl text-5xl font-black uppercase leading-[0.9] tracking-[-0.065em] sm:text-7xl lg:text-8xl">
                Nuestra
                <span class="mt-2 block bg-gradient-to-r from-white via-cyan-100 to-violet-300 bg-clip-text text-transparent">Historia<span class="text-cyan-300">.</span></span>
            </h1>

            <p class="mx-auto mt-8 max-w-2xl text-sm leading-7 text-white/55 sm:text-base sm:leading-8">
                Conoce cómo nació Incognito Group Design and Much, quiénes somos y hacia dónde vamos.
            </p>

            <div class="mx-auto mt-10 h-px w-32 bg-gradient-to-r from-transparent via-cyan-300 to-transparent shadow-[0_0_18px_rgba(103,232,249,0.65)]"></div>
        </section>

        {{-- ORIGEN --}}
        <section class="mb-20 grid grid-cols-1 items-stretch gap-6 lg:mb-28 lg:grid-cols-2 lg:gap-8">
            <div class="group relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.035] p-7 backdrop-blur-xl transition duration-500 hover:border-cyan-300/25 hover:bg-white/[0.05] sm:p-10 lg:p-12">
                <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-cyan-400/10 blur-[80px] transition duration-500 group-hover:bg-cyan-400/20"></div>

                <div class="relative">
                    <span class="mb-6 inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.28em] text-cyan-300">
                        <span class="h-px w-7 bg-cyan-300"></span>
                        Nuestro origen
                    </span>

                    <h2 class="mb-7 text-3xl font-black uppercase leading-[0.95] tracking-tight sm:text-4xl">
                        ¿Cómo<br class="hidden sm:block"> empezamos<span class="text-cyan-300">?</span>
                    </h2>

                    <p class="mb-5 text-sm leading-7 text-white/65 sm:text-base sm:leading-8">
                        Incognito Group nació en Málaga, Santander, como una idea entre personas apasionadas
                        por el arte, la comunicación y la tecnología. Lo que comenzó como proyectos pequeños
                        para amigos y conocidos, fue creciendo hasta convertirse en una agencia creativa
                        con presencia regional.
                    </p>

                    <p class="text-sm leading-7 text-white/50 sm:text-base sm:leading-8">
                        Desde el inicio, nuestra filosofía fue clara: calidad sin pretextos, creatividad sin límites
                        y compromiso con cada cliente, sin importar el tamaño del proyecto.
                    </p>
                </div>
            </div>

            <div class="group relative flex min-h-[320px] items-center justify-center overflow-hidden rounded-[2rem] border border-cyan-300/20 bg-[#0d1118] p-8 text-center shadow-[inset_0_0_80px_rgba(34,211,238,0.035)] sm:min-h-[420px] sm:p-12">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(34,211,238,0.12),transparent_58%)]"></div>
                <div class="absolute inset-5 rounded-[1.5rem] border border-white/[0.06]"></div>
                <div class="absolute left-8 top-8 h-8 w-8 border-l border-t border-cyan-300/60"></div>
                <div class="absolute bottom-8 right-8 h-8 w-8 border-b border-r border-violet-300/60"></div>

                <div class="relative">
                    <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-[2rem] border border-cyan-200/30 bg-cyan-300/[0.07] text-6xl shadow-[0_0_55px_rgba(34,211,238,0.15)] transition duration-500 group-hover:scale-105 group-hover:shadow-[0_0_75px_rgba(34,211,238,0.25)]">
                        🎯
                    </div>
                    <p class="mx-auto mt-8 max-w-xs text-sm font-medium italic leading-7 text-white/65 sm:text-base">
                        "Crear con propósito, comunicar con impacto."
                    </p>
                    <span class="mt-5 block text-[9px] font-bold uppercase tracking-[0.35em] text-cyan-300/70">Nuestra filosofía</span>
                </div>
            </div>
        </section>

        {{-- MISIÓN Y VISIÓN --}}
        <section class="mb-20 lg:mb-28">
            <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-violet-300">Lo que nos mueve</span>
                    <h2 class="mt-3 text-3xl font-black uppercase tracking-tight sm:text-5xl">Misión y visión<span class="text-cyan-300">.</span></h2>
                </div>
                <p class="max-w-md text-sm leading-6 text-white/45">Ideas con propósito. Creatividad orientada al futuro.</p>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <article class="group relative overflow-hidden rounded-[1.75rem] border border-white/10 bg-gradient-to-br from-white/[0.07] to-white/[0.015] p-7 transition duration-500 hover:-translate-y-1 hover:border-cyan-300/35 sm:p-9">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-cyan-400/10 blur-[60px] transition group-hover:bg-cyan-400/20"></div>
                    <div class="relative">
                        <div class="mb-7 flex h-14 w-14 items-center justify-center rounded-2xl border border-cyan-300/25 bg-cyan-300/10 text-3xl shadow-[0_0_30px_rgba(34,211,238,0.08)]">🧭</div>
                        <h3 class="mb-4 text-xl font-black uppercase tracking-wide sm:text-2xl">Nuestra Misión</h3>
                        <p class="text-sm leading-7 text-white/60 sm:text-base sm:leading-8">
                            Brindar soluciones creativas integrales que conecten a las marcas con sus audiencias
                            a través de producción audiovisual, musical, diseño y manufactura, con altos estándares
                            de calidad y compromiso humano.
                        </p>
                        <div class="mt-8 h-px w-full bg-gradient-to-r from-cyan-300/50 via-white/10 to-transparent"></div>
                    </div>
                </article>

                <article class="group relative overflow-hidden rounded-[1.75rem] border border-violet-300/20 bg-gradient-to-br from-violet-500/[0.13] via-[#11101b] to-cyan-400/[0.04] p-7 transition duration-500 hover:-translate-y-1 hover:border-violet-300/40 sm:p-9">
                    <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-violet-500/15 blur-[60px] transition group-hover:bg-violet-500/25"></div>
                    <div class="relative">
                        <div class="mb-7 flex h-14 w-14 items-center justify-center rounded-2xl border border-violet-300/30 bg-violet-300/10 text-3xl shadow-[0_0_30px_rgba(167,139,250,0.1)]">🚀</div>
                        <h3 class="mb-4 text-xl font-black uppercase tracking-wide sm:text-2xl">Nuestra Visión</h3>
                        <p class="text-sm leading-7 text-white/65 sm:text-base sm:leading-8">
                            Ser la agencia creativa de referencia en la región de García Rovira y Santander,
                            expandiendo nuestro impacto a nivel nacional con una plataforma digital que conecte
                            talento creativo con quienes lo necesitan.
                        </p>
                        <div class="mt-8 h-px w-full bg-gradient-to-r from-violet-300/60 via-white/10 to-transparent"></div>
                    </div>
                </article>
            </div>
        </section>

        {{-- LÍNEA DE TIEMPO --}}
        <section class="mb-8">
            <div class="mb-12 text-center">
                <span class="text-[10px] font-bold uppercase tracking-[0.3em] text-cyan-300">Nuestra evolución</span>
                <h2 class="mt-4 text-3xl font-black uppercase tracking-tight sm:text-5xl">Nuestro camino<span class="text-cyan-300">.</span></h2>
            </div>

            <div class="relative mx-auto max-w-3xl">
                <div class="absolute bottom-0 left-[7px] top-2 w-px bg-gradient-to-b from-cyan-300 via-violet-400/60 to-transparent shadow-[0_0_12px_rgba(103,232,249,0.35)]"></div>

                <article class="group relative pb-4 pl-10 sm:pl-14">
                    <span class="absolute left-0 top-1 flex h-4 w-4 items-center justify-center rounded-full border border-cyan-200 bg-[#07070b] shadow-[0_0_18px_rgba(103,232,249,0.8)]">
                        <span class="h-1.5 w-1.5 rounded-full bg-cyan-300"></span>
                    </span>

                    <div class="rounded-2xl border border-white/10 bg-white/[0.035] p-6 transition duration-500 group-hover:border-cyan-300/25 group-hover:bg-white/[0.05] sm:p-8">
                        <p class="mb-3 text-xs font-black tracking-[0.25em] text-cyan-300">2020</p>
                        <h3 class="mb-3 text-xl font-black uppercase tracking-tight text-white sm:text-2xl">Los primeros proyectos</h3>
                        <p class="text-sm leading-7 text-white/55">Fundados Por Cesar Ortiz Design</p>
                    </div>
                </article>
            </div>
        </section>

    </main>
</div>

@endsection
