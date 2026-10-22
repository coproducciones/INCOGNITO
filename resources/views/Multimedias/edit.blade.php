@extends('layouts.app')

@section('title', 'Editar recurso multimedia')

@section('content')

<div class="mx-auto max-w-3xl">

    <form
        method="POST"
        action="{{ route('multimedias.update', ['media' => $media->id]) }}"
        class="rounded-xl border border-white/[0.08] bg-[#1D1D1D] p-6 shadow-lg sm:p-8"
    >

        @csrf
        @method('PUT')

        <h1 class="mb-6 border-b border-white/[0.08] pb-4 text-2xl font-semibold tracking-wide text-white">
            Editar recurso multimedia
        </h1>

        @include('Multimedias._form')

        <div class="mt-6 flex flex-col-reverse justify-end gap-3 border-t border-white/[0.08] pt-5 sm:flex-row">

            <a
                href="{{ route('multimedias.index') }}"
                class="inline-flex items-center justify-center rounded-lg border border-white/[0.12] px-4 py-2.5 text-sm font-medium text-white/70 transition duration-200 hover:border-[#A99045]/50 hover:bg-white/[0.04] hover:text-white"
            >
                Cancelar
            </a>

            @if(auth()->check() && auth()->user()->tienePermiso('multimedia.editar'))

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg border border-[#A99045] bg-[#A99045] px-4 py-2.5 text-sm font-semibold text-black transition duration-200 hover:border-[#D8C17F] hover:bg-[#D8C17F]"
                >
                    Guardar cambios
                </button>

            @endif

        </div>

    </form>

</div>

@endsection