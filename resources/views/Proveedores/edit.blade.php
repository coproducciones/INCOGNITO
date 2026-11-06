@extends('layouts.app')

@section('title', 'Editar proveedor')

@section('content')

<div class="mx-auto max-w-3xl px-4 py-6">

    {{-- ENCABEZADO --}}
    <div class="mb-8">
        <h1 class="text-xl font-black uppercase tracking-widest text-white">
            Editar proveedor
        </h1>

        <p class="mt-1 text-xs font-bold uppercase tracking-widest text-white/40">
            Actualiza la información principal del proveedor.
        </p>

        <div class="mt-3 h-[3px] w-[60px] rounded-full bg-[#A99045]"></div>
    </div>


    {{-- MENSAJES DE VALIDACIÓN --}}
    @if ($errors->any())
        <div class="mb-6 rounded-xl border border-red-400/30 bg-red-400/10 p-4">

            <p class="mb-2 font-bold text-red-300">
                Se encontraron los siguientes errores:
            </p>

            <ul class="list-disc space-y-1 pl-5 text-sm text-red-200">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- FORMULARIO --}}
    @if(auth()->check() && auth()->user()->tienePermiso('proveedores.crear'))

        <form
            method="POST"
            action="{{ route('proveedores.update', $proveedor) }}"
            class="space-y-6 rounded-xl border border-[#A99045]/25 bg-[#111111] p-5 shadow-xl shadow-black/20 sm:p-8"
        >

            @csrf
            @method('PUT')


            {{-- USUARIO --}}
            <div>
                <label
                    for="id_usuario"
                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]"
                >
                    Usuario
                </label>

                <select
                    id="id_usuario"
                    name="id_usuario"
                    required
                    class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
                >
                    <option value="" class="bg-[#1D1D1D] text-white/60">
                        Selecciona un usuario
                    </option>

                    @foreach ($usuarios as $usuario)
                        <option
                            value="{{ $usuario->id }}"
                            @selected(old('id_usuario') == $usuario->id)
                            class="bg-[#1D1D1D] text-white"
                        >
                            {{ $usuario->nombre }}
                            —
                            {{ $usuario->email }}
                        </option>
                    @endforeach
                </select>

                @error('id_usuario')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- CATEGORÍAS DEL PROVEEDOR --}}
            @php
                $categoriasSeleccionadas = old('categorias', isset($proveedor)
                    ? $proveedor->categorias->pluck('id')->all()
                    : []);
            @endphp
            <div>
                <span class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]">
                    Categorías de servicio
                </span>
                <p class="mb-3 text-xs text-white/50">Selecciona una o varias categorías. Se utiliza el mismo catálogo de categorías de productos y contenidos.</p>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                    @forelse ($categorias as $categoria)
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white transition hover:border-[#A99045]/60">
                            <input
                                type="checkbox"
                                name="categorias[]"
                                value="{{ $categoria->id }}"
                                @checked(in_array($categoria->id, $categoriasSeleccionadas))
                                class="rounded border-white/30 bg-[#111111] text-[#A99045] focus:ring-[#A99045]"
                            >
                            <span>
                                <span class="block font-semibold">{{ $categoria->nombre }}</span>
                                @if ($categoria->descripcion)
                                    <span class="mt-1 block text-xs text-white/45">{{ $categoria->descripcion }}</span>
                                @endif
                            </span>
                        </label>
                    @empty
                        <p class="text-sm text-red-300">No hay categorías registradas. Contacta al administrador.</p>
                    @endforelse
                </div>

                @error('categorias')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
                @error('categorias.*')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- ESPECIALIDAD --}}
            <div>
                <label
                    for="especialidad"
                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]"
                >
                    Especialidad
                </label>

                <input
                    type="text"
                    id="especialidad"
                    name="especialidad"
                    value="{{ old('especialidad') }}"
                    required
                    maxlength="100"
                    placeholder="Ej. Diseño gráfico, fotografía, producción..."
                    class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
                >

                @error('especialidad')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- TELÉFONO --}}
            <div>
                <label
                    for="telefono"
                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]"
                >
                    Teléfono
                </label>

                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono') }}"
                    required
                    maxlength="20"
                    placeholder="Ej. 3001234567"
                    class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
                >

                @error('telefono')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- WHATSAPP --}}
            <div>
                <label
                    for="whatsapp"
                    class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#D8C17F]"
                >
                    WhatsApp
                </label>

                <input
                    type="text"
                    id="whatsapp"
                    name="whatsapp"
                    value="{{ old('whatsapp') }}"
                    maxlength="20"
                    placeholder="Ej. 3001234567"
                    class="w-full rounded-lg border border-white/10 bg-[#1D1D1D] px-4 py-3 text-sm text-white placeholder:text-white/30 outline-none transition focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
                >

                @error('whatsapp')
                    <p class="mt-2 text-xs text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- BOTONES --}}
            <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-6">

                <a
                    href="{{ route('proveedores.index') }}"
                    class="rounded-lg border border-white/15 bg-[#1D1D1D] px-5 py-3 text-xs font-bold uppercase tracking-widest text-white/70 transition hover:border-[#A99045]/50 hover:text-[#D8C17F]"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="rounded-lg bg-[#A99045] px-6 py-3 text-xs font-black uppercase tracking-widest text-[#111111] transition hover:bg-[#D8C17F]"
                >
                    Guardar proveedor
                </button>

            </div>

        </form>

    @else

        <div class="rounded-xl border border-red-400/30 bg-red-400/10 p-6 text-center">
            <p class="font-semibold text-red-300">
                No tienes permiso para registrar proveedores.
            </p>

            <a
                href="{{ route('proveedores.index') }}"
                class="mt-4 inline-block rounded-lg border border-white/15 bg-[#1D1D1D] px-5 py-3 text-xs font-bold uppercase tracking-wider text-white/70 transition hover:border-[#A99045]/50 hover:text-[#D8C17F]"
            >
                Volver a proveedores
            </a>
        </div>

    @endif

</div>

@endsection
