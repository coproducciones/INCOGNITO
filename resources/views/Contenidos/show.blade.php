@extends('layouts.app')
@section('title', 'Detalle de contenido')
@section('content')
<div class="mx-auto max-w-3xl rounded-xl border border-white/10 bg-[#111111] p-6"><div class="mb-6 flex items-center justify-between"><h1 class="text-2xl font-semibold text-white">{{ $contenido->titulo }}</h1><a href="{{ route('contenidos.edit', $contenido) }}" class="text-[#00c896]">Editar</a></div><p class="mb-2 text-xs uppercase tracking-wider text-gray-500">{{ $contenido->seccion }}</p><p class="whitespace-pre-line text-gray-300">{{ $contenido->descripcion ?: 'Sin descripción.' }}</p></div>
@endsection
