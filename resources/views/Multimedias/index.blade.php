@extends('layouts.app')

@section('title', 'Gestión de multimedia')

@section('content')
<div class="space-y-6">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-wide text-white">
                Multimedia
            </h1>

            <p class="mt-1 text-sm text-white/50">
                Administra imágenes, videos y documentos asociados a tus productos y contenidos.
            </p>
        </div>

        @auth
            @if(auth()->user()->tienePermiso('multimedia.crear'))
                <a href="{{ route('multimedias.create') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-[#A99045] bg-[#A99045] px-4 py-2.5 text-sm font-semibold text-black transition hover:border-[#D8C17F] hover:bg-[#D8C17F]">
                    + Nuevo recurso
                </a>
            @endif
        @endauth
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="rounded-lg border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- RESUMEN --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-xl border border-white/[0.08] bg-[#1D1D1D] p-5 transition hover:border-[#A99045]/40">
            <p class="text-sm text-white/50">Recursos registrados</p>
            <p class="mt-2 text-3xl font-semibold text-white">
                {{ $medias->count() }}
            </p>
        </div>

        <div class="rounded-xl border border-white/[0.08] bg-[#1D1D1D] p-5 transition hover:border-[#A99045]/40">
            <p class="text-sm text-white/50">Imágenes</p>
            <p class="mt-2 text-3xl font-semibold text-white">
                {{ $medias->filter(fn ($media) => in_array(strtolower($media->tipo ?? ''), ['imagen', 'image', 'img']))->count() }}
            </p>
        </div>

        <div class="rounded-xl border border-white/[0.08] bg-[#1D1D1D] p-5 transition hover:border-[#A99045]/40">
            <p class="text-sm text-white/50">Destacados</p>
            <p class="mt-2 text-3xl font-semibold text-[#D8C17F]">
                {{ $medias->where('destacado', true)->count() }}
            </p>
        </div>

    </div>

    {{-- LISTADO --}}
    <div class="overflow-hidden rounded-xl border border-white/[0.08] bg-[#1D1D1D]">

        <div class="border-b border-white/[0.08] px-5 py-4">
            <h2 class="font-semibold tracking-wide text-white">
                Recursos multimedia
            </h2>

            <p class="mt-1 text-xs text-white/40">
                Consulta las vistas previas y las asociaciones de cada recurso.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-white/70">

                <thead class="bg-[#151515] text-xs uppercase tracking-wider text-white/50">
                    <tr>
                        <th class="px-5 py-4">Recurso</th>
                        <th class="px-5 py-4">Tipo</th>
                        <th class="px-5 py-4">Asociación</th>
                        <th class="px-5 py-4">Estado</th>
                        <th class="px-5 py-4 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/[0.06]">

                    @forelse($medias as $media)

                        @php
                            $tipo = strtolower(trim($media->tipo ?? ''));

                            $esImagen = in_array($tipo, ['imagen', 'image', 'img']);
                            $esVideo = in_array($tipo, ['video', 'mp4', 'webm', 'ogg']);
                            $esDocumento = in_array($tipo, ['documento', 'document', 'pdf', 'archivo', 'documento pdf']);

                            /*
                             * Admite:
                             * 1. Una URL externa antigua.
                             * 2. Una ruta relativa guardada en storage/app/public.
                             */
                            $ruta = trim((string) $media->url);

                            if (filter_var($ruta, FILTER_VALIDATE_URL)) {
                                $urlRecurso = $ruta;
                            } else {
                                $ruta = ltrim($ruta, '/');

                                if (str_starts_with($ruta, 'storage/')) {
                                    $ruta = substr($ruta, strlen('storage/'));
                                }

                                if (str_starts_with($ruta, 'public/')) {
                                    $ruta = substr($ruta, strlen('public/'));
                                }

                                $urlRecurso = \Illuminate\Support\Facades\Storage::disk('public')->url($ruta);
                            }
                        @endphp

                        <tr class="align-top transition hover:bg-white/[0.02]">

                            {{-- VISTA PREVIA --}}
                            <td class="px-5 py-4">
                                <div class="flex min-w-[220px] items-start gap-4">

                                    <div class="flex h-24 w-32 shrink-0 items-center justify-center overflow-hidden rounded-lg border border-white/[0.08] bg-[#151515]">

                                        @if($esImagen)

                                            <a href="{{ $urlRecurso }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               title="Abrir imagen"
                                               class="block h-full w-full">

                                                <img src="{{ $urlRecurso }}"
                                                     alt="Multimedia {{ $media->id }}"
                                                     loading="lazy"
                                                     class="h-24 w-32 object-cover"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                                <span style="display:none"
                                                      class="h-24 w-32 items-center justify-center text-center text-xs text-white/40">
                                                    Imagen no disponible
                                                </span>
                                            </a>

                                        @elseif($esVideo)

                                            <video controls
                                                   preload="metadata"
                                                   class="h-24 w-32 object-contain">
                                                <source src="{{ $urlRecurso }}">
                                                Tu navegador no puede reproducir este video.
                                            </video>

                                        @elseif($esDocumento)

                                            <a href="{{ $urlRecurso }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="flex h-full w-full flex-col items-center justify-center gap-2 text-[#D8C17F] transition hover:bg-white/[0.04]">
                                                <span class="text-2xl">▤</span>
                                                <span class="text-xs">Abrir documento</span>
                                            </a>

                                        @else

                                            <a href="{{ $urlRecurso }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="flex h-full w-full flex-col items-center justify-center gap-2 text-white/50 transition hover:bg-white/[0.04]">
                                                <span class="text-2xl">↗</span>
                                                <span class="text-xs">Abrir recurso</span>
                                            </a>

                                        @endif

                                    </div>

                                    <div class="min-w-0">
                                        <p class="font-medium text-white">
                                            Recurso #{{ $media->id }}
                                        </p>

                                        <a href="{{ $urlRecurso }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="mt-2 block max-w-xs break-all text-xs text-white/40 transition hover:text-[#D8C17F]">
                                            {{ $media->url }}
                                        </a>
                                    </div>

                                </div>
                            </td>

                            {{-- TIPO --}}
                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="inline-flex rounded-full border border-white/[0.08] bg-[#151515] px-3 py-1 text-xs text-white/70">
                                    {{ ucfirst($media->tipo) }}
                                </span>
                            </td>

                            {{-- ASOCIACIÓN --}}
                            <td class="px-5 py-4">

                                @if($media->producto)
                                    <p class="text-xs text-[#D8C17F]">Producto</p>
                                    <p class="mt-1 font-medium text-white">
                                        {{ $media->producto->nombre }}
                                    </p>
                                    <p class="mt-1 text-xs text-white/40">
                                        ID: {{ $media->producto->id }}
                                    </p>

                                @elseif($media->contenido)
                                    <p class="text-xs text-[#D8C17F]">Contenido</p>
                                    <p class="mt-1 font-medium text-white">
                                        {{ $media->contenido->titulo }}
                                    </p>
                                    <p class="mt-1 text-xs text-white/40">
                                        ID: {{ $media->contenido->id_contenido }}
                                    </p>

                                @else
                                    <span class="text-xs text-red-400">
                                        Asociación no disponible
                                    </span>
                                @endif

                            </td>

                            {{-- ESTADO --}}
                            <td class="whitespace-nowrap px-5 py-4">
                                @if($media->destacado)
                                    <span class="rounded-full border border-[#A99045]/30 bg-[#A99045]/10 px-3 py-1 text-xs font-medium text-[#D8C17F]">
                                        Destacado
                                    </span>
                                @else
                                    <span class="rounded-full border border-white/[0.06] bg-white/[0.03] px-3 py-1 text-xs text-white/40">
                                        Normal
                                    </span>
                                @endif
                            </td>

                            {{-- ACCIONES --}}
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <div class="flex justify-end gap-3">

                                    @auth
                                        @if(auth()->user()->tienePermiso('multimedia.ver'))
                                            <a href="{{ route('multimedias.show', ['media' => $media->id]) }}"
                                               class="text-white/60 transition hover:text-[#D8C17F]">
                                                Ver
                                            </a>
                                        @endif

                                        @if(auth()->user()->tienePermiso('multimedia.editar'))
                                            <a href="{{ route('multimedias.edit', ['media' => $media->id]) }}"
                                               class="text-[#D8C17F] transition hover:text-white">
                                                Editar
                                            </a>
                                        @endif

                                        @if(auth()->user()->tienePermiso('multimedia.eliminar'))
                                            <form method="POST"
                                                  action="{{ route('multimedias.destroy', ['media' => $media->id]) }}"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este recurso?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-400 transition hover:text-red-300">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    @endauth

                                </div>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center">
                                <p class="font-medium text-white/70">
                                    No hay recursos multimedia registrados.
                                </p>

                                <p class="mt-2 text-sm text-white/40">
                                    Cuando registres una imagen, video o documento, aparecerá aquí.
                                </p>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection