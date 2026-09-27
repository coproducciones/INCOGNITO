@extends('layouts.app')

@section('title', 'Nuestro Trabajo')

@section('content')

<div
    class="min-h-screen bg-cover bg-center bg-fixed relative"
    style="background-image: url('/images/fondo-nuestro-trabajo.jpg');"
>

    {{-- Capa oscura sobre la imagen --}}
    <div class="absolute inset-0 bg-black/60"></div>

    {{-- Contenido --}}
    <div class="relative max-w-7xl mx-auto px-6 py-12">

        {{-- Hero --}}
        <div class="text-center mb-16">

            <h1 class="text-4xl font-bold text-white mb-4">
                Nuestro Trabajo
            </h1>

            <p class="text-lg text-gray-200 max-w-2xl mx-auto mt-5">
                Somos un equipo creativo dedicado a la producción <strong>audiovisual,
                musical, manufactura y artes visuales.</strong>
            </p>

            <h2 class="text-2xl font-bold text-green-400 mb-4">
                Aquí encontrarás una muestra de lo que hacemos.
            </h2>

        </div>


        {{-- Áreas de trabajo --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">

            {{-- Producción Audiovisual --}}
            <div class="bg-white/95 rounded-2xl shadow p-6 text-center hover:shadow-lg hover:-translate-y-1 transition">

                <div class="text-4xl mb-4">
                    🎬
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Producción Audiovisual
                </h3>

                <p class="text-sm text-gray-500">
                    Fotografía, video corporativo, cobertura de eventos y
                    edición profesional.
                </p>

            </div>


            {{-- Producción Musical --}}
            <div class="bg-white/95 rounded-2xl shadow p-6 text-center hover:shadow-lg hover:-translate-y-1 transition">

                <div class="text-4xl mb-4">
                    🎵
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Producción Musical
                </h3>

                <p class="text-sm text-gray-500">
                    Grabación, mezcla, masterización y producción de contenido
                    sonoro.
                </p>

            </div>


            {{-- Artes Visuales --}}
            <div class="bg-white/95 rounded-2xl shadow p-6 text-center hover:shadow-lg hover:-translate-y-1 transition">

                <div class="text-4xl mb-4">
                    🎨
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Artes Visuales
                </h3>

                <p class="text-sm text-gray-500">
                    Diseño gráfico, identidad de marca, ilustración y arte
                    digital.
                </p>

            </div>


            {{-- Manufactura --}}
            <div class="bg-white/95 rounded-2xl shadow p-6 text-center hover:shadow-lg hover:-translate-y-1 transition">

                <div class="text-4xl mb-4">
                    🏭
                </div>

                <h3 class="text-lg font-semibold text-gray-800 mb-2">
                    Manufactura
                </h3>

                <p class="text-sm text-gray-500">
                    Producción de materiales físicos, merchandising y productos
                    personalizados.
                </p>

            </div>

        </div>


        {{-- Estadísticas --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">

            <div class="bg-gray-900/90 rounded-2xl p-8 text-center text-white">
                <p class="text-5xl font-bold mb-2">
                    +120
                </p>

                <p class="text-gray-300 text-sm">
                    Proyectos completados
                </p>
            </div>


            <div class="bg-gray-900/90 rounded-2xl p-8 text-center text-white">
                <p class="text-5xl font-bold mb-2">
                    +60
                </p>

                <p class="text-gray-300 text-sm">
                    Clientes satisfechos
                </p>
            </div>


            <div class="bg-gray-900/90 rounded-2xl p-8 text-center text-white">
                <p class="text-5xl font-bold mb-2">
                    4+
                </p>

                <p class="text-gray-300 text-sm">
                    Años de experiencia
                </p>
            </div>

        </div>


        {{-- CTA --}}
        <div class="text-center">

            <p class="text-gray-200 mb-4">
                ¿Tienes un proyecto en mente?
            </p>

            <a
                href="#"
                class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold px-8 py-3 rounded-full transition"
            >
                Trabaja con nosotros
            </a>

        </div>

    </div>

</div>

@endsection