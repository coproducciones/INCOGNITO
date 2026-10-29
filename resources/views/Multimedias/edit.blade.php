@extends('layouts.app')

@section('title', 'Editar recurso multimedia')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <h1 class="text-2xl font-black uppercase tracking-widest text-white">
            Editar recurso multimedia
        </h1>
        <p class="mt-2 text-xs font-bold uppercase tracking-widest text-white/40">
            Actualiza el archivo o modifica su asociación.
        </p>
    </div>

    @if($errors->any())
        <div class="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3">
            <ul class="list-inside list-disc space-y-1 text-sm text-red-300">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('multimedias.update', $media) }}"
        enctype="multipart/form-data"
        class="space-y-6 rounded-xl border border-white/[0.08] bg-[#1D1D1D] p-6 shadow-lg sm:p-8"
    >
        @csrf
        @method('PUT')

        @include('Multimedias._form')

        <div class="flex flex-col-reverse justify-end gap-3 border-t border-white/[0.08] pt-5 sm:flex-row">
            <a
                href="{{ route('multimedias.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-white/[0.12] px-4 py-2.5 text-sm font-medium text-white/70 hover:bg-white/[0.04] hover:text-white"
            >
                Cancelar
            </a>

            @if(auth()->check() && auth()->user()->tienePermiso('multimedia.editar'))
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-[#A99045] bg-[#A99045] px-4 py-2.5 text-sm font-semibold text-black hover:bg-[#D8C17F]"
                >
                    Guardar cambios
                </button>
            @endif
        </div>
    </form>
</div>
@endsection