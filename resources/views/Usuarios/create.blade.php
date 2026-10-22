@extends('layouts.app')

@section('title')
    Nuevo Usuario
@endsection

@section('content')

<div class="container mx-auto px-4 py-8">

    <div class="max-w-2xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-8">
            <h1 class="text-2xl font-black uppercase tracking-widest text-white">
                Registrar Usuario
            </h1>

            <div class="mt-3 h-[3px] w-[60px] rounded-full"
                 style="background-color: #A99045;"></div>
        </div>

        {{-- Errores generales --}}
        @if($errors->any())

            <div class="mb-6 rounded-xl border px-5 py-4"
                 style="background-color: #2A1717; border-color: #7F3030; color: #FCA5A5;">

                <p class="mb-2 text-sm font-bold">
                    Se encontraron algunos errores:
                </p>

                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif

        {{-- Formulario --}}
        <form action="{{ route('usuarios.store') }}"
              method="POST"
              class="rounded-2xl border p-6 shadow-xl sm:p-8"
              style="background-color: #111111; border-color: rgba(169, 144, 69, 0.35);">

            @csrf

            {{-- Nombre --}}
            <div class="mb-6">

                <label for="nombre"
                       class="mb-2 block text-sm font-bold tracking-wide text-gray-200">
                    Nombre
                </label>

                <input type="text"
                       id="nombre"
                       name="nombre"
                       value="{{ old('nombre') }}"
                       class="w-full rounded-lg border px-4 py-3 text-white outline-none transition focus:ring-2"
                       style="background-color: #1D1D1D; border-color: #3A3A3A; --tw-ring-color: #A99045;"
                       placeholder="Ingrese el nombre"
                       required>

                @error('nombre')
                    <p class="mt-2 text-sm" style="color: #F87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Email --}}
            <div class="mb-6">

                <label for="email"
                       class="mb-2 block text-sm font-bold tracking-wide text-gray-200">
                    Correo electrónico
                </label>

                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       class="w-full rounded-lg border px-4 py-3 text-white outline-none transition focus:ring-2"
                       style="background-color: #1D1D1D; border-color: #3A3A3A; --tw-ring-color: #A99045;"
                       placeholder="ejemplo@correo.com"
                       required>

                @error('email')
                    <p class="mt-2 text-sm" style="color: #F87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Contraseña --}}
            <div class="mb-6">

                <label for="password"
                       class="mb-2 block text-sm font-bold tracking-wide text-gray-200">
                    Contraseña
                </label>

                <input type="password"
                       id="password"
                       name="password"
                       class="w-full rounded-lg border px-4 py-3 text-white outline-none transition focus:ring-2"
                       style="background-color: #1D1D1D; border-color: #3A3A3A; --tw-ring-color: #A99045;"
                       placeholder="Mínimo 8 caracteres"
                       required>

                @error('password')
                    <p class="mt-2 text-sm" style="color: #F87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Confirmar contraseña --}}
            <div class="mb-6">

                <label for="password_confirmation"
                       class="mb-2 block text-sm font-bold tracking-wide text-gray-200">
                    Confirmar contraseña
                </label>

                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       class="w-full rounded-lg border px-4 py-3 text-white outline-none transition focus:ring-2"
                       style="background-color: #1D1D1D; border-color: #3A3A3A; --tw-ring-color: #A99045;"
                       placeholder="Repita la contraseña"
                       required>

            </div>

            {{-- Teléfono --}}
            <div class="mb-8">

                <label for="telefono"
                       class="mb-2 block text-sm font-bold tracking-wide text-gray-200">
                    Teléfono
                </label>

                <input type="text"
                       id="telefono"
                       name="telefono"
                       value="{{ old('telefono') }}"
                       maxlength="20"
                       class="w-full rounded-lg border px-4 py-3 text-white outline-none transition focus:ring-2"
                       style="background-color: #1D1D1D; border-color: #3A3A3A; --tw-ring-color: #A99045;"
                       placeholder="Ingrese el teléfono">

                @error('telefono')
                    <p class="mt-2 text-sm" style="color: #F87171;">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Botones --}}
            <div class="flex flex-col-reverse justify-end gap-3 border-t pt-6 sm:flex-row"
                 style="border-color: rgba(255, 255, 255, 0.08);">

                <a href="{{ route('usuarios.index') }}"
                   class="rounded-lg border px-5 py-3 text-center text-sm font-bold text-gray-200 transition hover:bg-white/5"
                   style="border-color: #444444;">
                    Cancelar
                </a>

                {{-- Nivel 2: crear usuario --}}
                @if(auth()->check() && auth()->user()->tienePermiso('usuarios.crear'))

                    <button type="submit"
                            class="rounded-lg px-5 py-3 text-sm font-black transition hover:brightness-110"
                            style="background-color: #A99045; color: #111111;">
                        Guardar usuario
                    </button>

                @endif

            </div>

        </form>

    </div>

</div>

@endsection
