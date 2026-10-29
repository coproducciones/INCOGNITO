<div class="space-y-6">

    {{-- ARCHIVO --}}
    <div>
        <label for="archivo" class="mb-2 block text-sm font-medium text-gray-300">
            Archivo multimedia
        </label>

        <input
            type="file"
            id="archivo"
            name="archivo"
            accept="image/jpeg,image/png,image/webp,image/gif,video/mp4,video/webm,application/pdf"
            @required(!isset($media))
            class="block w-full rounded-lg border border-white/10 bg-[#1a1a1a] p-3 text-sm text-gray-300
                   file:mr-4 file:rounded-md file:border-0 file:bg-[#A99045]
                   file:px-4 file:py-2 file:font-semibold file:text-black
                   hover:file:bg-[#D8C17F] focus:border-[#A99045] focus:outline-none"
        >

        <p class="mt-2 text-xs leading-5 text-gray-500">
            Formatos permitidos: JPG, PNG, WEBP, GIF, MP4, WEBM y PDF.
            Tamaño máximo: 10 MB.
        </p>

        @if(isset($media) && $media->url)
            <div class="mt-4 rounded-lg border border-white/10 bg-black/20 p-4">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-[#D8C17F]">
                    Archivo actual
                </p>

                @if(strtolower($media->tipo) === 'imagen')
                    <img
                        src="{{ $media->url_publica }}"
                        alt="Archivo multimedia actual"
                        class="max-h-64 rounded-lg object-contain"
                    >
                @else
                    <a
                        href="{{ $media->url_publica }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-sm text-[#D8C17F] underline"
                    >
                        Abrir archivo actual
                    </a>
                @endif

                <p class="mt-2 break-all text-xs text-gray-500">
                    {{ $media->url }}
                </p>
            </div>

            <p class="mt-2 text-xs text-gray-500">
                Si no seleccionas un archivo nuevo, se conservará el actual.
            </p>
        @endif

        <div id="vista-previa" class="mt-4 hidden">
            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-[#D8C17F]">
                Vista previa del archivo seleccionado
            </p>
            <img
                id="imagen-previa"
                alt="Vista previa"
                class="hidden max-h-64 rounded-lg object-contain"
            >
            <p id="nombre-archivo" class="mt-2 break-all text-sm text-gray-400"></p>
        </div>

        @error('archivo')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- TIPO --}}
    <div>
        <label for="tipo" class="mb-2 block text-sm text-gray-300">
            Tipo de recurso
        </label>

        @php
            $tipoActual = old('tipo', $media->tipo ?? 'imagen');
        @endphp

        <select
            id="tipo"
            name="tipo"
            required
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white
                   focus:border-[#A99045] focus:outline-none"
        >
            <option value="imagen" @selected($tipoActual === 'imagen')>Imagen</option>
            <option value="video" @selected($tipoActual === 'video')>Video</option>
            <option value="documento" @selected($tipoActual === 'documento')>Documento</option>
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
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white
                   focus:border-[#A99045] focus:outline-none"
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
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white
                   focus:border-[#A99045] focus:outline-none"
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

    @error('destino')
        <div class="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3">
            <p class="text-sm text-red-400">{{ $message }}</p>
        </div>
    @enderror

    {{-- DESTACADO --}}
    <label class="flex cursor-pointer items-center gap-3 text-sm text-gray-300">
        <input
            type="checkbox"
            id="destacado"
            name="destacado"
            value="1"
            @checked((bool) old('destacado', $media->destacado ?? false))
            class="rounded border-white/20 bg-[#1a1a1a] text-[#A99045] focus:ring-[#A99045]"
        >
        <span>Marcar como destacado</span>
    </label>

    @error('destacado')
        <p class="text-sm text-red-400">{{ $message }}</p>
    @enderror

    <div class="rounded-lg border border-[#A99045]/30 bg-[#A99045]/5 px-4 py-3">
        <p class="text-sm font-semibold text-[#D8C17F]">
            Asociación obligatoria
        </p>
        <p class="mt-1 text-xs leading-5 text-gray-400">
            Cada recurso debe pertenecer a un producto o a un contenido,
            pero nunca a ambos al mismo tiempo.
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const producto = document.getElementById('id_producto');
    const contenido = document.getElementById('id_contenido');
    const archivo = document.getElementById('archivo');
    const tipo = document.getElementById('tipo');
    const vistaPrevia = document.getElementById('vista-previa');
    const imagenPrevia = document.getElementById('imagen-previa');
    const nombreArchivo = document.getElementById('nombre-archivo');

    if (producto && contenido) {
        producto.addEventListener('change', function () {
            if (producto.value !== '') contenido.value = '';
        });

        contenido.addEventListener('change', function () {
            if (contenido.value !== '') producto.value = '';
        });
    }

    if (archivo) {
        archivo.addEventListener('change', function () {
            const seleccionado = archivo.files[0];

            if (!seleccionado) {
                vistaPrevia?.classList.add('hidden');
                return;
            }

            vistaPrevia?.classList.remove('hidden');
            nombreArchivo.textContent = seleccionado.name;

            if (seleccionado.type.startsWith('image/')) {
                imagenPrevia.src = URL.createObjectURL(seleccionado);
                imagenPrevia.classList.remove('hidden');
            } else {
                imagenPrevia.removeAttribute('src');
                imagenPrevia.classList.add('hidden');
            }

            if (tipo) {
                if (seleccionado.type.startsWith('image/')) {
                    tipo.value = 'imagen';
                } else if (seleccionado.type.startsWith('video/')) {
                    tipo.value = 'video';
                } else {
                    tipo.value = 'documento';
                }
            }
        });
    }
});
</script>