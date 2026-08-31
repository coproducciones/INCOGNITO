@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#050505] text-white py-10">

    <div class="max-w-5xl mx-auto px-6">

        {{-- ENCABEZADO --}}
        <div class="mb-8">
            <div class="flex items-center justify-between gap-4">

                <div>
                    <p class="text-xs font-black uppercase tracking-[0.3em] text-emerald-400 mb-2">
                        Detalle de categoría
                    </p>

                    <h1 class="text-3xl font-black uppercase tracking-widest">
                        {{ $categoria->nombre }}
                    </h1>
                </div>

                <a
                    href="{{ route('categorias.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 font-black uppercase tracking-widest transition-all hover:bg-white/10"
                    style="
                        font-size:10px;
                        color:rgba(255,255,255,0.65);
                        border:1px solid rgba(255,255,255,0.15);
                        border-radius:4px;
                    "
                >
                    ← VOLVER
                </a>

            </div>
        </div>


        {{-- TARJETA PRINCIPAL --}}
        <div
            class="bg-[#0b0b0b] border border-white/10 rounded-lg overflow-hidden"
        >

            {{-- CABECERA --}}
            <div class="px-6 py-5 border-b border-white/10">
                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-[9px] uppercase tracking-[0.25em] text-white/40 font-black">
                            Información
                        </p>

                        <h2 class="mt-1 text-xl font-black uppercase">
                            {{ $categoria->nombre }}
                        </h2>
                    </div>

                    <span
                        class="px-3 py-1 text-[9px] font-black uppercase tracking-widest"
                        style="
                            color:#00c896;
                            border:1px solid rgba(0,200,150,0.25);
                            background:rgba(0,200,150,0.05);
                            border-radius:4px;
                        "
                    >
                        ACTIVA
                    </span>

                </div>
            </div>


            {{-- DATOS --}}
            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- ID --}}
                    <div>
                        <p class="text-[9px] uppercase tracking-[0.25em] text-white/40 font-black mb-2">
                            ID
                        </p>

                        <div
                            class="px-4 py-3 text-sm font-bold text-white/80"
                            style="
                                border:1px solid rgba(255,255,255,0.08);
                                background:rgba(255,255,255,0.02);
                                border-radius:4px;
                            "
                        >
                            #{{ $categoria->id }}
                        </div>
                    </div>


                    {{-- NOMBRE --}}
                    <div>
                        <p class="text-[9px] uppercase tracking-[0.25em] text-white/40 font-black mb-2">
                            Nombre
                        </p>

                        <div
                            class="px-4 py-3 text-sm font-bold text-white/80"
                            style="
                                border:1px solid rgba(255,255,255,0.08);
                                background:rgba(255,255,255,0.02);
                                border-radius:4px;
                            "
                        >
                            {{ $categoria->nombre }}
                        </div>
                    </div>


                    {{-- DESCRIPCIÓN --}}
                    @if(isset($categoria->descripcion))
                        <div class="md:col-span-2">

                            <p class="text-[9px] uppercase tracking-[0.25em] text-white/40 font-black mb-2">
                                Descripción
                            </p>

                            <div
                                class="px-4 py-4 text-sm leading-relaxed text-white/70"
                                style="
                                    border:1px solid rgba(255,255,255,0.08);
                                    background:rgba(255,255,255,0.02);
                                    border-radius:4px;
                                "
                            >
                                {{ $categoria->descripcion ?: 'Sin descripción registrada.' }}
                            </div>

                        </div>
                    @endif


                    {{-- FECHA DE CREACIÓN --}}
                    @if($categoria->created_at)
                        <div>

                            <p class="text-[9px] uppercase tracking-[0.25em] text-white/40 font-black mb-2">
                                Creada
                            </p>

                            <div
                                class="px-4 py-3 text-sm font-bold text-white/60"
                                style="
                                    border:1px solid rgba(255,255,255,0.08);
                                    background:rgba(255,255,255,0.02);
                                    border-radius:4px;
                                "
                            >
                                {{ $categoria->created_at->format('d/m/Y H:i') }}
                            </div>

                        </div>
                    @endif


                    {{-- FECHA DE ACTUALIZACIÓN --}}
                    @if($categoria->updated_at)
                        <div>

                            <p class="text-[9px] uppercase tracking-[0.25em] text-white/40 font-black mb-2">
                                Última actualización
                            </p>

                            <div
                                class="px-4 py-3 text-sm font-bold text-white/60"
                                style="
                                    border:1px solid rgba(255,255,255,0.08);
                                    background:rgba(255,255,255,0.02);
                                    border-radius:4px;
                                "
                            >
                                {{ $categoria->updated_at->format('d/m/Y H:i') }}
                            </div>

                        </div>
                    @endif

                </div>

            </div>


            {{-- ACCIONES --}}
            <div class="px-6 py-5 border-t border-white/10">

                <div class="flex items-center justify-end gap-2">

                    {{-- EDITAR --}}
                    <a
                        href="{{ route('categorias.edit', $categoria) }}"
                        class="inline-flex items-center justify-center px-4 py-2 font-black uppercase tracking-widest transition-all hover:bg-emerald-500/10"
                        style="
                            font-size:9px;
                            color:#00c896;
                            border:1px solid rgba(0,200,150,0.25);
                            border-radius:4px;
                        "
                    >
                        EDITAR
                    </a>


                    {{-- ELIMINAR --}}
                    <form
                        action="{{ route('categorias.destroy', $categoria) }}"
                        method="POST"
                        onsubmit="return confirm('¿Eliminar esta categoría?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 font-black uppercase tracking-widest transition-all hover:bg-red-500/10"
                            style="
                                font-size:9px;
                                color:#f87171;
                                border:1px solid rgba(248,113,113,0.25);
                                border-radius:4px;
                                background:transparent;
                                cursor:pointer;
                            "
                        >
                            ELIMINAR
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
