@extends('layouts.app')

@section('title')
    Usuarios
@endsection

@section('content')

<div class="container mx-auto px-4 py-6">

    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-3xl font-bold text-white drop-shadow"> // arreglar este color
                Usuarios
            </h1>

            <p class="text-gray-600 mt-1">
                Administración de usuarios del sistema
            </p>
        </div>

        <a
            href="{{ route('usuarios.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-black font-semibold px-5 py-2 rounded-lg shadow transition"
        >
            + Nuevo usuario
        </a>

    </div>


    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-5 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif


    {{-- Mensajes de error --}}
    @if($errors->any())
        <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- Tabla --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100">

                    <tr>

                        <th class="px-6 py-3 text-left text-sm font-bold text-black">
                            ID
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-bold text-black">
                            Nombre
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-bold text-black">
                            Email
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-bold text-black">
                            Teléfono
                        </th>

                        <th class="px-6 py-3 text-left text-sm font-bold text-black">
                            Fecha de registro
                        </th>

                        <th class="px-6 py-3 text-center text-sm font-bold text-black">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @forelse($usuarios as $usuario)

                        <tr class="hover:bg-gray-50">

                            <td class="px-6 py-4 text-gray-700">
                                {{ $usuario->id }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-black">
                                {{ $usuario->nombre }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $usuario->email }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $usuario->telefono ?? 'No registrado' }}
                            </td>

                            <td class="px-6 py-4 text-gray-700">
                                {{ $usuario->created_at?->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-center gap-2">

                                    {{-- Ver --}}
                                    <a
                                        href="{{ route('usuarios.show', $usuario->id) }}"
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm shadow"
                                    >
                                        Ver
                                    </a>

                                    {{-- Editar --}}
                                    <a
                                        href="{{ route('usuarios.edit', $usuario->id) }}"
                                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm shadow"
                                    >
                                        Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <form
                                        action="{{ route('usuarios.destroy', $usuario->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Está seguro de eliminar este usuario?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm shadow"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-8 text-center text-gray-500"
                            >
                                No hay usuarios registrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection