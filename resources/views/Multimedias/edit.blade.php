@extends('layouts.app')

@section('title', 'Editar recurso multimedia')

@section('content')

<div class="mx-auto max-w-3xl">

    <form
        method="POST"
        action="{{ route('multimedias.update', ['media' => $media->id]) }}"
        class="rounded-xl border border-white/10 bg-[#111111] p-6"
    >

        @csrf

        @method('PUT')

        <h1 class="mb-6 text-2xl font-semibold text-white">
            Editar recurso multimedia
        </h1>

        @include('Multimedias._form')

        <div class="mt-6 flex justify-end gap-3">

            <a
                href="{{ route('multimedias.index') }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-300 hover:bg-white/5"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="rounded-lg bg-[#00c896] px-4 py-2 font-semibold text-black hover:bg-[#00b085]"
            >
                Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection
