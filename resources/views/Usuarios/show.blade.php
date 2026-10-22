@extends('layouts.app')

@section('title')
    Ver Usuario
@endsection

@section('content')

<div class="container mx-auto px-4 py-8">

    <div class="max-w-2xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">

            <h1 class="text-2xl font-black uppercase tracking-widest text-white">
                Información del usuario
            </h1>

            <div class="mt-3 h-[3px] w-[60px] rounded-full"
                 style="background-color: #A99045;"></div>

            <p class="mt-3 text-sm text-gray-400">
                Detalles del usuario seleccionado.
            </p>

        </div>

        {{-- Información --}}
        <div class="rounded-2xl border p-6 shadow-xl sm:p-8"
             style="background-color: #111111; border-color: rgba(169, 144, 69, 0.35);">

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- ID --}}
                <div class="rounded-xl border p-4"
                     style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.08);">

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest"
                       style="color: #D8C17F;">
                        ID
                    </p>

                    <p class="break-words text-lg font-semibold text-white">
                        {{ $usuario->id }}
                    </p>

                </div>

                {{-- Nombre --}}
                <div class="rounded-xl border p-4"
                     style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.08);">

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest"
                       style="color: #D8C17F;">
                        Nombre
                    </p>

                    <p class="break-words text-lg font-semibold text-white">
                        {{ $usuario->nombre }}
                    </p>

                </div>

                {{-- Email --}}
                <div class="rounded-xl border p-4"
                     style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.08);">

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest"
                       style="color: #D8C17F;">
                        Correo electrónico
                    </p>

                    <p class="break-words text-lg font-semibold text-white">
                        {{ $usuario->email }}
                    </p>

                </div>

                {{-- Teléfono --}}
                <div class="rounded-xl border p-4"
                     style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.08);">

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest"
                       style="color: #D8C17F;">
                        Teléfono
                    </p>

                    <p class="break-words text-lg font-semibold text-white">
                        {{ $usuario->telefono ?? 'No registrado' }}
                    </p>

                </div>

                {{-- Fecha de creación --}}
                <div class="rounded-xl border p-4"
                     style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.08);">

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest"
                       style="color: #D8C17F;">
                        Fecha de registro
                    </p>

                    <p class="break-words text-lg font-semibold text-white">
                        {{ $usuario->created_at?->format('d/m/Y H:i') }}
                    </p>

                </div>

                {{-- Última actualización --}}
                <div class="rounded-xl border p-4"
                     style="background-color: #1D1D1D; border-color: rgba(255, 255, 255, 0.08);">

                    <p class="mb-2 text-xs font-bold uppercase tracking-widest"
                       style="color: #D8C17F;">
                        Última actualización
                    </p>

                    <p class="break-words text-lg font-semibold text-white">
                        {{ $usuario->updated_at?->format('d/m/Y H:i') }}
                    </p>

                </div>

            </div>

            {{-- Botones --}}
            <div class="mt-8 flex flex-col-reverse justify-end gap-3 border-t pt-6 sm:flex-row"
                 style="border-color: rgba(255, 255, 255, 0.08);">

                <a href="{{ route('usuarios.index') }}"
                   class="rounded-lg border px-5 py-3 text-center text-sm font-bold text-gray-200 transition hover:bg-white/5"
                   style="border-color: #444444;">
                    Volver
                </a>

                {{-- Nivel 2: editar usuario --}}
                @if(auth()->check() && auth()->user()->tienePermiso('usuarios.editar'))

                    <a href="{{ route('usuarios.edit', $usuario->id) }}"
                       class="rounded-lg px-5 py-3 text-center text-sm font-black transition hover:brightness-110"
                       style="background-color: #A99045; color: #111111;">
                        Editar
                    </a>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection