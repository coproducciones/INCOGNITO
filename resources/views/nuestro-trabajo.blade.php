@extends('layouts.app')

@section('title', 'Nuestro Trabajo')

@section('content')

<style>
    .studio-work {
        --studio-bg: #151515;
        --studio-panel: #1D1D1D;
        --studio-gold: #A99045;
        --studio-gold-light: #D8C17F;
        --studio-cream: #F5F3ED;
        --studio-red: #9E2428;

        background-color: var(--studio-bg);
        color: var(--studio-cream);
        isolation: isolate;
    }

    .studio-work .studio-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        border: 1px solid rgba(169, 144, 69, 0.4);
        background: rgba(169, 144, 69, 0.08);
        color: var(--studio-gold-light);
        padding: 0.65rem 1rem;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
    }

    .studio-work .studio-eyebrow-dot {
        width: 0.45rem;
        height: 0.45rem;
        flex-shrink: 0;
        border-radius: 50%;
        background: var(--studio-gold-light);
        box-shadow: 0 0 12px rgba(216, 193, 127, 0.65);
    }

    .studio-work .studio-heading {
        color: var(--studio-cream);
        font-weight: 900;
        line-height: 1.05;
        letter-spacing: -0.045em;
        text-transform: uppercase;
    }

    .studio-work .studio-heading-accent {
        color: var(--studio-gold-light);
    }

    .studio-work .studio-section-label {
        color: var(--studio-gold-light);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.22em;
        text-transform: uppercase;
    }

    .studio-work .studio-divider {
        height: 1px;
        width: 8rem;
        margin-left: auto;
        margin-right: auto;
        background: linear-gradient(
            90deg,
            transparent,
            var(--studio-gold),
            transparent
        );
    }

    .studio-work .studio-work-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(169, 144, 69, 0.22);
        border-radius: 1.25rem;
        background: linear-gradient(
            145deg,
            rgba(255, 255, 255, 0.045),
            rgba(255, 255, 255, 0.012)
        );
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.22);
        transition:
            transform 300ms ease,
            border-color 300ms ease,
            background-color 300ms ease,
            box-shadow 300ms ease;
    }

    .studio-work .studio-work-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 12%;
        right: 12%;
        height: 1px;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(216, 193, 127, 0.85),
            transparent
        );
    }

    .studio-work .studio-work-card:hover {
        transform: translateY(-7px);
        border-color: rgba(216, 193, 127, 0.65);
        background: linear-gradient(
            145deg,
            rgba(169, 144, 69, 0.11),
            rgba(255, 255, 255, 0.025)
        );
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.35);
    }

    .studio-work .studio-work-icon {
        display: flex;
        width: 4rem;
        height: 4rem;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        border: 1px solid rgba(169, 144, 69, 0.35);
        border-radius: 1rem;
        background: rgba(169, 144, 69, 0.1);
        font-size: 2rem;
        transition:
            transform 300ms ease,
            box-shadow 300ms ease,
            border-color 300ms ease;
    }

    .studio-work .studio-work-card:hover .studio-work-icon {
        transform: scale(1.08);
        border-color: rgba(216, 193, 127, 0.7);
        box-shadow: 0 0 24px rgba(169, 144, 69, 0.17);
    }

    .studio-work .studio-stat-card {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(169, 144, 69, 0.28);
        border-radius: 1.25rem;
        background: var(--studio-panel);
        padding: 2rem;
        text-align: center;
        transition:
            transform 300ms ease,
            border-color 300ms ease;
    }

    .studio-work .studio-stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(216, 193, 127, 0.7);
    }

    .studio-work .studio-stat-number {
        position: relative;
        margin-bottom: 0.75rem;
        color: var(--studio-gold-light);
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 900;
        line-height: 1;
        letter-spacing: -0.04em;
    }

    .studio-work .studio-cta {
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(169, 144, 69, 0.38);
        border-radius: 1.75rem;
        background:
            radial-gradient(
                ellipse at top right,
                rgba(169, 144, 69, 0.14),
                transparent 50%
            ),
            radial-gradient(
                ellipse at bottom left,
                rgba(158, 36, 40, 0.09),
                transparent 45%
            ),
            #1D1D1D;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.24);
    }

    .studio-work .studio-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: 1px solid rgba(216, 193, 127, 0.65);
        border-radius: 9999px;
        background: var(--studio-gold);
        padding: 0.9rem 2rem;
        color: #151515;
        font-size: 0.875rem;
        font-weight: 800;
        transition:
            transform 300ms ease,
            background-color 300ms ease,
            box-shadow 300ms ease;
    }

    .studio-work .studio-primary:hover {
        transform: translateY(-3px);
        background: var(--studio-gold-light);
        box-shadow: 0 8px 28px rgba(169, 144, 69, 0.22);
    }

    .studio-work a:focus-visible {
        outline: 2px solid var(--studio-gold-light);
        outline-offset: 4px;
    }

    @media (prefers-reduced-motion: reduce) {
        .studio-work *,
        .studio-work *::before,
        .studio-work *::after {
            scroll-behavior: auto !important;
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="studio-work relative min-h-screen overflow-hidden">

    {{-- Fondo premium con brillos dorados y textura sutil --}}
    <div
        class="pointer-events-none absolute inset-0 -z-10 overflow-hidden"
        aria-hidden="true"
    >
        <div class="absolute -top-40 left-1/2 h-[30rem] w-[50rem] -translate-x-1/2 rounded-full bg-[#A99045]/10 blur-[120px]"></div>

        <div class="absolute top-[28rem] -left-40 h-[28rem] w-[28rem] rounded-full bg-[#A99045]/10 blur-[110px]"></div>

        <div class="absolute right-[-8rem] top-[42rem] h-[26rem] w-[26rem] rounded-full bg-[#9E2428]/10 blur-[110px]"></div>

        <div class="absolute inset-0 opacity-[0.045] [background-image:linear-gradient(rgba(216,193,127,0.5)_1px,transparent_1px),linear-gradient(90deg,rgba(216,193,127,0.5)_1px,transparent_1px)] [background-size:44px_44px]"></div>

        <div class="absolute inset-0 bg-gradient-to-b from-[#151515]/20 via-[#151515]/55 to-[#151515]"></div>
    </div>

    {{-- Imagen de fondo con capa oscura --}}
    <div
        class="pointer-events-none absolute inset-0 -z-10 bg-cover bg-center opacity-[0.12]"
        style="background-image: url('/images/fondo-nuestro-trabajo.jpg');"
        aria-hidden="true"
    ></div>

    <div class="relative mx-auto max-w-7xl px-6 py-16 sm:py-20 lg:px-8">

        {{-- Hero --}}
        <header class="mx-auto mb-20 max-w-4xl text-center">

            <span class="studio-eyebrow mb-6">
                <span class="studio-eyebrow-dot"></span>
                Incognito Group Design and Much
            </span>

            <h1 class="studio-heading mt-7 text-4xl sm:text-5xl lg:text-7xl">
                Nuestro
                <span class="studio-heading-accent">Trabajo</span>
            </h1>

            <p class="mx-auto mt-6 max-w-2xl text-base leading-8 text-gray-300 sm:text-lg">
                Somos un equipo creativo dedicado a la producción
                <strong class="font-semibold text-[#D8C17F]">
                    audiovisual, musical, manufactura y artes visuales.
                </strong>
            </p>

            <div class="studio-divider mt-8"></div>

            <h2 class="mt-8 text-xl font-semibold text-[#D8C17F] sm:text-2xl">
                Aquí encontrarás una muestra de lo que hacemos.
            </h2>

        </header>

        {{-- Áreas de trabajo --}}
        <section
            aria-label="Áreas de trabajo"
            class="mb-20 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4"
        >

            {{-- Producción Audiovisual --}}
            <article class="studio-work-card group p-7 text-center">

                <div class="studio-work-icon">
                    🎬
                </div>

                <p class="studio-section-label mb-3">01 / Producción</p>

                <h3 class="mb-3 text-lg font-bold text-[#F5F3ED]">
                    Producción Audiovisual
                </h3>

                <p class="text-sm leading-7 text-gray-400">
                    Fotografía, video corporativo, cobertura de eventos y edición profesional.
                </p>

            </article>

            {{-- Producción Musical --}}
            <article class="studio-work-card group p-7 text-center">

                <div class="studio-work-icon">
                    🎵
                </div>

                <p class="studio-section-label mb-3">02 / Sonido</p>

                <h3 class="mb-3 text-lg font-bold text-[#F5F3ED]">
                    Producción Musical
                </h3>

                <p class="text-sm leading-7 text-gray-400">
                    Grabación, mezcla, masterización y producción de contenido sonoro.
                </p>

            </article>

            {{-- Artes Visuales --}}
            <article class="studio-work-card group p-7 text-center">

                <div class="studio-work-icon">
                    🎨
                </div>

                <p class="studio-section-label mb-3">03 / Diseño</p>

                <h3 class="mb-3 text-lg font-bold text-[#F5F3ED]">
                    Artes Visuales
                </h3>

                <p class="text-sm leading-7 text-gray-400">
                    Diseño gráfico, identidad de marca, ilustración y arte digital.
                </p>

            </article>

            {{-- Manufactura --}}
            <article class="studio-work-card group p-7 text-center">

                <div class="studio-work-icon">
                    🏭
                </div>

                <p class="studio-section-label mb-3">04 / Producción física</p>

                <h3 class="mb-3 text-lg font-bold text-[#F5F3ED]">
                    Manufactura
                </h3>

                <p class="text-sm leading-7 text-gray-400">
                    Producción de materiales físicos, merchandising y productos personalizados.
                </p>

            </article>

        </section>

        {{-- Estadísticas --}}
        <section
            aria-label="Estadísticas"
            class="mb-20 grid grid-cols-1 gap-6 sm:grid-cols-3"
        >

            <div class="studio-stat-card">
                <div class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#A99045]/10 blur-2xl"></div>

                <p class="studio-stat-number">+120</p>

                <p class="relative text-sm text-gray-300">
                    Proyectos completados
                </p>
            </div>

            <div class="studio-stat-card">
                <div class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#A99045]/10 blur-2xl"></div>

                <p class="studio-stat-number">+60</p>

                <p class="relative text-sm text-gray-300">
                    Clientes satisfechos
                </p>
            </div>

            <div class="studio-stat-card">
                <div class="pointer-events-none absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#9E2428]/10 blur-2xl"></div>

                <p class="studio-stat-number">4+</p>

                <p class="relative text-sm text-gray-300">
                    Años de experiencia
                </p>
            </div>

        </section>

        {{-- CTA --}}
        <section class="studio-cta px-6 py-12 text-center sm:px-12">

            <div class="pointer-events-none absolute left-1/2 top-0 h-px w-2/3 -translate-x-1/2 bg-gradient-to-r from-transparent via-[#D8C17F]/80 to-transparent"></div>

            <p class="studio-section-label mb-4">
                Hagamos algo extraordinario
            </p>

            <h2 class="studio-heading text-2xl sm:text-3xl">
                ¿Tienes un proyecto en mente?
            </h2>

            <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-gray-400">
                Convirtamos tus ideas en proyectos creativos con identidad, calidad e impacto.
            </p>


<a
    href="https://wa.me/573114531914?text=Hola%2C%20Incognito%20Group%20Design.%20Estoy%20interesado%20en%20trabajar%20con%20ustedes%20y%20quiero%20consultar%20sobre%20sus%20servicios."
    target="_blank"
    rel="noopener noreferrer"
    class="studio-primary mt-8 focus:outline-none focus:ring-2 focus:ring-[#D8C17F] focus:ring-offset-2 focus:ring-offset-[#151515]"
>
    Trabaja con nosotros
    <span aria-hidden="true">↗</span>
</a>


        </section>

    </div>
</div>

@endsection
