@extends('layouts.app')

@section('title', 'Crear mi perfil de proveedor')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8">

    {{-- Encabezado --}}
    <div class="mb-8">
        <h1 class="text-2xl font-black uppercase tracking-widest text-white"
            style="letter-spacing: 0.15em;">
            Quiero ofrecer mis servicios
        </h1>

        <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>

        <p class="mt-3 text-sm text-white/60">
            Completa tus datos profesionales para crear tu perfil de proveedor.
        </p>
    </div>

    {{-- Errores generales --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 p-4">
            <ul class="list-disc space-y-1 pl-5 text-sm text-red-300">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form
        method="POST"
        action="{{ route('proveedores.mi-perfil.store') }}"
        class="space-y-6 rounded-2xl border border-[#A99045]/30 bg-[#111111] p-6 shadow-xl shadow-black/30 sm:p-8"
    >
        @csrf

        {{-- Especialidad --}}
        <div>
            <label for="especialidad"
                   class="mb-2 block text-xs font-bold uppercase tracking-widest text-white/80">
                Especialidad
            </label>

            <input
                id="especialidad"
                name="especialidad"
                type="text"
                maxlength="150"
                required
                value="{{ old('especialidad') }}"
                placeholder="Ej. Diseño gráfico, fotografía o producción"
                class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
            >

            @error('especialidad')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div>
            <label for="telefono"
                   class="mb-2 block text-xs font-bold uppercase tracking-widest text-white/80">
                Teléfono
            </label>

            <input
                id="telefono"
                name="telefono"
                type="text"
                maxlength="20"
                required
                value="{{ old('telefono') }}"
                placeholder="Tu teléfono de contacto"
                class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
            >

            @error('telefono')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- WhatsApp --}}
        <div>
            <label for="whatsapp"
                   class="mb-2 block text-xs font-bold uppercase tracking-widest text-white/80">
                WhatsApp (opcional)
            </label>

            <input
                id="whatsapp"
                name="whatsapp"
                type="text"
                maxlength="20"
                value="{{ old('whatsapp') }}"
                placeholder="Tu número de WhatsApp"
                class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
            >

            @error('whatsapp')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcion"
                   class="mb-2 block text-xs font-bold uppercase tracking-widest text-white/80">
                Descripción de tus servicios (opcional)
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                rows="4"
                class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
                placeholder="Describe tu experiencia y los servicios que ofreces"
            >{{ old('descripcion') }}</textarea>

            @error('descripcion')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- URL de la foto --}}
        <div>
            <label for="foto_url"
                   class="mb-2 block text-xs font-bold uppercase tracking-widest text-white/80">
                URL de tu foto (opcional)
            </label>

            <input
                id="foto_url"
                name="foto_url"
                type="url"
                maxlength="255"
                value="{{ old('foto_url') }}"
                placeholder="https://ejemplo.com/mi-foto.jpg"
                class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]/40"
            >

            @error('foto_url')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-6">

            <a
                href="{{ route('proveedores.index') }}"
                class="rounded-lg border border-white/15 bg-[#1D1D1D] px-5 py-2.5 text-sm font-semibold text-white/70 transition hover:border-white/30 hover:bg-[#252525] hover:text-white"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-lg border border-[#D8C17F] bg-[#A99045] px-5 py-2.5 text-sm font-bold text-[#111111] transition hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#A99045]/50"
            >
                Crear mi perfil
            </button>

        </div>
    </form>
</div>
@endsection