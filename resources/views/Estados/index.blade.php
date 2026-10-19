@extends('layouts.app')

@section('title', 'Estados generales')

@section('content')
<div class="min-h-screen space-y-8 pb-10">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/20">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="1.8">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">
                    Estados generales
                </h1>

                <p class="mt-1 text-sm text-gray-400">
                    Administra y organiza los estados del sistema.
                </p>
            </div>
        </div>

        <a href="{{ route('estados.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-950/20 transition duration-200 hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 focus:ring-offset-gray-950">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Nuevo estado
        </a>
    </div>


    {{-- NOTIFICACIONES --}}
    @if (session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-emerald-300"
             role="status">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <div>
                <p class="font-semibold">Operación exitosa</p>
                <p class="mt-1 text-sm text-emerald-200/80">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-red-300"
             role="alert">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z"/>
            </svg>

            <div>
                <p class="font-semibold">No se pudo completar la operación</p>
                <p class="mt-1 text-sm text-red-200/80">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif


    {{-- RESUMEN --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

        <div class="rounded-2xl border border-white/10 bg-gray-900/70 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">
                        Total de estados
                    </p>

                    <p class="mt-2 text-3xl font-bold text-white">
                        {{ $estados->count() }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Registros cargados en esta vista
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-white/10 bg-gray-900/70 p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">
                        Estado del módulo
                    </p>

                    <p class="mt-2 text-xl font-bold text-white">
                        {{ $estados->isEmpty() ? 'Sin registros' : 'Disponible' }}
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        {{ $estados->isEmpty()
                            ? 'Puedes comenzar creando un estado.'
                            : 'Puedes administrar tus registros.' }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 3a11.955 11.955 0 01-8.618 2.984A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.042-.133-2.053-.382-3.016z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>


    {{-- TABLA --}}
    <div class="overflow-hidden rounded-2xl border border-white/10 bg-gray-900/70 shadow-xl shadow-black/10">

        {{-- CABECERA DE LA TABLA --}}
        <div class="flex flex-col gap-2 border-b border-white/10 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-lg font-semibold text-white">
                    Listado de estados
                </h2>

                <p class="mt-1 text-sm text-gray-400">
                    Consulta, modifica o elimina los estados registrados.
                </p>
            </div>

            <span class="inline-flex w-fit items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-gray-300">
                <span class="h-2 w-2 rounded-full {{ $estados->isEmpty() ? 'bg-gray-500' : 'bg-emerald-400' }}"></span>
                {{ $estados->count() }} {{ $estados->count() === 1 ? 'registro' : 'registros' }}
            </span>
        </div>


        {{-- CONTENIDO --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[600px] text-left">

                <thead class="bg-white/[0.03]">
                    <tr class="border-b border-white/10">

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                            #
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Tipo
                        </th>

                        <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Nombre del estado
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-400">
                            Acciones
                        </th>

                    </tr>
                </thead>

                <tbody class="divide-y divide-white/5">

                    @forelse ($estados as $estado)

                        <tr class="transition duration-150 hover:bg-white/[0.03]">

                            {{-- IDENTIFICADOR VISUAL --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="text-sm font-medium text-gray-500">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            {{-- TIPO --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-lg border border-blue-400/20 bg-blue-400/10 px-3 py-1.5 text-xs font-semibold text-blue-300">
                                    {{ $estado->tipo }}
                                </span>
                            </td>

                            {{-- NOMBRE --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500/20 to-teal-500/10 text-sm font-bold text-emerald-300 ring-1 ring-emerald-500/10">
                                        {{ \Illuminate\Support\Str::upper(
                                            \Illuminate\Support\Str::substr(
                                                $estado->nombre, 0, 1
                                            )
                                        ) }}
                                    </div>

                                    <div>
                                        <p class="font-medium text-gray-100">
                                            {{ $estado->nombre }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-gray-500">
                                            Estado general
                                        </p>
                                    </div>

                                </div>
                            </td>

                            {{-- ACCIONES --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- EDITAR --}}
                                    <a
                                        href="{{ route('estados.edit', $estado) }}"
                                        title="Editar estado"
                                        aria-label="Editar estado {{ $estado->nombre }}"
                                        class="inline-flex items-center gap-2 rounded-lg border border-emerald-500/20 bg-emerald-500/10 px-3 py-2 text-xs font-semibold text-emerald-300 transition hover:border-emerald-500/40 hover:bg-emerald-500/20 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
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

                                        Editar
                                    </a>


                                    {{-- ELIMINAR --}}
                                    <form
                                        method="POST"
                                        action="{{ route('estados.destroy', $estado) }}"
                                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar el estado {{ addslashes($estado->nombre) }}? Esta acción no se puede deshacer.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            title="Eliminar estado"
                                            aria-label="Eliminar estado {{ $estado->nombre }}"
                                            class="inline-flex items-center gap-2 rounded-lg border border-red-500/20 bg-red-500/10 px-3 py-2 text-xs font-semibold text-red-300 transition hover:border-red-500/40 hover:bg-red-500/20 focus:outline-none focus:ring-2 focus:ring-red-500"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M6 7h12m-10 0V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0l-.7 12H8.7L8 7m3 3v6m3-6v6"/>
                                            </svg>

                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        {{-- ESTADO VACÍO --}}
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/[0.03] text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-8 w-8"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.5">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>

                                <h3 class="mt-5 text-base font-semibold text-white">
                                    No hay estados registrados
                                </h3>

                                <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-400">
                                    Todavía no tienes estados generales. Crea el primero para comenzar a organizar tus registros.
                                </p>

                                <a
                                    href="{{ route('estados.create') }}"
                                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-400"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M12 4v16m8-8H4"/>
                                    </svg>

                                    Crear primer estado
                                </a>

                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- PIE DE TABLA --}}
        @if ($estados->isNotEmpty())
            <div class="flex flex-col gap-2 border-t border-white/10 bg-white/[0.02] px-6 py-4 text-xs text-gray-500 sm:flex-row sm:items-center sm:justify-between">
                <p>
                    Mostrando {{ $estados->count() }}
                    {{ $estados->count() === 1 ? 'estado' : 'estados' }}
                    en esta vista.
                </p>

                <p>
                    Gestión de estados generales
                </p>
            </div>
        @endif

    </div>

</div>
@endsection