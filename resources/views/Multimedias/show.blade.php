@extends('layouts.app')

@section('title', 'Detalle del recurso multimedia')

@section('content')
@php
    $tipo = strtolower(trim($media->tipo ?? ''));
    $esImagen = in_array($tipo, ['imagen', 'image', 'img']);
    $esVideo = in_array($tipo, ['video', 'mp4', 'webm', 'ogg']);
    $esDocumento = in_array($tipo, ['documento', 'document', 'pdf', 'archivo', 'documento pdf']);
@endphp

<div class="mx-auto max-w-4xl space-y-6">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">
                Detalle del recurso multimedia
            </h1>
            <p class="mt-1 text-sm text-gray-400">
                Información del recurso #{{ $media->id }}
            </p>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('multimedia.editar'))
            <a href="{{ route('multimedias.edit', ['media' => $media->id]) }}"
               class="inline-flex justify-center rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:bg-[#00b085]">
                Editar recurso
            </a>
        @endif
    </div>

    {{-- VISTA PREVIA --}}
    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">
        <div class="border-b border-white/10 px-5 py-4">
            <h2 class="font-semibold text-white">Vista previa</h2>
        </div>

        <div class="flex min-h-64 items-center justify-center bg-[#0b0b0b] p-5">
            @if($esImagen)
                <a href="{{ $media->url }}"
                   target="_blank"
                   rel="noopener noreferrer">
                    <img src="{{ $media->url }}"
                         alt="Recurso multimedia {{ $media->id }}"
                         class="max-h-[520px] max-w-full rounded-lg object-contain"
                         onerror="this.style.display='none'; document.getElementById('preview-error').classList.remove('hidden');">
                </a>
                <p id="preview-error" class="hidden text-sm text-gray-400">
                    No se pudo cargar la imagen. Comprueba la URL.
                </p>
            @elseif($esVideo)
                <video controls preload="metadata" class="max-h-[520px] w-full rounded-lg">
                    <source src="{{ $media->url }}">
                    Tu navegador no puede reproducir este video.
                </video>
            @elseif($esDocumento)
                <div class="py-8 text-center">
                    <div class="mb-4 text-5xl text-[#00c896]">▤</div>
                    <p class="font-medium text-white">Documento multimedia</p>
                    <p class="mt-2 text-sm text-gray-400">
                        Abre el documento en una nueva pestaña para consultarlo.
                    </p>
                    <a href="{{ $media->url }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="mt-5 inline-flex rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black hover:bg-[#00b085]">
                        Abrir documento
                    </a>
                </div>
            @else
                <div class="py-8 text-center">
                    <p class="text-gray-300">Vista previa no disponible para este tipo.</p>
                    <a href="{{ $media->url }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="mt-4 inline-flex rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-300 hover:bg-white/5">
                        Abrir recurso
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- INFORMACIÓN --}}
    <div class="rounded-xl border border-white/10 bg-[#111111] p-5 sm:p-6">
        <h2 class="mb-4 font-semibold text-white">Información del recurso</h2>

        <dl class="divide-y divide-white/10">
            <div class="grid gap-2 py-4 sm:grid-cols-3">
                <dt class="text-sm text-gray-500">Identificador</dt>
                <dd class="text-sm text-white sm:col-span-2">{{ $media->id }}</dd>
            </div>

            <div class="grid gap-2 py-4 sm:grid-cols-3">
                <dt class="text-sm text-gray-500">Tipo</dt>
                <dd class="text-sm text-white sm:col-span-2">{{ ucfirst($media->tipo) }}</dd>
            </div>

            <div class="grid gap-2 py-4 sm:grid-cols-3">
                <dt class="text-sm text-gray-500">URL</dt>
                <dd class="break-all text-sm text-gray-300 sm:col-span-2">
                    <a href="{{ $media->url }}"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="hover:text-[#00c896]">
                        {{ $media->url }}
                    </a>
                </dd>
            </div>

            <div class="grid gap-2 py-4 sm:grid-cols-3">
                <dt class="text-sm text-gray-500">Destacado</dt>
                <dd class="sm:col-span-2">
                    @if($media->destacado)
                        <span class="text-sm text-[#00c896]">Sí</span>
                    @else
                        <span class="text-sm text-gray-400">No</span>
                    @endif
                </dd>
            </div>

            <div class="grid gap-2 py-4 sm:grid-cols-3">
                <dt class="text-sm text-gray-500">Producto asociado</dt>
                <dd class="text-sm text-white sm:col-span-2">
                    @if($media->producto)
                        {{ $media->producto->nombre }}
                    @else
                        <span class="text-gray-500">No aplica</span>
                    @endif
                </dd>
            </div>

            <div class="grid gap-2 py-4 sm:grid-cols-3">
                <dt class="text-sm text-gray-500">Contenido asociado</dt>
                <dd class="text-sm text-white sm:col-span-2">
                    @if($media->contenido)
                        {{ $media->contenido->titulo }}
                    @else
                        <span class="text-gray-500">No aplica</span>
                    @endif
                </dd>
            </div>
        </dl>

        {{-- ACCIONES --}}
        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <a href="{{ route('multimedias.index') }}"
               class="rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-300 hover:bg-white/5">
                ← Volver al listado
            </a>

            @if(auth()->check() && auth()->user()->tienePermiso('multimedia.eliminar'))
                <form method="POST"
                      action="{{ route('multimedias.destroy', ['media' => $media->id]) }}"
                      onsubmit="return confirm('¿Seguro que deseas eliminar este recurso multimedia?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="rounded-lg border border-red-500/20 px-4 py-2 text-sm text-red-400 hover:bg-red-500/10">
                        Eliminar recurso
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection