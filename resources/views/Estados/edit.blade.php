@extends('layouts.app')

@section('title', 'Editar estado')

@section('content')
<div class="mx-auto max-w-3xl space-y-8 pb-10">

    {{-- ENCABEZADO --}}
    <div class="flex items-center gap-4">
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-7 w-7"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="1.8">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M19.5 7.125L16.875 4.5"/>
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                Editar estado
            </h1>
            <p class="mt-1 text-sm text-gray-400">
                Actualiza la información del estado seleccionado.
            </p>
        </div>
    </div>


    {{-- INFORMACIÓN ACTUAL --}}
    <div class="flex items-center gap-4 rounded-2xl border border-white/10 bg-gray-900/50 p-5">

        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 text-lg font-bold text-emerald-300 ring-1 ring-emerald-500/10">
            {{ \Illuminate\Support\Str::upper(
                \Illuminate\Support\Str::substr($estado->nombre, 0, 1)
            ) }}
        </div>

        <div class="min-w-0 flex-1">
            <p class="text-xs font-medium uppercase tracking-wider text-gray-500">
                Registro seleccionado
            </p>
            <p class="mt-1 truncate font-semibold text-white">
                {{ $estado->nombre }}
            </p>
            <p class="mt-1 text-sm text-gray-400">
                Tipo: {{ $estado->tipo }}
            </p>
        </div>

        <span class="inline-flex shrink-0 items-center gap-2 rounded-full border border-blue-400/20 bg-blue-400/10 px-3 py-1.5 text-xs font-semibold text-blue-300">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-4 w-4"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
            </svg>
            Edición
        </span>
    </div>


    {{-- FORMULARIO --}}
    <div class="overflow-hidden rounded-2xl border border-white/10 bg-gray-900/70 shadow-xl shadow-black/10">

        <div class="border-b border-white/10 px-6 py-5 sm:px-8">
            <h2 class="text-lg font-semibold text-white">
                Modificar información
            </h2>
            <p class="mt-1 text-sm text-gray-400">
                Cambia los campos necesarios y guarda las modificaciones.
            </p>
        </div>

        <form method="POST"
              action="{{ route('estados.update', $estado) }}"
              class="space-y-6 p-6 sm:p-8">

            @csrf
            @method('PUT')

            {{-- ERRORES DE VALIDACIÓN --}}
            @if ($errors->any())
                <div class="rounded-xl border border-red-500/20 bg-red-500/10 p-4"
                     role="alert">
                    <p class="font-semibold text-red-300">
                        No se pudieron guardar los cambios.
                    </p>

                    <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-200/90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- TIPO --}}
            <div>
                <label for="tipo"
                       class="mb-2 block text-sm font-semibold text-gray-200">
                    Tipo de estado
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="tipo"
                    name="tipo"
                    value="{{ old('tipo', $estado->tipo) }}"
                    placeholder="Ingrese el tipo de estado"
                    autocomplete="off"
                    required
                    class="w-full rounded-xl border border-white/10 bg-gray-950 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 @error('tipo') border-red-500 @enderror"
                >

                @error('tipo')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>


            {{-- NOMBRE --}}
            <div>
                <label for="nombre"
                       class="mb-2 block text-sm font-semibold text-gray-200">
                    Nombre del estado
                    <span class="text-red-400">*</span>
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $estado->nombre) }}"
                    placeholder="Ingrese el nombre del estado"
                    autocomplete="off"
                    required
                    class="w-full rounded-xl border border-white/10 bg-gray-950 px-4 py-3 text-sm text-white placeholder-gray-500 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 @error('nombre') border-red-500 @enderror"
                >

                @error('nombre')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>


            {{-- AVISO --}}
            <div class="flex items-start gap-3 rounded-xl border border-blue-400/10 bg-blue-400/5 p-4">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="mt-0.5 h-5 w-5 shrink-0 text-blue-400"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.852l.041-.02M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-5.25h.008v.008H12V6.75z"/>
                </svg>

                <p class="text-sm leading-6 text-gray-400">
                    Los cambios se aplicarán al guardar el formulario.
                    Revisa la información antes de confirmar la actualización.
                </p>
            </div>


            {{-- BOTONES --}}
            <div class="flex flex-col-reverse gap-3 border-t border-white/10 pt-6 sm:flex-row sm:justify-end">

                <a href="{{ route('estados.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/10 px-5 py-3 text-sm font-semibold text-gray-300 transition hover:bg-white/5 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                    </svg>

                    Cancelar
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-500 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-950/20 transition hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 13l4 4L19 7"/>
                    </svg>

                    Guardar cambios
                </button>
            </div>

        </form>
    </div>

    <p class="text-center text-xs text-gray-500">
        Gestión de estados generales
    </p>

</div>
@endsection