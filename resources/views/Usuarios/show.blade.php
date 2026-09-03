@extends('layouts.app')

@section('title')
    Ver Usuario
@endsection

@section('content')

<div class="container mx-auto px-4 py-6">

    <div class="max-w-2xl mx-auto">

        {{-- Encabezado --}}
        <div class="mb-6">

            <h1 class="text-3xl font-bold text-black drop-shadow">
                Información del usuario
            </h1>

            <p class="text-gray-600 mt-1">
                Detalles del usuario seleccionado.
            </p>

        </div>


        {{-- Información --}}
        <div class="bg-white rounded-xl shadow-md p-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- ID --}}
                <div>
                    <p class="text-sm text-gray-500">
                        ID
                    </p>

                    <p class="text-lg font-semibold text-black">
                        {{ $usuario->id }}
                    </p>
                </div>


                {{-- Nombre --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Nombre
                    </p>

                    <p class="text-lg font-semibold text-black">
                        {{ $usuario->nombre }}
                    </p>
                </div>


                {{-- Email --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Correo electrónico
                    </p>

                    <p class="text-lg font-semibold text-black">
                        {{ $usuario->email }}
                    </p>
                </div>


                {{-- Teléfono --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Teléfono
                    </p>

                    <p class="text-lg font-semibold text-black">
                        {{ $usuario->telefono ?? 'No registrado' }}
                    </p>
                </div>


                {{-- Fecha de creación --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Fecha de registro
                    </p>

                    <p class="text-lg font-semibold text-black">
                        {{ $usuario->created_at?->format('d/m/Y H:i') }}
                    </p>
                </div>


                {{-- Última actualización --}}
                <div>
                    <p class="text-sm text-gray-500">
                        Última actualización
                    </p>

                    <p class="text-lg font-semibold text-black">
                        {{ $usuario->updated_at?->format('d/m/Y H:i') }}
                    </p>
                </div>

            </div>


            {{-- Botones --}}
            <div class="flex justify-end gap-3 mt-8">

                <a
                    href="{{ route('usuarios.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-5 py-2 rounded-lg shadow"
                >
                    Volver
                </a>

                <a
                    href="{{ route('usuarios.edit', $usuario->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg shadow"
                >
                    Editar
                </a>

            </div>

        </div>

    </div>

</div>

@endsection