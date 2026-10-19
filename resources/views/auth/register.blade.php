@extends('layouts.app')

@section('title', 'Crear cuenta | Incógnito')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center px-4 py-10">
    <div class="w-full max-w-2xl">
        <div class="mb-8 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.35em] text-[#00c896]">Incógnito | Grupo de Diseño</p>
            <h1 class="mt-3 text-3xl sm:text-4xl font-bold tracking-tight text-white">Crea tu cuenta</h1>
            <p class="mt-3 text-sm text-gray-400">Elige el tipo de cuenta que mejor se adapta a ti.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-xl border border-red-500/30 bg-red-500/10 p-4 text-sm text-red-200">
                <p class="font-semibold">Revisa la información:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('registro.store') }}"
              class="space-y-6 rounded-2xl border border-white/10 bg-gray-950/80 p-5 shadow-2xl sm:p-8">
            @csrf

            <div>
                <label for="nombre" class="mb-2 block text-sm font-medium text-gray-200">Nombre completo</label>
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required autocomplete="name"
                       class="w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white outline-none transition focus:border-[#00c896] focus:ring-2 focus:ring-[#00c896]/20">
                @error('nombre') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-gray-200">Correo electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email"
                           class="w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white outline-none transition focus:border-[#00c896] focus:ring-2 focus:ring-[#00c896]/20">
                    @error('email') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="telefono" class="mb-2 block text-sm font-medium text-gray-200">Teléfono <span class="text-gray-500">(opcional)</span></label>
                    <input id="telefono" name="telefono" type="tel" value="{{ old('telefono') }}" autocomplete="tel"
                           class="w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white outline-none transition focus:border-[#00c896] focus:ring-2 focus:ring-[#00c896]/20">
                    @error('telefono') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <fieldset>
                <legend class="mb-3 text-sm font-medium text-gray-200">Tipo de cuenta</legend>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="cursor-pointer rounded-xl border border-white/10 bg-gray-900 p-4 transition has-[:checked]:border-[#00c896] has-[:checked]:bg-[#00c896]/10">
                        <span class="flex items-start gap-3">
                            <input type="radio" name="tipo_cuenta" value="cliente" required {{ old('tipo_cuenta', 'cliente') === 'cliente' ? 'checked' : '' }}
                                   class="mt-1 accent-[#00c896]">
                            <span>
                                <span class="block font-semibold text-white">Cliente</span>
                                <span class="mt-1 block text-sm text-gray-400">Explora productos, realiza pedidos y administra tu cuenta.</span>
                            </span>
                        </span>
                    </label>
                    <label class="cursor-pointer rounded-xl border border-white/10 bg-gray-900 p-4 transition has-[:checked]:border-[#00c896] has-[:checked]:bg-[#00c896]/10">
                        <span class="flex items-start gap-3">
                            <input type="radio" name="tipo_cuenta" value="proveedor" required {{ old('tipo_cuenta') === 'proveedor' ? 'checked' : '' }}
                                   class="mt-1 accent-[#00c896]">
                            <span>
                                <span class="block font-semibold text-white">Proveedor / Empresa</span>
                                <span class="mt-1 block text-sm text-gray-400">Administra tu perfil comercial y la información que te corresponda.</span>
                            </span>
                        </span>
                    </label>
                </div>
                @error('tipo_cuenta') <p class="mt-2 text-sm text-red-300">{{ $message }}</p> @enderror
            </fieldset>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-gray-200">Contraseña</label>
                    <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password"
                           class="w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white outline-none transition focus:border-[#00c896] focus:ring-2 focus:ring-[#00c896]/20">
                    @error('password') <p class="mt-1 text-sm text-red-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-200">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password"
                           class="w-full rounded-xl border border-white/10 bg-gray-900 px-4 py-3 text-white outline-none transition focus:border-[#00c896] focus:ring-2 focus:ring-[#00c896]/20">
                </div>
            </div>

            <label class="flex items-start gap-3 text-sm text-gray-400">
                <input type="checkbox" name="acepta_terminos" value="1" required {{ old('acepta_terminos') ? 'checked' : '' }}
                       class="mt-1 accent-[#00c896]">
                <span>Confirmo que los datos son correctos y acepto las condiciones de uso.</span>
            </label>
            @error('acepta_terminos') <p class="text-sm text-red-300">{{ $message }}</p> @enderror

            <button type="submit"
                    class="w-full rounded-xl bg-[#00c896] px-5 py-3 font-bold text-gray-950 transition hover:bg-[#00dda8] focus:outline-none focus:ring-2 focus:ring-[#00c896] focus:ring-offset-2 focus:ring-offset-gray-950">
                Crear cuenta
            </button>

            <p class="text-center text-sm text-gray-400">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="font-semibold text-[#00c896] hover:underline">Inicia sesión</a>
            </p>
        </form>
    </div>
</div>
@endsection
