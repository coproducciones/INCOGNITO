@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')

<div class="studio-profile relative isolate min-h-[75vh] overflow-hidden px-4 py-12 text-white sm:px-6 lg:px-10 lg:py-16">

    {{-- ESTILOS DEL PERFIL --}}
    <style>
        .studio-profile {
            --profile-gold: rgba(169, 144, 69, .14);
            --profile-gold-light: rgba(216, 193, 127, .10);
            background:
                radial-gradient(ellipse at 10% 10%, var(--profile-gold), transparent 38%),
                radial-gradient(ellipse at 90% 85%, var(--profile-gold-light), transparent 35%),
                #111111;
        }

        .studio-profile .profile-panel {
            background: linear-gradient(145deg, rgba(29, 29, 29, .98), rgba(17, 17, 17, .99));
            border: 1px solid rgba(255, 255, 255, .08);
            box-shadow: 0 24px 70px rgba(0, 0, 0, .35);
        }

        .studio-profile .profile-field {
            min-width: 0;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 1rem;
            background: rgba(255, 255, 255, .02);
            padding: 1.25rem;
            transition: border-color .3s, background-color .3s;
        }

        .studio-profile .profile-field:hover {
            border-color: rgba(169, 144, 69, .35);
            background: rgba(169, 144, 69, .04);
        }

        .studio-profile .profile-primary {
            background: linear-gradient(110deg, #A99045 0%, #D8C17F 100%);
            box-shadow: 0 0 24px rgba(169, 144, 69, .14);
        }

        .studio-profile .profile-primary:hover {
            box-shadow: 0 0 30px rgba(169, 144, 69, .24);
        }

        .studio-profile .profile-avatar {
            background: linear-gradient(145deg, rgba(169, 144, 69, .18), rgba(216, 193, 127, .10));
            box-shadow: 0 0 32px rgba(169, 144, 69, .08);
        }

        @media (prefers-reduced-motion: reduce) {
            .studio-profile * {
                transition-duration: .01ms !important;
            }
        }
    </style>

    <div class="relative mx-auto w-full max-w-5xl">

        {{-- ENCABEZADO --}}
        <div class="mb-10">

            <a
                href="{{ route('mi-cuenta') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-white/45 transition hover:text-[#D8C17F]"
            >
                <span aria-hidden="true">←</span>
                Volver a mi cuenta
            </a>

            <div class="mt-8 flex items-center gap-3">
                <span class="h-px w-10 bg-gradient-to-r from-[#A99045] to-[#D8C17F]"></span>

                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#D8C17F]">
                    Información personal
                </p>
            </div>

            <h1 class="mt-4 text-4xl font-black uppercase leading-tight tracking-[-0.045em] sm:text-6xl">
                Mi
                <span class="bg-gradient-to-r from-[#A99045] via-[#D8C17F] to-white bg-clip-text text-transparent">
                    perfil
                </span>
            </h1>

            <p class="mt-4 max-w-xl text-sm leading-7 text-white/45">
                Consulta la información asociada a tu cuenta.
            </p>

        </div>

        {{-- TARJETA PRINCIPAL --}}
        <div class="profile-panel relative isolate overflow-hidden rounded-3xl">

            {{-- DETALLES DECORATIVOS --}}
            <div class="pointer-events-none absolute -right-24 -top-24 -z-10 h-72 w-72 rounded-full bg-[#A99045]/[0.08] blur-[90px]"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-24 -z-10 h-72 w-72 rounded-full bg-[#D8C17F]/[0.06] blur-[90px]"></div>

            <div class="relative p-5 sm:p-8 lg:p-10">

                {{-- IDENTIDAD DEL USUARIO --}}
                <div class="flex flex-col gap-6 border-b border-white/[0.08] pb-8 sm:flex-row sm:items-center">

                    <div class="profile-avatar flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-[#A99045]/30 p-1 sm:h-28 sm:w-28">

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($usuario->nombre) }}&background=111111&color=D8C17F&size=160"
                            alt="Avatar de {{ $usuario->nombre }}"
                            class="h-full w-full rounded-xl object-cover"
                        >

                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-3">

                            <span class="rounded-full border border-[#A99045]/30 bg-[#A99045]/10 px-3 py-1.5 text-[9px] font-bold uppercase tracking-[0.2em] text-[#D8C17F]">
                                Perfil
                            </span>

                            <span class="flex items-center gap-2 text-[9px] font-medium uppercase tracking-[0.18em] text-white/35">
                                <span class="h-1.5 w-1.5 rounded-full bg-[#D8C17F]"></span>
                                Información de la cuenta
                            </span>

                        </div>

                        <h2 class="mt-4 break-words text-2xl font-black uppercase tracking-tight text-white sm:text-3xl">
                            {{ $usuario->nombre }}
                        </h2>

                        <p class="mt-2 break-all text-sm text-white/45">
                            {{ $usuario->email }}
                        </p>

                    </div>

                </div>

                {{-- DATOS PERSONALES --}}
                <div class="mt-8">

                    <div class="mb-5 flex items-center gap-3">
                        <span class="h-5 w-1 rounded-full bg-gradient-to-b from-[#A99045] to-[#D8C17F]"></span>

                        <h3 class="text-xs font-black uppercase tracking-[0.2em] text-white/75">
                            Datos personales
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- NOMBRE --}}
                        <div class="profile-field">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/35">
                                Nombre
                            </p>

                            <p class="mt-3 break-words text-sm font-semibold leading-6 text-white">
                                {{ $usuario->nombre }}
                            </p>
                        </div>

                        {{-- CORREO --}}
                        <div class="profile-field">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/35">
                                Correo electrónico
                            </p>

                            <p class="mt-3 break-all text-sm font-semibold leading-6 text-white">
                                {{ $usuario->email }}
                            </p>
                        </div>

                        {{-- TELÉFONO --}}
                        <div class="profile-field">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/35">
                                Teléfono
                            </p>

                            <p class="mt-3 break-words text-sm font-semibold leading-6 text-white">
                                {{ $usuario->telefono ?: 'No registrado' }}
                            </p>
                        </div>

                        {{-- FECHA DE REGISTRO --}}
                        <div class="profile-field">
                            <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-white/35">
                                Miembro desde
                            </p>

                            <p class="mt-3 text-sm font-semibold leading-6 text-white">
                                {{ $usuario->created_at?->format('d/m/Y') ?? 'No disponible' }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- ACCIONES --}}
                <div class="mt-8 flex flex-col-reverse gap-3 border-t border-white/[0.08] pt-6 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('mi-cuenta') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full border border-white/10 bg-white/[0.03] px-6 py-3 text-[10px] font-black uppercase tracking-[0.16em] text-white/65 transition duration-300 hover:border-white/25 hover:bg-white/[0.07] hover:text-white"
                    >
                        <span aria-hidden="true">←</span>
                        Volver
                    </a>

                    <a
                        href="{{ route('mi-cuenta.perfil.edit') }}"
                        class="profile-primary inline-flex items-center justify-center gap-3 rounded-full px-6 py-3 text-[10px] font-black uppercase tracking-[0.16em] text-[#111111] transition duration-300 hover:-translate-y-0.5"
                    >
                        Editar perfil

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 17 17 7M8 7h9v9" />
                        </svg>
                    </a>

                </div>

            </div>

        </div>

        {{-- PIE DECORATIVO --}}
        <div class="mt-6 flex items-center justify-center gap-3">
            <span class="h-px flex-1 bg-gradient-to-r from-transparent to-white/[0.08]"></span>

            <span class="text-[9px] font-medium uppercase tracking-[0.25em] text-white/20">
                Incógnito · Group Design
            </span>

            <span class="h-px flex-1 bg-gradient-to-l from-transparent to-white/[0.08]"></span>
        </div>

    </div>

</div>

@endsection
