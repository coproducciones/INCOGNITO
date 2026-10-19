@extends('layouts.app')

@section('title', 'Gestión de contenido')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-white">
                Contenidos
            </h1>
            <p class="text-sm text-gray-400">
                Administra la información pública del sistema.
            </p>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('contenido.crear'))
            <a
                href="{{ route('contenidos.create') }}"
                class="inline-flex items-center justify-center rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black transition hover:bg-[#00a87e]"
            >
                + Nuevo contenido
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="rounded-lg border border-green-500/20 bg-green-500/10 px-4 py-3 text-sm text-green-300">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="rounded-lg border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm text-red-300">
            <ul class="list-inside list-disc">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#111111]">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm text-gray-300">
                <thead class="border-b border-white/10 bg-[#1a1a1a] text-xs uppercase tracking-wider text-gray-400">
                    <tr>
                        <th class="px-5 py-4">Título</th>
                        <th class="px-5 py-4">Sección</th>
                        <th class="px-5 py-4">Descripción</th>
                        <th class="px-5 py-4 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-white/5">
                    @forelse($contenidos as $contenido)
                        <tr class= transition hover:bg-white/[0.03]>
                            <td class="px-5 py-4 font-medium text-white">
                                {{ $contenido->titulo }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $contenido->seccion }}
                            </td>

                            <td class="max-w-md px-5 py-4">
                                {{ \Illuminate\Support\Str::limit($contenido->descripcion ?? '', 100) ?: 'Sin descripción' }}
                            </td>

                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                @if(auth()->check() && auth()->user()->tienePermiso('contenido.ver'))
                                    <a
                                        href="{{ route('contenidos.show', $contenido) }}"
                                        class="mr-3 text-gray-300 hover:text-white"
                                    >
                                        Ver
                                    </a>
                                @endif

                                @if(auth()->check() && auth()->user()->tienePermiso('contenido.editar'))
                                    <a
                                        href="{{ route('contenidos.edit', $contenido) }}"
                                        class="mr-3 text-[#00c896] hover:text-[#00e0aa]"
                                    >
                                        Editar
                                    </a>
                                @endif

                                @if(auth()->check() && auth()->user()->tienePermiso('contenido.eliminar'))
                                    <form
                                        method="POST"
                                        action="{{ route('contenidos.destroy', $contenido) }}"
                                        class="inline"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este contenido?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-400 hover:text-red-300"
                                        >
                                            Eliminar
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center">
                                <p class="font-medium text-gray-300">
                                    No hay contenidos registrados.
                                </p>
                                <p class="mt-1 text-sm text-gray-500">
                                    Crea el primer contenido para que pueda asociarse a una multimedia.
                                </p>

                                @if(auth()->check() && auth()->user()->tienePermiso('contenido.crear'))
                                    <a
                                        href="{{ route('contenidos.create') }}"
                                        class="mt-4 inline-flex rounded-lg bg-[#00c896] px-4 py-2 font-semibold text-black hover:bg-[#00a87e]"
                                    >
                                        Crear contenido
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection