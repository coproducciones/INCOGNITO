<div class="space-y-5">

    {{-- URL --}}
    <div>
        <label for="url" class="mb-2 block text-sm text-gray-300">
            URL del recurso
        </label>

        <input
            type="url"
            id="url"
            name="url"
            value="{{ old('url', $media->url ?? '') }}"
            required
            maxlength="255"
            placeholder="https://..."
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >

        @error('url')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror

        <p class="mt-1 text-xs text-gray-500">
            Introduce una URL accesible para el archivo. Puede ser una imagen,
            un video, un documento u otro recurso.
        </p>
    </div>

    {{-- TIPO --}}
    <div>
        <label for="tipo" class="mb-2 block text-sm text-gray-300">
            Tipo de recurso
        </label>

        <select
            id="tipo"
            name="tipo"
            required
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >
            @php
                $tipoActual = old('tipo', $media->tipo ?? '');
                $tiposDisponibles = ['imagen', 'video', 'documento'];
            @endphp

            @if($tipoActual && !in_array(strtolower($tipoActual), $tiposDisponibles))
                <option value="{{ $tipoActual }}" selected>
                    {{ ucfirst($tipoActual) }} (tipo actual)
                </option>
            @endif

            <option value="">Selecciona un tipo</option>

            <option value="imagen" @selected(strtolower($tipoActual) === 'imagen')>
                Imagen
            </option>

            <option value="video" @selected(strtolower($tipoActual) === 'video')>
                Video
            </option>

            <option value="documento" @selected(strtolower($tipoActual) === 'documento')>
                Documento
            </option>
        </select>

        @error('tipo')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- ASOCIACIÓN CON PRODUCTO --}}
    <div>
        <label for="id_producto" class="mb-2 block text-sm text-gray-300">
            Asociar a producto
        </label>

        <select
            id="id_producto"
            name="id_producto"
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >
            <option value="">Sin producto</option>

            @foreach($productos as $producto)
                <option
                    value="{{ $producto->id }}"
                    @selected((string) old('id_producto', $media->id_producto ?? '') === (string) $producto->id)
                >
                    {{ $producto->nombre }}
                </option>
            @endforeach
        </select>

        @error('id_producto')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- ASOCIACIÓN CON CONTENIDO --}}
    <div>
        <label for="id_contenido" class="mb-2 block text-sm text-gray-300">
            Asociar a contenido
        </label>

        <select
            id="id_contenido"
            name="id_contenido"
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >
            <option value="">Sin contenido</option>

            @foreach($contenidos as $contenido)
                <option
                    value="{{ $contenido->id_contenido }}"
                    @selected((string) old('id_contenido', $media->id_contenido ?? '') === (string) $contenido->id_contenido)
                >
                    {{ $contenido->titulo }}
                </option>
            @endforeach
        </select>

        @error('id_contenido')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- ERROR DE ASOCIACIÓN --}}
    @error('destino')
        <div class="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3">
            <p class="text-sm text-red-400">{{ $message }}</p>
        </div>
    @enderror

    {{-- DESTACADO --}}
    <div>
        <label class="flex cursor-pointer items-center gap-3 text-sm text-gray-300">
            <input
                type="checkbox"
                id="destacado"
                name="destacado"
                value="1"
                @checked((bool) old('destacado', $media->destacado ?? false))
                class="rounded border-white/20 bg-[#1a1a1a] text-[#00c896] focus:ring-[#00c896]"
            >

            <span>Marcar como destacado</span>
        </label>

        @error('destacado')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- REGLA DE ASOCIACIÓN --}}
    <div class="rounded-lg border border-[#00c896]/20 bg-[#00c896]/5 px-4 py-3">
        <p class="text-sm font-medium text-[#00c896]">
            Asociación obligatoria
        </p>
        <p class="mt-1 text-xs leading-5 text-gray-400">
            Cada recurso debe pertenecer a un producto o a un contenido.
            No puedes asociarlo a ambos al mismo tiempo.
        </p>
    </div>
</div>

{{-- MANTENER UNA SOLA ASOCIACIÓN --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const producto = document.getElementById('id_producto');
        const contenido = document.getElementById('id_contenido');

        if (!producto || !contenido) {
            return;
        }

        producto.addEventListener('change', function () {
            if (producto.value !== '') {
                contenido.value = '';
            }
        });

        contenido.addEventListener('change', function () {
            if (contenido.value !== '') {
                producto.value = '';
            }
        });
    });
</script>