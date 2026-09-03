@extends('layouts.app')

@section('title')
    Editar Usuario
@endsection

@section('content')

<div class="container mx-auto px-4 py-6">

    <div class="max-w-2xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-white drop-shadow">
                Editar usuario
            </h1>

            <p class="text-gray-600 mt-1">
                Modifique la información del usuario.
            </p>

        </div>


        {{-- Errores --}}
        @if($errors->any())

            <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <ul class="list-disc list-inside">

                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Formulario --}}
        <form
            action="{{ route('usuarios.update', $usuario->id) }}"
            method="POST"
            class="bg-white rounded-xl shadow-md p-6"
        >

            @csrf
            @method('PUT')


            {{-- Nombre --}}
            <div class="mb-5">

                <label
                    for="nombre"
                    class="block text-sm font-semibold text-black mb-2"
                >
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre', $usuario->nombre) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-black bg-white"
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

                <label
                    for="email"
                    class="block text-sm font-semibold text-black mb-2"
                >
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $usuario->email) }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-black bg-white"
                    required
                >

                @error('email')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Nueva contraseña --}}
            <div class="mb-5">

                <label
                    for="password"
                    class="block text-sm font-semibold text-black mb-2 text-black bg-white"
                >
                    Nueva contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-black bg-white"
                    placeholder="Déjelo vacío para conservar la actual"
                >

                @error('password')
                    <p class="text-red-600 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Confirmar nueva contraseña --}}
            <div class="mb-5">

                <label
                    for="password_confirmation"
                    class="block text-sm font-semibold text-black mb-2"
                >
                    Confirmar nueva contraseña
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-black bg-white"
                    placeholder="Repita la nueva contraseña"
                >

            </div>


            {{-- Teléfono --}}
            <div class="mb-6">

                <label
                    for="telefono"
                    class="block text-sm font-semibold text-black mb-2"
                >
                    Teléfono
                </label>

                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono', $usuario->telefono) }}"
                    maxlength="20"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none text-black bg-white"
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
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-2 rounded-lg shadow"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg shadow"
                >
                    Actualizar usuario
                </button>

            </div>

        </form>

    </div>

</div>

@endsection