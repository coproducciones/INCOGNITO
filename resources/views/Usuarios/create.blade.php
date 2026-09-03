```blade
@extends('layouts.app')

@section('title')
    Nuevo Usuario
@endsection

@section('content')

<div class="container mx-auto px-4 py-6">

    <div class="max-w-2xl mx-auto">

        <h1 class="text-3xl font-bold text-white mb-6">
            Registrar Usuario
        </h1>

        @if($errors->any())
            <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('usuarios.store') }}" method="POST" class="bg-stone-700 rounded-xl shadow-md p-6">

            @csrf

            {{-- Nombre --}}
            <div class="mb-5">
                <label for="nombre" class="block text-sm font-semibold text-white mb-2">
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white"
                    placeholder="Ingrese el nombre"
                    required
                >

                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-white mb-2">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white"
                    placeholder="ejemplo@correo.com"
                    required
                >

                @error('email')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Contraseña --}}
            <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-white mb-2">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white"
                    placeholder="Mínimo 8 caracteres"
                    required
                >

                @error('password')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Confirmar contraseña --}}
            <div class="mb-5">
                <label for="password_confirmation" class="block text-sm font-semibold text-white mb-2">
                    Confirmar contraseña
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white"
                    placeholder="Repita la contraseña"
                    required
                >
            </div>


            {{-- Teléfono --}}
            <div class="mb-6">
                <label for="telefono" class="block text-sm font-semibold text-white mb-2">
                    Teléfono
                </label>

                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono') }}"
                    maxlength="20"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-black bg-white"
                    placeholder="Ingrese el teléfono"
                >

                @error('telefono')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- Botones --}}
            <div class="flex justify-end gap-3">

                <a
                    href="{{ route('usuarios.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-black font-semibold px-5 py-2 rounded-lg"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg"
                >
                    Guardar usuario
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
```
