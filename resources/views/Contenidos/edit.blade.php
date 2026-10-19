@extends('layouts.app')

@section('title', 'Editar contenido')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">

    <div>
        <h1 class="text-2xl font-semibold text-white">
            Editar contenido
        </h1>
        <p class="mt-1 text-sm text-gray-400">
            Actualiza la información del contenido seleccionado.
        </p>
    </div>

    @if($categorias->isEmpty())
        <div class="rounded-lg border border-yellow-500/20 bg-yellow-500/10 p-4 text-sm text-yellow-200">
            No hay categorías disponibles. Registra una categoría antes de actualizar este contenido.
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('contenidos.update', $contenido) }}"
        class="rounded-xl border border-white/10 bg-[#111111] p-6"
    >
        @csrf
        @method('PUT')

        @include('Contenidos._form')

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <a
                href="{{ route('contenidos.index') }}"
                class="rounded-lg border border-white/10 px-4 py-2 text-center text-sm text-gray-300 hover:bg-white/5"
            >
                Cancelar
            </a>

            @if(auth()->check() && auth()->user()->tienePermiso('contenido.editar'))
                <button
                    type="submit"
                    @disabled($categorias->isEmpty())
                    class="rounded-lg bg-[#00c896] px-5 py-2 text-sm font-semibold text-black transition hover:bg-[#00a87e] disabled:cursor-not-allowed disabled:opacity-40"
                >
                    Guardar cambios
                </button>
            @endif
        </div>
    </form>

</div>
@endsection