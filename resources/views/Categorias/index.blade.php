@extends('layouts.app')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-white font-black text-xl uppercase tracking-widest">
                Categorías
            </h1>
            <p class="text-xs uppercase tracking-widest mt-1"
                style="color:rgba(255,255,255,0.4);">
                Gestión de categorías
            </p>
        </div>

        <a href="{{ route('categorias.create') }}"
            class="flex items-center gap-2 px-5 py-2 font-black uppercase tracking-widest transition-colors"
            style="background-color:#00c896; color:#000; border-radius:4px; font-size:11px;">
            + Nueva categoría
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 px-4 py-3 font-bold text-sm uppercase tracking-wider"
            style="background-color:rgba(0,200,150,0.1); border:1px solid rgba(0,200,150,0.3); color:#00c896; border-radius:4px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background-color:#1a1a1a; border:1px solid rgba(255,255,255,0.08); border-radius:4px; overflow:hidden;">
        <table class="w-full">
            <thead>
                <tr style="border-bottom:1px solid rgba(255,255,255,0.08);">
                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="color:rgba(255,255,255,0.4); font-size:10px;">ID</th>
                    <th class="px-6 py-4 text-left font-black uppercase tracking-widest"
                        style="color:rgba(255,255,255,0.4); font-size:10px;">Nombre</th>
                    <th class="px-6 py-4 text-center font-black uppercase tracking-widest"
                        style="color:rgba(255,255,255,0.4); font-size:10px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr style="border-bottom:1px solid rgba(255,255,255,0.05);"
                        onmouseenter="this.style.background='rgba(255,255,255,0.03)'"
                        onmouseleave="this.style.background='transparent'">

                        <td class="px-6 py-4 font-bold"
                            style="color:rgba(255,255,255,0.35); font-size:12px;">
                            #{{ $categoria->id }}
                        </td>
                        <td class="px-6 py-4 font-bold text-white"
                            style="font-size:13px;">
                            {{ $categoria->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('categorias.edit', $categoria) }}"
                                    class="px-4 py-2 font-black uppercase tracking-widest"
                                    style="font-size:10px; background-color:rgba(255,200,0,0.1); color:#fbbf24; border:1px solid rgba(251,191,36,0.3); border-radius:4px;">
                                    Editar
                                </a>
                                <form action="{{ route('categorias.destroy', $categoria) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-4 py-2 font-black uppercase tracking-widest"
                                        style="font-size:10px; background-color:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(248,113,113,0.3); border-radius:4px;">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center font-bold uppercase tracking-widest"
                            style="color:rgba(255,255,255,0.25); font-size:11px;">
                            No hay categorías registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection