@extends('layouts.app')

@section('title', 'Crear rol')

@section('content')

<div class="w-full max-w-4xl">

    {{-- ===================================================== --}}
    {{-- ENCABEZADO --}}
    {{-- ===================================================== --}}

    <div class="mb-8">

        <h1
            class="font-black uppercase tracking-widest text-white"
            style="font-size:22px;letter-spacing:.15em;"
        >
            Crear rol
        </h1>

        <div class="mt-3 h-[3px] w-[60px]" style="background:#A99045;"></div>

        <p
            class="mt-3 font-bold"
            style="font-size:12px;color:rgba(255,255,255,.45);"
        >
            Registra un nuevo rol y asigna los permisos que tendrá.
        </p>

    </div>

    {{-- ===================================================== --}}
    {{-- ERRORES GENERALES --}}
    {{-- ===================================================== --}}

    @if ($errors->any())

        <div
            class="mb-6 rounded-md p-4"
            style="background:rgba(127,29,29,.2);border:1px solid rgba(248,113,113,.3);"
        >

            <p class="mb-2 font-bold" style="font-size:12px;color:#fca5a5;">
                No se pudo crear el rol.
            </p>

            <ul class="list-inside list-disc" style="font-size:12px;color:#fca5a5;">

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- ===================================================== --}}
    {{-- FORMULARIO --}}
    {{-- ===================================================== --}}

    <form
        method="POST"
        action="{{ route('roles.store') }}"
        class="space-y-6"
    >

        @csrf

        {{-- ================================================= --}}
        {{-- INFORMACIÓN DEL ROL --}}
        {{-- ================================================= --}}

        <div
            class="p-6"
            style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);border-radius:6px;box-shadow:0 8px 24px rgba(0,0,0,.15);"
        >

            <h2
                class="mb-5 font-black uppercase tracking-widest text-white"
                style="font-size:13px;letter-spacing:.1em;"
            >
                Información del rol
            </h2>

            <div class="mb-5 h-px" style="background:rgba(169,144,69,.2);"></div>

            {{-- Nombre --}}

            <div>

                <label
                    for="nombre"
                    class="mb-2 block font-bold uppercase tracking-widest"
                    style="font-size:10px;color:rgba(255,255,255,.65);"
                >
                    Nombre
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    value="{{ old('nombre') }}"
                    placeholder="Ejemplo: Administrador"
                    class="w-full px-4 py-3 text-white outline-none transition-all"
                    style="font-size:12px;background:#111111;border:1px solid rgba(255,255,255,.12);border-radius:4px;color:#ffffff;"
                    onfocus="this.style.borderColor='#A99045';this.style.boxShadow='0 0 0 1px rgba(169,144,69,.2)'"
                    onblur="this.style.borderColor='rgba(255,255,255,.12)';this.style.boxShadow='none'"
                    required
                >

                @error('nombre')

                    <p class="mt-2" style="font-size:11px;color:#f87171;">
                        {{ $message }}
                    </p>

                @enderror

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- PERMISOS --}}
        {{-- ================================================= --}}

        <div
            class="overflow-hidden"
            style="background:#1D1D1D;border:1px solid rgba(169,144,69,.25);border-radius:6px;box-shadow:0 8px 24px rgba(0,0,0,.15);"
        >

            <div
                class="px-5 py-5"
                style="background:rgba(169,144,69,.05);border-bottom:1px solid rgba(169,144,69,.25);"
            >

                <h2
                    class="font-black uppercase tracking-widest text-white"
                    style="font-size:13px;letter-spacing:.1em;"
                >
                    Permisos del rol
                </h2>

                <p class="mt-2" style="font-size:11px;color:rgba(255,255,255,.45);">
                    Selecciona los permisos que tendrá este rol.
                </p>

            </div>

            <div style="border-color:rgba(255,255,255,.05);">

                @forelse ($permisos as $permiso)

                    @php
                        $seleccionado = in_array(
                            $permiso->id_permiso,
                            old('permisos', [])
                        );
                    @endphp

                    <label
                        for="permiso_{{ $permiso->id_permiso }}"
                        class="flex cursor-pointer items-center gap-4 px-5 py-4 transition-colors hover:bg-white/[0.03]"
                        style="border-bottom:1px solid rgba(255,255,255,.05);"
                    >

                        <input
                            type="checkbox"
                            id="permiso_{{ $permiso->id_permiso }}"
                            name="permisos[]"
                            value="{{ $permiso->id_permiso }}"
                            @checked($seleccionado)
                            class="h-4 w-4 rounded"
                            style="accent-color:#A99045;"
                        >

                        <div class="min-w-0 flex-1">

                            <div class="font-bold text-white" style="font-size:12px;">
                                {{ $permiso->nombre }}
                            </div>

                            <div class="mt-2 font-bold uppercase tracking-widest" style="font-size:9px;color:rgba(255,255,255,.35);">

                                Módulo:

                                <span class="normal-case tracking-normal" style="font-size:11px;color:rgba(255,255,255,.6);">
                                    {{ $permiso->modulo }}
                                </span>

                            </div>

                        </div>

                        <span
                            class="font-bold"
                            style="font-size:10px;color:#D8C17F;"
                        >
                            #{{ $permiso->id_permiso }}
                        </span>

                    </label>

                @empty

                    <div class="px-5 py-10 text-center">

                        <p style="font-size:12px;color:rgba(255,255,255,.5);">
                            No hay permisos registrados.
                        </p>

                        @if (auth()->check() && auth()->user()->tienePermiso('permisos.crear'))

                            <a
                                href="{{ route('permisos.create') }}"
                                class="mt-4 inline-block font-bold uppercase tracking-widest transition-colors hover:opacity-80"
                                style="font-size:10px;color:#D8C17F;"
                            >
                                Crear un permiso
                            </a>

                        @endif

                    </div>

                @endforelse

            </div>

        </div>

        {{-- ================================================= --}}
        {{-- BOTONES --}}
        {{-- ================================================= --}}

        <div class="flex flex-wrap gap-3">

            @if (auth()->check() && auth()->user()->tienePermiso('roles.crear'))

                <button
                    type="submit"
                    class="px-5 py-3 font-black uppercase tracking-widest transition-all hover:opacity-90"
                    style="font-size:10px;background:#A99045;color:#111111;border:1px solid #D8C17F;border-radius:4px;"
                >
                    Guardar
                </button>

            @endif

            <a
                href="{{ route('roles.index') }}"
                class="inline-flex items-center justify-center px-5 py-3 font-black uppercase tracking-widest transition-all hover:bg-white/5"
                style="font-size:10px;color:rgba(255,255,255,.7);border:1px solid rgba(255,255,255,.15);border-radius:4px;"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection
