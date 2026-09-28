<div class="space-y-5">

    {{-- ============================================================
         URL
    ============================================================ --}}

    <div>

        <label
            for="url"
            class="mb-2 block text-sm text-gray-300"
        >
            URL
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

            <p class="mt-1 text-sm text-red-400">
                {{ $message }}
            </p>

        @enderror

    </div>


    {{-- ============================================================
         TIPO
    ============================================================ --}}

    <div>

        <label
            for="tipo"
            class="mb-2 block text-sm text-gray-300"
        >
            Tipo
        </label>

        <input
            type="text"
            id="tipo"
            name="tipo"
            value="{{ old('tipo', $media->tipo ?? '') }}"
            required
            maxlength="20"
            placeholder="imagen, video, documento..."
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >

        @error('tipo')

            <p class="mt-1 text-sm text-red-400">
                {{ $message }}
            </p>

        @enderror

    </div>


    {{-- ============================================================
         PRODUCTO
    ============================================================ --}}

    <div>

        <label
            for="id_producto"
            class="mb-2 block text-sm text-gray-300"
        >
            Asociar a producto
        </label>

        <select
            id="id_producto"
            name="id_producto"
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >

            <option value="">
                Sin producto
            </option>

            @foreach($productos as $producto)

                <option
                    value="{{ $producto->id }}"
                    @selected(
                        old(
                            'id_producto',
                            $media->id_producto ?? ''
                        ) == $producto->id
                    )
                >
                    {{ $producto->nombre }}
                </option>

            @endforeach

        </select>

        @error('id_producto')

            <p class="mt-1 text-sm text-red-400">
                {{ $message }}
            </p>

        @enderror

    </div>


    {{-- ============================================================
         CONTENIDO
    ============================================================ --}}

    <div>

        <label
            for="id_contenido"
            class="mb-2 block text-sm text-gray-300"
        >
            Asociar a contenido
        </label>

        <select
            id="id_contenido"
            name="id_contenido"
            class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white focus:border-[#00c896] focus:outline-none"
        >

            <option value="">
                Sin contenido
            </option>

            @foreach($contenidos as $contenido)

                <option
                    value="{{ $contenido->id_contenido }}"
                    @selected(
                        old(
                            'id_contenido',
                            $media->id_contenido ?? ''
                        ) == $contenido->id_contenido
                    )
                >
                    {{ $contenido->titulo }}
                </option>

            @endforeach

        </select>

        @error('id_contenido')

            <p class="mt-1 text-sm text-red-400">
                {{ $message }}
            </p>

        @enderror

    </div>


    {{-- ============================================================
         ERROR DE DESTINO
    ============================================================ --}}

    @error('destino')

        <div class="rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3">

            <p class="text-sm text-red-400">
                {{ $message }}
            </p>

        </div>

    @enderror


    {{-- ============================================================
         DESTACADO
    ============================================================ --}}

    <label class="flex items-center gap-3 text-sm text-gray-300">

        <input
            type="checkbox"
            name="destacado"
            value="1"
            @checked(
                old(
                    'destacado',
                    $media->destacado ?? false
                )
            )
            class="rounded border-white/20 bg-[#1a1a1a]"
        >

        <span>
            Marcar como destacado
        </span>

    </label>


    {{-- ============================================================
         INFORMACIÓN
    ============================================================ --}}

    <p class="text-xs text-gray-500">
        La media debe estar asociada exactamente a un producto
        o a un contenido.
    </p>

</div>
