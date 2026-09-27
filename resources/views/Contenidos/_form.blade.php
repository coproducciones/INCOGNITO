<div class="space-y-5">
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-300">Título</label>
        <input type="text" name="titulo" value="{{ old('titulo', $contenido->titulo ?? '') }}" required maxlength="150" class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]">
        @error('titulo')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-300">Sección</label>
        <input type="text" name="seccion" value="{{ old('seccion', $contenido->seccion ?? '') }}" required maxlength="100" class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]">
        @error('seccion')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="mb-2 block text-sm font-medium text-gray-300">Descripción</label>
        <textarea name="descripcion" rows="6" class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-3 text-white outline-none focus:border-[#00c896]">{{ old('descripcion', $contenido->descripcion ?? '') }}</textarea>
        @error('descripcion')<p class="mt-1 text-sm text-red-400">{{ $message }}</p>@enderror
    </div>
</div>
