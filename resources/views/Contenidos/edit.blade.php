@extends('layouts.app')
@section('title', 'Editar contenido')
@section('content')
<div class="mx-auto max-w-3xl space-y-6"><div><h1 class="text-2xl font-semibold text-white">Editar contenido</h1><p class="text-sm text-gray-400">Actualiza la información seleccionada.</p></div><form method="POST" action="{{ route('contenidos.update', $contenido) }}" class="rounded-xl border border-white/10 bg-[#111111] p-6">@csrf @method('PUT') @include('Contenidos._form')<div class="mt-6 flex justify-end gap-3"><a href="{{ route('contenidos.index') }}" class="rounded-lg border border-white/10 px-4 py-2 text-sm text-gray-300">Cancelar</a><button class="rounded-lg bg-[#00c896] px-4 py-2 text-sm font-semibold text-black">Actualizar</button></div></form></div>
@endsection
