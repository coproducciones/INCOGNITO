@extends('layouts.app')

@section('title', 'Nuestra Historia')

@section('content')

<div class="studio-shell relative isolate min-h-screen overflow-x-clip bg-[#151515] text-[#F5F3ED]">

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

        .studio-history-hero {
            background:
                radial-gradient(
                    ellipse at 50% 10%,
                    rgba(169, 144, 69, .12),
                    transparent 45%
                ),
                radial-gradient(
                    ellipse at 5% 90%,
                    rgba(158, 36, 40, .06),
                    transparent 35%
                ),
                #151515;
        }

        .studio-history-card {
            position: relative;
            isolation: isolate;
            min-width: 0;
            overflow: hidden;
            border: 1px solid var(--studio-border);
            border-radius: 1rem;
            background: linear-gradient(
                145deg,
                rgba(245, 243, 237, .045),
                rgba(245, 243, 237, .008)
            );
            transform: translateZ(0);
            transition:
                transform .35s ease,
                border-color .35s ease,
                background .35s ease,
                box-shadow .35s ease;
        }

        .studio-history-card:hover {
            transform: translateY(-5px);
            border-color: rgba(169, 144, 69, .45);
            background: linear-gradient(
                145deg,
                rgba(245, 243, 237, .065),
                rgba(245, 243, 237, .015)
            );
            box-shadow:
                0 15px 45px rgba(0, 0, 0, .22),
                0 0 25px rgba(169, 144, 69, .05);
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

        .studio-shell a:focus-visible,
        .studio-shell button:focus-visible {
            outline: 2px solid var(--studio-gold);
            outline-offset: 4px;
        }

        @media (min-width: 1024px) {
            .studio-history-card {
                border-radius: 1rem;
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

            .studio-history-card:hover {
                transform: none;
            }
        }
    </style>


    {{-- =========================================================
         FONDO DECORATIVO
    ========================================================== --}}

    <div
        aria-hidden="true"
        class="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
    >

        <div class="absolute -top-40 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-[#A99045]/[0.10] blur-[120px]"></div>

        <div class="absolute right-[-8rem] top-[35rem] h-80 w-80 rounded-full bg-[#9E2428]/[0.05] blur-[110px]"></div>

        <div class="absolute bottom-0 left-[-8rem] h-96 w-96 rounded-full bg-[#A99045]/[0.06] blur-[130px]"></div>

        <div class="studio-card-grid absolute inset-0 opacity-[0.025]"></div>

    </div>


    <main class="relative mx-auto max-w-7xl px-5 pb-24 pt-28 sm:px-6 sm:pt-32 lg:px-10 lg:pb-32">

        {{-- =========================================================
             HERO
        ========================================================== --}}

        <section
            id="inicio"
            class="studio-history-hero relative mb-20 overflow-hidden rounded-2xl border border-[#F5F3ED]/[0.08] px-5 py-20 text-center sm:mb-28 sm:px-10 sm:py-28 lg:py-36"
        >

            {{-- LUCES DECORATIVAS --}}

            <div
                aria-hidden="true"
                class="pointer-events-none absolute -left-20 top-10 h-64 w-64 rounded-full bg-[#A99045]/[0.08] blur-[100px]"
            ></div>

            <div
                aria-hidden="true"
                class="pointer-events-none absolute -right-20 bottom-0 h-72 w-72 rounded-full bg-[#9E2428]/[0.06] blur-[100px]"
            ></div>


            {{-- CUADRÍCULA --}}

            <div
                aria-hidden="true"
                class="studio-card-grid pointer-events-none absolute inset-0 opacity-[0.035]"
            ></div>


            <div class="relative z-10">

                <div class="mx-auto mb-8 inline-flex items-center gap-3 rounded-lg border border-[#A99045]/25 bg-[#A99045]/[0.06] px-4 py-2 backdrop-blur-xl">

                    <span class="h-1.5 w-1.5 rounded-full bg-[#A99045]"></span>

                    <span class="text-[9px] font-bold uppercase tracking-[0.25em] text-[#D8C17F] sm:text-[10px]">
                        Incognito Group Design and Much
                    </span>

                </div>


                <h1 class="mx-auto max-w-5xl text-5xl font-black uppercase leading-[0.85] tracking-[-0.075em] text-[#F5F3ED] sm:text-7xl lg:text-8xl">

                    Nuestra

                    <span class="mt-3 block text-[#D8C17F]">
                        Historia<span class="text-[#A99045]">.</span>
                    </span>

                </h1>


                <p class="mx-auto mt-8 max-w-2xl text-md leading-7 text-[#F5F3ED]/55 sm:text-base">
                    Conoce cómo nació Incognito Group Design and Much, quiénes somos y hacia dónde vamos.
                </p>


                <div class="mx-auto mt-10 h-px w-24 bg-gradient-to-r from-transparent via-[#A99045] to-transparent"></div>

            </div>

        </section>


        {{-- =========================================================
             NUESTRO ORIGEN
        ========================================================== --}}

        <section
            id="origen"
            class="mb-20 grid grid-cols-1 items-stretch gap-5 lg:mb-28 lg:grid-cols-2 lg:gap-6"
        >

            {{-- INFORMACIÓN DEL ORIGEN --}}

            <article class="studio-history-card group p-7 sm:p-10 lg:p-12">

                {{-- DETALLES DECORATIVOS --}}

                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute -right-24 -top-24 -z-10 h-64 w-64 rounded-full bg-[#A99045]/[0.09] blur-[90px] transition duration-700 group-hover:bg-[#A99045]/[0.17]"
                ></div>

                <div
                    aria-hidden="true"
                    class="pointer-events-none absolute inset-0 -z-10 bg-gradient-to-br from-[#A99045]/[0.025] via-transparent to-[#9E2428]/[0.025]"
                ></div>


                <div class="relative">

                    <span class="studio-eyebrow mb-7">
                        Nuestro origen
                    </span>


                    <h2 class="mb-7 text-3xl font-black uppercase leading-[0.92] tracking-[-0.045em] text-[#F5F3ED] sm:text-4xl lg:text-5xl">

                        ¿Cómo<br class="hidden sm:block">
                        empezamos<span class="text-[#A99045]">?</span>

                    </h2>


                    <p class="mb-5 text-sm leading-7 text-[#F5F3ED]/65 sm:text-base sm:leading-8">
                        Incognito Group nació en Málaga, Santander, como una idea entre personas apasionadas
                        por el arte, la comunicación y la tecnología. Lo que comenzó como proyectos pequeños
                        para amigos y conocidos, fue creciendo hasta convertirse en una agencia creativa
                        con presencia regional.
                    </p>


                    <p class="text-sm leading-7 text-[#F5F3ED]/50 sm:text-base sm:leading-8">
                        Desde el inicio, nuestra filosofía fue clara: calidad sin pretextos, creatividad sin límites
                        y compromiso con cada cliente, sin importar el tamaño del proyecto.
                    </p>


                    <div class="mt-9 h-px w-full bg-gradient-to-r from-[#A99045]/50 via-[#F5F3ED]/10 to-transparent"></div>

                </div>

            </article>


            {{-- FILOSOFÍA --}}

            <article class="studio-history-card group flex min-h-[350px] items-center justify-center bg-[#1D1D1D] p-8 text-center shadow-[inset_0_0_80px_rgba(169,144,69,.025)] sm:min-h-[420px] sm:p-12">

                {{-- FONDO DECORATIVO --}}

                <div
                    aria-hidden="true"
                    class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(169,144,69,.12),transparent_58%)]"
                ></div>

                <div
                    aria-hidden="true"
                    class="studio-card-grid absolute inset-0 -z-10 opacity-[0.04]"
                ></div>

                <div
                    aria-hidden="true"
                    class="absolute inset-5 rounded-xl border border-[#F5F3ED]/[0.06]"
                ></div>

                <div
                    aria-hidden="true"
                    class="absolute left-8 top-8 h-8 w-8 border-l border-t border-[#A99045]/60"
                ></div>

                <div
                    aria-hidden="true"
                    class="absolute bottom-8 right-8 h-8 w-8 border-b border-r border-[#A99045]/60"
                ></div>


                <div class="relative z-10">

                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#A99045]/[0.07] text-5xl shadow-[0_0_45px_rgba(169,144,69,.08)] transition duration-500 group-hover:scale-105 group-hover:border-[#A99045]/50 group-hover:shadow-[0_0_65px_rgba(169,144,69,.15)] sm:h-28 sm:w-28 sm:text-6xl">
                        🎯
                    </div>


                    <p class="mx-auto mt-8 max-w-xs text-sm font-medium italic leading-7 text-[#F5F3ED]/65 sm:text-base">
                        "Crear con propósito, comunicar con impacto."
                    </p>


                    <span class="mt-5 block text-[9px] font-bold uppercase tracking-[0.3em] text-[#D8C17F]/80">
                        Nuestra filosofía
                    </span>

                </div>

            </article>

        </section>


        {{-- =========================================================
             MISIÓN Y VISIÓN
        ========================================================== --}}

        <section id="mision-vision" class="studio-section-dark mb-20 rounded-2xl px-5 py-16 sm:px-8 sm:py-20 lg:mb-28 lg:px-12 lg:py-24">

            {{-- ENCABEZADO --}}

            <div class="mb-10 grid grid-cols-1 items-end gap-5 sm:mb-12 lg:grid-cols-2 lg:gap-10">

                <div>

                    <span class="studio-eyebrow">
                        Lo que nos mueve
                    </span>

                    <h2 class="studio-section-title mt-6 text-[#F5F3ED]">
                        Misión y<br class="hidden sm:block">
                        visión<span class="text-[#A99045]">.</span>
                    </h2>

                </div>


                <p class="max-w-md text-sm leading-7 text-[#F5F3ED]/45 sm:text-base sm:leading-8 lg:justify-self-end">
                    Ideas con propósito. Creatividad orientada al futuro.
                </p>

            </div>


            {{-- TARJETAS --}}

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- MISIÓN --}}

                <article class="studio-history-card group p-7 sm:p-9">

                    <div
                        aria-hidden="true"
                        class="absolute -right-12 -top-12 -z-10 h-44 w-44 rounded-full bg-[#A99045]/[0.09] blur-[65px] transition duration-700 group-hover:bg-[#A99045]/[0.18]"
                    ></div>

                    <div
                        aria-hidden="true"
                        class="absolute inset-0 -z-10 bg-gradient-to-br from-[#A99045]/[0.04] via-transparent to-transparent"
                    ></div>


                    <div class="relative">

                        <div class="mb-7 flex h-14 w-14 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#A99045]/[0.08] text-3xl shadow-[0_0_30px_rgba(169,144,69,.06)] transition duration-300 group-hover:border-[#A99045]/50">
                            🧭
                        </div>


                        <h3 class="mb-5 text-xl font-black uppercase tracking-wide text-[#F5F3ED] transition-colors group-hover:text-[#D8C17F] sm:text-2xl">
                            Nuestra Misión
                        </h3>


                        <p class="text-sm leading-7 text-[#F5F3ED]/60 sm:text-base sm:leading-8">
                            Brindar soluciones creativas integrales que conecten a las marcas con sus audiencias
                            a través de producción audiovisual, musical, diseño y manufactura, con altos estándares
                            de calidad y compromiso humano.
                        </p>


                        <div class="mt-8 h-px w-full bg-gradient-to-r from-[#A99045]/50 via-[#F5F3ED]/10 to-transparent"></div>

                    </div>

                </article>


                {{-- VISIÓN --}}

                <article class="studio-history-card group border-[#A99045]/15 bg-gradient-to-br from-[#A99045]/[0.08] via-[#1D1D1D] to-[#9E2428]/[0.025] p-7 sm:p-9">

                    <div
                        aria-hidden="true"
                        class="absolute -right-12 -top-12 -z-10 h-44 w-44 rounded-full bg-[#A99045]/[0.12] blur-[65px] transition duration-700 group-hover:bg-[#A99045]/[0.22]"
                    ></div>

                    <div
                        aria-hidden="true"
                        class="absolute inset-0 -z-10 bg-gradient-to-br from-[#A99045]/[0.035] via-transparent to-[#9E2428]/[0.025]"
                    ></div>


                    <div class="relative">

                        <div class="mb-7 flex h-14 w-14 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#A99045]/[0.08] text-3xl shadow-[0_0_30px_rgba(169,144,69,.07)] transition duration-300 group-hover:border-[#A99045]/50">
                            🚀
                        </div>


                        <h3 class="mb-5 text-xl font-black uppercase tracking-wide text-[#F5F3ED] transition-colors group-hover:text-[#D8C17F] sm:text-2xl">
                            Nuestra Visión
                        </h3>


                        <p class="text-sm leading-7 text-[#F5F3ED]/65 sm:text-base sm:leading-8">
                            Ser la agencia creativa de referencia en la región de García Rovira y Santander,
                            expandiendo nuestro impacto a nivel nacional con una plataforma digital que conecte
                            talento creativo con quienes lo necesitan.
                        </p>


                        <div class="mt-8 h-px w-full bg-gradient-to-r from-[#A99045]/60 via-[#F5F3ED]/10 to-transparent"></div>

                    </div>

                </article>

            </div>

        </section>


        {{-- =========================================================
             LÍNEA DE TIEMPO
        ========================================================== --}}

        <section
            id="trayectoria"
            class="studio-section-black relative mb-8 overflow-hidden rounded-2xl border border-[#F5F3ED]/[0.08] px-5 py-16 sm:px-10 sm:py-20 lg:px-16 lg:py-24"
        >

            {{-- FONDO DECORATIVO --}}

            <div
                aria-hidden="true"
                class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#A99045]/[0.08] blur-[100px]"
            ></div>

            <div
                aria-hidden="true"
                class="pointer-events-none absolute -bottom-24 -left-20 h-72 w-72 rounded-full bg-[#9E2428]/[0.06] blur-[100px]"
            ></div>

            <div
                aria-hidden="true"
                class="studio-card-grid absolute inset-0 opacity-[0.025]"
            ></div>


            <div class="relative z-10">

                {{-- ENCABEZADO --}}

                <div class="mb-12 text-center sm:mb-16">

                    <span class="studio-eyebrow">
                        Nuestra evolución
                    </span>


                    <h2 class="mt-6 text-3xl font-black uppercase tracking-[-0.05em] text-[#F5F3ED] sm:text-5xl lg:text-6xl">

                        Nuestro camino<span class="text-[#A99045]">.</span>

                    </h2>


                    <div class="mx-auto mt-6 h-px w-20 bg-gradient-to-r from-transparent via-[#A99045] to-transparent"></div>

                </div>


                {{-- HISTORIA CRONOLÓGICA --}}

                <div class="relative mx-auto max-w-3xl">

                    {{-- LÍNEA VERTICAL --}}

                    <div
                        aria-hidden="true"
                        class="absolute bottom-0 left-[7px] top-2 w-px bg-gradient-to-b from-[#A99045] via-[#D8C17F]/60 to-transparent"
                    ></div>


                    {{-- PRIMER PROYECTO --}}

                    <article class="group relative pb-4 pl-10 sm:pl-14">

                        <span class="absolute left-0 top-1 flex h-4 w-4 items-center justify-center rounded-full border border-[#D8C17F] bg-[#151515] shadow-[0_0_18px_rgba(169,144,69,.4)]">

                            <span class="h-1.5 w-1.5 rounded-full bg-[#A99045]"></span>

                        </span>


                        <div class="studio-history-card p-6 transition duration-500 group-hover:border-[#A99045]/40 sm:p-8">

                            <div
                                aria-hidden="true"
                                class="absolute -right-12 -top-12 -z-10 h-36 w-36 rounded-full bg-[#A99045]/[0.05] blur-[60px] transition duration-500 group-hover:bg-[#A99045]/[0.12]"
                            ></div>


                            <p class="mb-3 text-xs font-black tracking-[0.25em] text-[#D8C17F]">
                                2020
                            </p>


                            <h3 class="mb-4 text-xl font-black uppercase tracking-tight text-[#F5F3ED] transition-colors group-hover:text-[#D8C17F] sm:text-2xl">
                                Los primeros proyectos
                            </h3>


                            <p class="text-sm leading-7 text-[#F5F3ED]/55 sm:text-base">
                                Fundados Por Cesar Ortiz Design
                            </p>


                            <div class="mt-6 h-px w-full bg-gradient-to-r from-[#A99045]/35 via-[#F5F3ED]/[0.08] to-transparent"></div>

                        </div>

                    </article>

                </div>

            </div>

        </section>

    </main>

</div>

@endsection
