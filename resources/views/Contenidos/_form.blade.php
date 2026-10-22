<div class="space-y-5">

    {{-- TÍTULO --}}
    <div>
        <label
            for="titulo"
            class="mb-2 block text-sm font-medium tracking-wide text-[#F5F3ED]"
        >
            Título
        </label>

        <input
            type="text"
            id="titulo"
            name="titulo"
            value="{{ old('titulo', $contenido->titulo ?? '') }}"
            maxlength="150"
            required
            class="w-full rounded-lg border border-white/[0.08] bg-[#151515] px-4 py-3 text-white outline-none transition duration-200 placeholder:text-white/30 focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
            placeholder="Ej. Diseño de identidad visual"
        >

        @error('titulo')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

    {{-- CATEGORÍA / SECCIÓN --}}
    <div>
        <label
            for="categoria_id"
            class="mb-2 block text-sm font-medium tracking-wide text-[#F5F3ED]"
        >
            Categoría / Sección
        </label>

        @php
            $categoriaSeleccionada = old(
                'categoria_id',
                isset($contenido)
                    ? $contenido->categorias->first()?->id
                    : ''
            );
        @endphp

        <select
            id="categoria_id"
            name="categoria_id"
            required
            class="w-full rounded-lg border border-white/[0.08] bg-[#151515] px-4 py-3 text-white outline-none transition duration-200 focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
        >
            <option value="">Selecciona una categoría</option>

            @foreach($categorias as $categoria)
                <option
                    value="{{ $categoria->id }}"
                    @selected((string) $categoriaSeleccionada === (string) $categoria->id)
                >
                    {{ $categoria->nombre }}
                </option>
            @endforeach
        </select>

        @error('categoria_id')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror

        <p class="mt-2 text-xs leading-relaxed text-white/40">
            La categoría seleccionada se guardará como sección y se asociará al contenido.
        </p>
    </div>

    {{-- DESCRIPCIÓN --}}
    <div>
        <label
            for="descripcion"
            class="mb-2 block text-sm font-medium tracking-wide text-[#F5F3ED]"
        >
            Descripción
        </label>

        <textarea
            id="descripcion"
            name="descripcion"
            rows="6"
            class="w-full rounded-lg border border-white/[0.08] bg-[#151515] px-4 py-3 text-white outline-none transition duration-200 placeholder:text-white/30 focus:border-[#A99045] focus:ring-1 focus:ring-[#A99045]"
            placeholder="Describe el contenido..."
        >{{ old('descripcion', $contenido->descripcion ?? '') }}</textarea>

        @error('descripcion')
            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
        @enderror
    </div>

</div>
