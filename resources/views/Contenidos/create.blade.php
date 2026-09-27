@extends('layouts.app')

@section('title', 'Nuevo contenido')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold text-white mb-1">Nuevo contenido</h1>
    <p class="text-gray-400 mb-8">Registra información pública para una sección.</p>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/40 text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contenidos.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Título --}}
        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-300 mb-1">Título</label>
            <input type="text" 
                   name="titulo" 
                   id="titulo" 
                   value="{{ old('titulo') }}"
                   class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-2.5 text-white focus:border-[#00c896] focus:outline-none focus:ring-1 focus:ring-[#00c896]"
                   required>
        </div>

        {{-- Sección / Categoría --}}
        <div>
            <label for="categoria_id" class="block text-sm font-medium text-gray-300 mb-1">Sección / Categoría</label>
            <select name="categoria_id" 
                    id="categoria_id" 
                    class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-2.5 text-white focus:border-[#00c896] focus:outline-none focus:ring-1 focus:ring-[#00c896]"
                    required>
                <option value="">Selecciona una sección</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Descripción --}}
        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-300 mb-1">Descripción</label>
            <textarea name="descripcion" 
                      id="descripcion" 
                      rows="5"
                      class="w-full rounded-lg border border-white/10 bg-[#1a1a1a] px-4 py-2.5 text-white focus:border-[#00c896] focus:outline-none focus:ring-1 focus:ring-[#00c896]">{{ old('descripcion') }}</textarea>
        </div>

{{-- Botones --}}
<div class="flex justify-between items-center pt-4">
    {{-- Botón Volver --}}
    <a href="{{ route('contenidos.index') }}" 
       class="px-5 py-2.5 rounded-lg border border-white/20 text-gray-300 hover:bg-white/5 transition-colors">
        ← Volver a contenidos
    </a>

    <div class="flex gap-3">
        <a href="{{ url()->previous() }}" 
           class="px-5 py-2.5 rounded-lg border border-white/20 text-gray-300 hover:bg-white/5 transition-colors">
            Cancelar
        </a>
        <button type="submit" 
                class="bg-[#00c896] hover:bg-[#00b085] text-white font-medium px-6 py-2.5 rounded-lg transition-colors">
            Guardar
        </button>
    </div>
</div>
</form>
@endsection