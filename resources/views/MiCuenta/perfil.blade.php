@extends('layouts.app')

@section('title', 'Mi perfil')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-8">
        <a
            href="{{ route('mi-cuenta') }}"
            class="text-sm text-gray-500 transition hover:text-brand-500"
        >
            ← Volver a mi cuenta
        </a>

        <p class="mt-5 text-brand-500 text-xs font-black uppercase tracking-[0.25em]">
            Información personal
        </p>

        <h1 class="mt-2 text-3xl sm:text-4xl font-black text-white">
            Mi perfil
        </h1>

        <p class="mt-2 text-gray-400">
            Consulta la información asociada a tu cuenta.
        </p>
    </div>

    <div class="rounded-2xl border border-white/10 bg-dark-800 shadow-xl overflow-hidden">

        <div class="p-6 sm:p-8">

            <div class="flex flex-col sm:flex-row sm:items-center gap-5 pb-8 border-b border-white/10">

                <img
                    src="https://ui-avatars.com/api/?name= {{ urlencode($usuario->nombre) }}&background=00c896&color=000&size=160"
                    alt="Avatar de {{ $usuario->nombre }}"
                    class="w-24 h-24 rounded-2xl object-cover border border-white/10"
                >

                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                        Perfil
                    </p>

                    <h2 class="mt-1 text-2xl font-black text-white">
                        {{ $usuario->nombre }}
                    </h2>

                    <p class="mt-1 text-gray-400">
                        {{ $usuario->email }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                        Nombre
                    </p>

                    <p class="mt-2 text-white font-semibold">
                        {{ $usuario->nombre }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                        Correo electrónico
                    </p>

                    <p class="mt-2 text-white font-semibold break-all">
                        {{ $usuario->email }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                        Teléfono
                    </p>

                    <p class="mt-2 text-white font-semibold">
                        {{ $usuario->telefono ?: 'No registrado' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-gray-500">
                        Miembro desde
                    </p>

                    <p class="mt-2 text-white font-semibold">
                        {{ $usuario->created_at?->format('d/m/Y') ?? 'No disponible' }}
                    </p>
                </div>

            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3 mt-10 pt-6 border-t border-white/10">

                <a
                    href="{{ route('mi-cuenta') }}"
                    class="inline-flex justify-center rounded-lg border border-white/10 px-5 py-3 text-sm font-black uppercase tracking-wider text-gray-300 transition hover:bg-white/5"
                >
                    Volver
                </a>

                <a
                    href="{{ route('mi-cuenta.perfil.edit') }}"
                    class="inline-flex justify-center rounded-lg bg-brand-500 px-5 py-3 text-sm font-black uppercase tracking-wider text-black transition hover:bg-brand-600"
                >
                    Editar perfil
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
