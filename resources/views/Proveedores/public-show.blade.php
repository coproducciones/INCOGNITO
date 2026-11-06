@extends('layouts.app')

@section('title', 'Perfil de proveedor | Incógnito')

@section('content')
<div class="min-h-screen bg-[#151515] px-5 py-12 text-[#F5F3ED] sm:px-8">
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('servicios') }}"
           class="text-sm font-semibold text-[#D8C17F] transition hover:text-white">
            ← Volver al catálogo
        </a>

        <article class="mt-6 overflow-hidden rounded-3xl border border-[#A99045]/30 bg-[#1D1D1D]">
            <div class="h-2 bg-gradient-to-r from-[#80672D] via-[#D8C17F] to-[#80672D]"></div>
            <div class="p-6 sm:p-10">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
                    @if($proveedor->foto_url)
                        <img src="{{ $proveedor->foto_url }}"
                             alt="Imagen del proveedor"
                             class="h-28 w-28 rounded-2xl border border-[#A99045]/40 object-cover">
                    @else
                        <div class="flex h-28 w-28 items-center justify-center rounded-2xl border border-[#A99045]/40 bg-[#A99045]/10 text-4xl text-[#D8C17F]">
                            ✦
                        </div>
                    @endif

                    <div>
                        <p class="text-xs font-bold uppercase tracking-[.2em] text-[#D8C17F]">
                            Perfil profesional
                        </p>
                        <h1 class="mt-2 text-3xl font-black sm:text-4xl">
                            {{ $proveedor->usuario?->nombre ?: 'Proveedor independiente' }}
                        </h1>
                        <p class="mt-2 text-lg text-[#D8C17F]">
                            {{ $proveedor->especialidad }}
                        </p>
                    </div>
                </div>

                <div class="mt-9 border-t border-white/10 pt-7">
                    <h2 class="text-sm font-black uppercase tracking-widest text-[#D8C17F]">
                        Acerca de sus servicios
                    </h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-8 text-gray-300">
                        {{ $proveedor->descripcion ?: 'Este proveedor aún no ha agregado una descripción.' }}
                    </p>
                </div>

                <div class="mt-8 border-t border-white/10 pt-7">
                    <h2 class="text-sm font-black uppercase tracking-widest text-[#D8C17F]">
                        Categorías
                    </h2>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($proveedor->categorias as $categoria)
                            <a href="{{ route('servicios', ['categoria' => $categoria->id]) }}"
                               class="rounded-full border border-[#A99045]/40 bg-[#A99045]/10 px-4 py-2 text-sm font-semibold text-[#D8C17F] hover:bg-[#A99045]/20">
                                {{ $categoria->nombre }}
                            </a>
                        @endforeach
                    </div>
                </div>

                @if($proveedor->whatsapp_url || $proveedor->telefono)
                    <div class="mt-8 flex flex-wrap items-center gap-3 border-t border-white/10 pt-7">
                        @if($proveedor->whatsapp_url)
                            <a href="{{ $proveedor->whatsapp_url }}"
                               target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center justify-center rounded-full bg-[#A99045] px-6 py-3 text-sm font-bold text-[#151515] transition hover:bg-[#D8C17F]">
                                Contactar por WhatsApp
                            </a>
                        @endif
                        @if($proveedor->telefono)
                            <span class="text-sm text-gray-400">
                                Teléfono: {{ $proveedor->telefono }}
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </article>
    </div>
</div>
@endsection
