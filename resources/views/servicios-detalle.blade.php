
@extends('layouts.app')

@section('title', $producto->nombre . ' - Servicios')

@section('content')

@php
    $whatsappMensaje = 'Hola, Incógnito Group Design. Estoy interesado en el producto: '
        . $producto->nombre;

    $whatsapp = 'https://wa.me/573114531914?text='
        . urlencode($whatsappMensaje);

    $categoriaNombre = $producto->categoria->nombre ?? 'Categoría general';

    $precio = number_format((float) $producto->precio, 0, ',', '.');
@endphp

<div class="min-h-screen bg-[#111111] text-[#F5F3ED]">

    {{-- ENCABEZADO --}}
    <section class="relative overflow-hidden border-b border-white/10 bg-[#151515]">

        <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-[#A99045]/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-5 py-10 sm:px-8">

            <a
                href="{{ route('servicios') }}"
                class="inline-flex items-center gap-2 text-sm text-[#D8C17F] transition hover:text-white"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="m15 18-6-6 6-6"/>
                </svg>

                Volver a servicios
            </a>

            <p class="mt-8 text-xs font-bold uppercase tracking-[0.3em] text-[#A99045]">
                INCÓGNITO GROUP DESIGN
            </p>

            <h1 class="mt-3 text-3xl font-black uppercase tracking-tight sm:text-5xl">
                Detalles del producto
            </h1>

            <div class="mt-5 h-1 w-16 bg-[#A99045]"></div>

            <p class="mt-5 max-w-2xl text-sm leading-7 text-gray-400">
                Conoce las características de nuestros productos y contáctanos
                para recibir asesoría personalizada.
            </p>

        </div>
    </section>


    {{-- DETALLE DEL PRODUCTO --}}
    <section class="mx-auto max-w-7xl px-5 py-12 sm:px-8 lg:py-16">

        <div class="grid gap-10 lg:grid-cols-2 lg:gap-16">

            {{-- IMAGEN Y PRESENTACIÓN --}}
            <div class="relative flex min-h-[320px] items-center justify-center overflow-hidden rounded-2xl border border-white/10 bg-[#1D1D1D] p-8 sm:min-h-[460px]">

                <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(169,144,69,0.12),transparent_65%)]"></div>

                <div class="relative text-center">

                    <div class="mx-auto flex h-28 w-28 items-center justify-center rounded-full border border-[#A99045]/40 bg-[#A99045]/10">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-14 w-14 text-[#D8C17F]"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.1"
                        >
                            <path d="M3 7.5 12 3l9 4.5v9L12 21l-9-4.5z"/>
                            <path d="m3 7.5 9 4.5 9-4.5M12 12v9M7.5 5.25l9 4.5"/>
                        </svg>

                    </div>

                    <p class="mt-6 text-xs font-bold uppercase tracking-[0.3em] text-[#A99045]">
                        Nuestro catálogo
                    </p>

                    <p class="mt-2 text-sm text-gray-400">
                        {{ $categoriaNombre }}
                    </p>

                </div>

                <span class="absolute left-5 top-5 rounded-full border border-white/10 bg-black/30 px-4 py-2 text-[10px] font-bold uppercase tracking-widest text-[#D8C17F]">
                    Referencia #{{ $producto->id }}
                </span>

                <span class="absolute right-5 top-5 rounded-full border border-white/10 bg-black/30 px-4 py-2 text-[10px] font-bold uppercase tracking-widest {{ $producto->stock > 0 ? 'text-emerald-400' : 'text-red-400' }}">
                    {{ $producto->stock > 0 ? 'Disponible' : 'Agotado' }}
                </span>

            </div>


            {{-- INFORMACIÓN DEL PRODUCTO --}}
            <div class="flex flex-col justify-center">

                <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#A99045]">
                    {{ $categoriaNombre }}
                </p>

                <h2 class="mt-4 break-words text-3xl font-black uppercase leading-tight sm:text-4xl">
                    {{ $producto->nombre }}
                </h2>

                <div class="mt-5 h-1 w-16 bg-[#A99045]"></div>


                {{-- PRECIO --}}
                <div class="mt-7">

                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">
                        Precio
                    </p>

                    <p class="mt-2 text-3xl font-extrabold text-[#D8C17F]">
                        ${{ $precio }}

                        <span class="text-sm font-medium text-gray-400">
                            COP
                        </span>
                    </p>

                </div>


                {{-- DESCRIPCIÓN --}}
                <div class="mt-8 border-t border-white/10 pt-6">

                    <h3 class="text-sm font-bold uppercase tracking-widest text-white">
                        Descripción
                    </h3>

                    <p class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-300">{{ $producto->descripcion ?: 'Contáctanos para conocer más detalles sobre este producto y sus características.' }}</p>

                </div>


                {{-- DISPONIBILIDAD Y EXISTENCIAS --}}
                <div class="mt-7 grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div class="rounded-xl border border-white/10 bg-[#1D1D1D] p-4">

                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            Disponibilidad
                        </p>

                        @if ($producto->stock > 0)

                            <p class="mt-2 flex items-center gap-2 text-sm font-bold text-emerald-400">
                                <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                                Disponible
                            </p>

                        @else

                            <p class="mt-2 flex items-center gap-2 text-sm font-bold text-red-400">
                                <span class="h-2 w-2 rounded-full bg-red-400"></span>
                                Agotado
                            </p>

                        @endif

                    </div>


                    <div class="rounded-xl border border-white/10 bg-[#1D1D1D] p-4">

                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                            Existencias
                        </p>

                        <p class="mt-2 text-sm font-bold text-white">
                            {{ $producto->stock }}
                            {{ $producto->stock == 1 ? 'unidad' : 'unidades' }}
                        </p>

                    </div>

                </div>


                {{-- BOTONES DE ACCIÓN --}}
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    {{-- WHATSAPP --}}
                    <a
                        href="{{ $whatsapp }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex flex-1 items-center justify-center gap-3 rounded-lg bg-[#A99045] px-6 py-4 text-center text-xs font-extrabold uppercase tracking-widest text-black transition hover:bg-[#D8C17F]"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path d="M20.52 3.48A11.86 11.86 0 0 0 12.08 0C5.5 0 .15 5.35.15 11.93c0 2.1.55 4.15 1.6 5.96L.05 24l6.27-1.64a11.9 11.9 0 0 0 5.76 1.47h.01c6.58 0 11.93-5.35 11.93-11.93 0-3.19-1.24-6.19-3.5-8.42ZM12.08 21.8a9.86 9.86 0 0 1-5.02-1.37l-.36-.21-3.72.98.99-3.63-.24-.37a9.82 9.82 0 0 1-1.51-5.27c0-5.45 4.43-9.88 9.88-9.88a9.8 9.8 0 0 1 6.99 2.9 9.8 9.8 0 0 1 2.89 6.99c0 5.45-4.43 9.86-9.9 9.86Zm5.42-7.39c-.3-.15-1.77-.87-2.04-.97-.28-.1-.48-.15-.68.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.26-.46-2.4-1.47-.88-.79-1.47-1.76-1.64-2.06-.17-.3-.02-.46.13-.61.14-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.68-1.63-.93-2.23-.24-.58-.49-.5-.68-.51h-.58c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.5s1.07 2.9 1.22 3.1c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.5 1.69.64.71.22 1.36.19 1.87.11.57-.08 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"/>
                        </svg>

                        Consultar por WhatsApp

                    </a>


                    {{-- VOLVER AL CATÁLOGO --}}
                    <a
                        href="{{ route('servicios') }}"
                        class="inline-flex items-center justify-center rounded-lg border border-white/15 px-6 py-4 text-xs font-bold uppercase tracking-widest text-white transition hover:border-[#A99045] hover:text-[#D8C17F]"
                    >
                        Ver catálogo
                    </a>

                </div>


                {{-- MENSAJE FINAL --}}
                <p class="mt-5 text-xs leading-6 text-gray-500">
                    ¿Tienes preguntas? Escríbenos para recibir asesoría personalizada sobre este producto.
                </p>

            </div>

        </div>

    </section>

</div>

@endsection
