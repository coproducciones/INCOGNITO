@extends('layouts.app')

@section('title', 'Crear cuenta | Incógnito')

@section('content')

<div class="register-page relative isolate min-h-screen overflow-hidden bg-[#111111] px-4 py-16 text-[#F5F3ED] sm:px-6 lg:py-24">

    {{-- Fondo decorativo --}}
    <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
        <div class="absolute -left-40 top-10 h-96 w-96 rounded-full bg-[#A99045]/10 blur-[120px]"></div>
        <div class="absolute -right-40 top-1/3 h-96 w-96 rounded-full bg-[#D8C17F]/10 blur-[120px]"></div>
        <div class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-[#A99045]/[0.07] blur-[120px]"></div>

        <div
            class="absolute inset-0 opacity-[0.035]"
            style="background-image: linear-gradient(rgba(216,193,127,.5) 1px, transparent 1px), linear-gradient(90deg, rgba(216,193,127,.5) 1px, transparent 1px); background-size: 40px 40px;">
        </div>
    </div>

    <div class="relative mx-auto max-w-3xl">

        {{-- Encabezado --}}
        <div class="mb-10 text-center">

            <div class="mx-auto mb-6 flex h-14 w-14 items-center justify-center rounded-2xl border border-[#A99045]/40 bg-gradient-to-br from-[#D8C17F]/15 to-[#A99045]/10 text-2xl font-black text-[#D8C17F] shadow-[0_0_30px_rgba(169,144,69,0.12)]">
                R
            </div>

            <p class="text-[10px] font-bold uppercase tracking-[0.35em] text-[#D8C17F] sm:text-xs">
                Incógnito · Company
            </p>

            <h1 class="mt-4 text-4xl font-black uppercase tracking-[-0.05em] text-[#F5F3ED] sm:text-5xl">
                Crea tu cuenta
            </h1>

            <div class="mx-auto mt-5 h-px w-20 bg-gradient-to-r from-transparent via-[#A99045] to-[#D8C17F]"></div>

            <p class="mx-auto mt-5 max-w-md text-sm leading-7 text-white/50">
                Elige el tipo de cuenta que mejor se adapte a ti.
            </p>

        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div role="status" class="mb-6 flex gap-3 rounded-2xl border border-emerald-400/25 bg-emerald-400/[0.07] p-4 text-sm text-emerald-200">
                <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                </svg>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div role="alert" class="mb-6 rounded-2xl border border-rose-400/25 bg-rose-500/[0.07] p-5 text-sm text-rose-200">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                    </svg>
                    <p class="font-bold uppercase tracking-wider">Revisa estos datos</p>
                </div>

                <ul class="mt-3 list-inside list-disc space-y-1 text-rose-200/80">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <form
            method="POST"
            action="{{ route('registro.store') }}"
            class="register-form relative overflow-hidden rounded-3xl border border-white/[0.08] bg-[#1D1D1D]/95 p-5 shadow-[0_25px_100px_rgba(0,0,0,0.45)] backdrop-blur-2xl sm:p-8 lg:p-10"
        >
            @csrf

            {{-- Línea decorativa --}}
            <div class="absolute left-0 top-0 h-[2px] w-full bg-gradient-to-r from-[#A99045] via-[#D8C17F] to-[#A99045]"></div>

            {{-- Tipo de cuenta --}}
            <div class="mb-8">
                <label for="tipo_cuenta" class="mb-3 block text-sm font-bold text-[#F5F3ED]">
                    Tipo de cuenta <span class="text-rose-400">*</span>
                </label>

                <div class="relative">
                    <select
                        id="tipo_cuenta"
                        name="tipo_cuenta"
                        required
                        class="register-input w-full appearance-none rounded-xl border border-white/10 bg-[#111111] px-4 py-4 pr-12 text-sm text-[#F5F3ED] outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                    >
                        <option value="" disabled {{ old('tipo_cuenta') ? '' : 'selected' }}>Selecciona una opción</option>
                        <option value="visitante" @selected(old('tipo_cuenta') === 'visitante')>Visitante — explorar y crear una cuenta básica</option>
                        <option value="proveedor" @selected(old('tipo_cuenta') === 'proveedor')>Proveedor — ofrecer productos o servicios</option>
                    </select>

                    <svg class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-[#D8C17F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </div>

                @error('tipo_cuenta')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror

                <p class="mt-3 flex items-start gap-2 text-xs leading-5 text-white/45">
                    <svg class="mt-0.5 h-4 w-4 shrink-0 text-[#D8C17F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11v5m0-9h.01M5 20h14a2 2 0 0 0 1.7-3L13.7 4a2 2 0 0 0-3.4 0l-7 13a2 2 0 0 0 1.7 3Z" />
                    </svg>
                    <span>Por seguridad, las cuentas Administrador y Usuario autorizado solo las asigna el equipo administrador.</span>
                </p>
            </div>

            {{-- Datos personales --}}
            <div class="mb-8">
                <div class="mb-5 flex items-center gap-3">
                    <span class="h-5 w-1 rounded-full bg-gradient-to-b from-[#D8C17F] to-[#A99045]"></span>
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-[#D8C17F]">
                        Datos personales
                    </h2>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="mb-2 block text-sm font-medium text-white/80">
                            Nombre completo <span class="text-rose-400">*</span>
                        </label>

                        <input
                            id="nombre"
                            name="nombre"
                            type="text"
                            value="{{ old('nombre') }}"
                            required
                            maxlength="255"
                            autocomplete="name"
                            placeholder="Tu nombre"
                            class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                        >

                        @error('nombre')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Correo --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-medium text-white/80">
                            Correo electrónico <span class="text-rose-400">*</span>
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            maxlength="255"
                            autocomplete="email"
                            placeholder="tu@correo.com"
                            class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="telefono" class="mb-2 block text-sm font-medium text-white/80">
                            Teléfono <span id="telefono-required" class="hidden text-rose-400">*</span>
                        </label>

                        <input
                            id="telefono"
                            name="telefono"
                            type="tel"
                            value="{{ old('telefono') }}"
                            maxlength="20"
                            autocomplete="tel"
                            placeholder="Número de contacto"
                            class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                        >

                        @error('telefono')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Empresa --}}
                    <div id="empresa-wrap">
                        <label for="empresa" class="mb-2 block text-sm font-medium text-white/80">
                            Empresa (opcional)
                        </label>

                        <input
                            id="empresa"
                            name="empresa"
                            value="{{ old('empresa') }}"
                            maxlength="150"
                            placeholder="Nombre de tu empresa"
                            class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                        >

                        @error('empresa')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Información del proveedor --}}
            <div
                id="proveedor-fields"
                class="mb-8 hidden space-y-5 rounded-2xl border border-[#A99045]/25 bg-gradient-to-br from-[#A99045]/[0.09] to-[#D8C17F]/[0.03] p-5 sm:p-6"
            >
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#A99045]/30 bg-[#A99045]/10 text-[#D8C17F]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18m-4-14h.01M9 11h.01M9 15h.01M9 19h.01m8-8h.01m-.01 4h.01m-.01 4h.01M13 21v-5h4v5" />
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-[#F5F3ED]">Información del proveedor</h2>
                        <p class="mt-1 text-xs leading-6 text-white/45">
                            Estos datos crearán tu ficha de proveedor y podrán completarse más adelante desde tu perfil.
                        </p>
                    </div>
                </div>

                {{-- Especialidad --}}
                <div>
                    <label for="especialidad" class="mb-2 block text-sm font-medium text-white/80">
                        Especialidad <span class="text-rose-400">*</span>
                    </label>

                    <input
                        id="especialidad"
                        name="especialidad"
                        value="{{ old('especialidad') }}"
                        maxlength="150"
                        placeholder="Ej. diseño gráfico, fotografía, manufactura"
                        class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                    >

                    @error('especialidad')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label for="whatsapp" class="mb-2 block text-sm font-medium text-white/80">
                        WhatsApp (opcional)
                    </label>

                    <input
                        id="whatsapp"
                        name="whatsapp"
                        value="{{ old('whatsapp') }}"
                        maxlength="20"
                        placeholder="Número con indicativo"
                        class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                    >

                    @error('whatsapp')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Descripción --}}
                <div>
                    <label for="descripcion" class="mb-2 block text-sm font-medium text-white/80">
                        Descripción (opcional)
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="3"
                        maxlength="5000"
                        placeholder="Cuéntanos sobre tus productos o servicios"
                        class="register-input w-full resize-y rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm leading-6 text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                    >{{ old('descripcion') }}</textarea>

                    @error('descripcion')
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Seguridad --}}
            <div class="mb-8">
                <div class="mb-5 flex items-center gap-3">
                    <span class="h-5 w-1 rounded-full bg-gradient-to-b from-[#D8C17F] to-[#A99045]"></span>
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-[#D8C17F]">
                        Seguridad de la cuenta
                    </h2>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">

                    {{-- Contraseña --}}
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium text-white/80">
                            Contraseña <span class="text-rose-400">*</span>
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres"
                            class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                        >

                        @error('password')
                            <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-medium text-white/80">
                            Confirmar contraseña <span class="text-rose-400">*</span>
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Repite la contraseña"
                            class="register-input w-full rounded-xl border border-white/10 bg-[#111111] px-4 py-3.5 text-sm text-[#F5F3ED] placeholder:text-white/25 outline-none transition duration-300 focus:border-[#A99045] focus:ring-2 focus:ring-[#A99045]/20"
                        >
                    </div>

                </div>
            </div>

            {{-- Términos y condiciones --}}
            <div class="border-t border-white/[0.08] pt-6">
                <label class="flex cursor-pointer items-start gap-3 text-sm leading-6 text-white/60">
                    <input
                        type="checkbox"
                        name="acepta_terminos"
                        value="1"
                        required
                        @checked(old('acepta_terminos'))
                        class="mt-1 h-4 w-4 shrink-0 rounded border-white/20 bg-[#111111] accent-[#D8C17F] focus:ring-2 focus:ring-[#A99045]/30"
                    >

                    <span>
                        Acepto los términos y condiciones para crear mi cuenta.
                        <span class="text-rose-400">*</span>
                    </span>
                </label>

                @error('acepta_terminos')
                    <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botón de registro --}}
            <button
                type="submit"
                class="register-submit mt-7 flex w-full items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-[#A99045] to-[#D8C17F] px-5 py-4 text-xs font-black uppercase tracking-[0.18em] text-[#111111] shadow-[0_0_25px_rgba(169,144,69,0.15)] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_0_35px_rgba(169,144,69,0.25)] focus:outline-none focus:ring-2 focus:ring-[#D8C17F] focus:ring-offset-2 focus:ring-offset-[#1D1D1D]"
            >
                Crear cuenta

                <svg class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </button>

            {{-- Acceso a login --}}
            <p class="mt-7 text-center text-sm text-white/45">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="ml-1 font-bold text-[#D8C17F] transition-colors hover:text-[#F5E4AE] hover:underline">
                    Inicia sesión
                </a>
            </p>

        </form>

        <p class="mt-7 text-center text-[10px] font-medium uppercase tracking-[0.22em] text-white/25">
            Incógnito · Group Design
        </p>

    </div>
