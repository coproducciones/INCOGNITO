@extends('layouts.app')

@section('title', 'Categorías')

@section('content')

<div class="min-h-screen bg-[#111111] p-4 text-[#F5F3ED] sm:p-6 lg:p-8">

    {{-- ENCABEZADO --}}
    <div class="mb-8 flex flex-col justify-between gap-5 sm:flex-row sm:items-center">

        <div>
            <div class="mb-2 flex items-center gap-3">
                <span class="h-7 w-1 rounded-full bg-gradient-to-b from-[#D8C17F] to-[#A99045]"></span>

                <h1 class="text-xl font-black uppercase tracking-[0.18em] text-[#F5F3ED] sm:text-2xl">
                    CATEGORÍAS
                </h1>
            </div>

            <p class="ml-4 text-[10px] font-bold uppercase tracking-[0.25em] text-white/40 sm:text-xs">
                Gestión de categorías
            </p>
        </div>

        @if(auth()->check() && auth()->user()->tienePermiso('categorias.crear'))

            <a
                href="{{ route('categorias.create') }}"
                class="inline-flex items-center justify-center gap-3 rounded-xl border border-[#D8C17F]/30 bg-gradient-to-r from-[#A99045] to-[#D8C17F] px-5 py-3 text-[10px] font-black uppercase tracking-[0.16em] text-[#111111] shadow-[0_0_20px_rgba(169,144,69,0.10)] transition duration-300 hover:-translate-y-0.5 hover:shadow-[0_0_30px_rgba(169,144,69,0.22)]"
            >
                <span class="text-base leading-none">+</span>
                NUEVA CATEGORÍA
            </a>

        @endif

    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div
            role="status"
            class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-400/25 bg-emerald-400/[0.07] px-4 py-4 text-sm font-medium text-emerald-300"
        >
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
            </svg>

            <p>{{ session('success') }}</p>
        </div>

    @endif

    {{-- MENSAJE DE ERROR --}}
    @if(session('error'))

        <div
            role="alert"
            class="mb-5 flex items-start gap-3 rounded-xl border border-rose-400/25 bg-rose-500/[0.07] px-4 py-4 text-sm font-medium text-rose-300"
        >
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.9 2.6 17.2A2 2 0 0 0 4.3 20h15.4a2 2 0 0 0 1.7-2.8L13.7 3.9a2 2 0 0 0-3.4 0Z" />
            </svg>

            <p>{{ session('error') }}</p>
        </div>

    @endif

    {{-- TABLA --}}
    <div class="overflow-hidden rounded-2xl border border-white/[0.08] bg-[#1D1D1D] shadow-[0_20px_60px_rgba(0,0,0,0.20)]">

        {{-- Cabecera de la tabla --}}
        <div class="flex items-center justify-between border-b border-white/[0.07] px-5 py-5 sm:px-6">
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.18em] text-[#D8C17F]">
                    Categorías registradas
                </h2>

                <p class="mt-1 text-xs text-white/40">
                    Administración y organización de categorías
                </p>
            </div>

            <div class="hidden h-10 w-10 items-center justify-center rounded-xl border border-[#A99045]/20 bg-[#A99045]/[0.07] text-[#D8C17F] sm:flex">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h7v5H4zM13 6h7v5h-7zM4 13h7v5H4zM13 13h7v5h-7z" />
                </svg>
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full min-w-[700px]">

                <thead>
                    <tr class="border-b border-white/[0.08] bg-[#151515]">

                        <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[0.18em] text-[#D8C17F]/80">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[0.18em] text-[#D8C17F]/80">
                            Nombre
                        </th>

                        <th class="px-6 py-4 text-left text-[10px] font-black uppercase tracking-[0.18em] text-[#D8C17F]/80">
                            Descripción
                        </th>

                        <th class="px-6 py-4 text-center text-[10px] font-black uppercase tracking-[0.18em] text-[#D8C17F]/80">
                            Acciones
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($categorias as $categoria)

                        <tr class="border-b border-white/[0.05] transition-colors duration-200 hover:bg-[#A99045]/[0.04]">

                            {{-- ID --}}
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center rounded-lg border border-white/[0.08] bg-[#111111] px-2.5 py-1 text-xs font-bold text-white/45">
                                    #{{ $categoria->id }}
                                </span>
                            </td>

                            {{-- Nombre --}}
                            <td class="px-6 py-5">
                                <span class="text-sm font-bold text-[#F5F3ED]">
                                    {{ $categoria->nombre }}
                                </span>
                            </td>

                            {{-- Descripción --}}
                            <td class="px-6 py-5">
                                <span class="text-xs leading-6 text-white/55">
                                    {{ $categoria->descripcion ?: 'Sin descripción' }}
                                </span>
                            </td>

                            {{-- Acciones --}}
                            <td class="px-6 py-5">

                                <div class="flex items-center justify-center gap-2">

                                    {{-- VER --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('categorias.ver'))

                                        <a
                                            href="{{ route('categorias.show', $categoria) }}"
                                            class="inline-flex min-w-[60px] items-center justify-center rounded-lg border border-white/10 bg-white/[0.02] px-3 py-2 text-[9px] font-black uppercase tracking-wider text-white/65 transition duration-200 hover:border-white/25 hover:bg-white/[0.06] hover:text-white"
                                        >
                                            VER
                                        </a>

                                    @endif

                                    {{-- EDITAR --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('categorias.editar'))

                                        <a
                                            href="{{ route('categorias.edit', $categoria) }}"
                                            class="inline-flex min-w-[60px] items-center justify-center rounded-lg border border-[#A99045]/30 bg-[#A99045]/[0.06] px-3 py-2 text-[9px] font-black uppercase tracking-wider text-[#D8C17F] transition duration-200 hover:border-[#D8C17F]/50 hover:bg-[#A99045]/[0.14]"
                                        >
                                            EDITAR
                                        </a>

                                    @endif

                                    {{-- ELIMINAR --}}
                                    @if(auth()->check() && auth()->user()->tienePermiso('categorias.eliminar'))

                                        <form
                                            action="{{ route('categorias.destroy', $categoria) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar esta categoría?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex min-w-[75px] items-center justify-center rounded-lg border border-rose-400/25 bg-rose-500/[0.04] px-3 py-2 text-[9px] font-black uppercase tracking-wider text-rose-300 transition duration-200 hover:border-rose-400/50 hover:bg-rose-500/[0.12]"
                                            >
                                                ELIMINAR
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-14 text-center"
                            >
                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl border border-[#A99045]/20 bg-[#A99045]/[0.06] text-[#D8C17F]/70">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h7v5H4zM13 6h7v5h-7zM4 13h7v5H4zM13 13h7v5h-7z" />
                                        </svg>
                                    </div>

                                    <p class="text-xs font-black uppercase tracking-[0.18em] text-white/45">
                                        NO HAY CATEGORÍAS REGISTRADAS.
                                    </p>

                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pie de tabla --}}
        <div class="border-t border-white/[0.06] bg-[#151515]/70 px-5 py-3 sm:px-6">
            <p class="text-[10px] font-medium uppercase tracking-[0.12em] text-white/30">
                Incógnito · Group Design
            </p>
        </div>

    </div>

</div>

@endsection