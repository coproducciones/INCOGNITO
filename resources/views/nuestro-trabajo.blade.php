@extends('layouts.app')

@section('title', 'Nuestro Trabajo')

@section('content')

<div class="relative isolate min-h-screen overflow-hidden bg-[#07070b] text-white">

    {{-- Fondo futurista con brillos --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
        <div class="absolute -top-40 left-1/2 h-[30rem] w-[50rem] -translate-x-1/2 rounded-full bg-cyan-500/10 blur-[120px]"></div>
        <div class="absolute top-[28rem] -left-40 h-[28rem] w-[28rem] rounded-full bg-violet-600/15 blur-[110px]"></div>
        <div class="absolute right-[-8rem] top-[42rem] h-[26rem] w-[26rem] rounded-full bg-emerald-500/10 blur-[110px]"></div>
        <div class="absolute inset-0 opacity-[0.07] [background-image:linear-gradient(rgba(255,255,255,0.14)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.14)_1px,transparent_1px)] [background-size:44px_44px]"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#07070b]/20 via-[#07070b]/50 to-[#07070b]"></div>
    </div>

    {{-- Imagen de fondo opcional con capa oscura --}}
    <div
        class="pointer-events-none absolute inset-0 -z-10 bg-cover bg-center opacity-15"
        style="background-image: url('/images/fondo-nuestro-trabajo.jpg');"
        aria-hidden="true"
    ></div>

    <div class="relative mx-auto max-w-7xl px-6 py-16 sm:py-20 lg:px-8">

        {{-- Hero --}}
        <header class="mx-auto mb-20 max-w-4xl text-center">
            <span class="mb-6 inline-flex items-center gap-2 rounded-full border border-cyan-300/25 bg-cyan-300/[0.07] px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-cyan-200 shadow-[0_0_30px_rgba(34,211,238,0.08)]">
                <span class="h-2 w-2 rounded-full bg-cyan-300 shadow-[0_0_12px_rgba(103,232,249,0.9)]"></span>
                Incognito Group Design and Much
            </span>

            <h1 class="text-4xl font-black tracking-tight text-white sm:text-5xl lg:text-7xl">
                Nuestro
                <span class="bg-gradient-to-r from-cyan-300 via-violet-300 to-emerald-300 bg-clip-text text-transparent">Trabajo</span>
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-300 sm:text-lg">
                Somos un equipo creativo dedicado a la producción
                <strong class="font-semibold text-white">audiovisual, musical, manufactura y artes visuales.</strong>
            </p>

            <div class="mx-auto mt-8 h-px w-32 bg-gradient-to-r from-transparent via-cyan-300 to-transparent"></div>

            <h2 class="mt-8 text-xl font-semibold text-emerald-300 sm:text-2xl">
                Aquí encontrarás una muestra de lo que hacemos.
            </h2>
        </header>

        {{-- Áreas de trabajo --}}
        <section aria-label="Áreas de trabajo" class="mb-20 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

            {{-- Producción Audiovisual --}}
            <article class="group relative rounded-2xl border border-white/10 bg-white/[0.04] p-7 text-center shadow-[0_12px_45px_rgba(0,0,0,0.2)] backdrop-blur-xl transition duration-300 hover:-translate-y-2 hover:border-cyan-300/40 hover:bg-cyan-300/[0.06] hover:shadow-[0_0_35px_rgba(34,211,238,0.10)]">
                <div class="pointer-events-none absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-cyan-300/70 to-transparent"></div>
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-cyan-300/20 bg-cyan-300/10 text-4xl transition duration-300 group-hover:scale-110 group-hover:shadow-[0_0_25px_rgba(34,211,238,0.18)]">
                    🎬
                </div>
                <h3 class="mb-3 text-lg font-bold text-white">Producción Audiovisual</h3>
                <p class="text-sm leading-7 text-gray-400">
                    Fotografía, video corporativo, cobertura de eventos y edición profesional.
                </p>
            </article>

            {{-- Producción Musical --}}
            <article class="group relative rounded-2xl border border-white/10 bg-white/[0.04] p-7 text-center shadow-[0_12px_45px_rgba(0,0,0,0.2)] backdrop-blur-xl transition duration-300 hover:-translate-y-2 hover:border-violet-300/40 hover:bg-violet-300/[0.06] hover:shadow-[0_0_35px_rgba(167,139,250,0.10)]">
                <div class="pointer-events-none absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-violet-300/70 to-transparent"></div>
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-violet-300/20 bg-violet-300/10 text-4xl transition duration-300 group-hover:scale-110 group-hover:shadow-[0_0_25px_rgba(167,139,250,0.18)]">
                    🎵
                </div>
                <h3 class="mb-3 text-lg font-bold text-white">Producción Musical</h3>
                <p class="text-sm leading-7 text-gray-400">
                    Grabación, mezcla, masterización y producción de contenido sonoro.
                </p>
            </article>

            {{-- Artes Visuales --}}
            <article class="group relative rounded-2xl border border-white/10 bg-white/[0.04] p-7 text-center shadow-[0_12px_45px_rgba(0,0,0,0.2)] backdrop-blur-xl transition duration-300 hover:-translate-y-2 hover:border-emerald-300/40 hover:bg-emerald-300/[0.06] hover:shadow-[0_0_35px_rgba(52,211,153,0.10)]">
                <div class="pointer-events-none absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-emerald-300/70 to-transparent"></div>
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-emerald-300/20 bg-emerald-300/10 text-4xl transition duration-300 group-hover:scale-110 group-hover:shadow-[0_0_25px_rgba(52,211,153,0.18)]">
                    🎨
                </div>
                <h3 class="mb-3 text-lg font-bold text-white">Artes Visuales</h3>
                <p class="text-sm leading-7 text-gray-400">
                    Diseño gráfico, identidad de marca, ilustración y arte digital.
                </p>
            </article>

            {{-- Manufactura --}}
            <article class="group relative rounded-2xl border border-white/10 bg-white/[0.04] p-7 text-center shadow-[0_12px_45px_rgba(0,0,0,0.2)] backdrop-blur-xl transition duration-300 hover:-translate-y-2 hover:border-amber-300/40 hover:bg-amber-300/[0.06] hover:shadow-[0_0_35px_rgba(252,211,77,0.10)]">
                <div class="pointer-events-none absolute inset-x-8 top-0 h-px bg-gradient-to-r from-transparent via-amber-300/70 to-transparent"></div>
                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-amber-300/20 bg-amber-300/10 text-4xl transition duration-300 group-hover:scale-110 group-hover:shadow-[0_0_25px_rgba(252,211,77,0.18)]">
                    🏭
                </div>
                <h3 class="mb-3 text-lg font-bold text-white">Manufactura</h3>
                <p class="text-sm leading-7 text-gray-400">
                    Producción de materiales físicos, merchandising y productos personalizados.
                </p>
            </article>

        </section>

        {{-- Estadísticas --}}
        <section aria-label="Estadísticas" class="mb-20 grid grid-cols-1 gap-6 sm:grid-cols-3">
            <div class="relative overflow-hidden rounded-2xl border border-cyan-300/20 bg-white/[0.04] p-8 text-center backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-cyan-400/10 blur-2xl"></div>
                <p class="relative mb-3 bg-gradient-to-r from-cyan-200 to-blue-300 bg-clip-text text-5xl font-black text-transparent">+120</p>
                <p class="relative text-sm text-gray-300">Proyectos completados</p>
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-violet-300/20 bg-white/[0.04] p-8 text-center backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-violet-400/10 blur-2xl"></div>
                <p class="relative mb-3 bg-gradient-to-r from-violet-200 to-fuchsia-300 bg-clip-text text-5xl font-black text-transparent">+60</p>
                <p class="relative text-sm text-gray-300">Clientes satisfechos</p>
            </div>

            <div class="relative overflow-hidden rounded-2xl border border-emerald-300/20 bg-white/[0.04] p-8 text-center backdrop-blur-xl">
                <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-emerald-400/10 blur-2xl"></div>
                <p class="relative mb-3 bg-gradient-to-r from-emerald-200 to-teal-300 bg-clip-text text-5xl font-black text-transparent">4+</p>
                <p class="relative text-sm text-gray-300">Años de experiencia</p>
            </div>
        </section>

        {{-- CTA --}}
        <section class="relative overflow-hidden rounded-3xl border border-white/10 bg-gradient-to-br from-cyan-400/[0.08] via-white/[0.03] to-violet-400/[0.08] px-6 py-12 text-center shadow-[0_0_60px_rgba(34,211,238,0.05)] sm:px-12">
            <div class="pointer-events-none absolute left-1/2 top-0 h-px w-2/3 -translate-x-1/2 bg-gradient-to-r from-transparent via-cyan-300/70 to-transparent"></div>

            <p class="mb-6 text-lg text-gray-200">
                ¿Tienes un proyecto en mente?
            </p>

            <a
                href="{{ route('login') }}"
                class="inline-flex items-center justify-center rounded-full border border-cyan-200/40 bg-cyan-300/10 px-8 py-3 font-semibold text-cyan-100 shadow-[0_0_25px_rgba(34,211,238,0.12)] transition duration-300 hover:-translate-y-1 hover:border-cyan-200 hover:bg-cyan-300/20 hover:shadow-[0_0_35px_rgba(34,211,238,0.22)] focus:outline-none focus:ring-2 focus:ring-cyan-300 focus:ring-offset-2 focus:ring-offset-[#07070b]"
            >
                Trabaja con nosotros
                <span class="ml-2" aria-hidden="true">↗</span>
            </a>
        </section>

    </div>
</div>

@endsection