</div>

{{-- Estilos adicionales --}}
<style>
    .register-page {
        --register-gold: rgba(169, 144, 69, .6);
    }

    .register-input {
        min-width: 0;
        color-scheme: dark;
    }

    .register-input::placeholder {
        opacity: 1;
    }

    .register-input:focus {
        box-shadow: 0 0 0 3px rgba(169, 144, 69, .08);
    }

    .register-form {
        isolation: isolate;
    }

    .register-submit svg {
        flex-shrink: 0;
    }

    @media (prefers-reduced-motion: reduce) {
        .register-page *,
        .register-page *::before,
        .register-page *::after {
            scroll-behavior: auto !important;
            animation-duration: .01ms !important;
            transition-duration: .01ms !important;
        }
    }
</style>

{{-- Lógica del tipo de cuenta --}}
<script>
    (() => {
        const initRegistrationForm = () => {
            const tipo = document.getElementById('tipo_cuenta');
            const proveedor = document.getElementById('proveedor-fields');
            const especialidad = document.getElementById('especialidad');
            const telefono = document.getElementById('telefono');
            const telefonoRequired = document.getElementById('telefono-required');
            const empresa = document.getElementById('empresa-wrap');

            if (!tipo || !proveedor || !especialidad || !telefono || !telefonoRequired || !empresa) {
                return;
            }

            const sync = () => {
                const esProveedor = tipo.value === 'proveedor';

                proveedor.classList.toggle('hidden', !esProveedor);
                especialidad.required = esProveedor;

                telefono.required = esProveedor;
                telefonoRequired.classList.toggle('hidden', !esProveedor);

                empresa.classList.toggle('hidden', tipo.value !== 'cliente');
            };

            tipo.addEventListener('change', sync);
            sync();
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initRegistrationForm, { once: true });
        } else {
            initRegistrationForm();
        }
    })();
</script>

@endsection
