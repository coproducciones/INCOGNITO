@extends('layouts.app')

@section('title', 'Registrar disponibilidad')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-white mb-2">Registrar disponibilidad</h1>
    <p class="text-gray-400 mb-6">Proveedor: {{ $proveedor->especialidad }}</p>
    <form method="POST" action="{{ route('proveedores.disponibilidades.store', $proveedor) }}" class="space-y-5 rounded-xl border border-white/10 bg-[#111111] p-6">
        @csrf
        <input type="hidden" name="id_proveedor" value="{{ $proveedor->id_proveedor }}">
        <div>
            <label class="block text-sm text-gray-300 mb-2">Fecha</label>
            <input type="date" name="fecha" value="{{ old('fecha') }}" required class="w-full rounded-lg bg-[#1a1a1a] border border-white/10 text-white px-3 py-2">
            @error('fecha') <p class="text-red-300 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm text-gray-300 mb-2">Disponibilidad</label>
            <select name="disponible" required class="w-full rounded-lg bg-[#1a1a1a] border border-white/10 text-white px-3 py-2">
                <option value="1">Disponible</option>
                <option value="0">No disponible</option>
            </select>
        </div>
        <button class="px-4 py-2 rounded-lg bg-[#00c896] text-black font-semibold">Guardar</button>

        
    </form>
</div>
@endsection
