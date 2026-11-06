@extends('layouts.app')

@section('title', 'Reseñas de mis productos')

@section('content')
<div class="w-full max-w-7xl">
    <div class="mb-8">
        <a href="{{ route('dashboard.gestion') }}"
           class="font-bold uppercase tracking-widest"
           style="font-size:9px;color:rgba(255,255,255,.4);">
            ← PANEL DE GESTIÓN
        </a>

        <h1 class="mt-5 font-black uppercase tracking-widest text-white"
            style="font-size:22px;letter-spacing:.15em;">
            RESEÑAS DE MIS PRODUCTOS
        </h1>

        <div class="mt-3 h-[3px] w-[60px]" style="background:#A99045;"></div>
        <p class="mt-3 text-xs" style="color:rgba(255,255,255,.45);">
            Puedes consultar las opiniones y responderlas. La calificación y el comentario original no se pueden modificar desde este módulo.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded border px-4 py-3 text-sm"
             style="background:rgba(169,144,69,.10);border-color:rgba(169,144,69,.35);color:#D8C17F;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 rounded border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="space-y-5">
        @forelse($resenas as $reseña)
            <article class="rounded-lg p-6"
                     style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <h2 class="font-black uppercase text-white">
                            {{ $reseña->producto?->nombre ?? 'PRODUCTO NO DISPONIBLE' }}
                        </h2>
                        <p class="mt-1 text-xs" style="color:rgba(255,255,255,.5);">
                            Cliente: {{ $reseña->usuario?->nombre ?? 'Usuario' }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p style="color:#D8C17F;">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $reseña->calificacion ? '★' : '☆' }}
                            @endfor
                        </p>
                        <p class="text-xs" style="color:rgba(255,255,255,.4);">
                            {{ $reseña->fecha?->format('d/m/Y H:i') ?? 'Sin fecha' }}
                        </p>
                    </div>
                </div>

                <div class="mt-5">
                    <p class="mb-2 text-xs font-bold uppercase tracking-widest" style="color:#D8C17F;">
                        Opinión del cliente
                    </p>
                    <p class="whitespace-pre-line text-sm leading-relaxed text-white/80">
                        {{ $reseña->comentario ?: 'El cliente no dejó un comentario.' }}
                    </p>
                </div>

                <form method="POST"
                      action="{{ route('proveedor.resenas.responder', $reseña) }}"
                      class="mt-5 border-t pt-5"
                      style="border-color:rgba(169,144,69,.18);">
                    @csrf
                    @method('PATCH')

                    <label for="respuesta-{{ $reseña->id_reseña }}"
                           class="mb-2 block text-xs font-bold uppercase tracking-widest"
                           style="color:#D8C17F;">
                        Tu respuesta
                    </label>

                    <textarea id="respuesta-{{ $reseña->id_reseña }}"
                              name="respuesta"
                              rows="3"
                              maxlength="2000"
                              required
                              class="w-full rounded border border-white/10 bg-black/20 px-4 py-3 text-sm text-white outline-none focus:border-[#A99045]">{{ old('respuesta', $reseña->respuesta) }}</textarea>

                    <div class="mt-3 flex justify-end">
                        <button type="submit"
                                class="rounded px-5 py-3 text-xs font-black uppercase tracking-widest"
                                style="background:#A99045;color:#111;">
                            {{ $reseña->respuesta ? 'Actualizar respuesta' : 'Publicar respuesta' }}
                        </button>
                    </div>
                </form>
            </article>
        @empty
            <div class="rounded-lg p-10 text-center"
                 style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);">
                <p class="font-bold uppercase tracking-widest text-white">Todavía no hay reseñas</p>
                <p class="mt-2 text-sm text-white/50">Cuando tus productos reciban opiniones, aparecerán aquí.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $resenas->links() }}
    </div>
</div>
@endsection
