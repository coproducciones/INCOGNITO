@extends('layouts.app')

@section('title')
    Usuarios
@endsection

@section('content')

<div class="container mx-auto px-4 py-8">

    {{-- Encabezado --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-black uppercase tracking-widest text-white">
                Usuarios
            </h1>

            <div class="mt-3 h-[3px] w-[60px] rounded-full"
                 style="background-color: #A99045;"></div>

            <p class="mt-3 text-sm text-gray-400">
                Administración de usuarios del sistema
            </p>

        </div>

        {{-- Nivel 2: crear usuario --}}
        @if(auth()->check() && auth()->user()->tienePermiso('usuarios.crear'))

            <a href="{{ route('usuarios.create') }}"
               class="inline-flex items-center justify-center rounded-lg px-5 py-3 text-sm font-black transition hover:brightness-110"
               style="background-color: #A99045; color: #111111;">
                + Nuevo usuario
            </a>

        @endif

    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))

        <div class="mb-6 rounded-xl border px-5 py-4 text-sm font-medium"
             style="background-color: #14251C; border-color: #286343; color: #86EFAC;">
            {{ session('success') }}
        </div>

    @endif

    {{-- Mensajes de error --}}
    @if($errors->any())

        <div class="mb-6 rounded-xl border px-5 py-4"
             style="background-color: #2A1717; border-color: #7F3030; color: #FCA5A5;">

            <ul class="list-disc list-inside space-y-1 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    {{-- Tabla --}}
    <div class="overflow-hidden rounded-2xl border shadow-xl"
         style="background-color: #111111; border-color: rgba(169, 144, 69, 0.35);">

        <div class="overflow-x-auto">

            <table class="w-full min-w-[900px] text-left">

                <thead style="background-color: #1D1D1D;">

                    <tr class="border-b"
                        style="border-color: rgba(169, 144, 69, 0.35);">

                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest"
                            style="color: #D8C17F;">
                            ID
                        </th>

                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest"
                            style="color: #D8C17F;">
                            Nombre
                        </th>

                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest"
                            style="color: #D8C17F;">
                            Email
                        </th>

                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest"
                            style="color: #D8C17F;">
                            Teléfono
                        </th>

                        <th class="px-6 py-4 text-xs font-black uppercase tracking-widest"
                            style="color: #D8C17F;">
                            Fecha de registro
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-black uppercase tracking-widest"
                            style="color: #D8C17F;">
                            Acciones
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y"
                       style="color: #E5E5E5; border-color: rgba(255, 255, 255, 0.08);">

                    @forelse($usuarios as $usuario)

                        <tr class="transition-colors hover:bg-white/[0.03]">

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-400">
                                {{ $usuario->id }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm font-bold text-white">
                                {{ $usuario->nombre }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-300">
                                {{ $usuario->email }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-300">
                                {{ $usuario->telefono ?? 'No registrado' }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-400">
                                {{ $usuario->created_at?->format('d/m/Y H:i') }}
                            </td>

                            <td class="px-6 py-4">

                                <div class="flex flex-wrap justify-center gap-2">

                                    {{-- Ver --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('usuarios.ver'))

                                        <a href="{{ route('usuarios.show', $usuario->id) }}"
                                           class="rounded-lg border px-3 py-2 text-sm font-bold transition hover:brightness-125"
                                           style="background-color: #252525; border-color: #444444; color: #E5E5E5;">
                                            Ver
                                        </a>

                                    @endif

                                    {{-- Editar --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('usuarios.editar'))

                                        <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                           class="rounded-lg px-3 py-2 text-sm font-bold transition hover:brightness-110"
                                           style="background-color: #A99045; color: #111111;">
                                            Editar
                                        </a>

                                    @endif

                                    {{-- Eliminar --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('usuarios.eliminar'))

                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('¿Está seguro de eliminar este usuario?');">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg border px-3 py-2 text-sm font-bold transition hover:brightness-125"
                                                    style="background-color: #3A1919; border-color: #7F3030; color: #FCA5A5;">
                                                Eliminar
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="px-6 py-10 text-center text-sm text-gray-400">
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
