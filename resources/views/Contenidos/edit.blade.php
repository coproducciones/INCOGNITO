@extends('layouts.app')

@section('title', 'Editar contenido')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    {{-- ENCABEZADO --}}
    <div>
        <h1
            class="font-black uppercase tracking-widest text-white"
            style="font-size:22px; letter-spacing:0.15em;"
        >
            EDITAR CONTENIDO
        </h1>

        <p
            class="mt-2 font-bold uppercase tracking-widest"
            style="font-size:10px; color:rgba(255,255,255,0.4);"
        >
            Actualiza la información del contenido seleccionado.
        </p>
    </div>


    {{-- AVISO: NO HAY CATEGORÍAS --}}
    @if($categorias->isEmpty())
        <div
            class="p-4"
            style="
                background:rgba(169,144,69,0.10);
                border:1px solid rgba(169,144,69,0.35);
                border-radius:4px;
                color:#D8C17F;
                font-size:12px;
            "
        >
            <p class="font-black uppercase tracking-widest mb-1" style="font-size:10px;">
                Atención
            </p>

            No hay categorías disponibles. Registra una categoría antes de actualizar este contenido.
        </div>
    @endif


    {{-- FORMULARIO DE EDICIÓN --}}
    <form
        method="POST"
        action="{{ route('contenidos.update', $contenido) }}"
        class="p-6 sm:p-8 space-y-6"
        style="
            background:#1D1D1D;
            border:1px solid rgba(255,255,255,0.08);
            border-radius:6px;
        "
    >
        @csrf
        @method('PUT')

        {{-- CAMPOS DEL FORMULARIO --}}
        @include('Contenidos._form')


        {{-- BOTONES --}}
        <div
            class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end pt-5"
            style="border-top:1px solid rgba(255,255,255,0.08);"
        >

            {{-- CANCELAR --}}
            <a
                href="{{ route('contenidos.index') }}"
                class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all duration-200 hover:bg-white/[0.05]"
                style="
                    font-size:10px;
                    color:rgba(255,255,255,0.65);
                    border:1px solid rgba(255,255,255,0.12);
                    border-radius:4px;
                "
            >
                Cancelar
            </a>


            {{-- GUARDAR CAMBIOS --}}
            @if(auth()->check() && auth()->user()->tienePermiso('contenido.editar'))
                <button
                    type="submit"
                    @disabled($categorias->isEmpty())
                    class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all duration-300 hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-40"
                    style="
                        font-size:10px;
                        color:#111111;
                        background:#A99045;
                        border:1px solid #A99045;
                        border-radius:4px;
                    "
                >
                    Guardar cambios
                </button>
            @endif

        </div>

    </form>

</div>

@endsection