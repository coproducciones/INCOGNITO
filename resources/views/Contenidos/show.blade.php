@extends('layouts.app')

@section('title', 'Detalle de contenido')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <div class="rounded-xl border border-white/10 bg-[#111111] p-6 sm:p-8">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-[#00c896]">
                    Detalle de contenido
                </p>

                <h1 class="mt-2 text-2xl font-semibold text-white">
                    {{ $contenido->titulo }}
                </h1>

                <p class="mt-2 text-sm text-gray-400">
                    Sección: {{ $contenido->seccion ?: 'Sin sección' }}
                </p>
            </div>

            @if(auth()->check() && auth()->user()->tienePermiso('contenido.editar'))
                <a
                    href="{{ route('contenidos.edit', $contenido) }}"
                    class="inline-flex justify-center rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:bg-[#00a87e]"
                >
                    Editar contenido
                </a>
            @endif
        </div>

        <div class="mt-8 border-t border-white/10 pt-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                Descripción
            </h2>

            <p class="mt-3 whitespace-pre-line leading-7 text-gray-300">{{ $contenido->descripcion ?: 'Sin descripción.' }}</p>
        </div>

        <div class="mt-8 border-t border-white/10 pt-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                Categorías asociadas
            </h2>

            <div class="mt-3 flex flex-wrap gap-2">
                @forelse($contenido->categorias as $categoria)
                    <span class="rounded-full border border-[#00c896]/20 bg-[#00c896]/10 px-3 py-1 text-sm text-[#00c896]">
                        {{ $categoria->nombre }}
                    </span>
                @empty
                    <p class="text-sm text-gray-500">
                        Este contenido no tiene categorías asociadas.
                    </p>
                @endforelse
            </div>
        </div>

        <div class="mt-8 border-t border-white/10 pt-6">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-gray-400">
                Multimedias relacionadas
            </h2>

            @forelse($contenido->media as $media)
                <div class="mt-3 flex flex-col gap-2 rounded-lg border border-white/10 bg-[#1a1a1a] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white">
                            {{ $media->tipo }}
                        </p>

                        <p class="break-all text-xs text-gray-400">
                            {{ $media->url }}
                        </p>
                    </div>

                    @if(auth()->check() && auth()->user()->tienePermiso('multimedia.ver'))
                        <a
                            href="{{ route('multimedias.show', ['media' => $media->id]) }}"
                            class="shrink-0 text-sm text-[#00c896] hover:text-[#00e0aa]"
                        >
                            Ver multimedia
                        </a>
                    @endif
                </div>
            @empty
                <p class="mt-3 text-sm text-gray-500">
                    Todavía no hay multimedias asociadas a este contenido.
                </p>
            @endforelse
        </div>

        <div class="mt-8 border-t border-white/10 pt-6">
            <a
                href="{{ route('contenidos.index') }}"
                class="text-sm text-gray-300 hover:text-white"
            >
                ← Volver a contenidos
            </a>
        </div>

    </div>
</div>
@endsection