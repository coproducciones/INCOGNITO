
@extends('layouts.app')

@section('title', 'Crear mi perfil de proveedor')

@section('content')
<div class="mx-auto max-w-3xl px-4 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">
            Quiero ofrecer mis servicios
        </h1>

        <p class="mt-2 text-sm text-gray-400">
            Completa tus datos profesionales para crear tu perfil de proveedor.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">
            <ul class="list-disc space-y-1 pl-5 text-sm text-red-200">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('proveedores.mi-perfil.store') }}"
        class="space-y-5 rounded-xl border border-white/10 bg-[#111111] p-6"
    >
        @csrf

        <div>
            <label for="especialidad" class="mb-2 block text-sm text-gray-300">
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
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]"
            >
            @error('especialidad')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telefono" class="mb-2 block text-sm text-gray-300">
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
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]"
            >
            @error('telefono')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="whatsapp" class="mb-2 block text-sm text-gray-300">
                WhatsApp (opcional)
            </label>

            <input
                id="whatsapp"
                name="whatsapp"
                type="text"
                maxlength="20"
                value="{{ old('whatsapp') }}"
                placeholder="Tu número de WhatsApp"
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]"
            >
            @error('whatsapp')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descripcion" class="mb-2 block text-sm text-gray-300">
                Descripción de tus servicios (opcional)
            </label>

            <textarea
                id="descripcion"
                name="descripcion"
                rows="4"
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]"
                placeholder="Describe tu experiencia y los servicios que ofreces"
            >{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="foto_url" class="mb-2 block text-sm text-gray-300">
                URL de tu foto (opcional)
            </label>

            <input
                id="foto_url"
                name="foto_url"
                type="url"
                maxlength="255"
                value="{{ old('foto_url') }}"
                placeholder="https://ejemplo.com/mi-foto.jpg"
                class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]"
            >
            @error('foto_url')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">
            <a
                href="{{ route('proveedores.index') }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-300 hover:bg-white/5"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[#00c896] px-5 py-2 text-sm font-semibold text-black hover:opacity-90"
            >
                Crear mi perfil
            </button>
        </div>
    </form>
</div>
@endsection
