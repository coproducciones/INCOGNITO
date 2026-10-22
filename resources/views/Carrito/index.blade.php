@extends('layouts.app')

@section('title', 'Mi carrito')

@section('content')

<div class="min-h-screen bg-[#111111] text-[#F5F3ED]">

    {{-- ENCABEZADO --}}
    <section class="relative overflow-hidden border-b border-white/10 bg-[#151515]">

        {{-- EFECTO DECORATIVO --}}
        <div class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-[#A99045]/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-5 py-10 sm:px-8">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#A99045]">
                        Mi compra
                    </p>

                    <h1 class="mt-3 text-3xl font-black uppercase tracking-tight sm:text-5xl">
                        Carrito de compras
                    </h1>

                    <div class="mt-5 h-1 w-16 bg-[#A99045]"></div>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-gray-400">
                        Revisa los productos antes de confirmar tu pedido.
                    </p>
                </div>

                <a
                    href="{{ route('productos.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/15 px-5 py-3 text-xs font-bold uppercase tracking-widest text-white transition hover:border-[#A99045] hover:text-[#D8C17F]"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>

                    Seguir comprando
                </a>

            </div>

        </div>
    </section>


    {{-- CONTENIDO DEL CARRITO --}}
    <section class="mx-auto max-w-7xl px-5 py-10 sm:px-8 lg:py-14">

        {{-- MENSAJE DE ÉXITO --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 rounded-xl border border-[#A99045]/30 bg-[#A99045]/10 px-5 py-4 text-sm leading-6 text-[#D8C17F]">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="mt-0.5 h-5 w-5 shrink-0"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="2">
                    <path d="m5 12 4 4L19 6"/>
                </svg>

                <span>{{ session('success') }}</span>
            </div>
        @endif


        {{-- MENSAJES DE VALIDACIÓN --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4 text-sm text-red-200">

                <p class="mb-2 font-bold uppercase tracking-widest">
                    Revisa la siguiente información
                </p>

                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- CARRITO VACÍO --}}
        @if($items->isEmpty())

            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-[#1D1D1D] px-6 py-14 text-center sm:px-10">

                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(169,144,69,0.10),transparent_65%)]"></div>

                <div class="relative">

                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full border border-[#A99045]/40 bg-[#A99045]/10">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-11 w-11 text-[#D8C17F]"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.5">
                            <path d="M3 3h2l2.4 12.2a2 2 0 0 0 2 1.6h8.8a2 2 0 0 0 2-1.6L22 7H6"/>
                            <circle cx="10" cy="21" r="1"/>
                            <circle cx="19" cy="21" r="1"/>
                        </svg>

                    </div>

                    <p class="mt-6 text-xs font-bold uppercase tracking-[0.3em] text-[#A99045]">
                        Mi compra
                    </p>

                    <h2 class="mt-3 text-2xl font-black uppercase tracking-tight">
                        Tu carrito está vacío
                    </h2>

                    <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-gray-400">
                        Agrega productos para comenzar a crear tu pedido.
                    </p>

                    <a
                        href="{{ route('productos.index') }}"
                        class="mt-7 inline-flex items-center justify-center gap-2 rounded-lg bg-[#A99045] px-6 py-4 text-xs font-extrabold uppercase tracking-widest text-black transition hover:bg-[#D8C17F]"
                    >
                        Ver productos

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M5 12h14m-7-7 7 7-7 7"/>
                        </svg>
                    </a>

                </div>

            </div>

        @else

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-[minmax(0,1fr)_340px] lg:gap-10">

                {{-- LISTA DE PRODUCTOS --}}
                <div class="min-w-0 space-y-5">

                    <div class="flex items-center justify-between border-b border-white/10 pb-4">

                        <h2 class="text-sm font-bold uppercase tracking-[0.2em] text-white">
                            Productos seleccionados
                        </h2>

                        <span class="text-xs font-semibold text-gray-400">
                            {{ $cantidadProductos }}
                            {{ $cantidadProductos == 1 ? 'producto' : 'productos' }}
                        </span>

                    </div>


                    {{-- TARJETAS DE PRODUCTOS --}}
                    @foreach($items as $item)

                        <article class="rounded-2xl border border-white/10 bg-[#1D1D1D] p-5 transition duration-300 hover:border-[#A99045]/40 sm:p-6">

                            <div class="flex flex-col gap-5 md:flex-row md:items-center">

                                {{-- INFORMACIÓN DEL PRODUCTO --}}
                                <div class="min-w-0 flex-1">

                                    <p class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#A99045]">
                                        Producto
                                    </p>

                                    <h3 class="mt-2 break-words text-lg font-black uppercase leading-snug text-white">
                                        {{ $item['producto']->nombre }}
                                    </h3>

                                    <div class="mt-4 space-y-2">

                                        <p class="text-sm text-gray-400">
                                            Precio unitario:
                                            <span class="font-semibold text-[#D8C17F]">
                                                ${{ number_format($item['precio'], 0, ',', '.') }}
                                            </span>
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Stock disponible: {{ $item['producto']->stock }}
                                        </p>

                                    </div>

                                </div>


                                {{-- ACTUALIZAR CANTIDAD --}}
                                <form
                                    method="POST"
                                    action="{{ route('carrito.update', $item['producto']->id) }}"
                                    class="flex flex-wrap items-end gap-3"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <div class="flex flex-col gap-2">

                                        <label
                                            class="text-[10px] font-bold uppercase tracking-widest text-gray-400"
                                            for="cantidad-{{ $item['producto']->id }}"
                                        >
                                            Cantidad
                                        </label>

                                        <input
                                            id="cantidad-{{ $item['producto']->id }}"
                                            name="cantidad"
                                            type="number"
                                            min="1"
                                            max="{{ $item['producto']->stock }}"
                                            value="{{ $item['cantidad'] }}"
                                            class="w-24 rounded-lg border border-white/10 bg-[#111111] px-3 py-3 text-center text-sm font-semibold text-[#F5F3ED] outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
                                        >

                                    </div>

                                    <button
                                        type="submit"
                                        class="rounded-lg border border-white/15 px-4 py-3 text-xs font-bold uppercase tracking-wider text-white transition hover:border-[#A99045] hover:text-[#D8C17F]"
                                    >
                                        Actualizar
                                    </button>

                                </form>


                                {{-- SUBTOTAL Y ELIMINAR --}}
                                <div class="flex items-center justify-between gap-4 border-t border-white/10 pt-4 md:min-w-[140px] md:flex-col md:items-end md:justify-center md:border-l md:border-t-0 md:pl-5 md:pt-0">

                                    <div class="md:text-right">

                                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">
                                            Subtotal
                                        </p>

                                        <p class="mt-2 text-xl font-extrabold text-[#D8C17F]">
                                            ${{ number_format($item['subtotal'], 0, ',', '.') }}
                                        </p>

                                    </div>

                                    <form
                                        method="POST"
                                        action="{{ route('carrito.remove', $item['producto']->id) }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-red-400 transition hover:text-red-300"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 viewBox="0 0 24 24"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path d="M3 6h18"/>
                                                <path d="M8 6V4h8v2"/>
                                                <path d="m19 6-1 14H6L5 6"/>
                                                <path d="M10 11v5M14 11v5"/>
                                            </svg>

                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </article>

                    @endforeach


                    {{-- VACIAR CARRITO --}}
                    <form method="POST" action="{{ route('carrito.clear') }}" class="pt-2">
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gray-400 transition hover:text-red-400"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M3 6h18"/>
                                <path d="M8 6V4h8v2"/>
                                <path d="m19 6-1 14H6L5 6"/>
                            </svg>

                            Vaciar carrito
                        </button>

                    </form>

                </div>


                {{-- RESUMEN DEL PEDIDO --}}
                <aside class="h-fit rounded-2xl border border-white/10 bg-[#1D1D1D] p-6 lg:sticky lg:top-6">

                    <p class="text-xs font-bold uppercase tracking-[0.3em] text-[#A99045]">
                        Tu compra
                    </p>

                    <h2 class="mt-3 text-2xl font-black uppercase tracking-tight text-white">
                        Resumen
                    </h2>

                    <div class="mt-5 h-1 w-12 bg-[#A99045]"></div>


                    {{-- DETALLE DE TOTALES --}}
                    <div class="mt-7 space-y-4 text-sm">

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-400">
                                Productos
                            </span>

                            <span class="font-semibold text-white">
                                {{ $cantidadProductos }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-400">
                                Subtotal
                            </span>

                            <span class="font-semibold text-white">
                                ${{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>


                    {{-- TOTAL --}}
                    <div class="my-6 border-t border-white/10"></div>

                    <div class="flex items-end justify-between gap-3">

                        <span class="text-sm font-bold uppercase tracking-widest text-gray-300">
                            Total
                        </span>

                        <div class="text-right">

                            <p class="text-2xl font-black text-[#D8C17F]">
                                ${{ number_format($total, 0, ',', '.') }}
                            </p>

                            <p class="mt-1 text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                COP
                            </p>

                        </div>

                    </div>


                    {{-- AVISO --}}
                    <div class="mt-6 rounded-xl border border-[#A99045]/20 bg-[#A99045]/5 p-4">

                        <div class="flex items-start gap-3">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="mt-0.5 h-5 w-5 shrink-0 text-[#D8C17F]"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M12 11v6M12 7h.01"/>
                            </svg>

                            <p class="text-xs leading-6 text-gray-400">
                                Al confirmar, el sistema volverá a validar productos y stock antes de crear el pedido.
                            </p>

                        </div>

                    </div>


                    {{-- CONFIRMAR PEDIDO --}}
                    <form method="POST" action="{{ route('carrito.confirmar') }}" class="mt-6">
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-3 rounded-lg bg-[#A99045] px-5 py-4 text-xs font-extrabold uppercase tracking-widest text-black transition hover:bg-[#D8C17F] focus:outline-none focus:ring-2 focus:ring-[#D8C17F] focus:ring-offset-2 focus:ring-offset-[#1D1D1D]"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="m5 12 4 4L19 6"/>
                            </svg>

                            Confirmar pedido
                        </button>

                    </form>


                    <p class="mt-4 text-center text-[10px] leading-5 text-gray-500">
                        Gracias por elegir Incógnito Group Design.
                    </p>

                </aside>

            </div>

        @endif

    </section>

</div>

@endsection