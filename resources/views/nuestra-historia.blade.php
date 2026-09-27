@extends('layouts.app')

@section('title', 'Nuestra Historia')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12">

    {{-- Hero --}}
    <div class="text-center mb-16">
        <h1 class="text-4xl font-bold 'text-white' 'text-white' mb-4">Nuestra Historia</h1>
        <p class="text-lg 'text-gray-500' text-white max-w-2xl mx-auto">
            Conoce cómo nació Incognito Group Design and Much, quiénes somos y hacia dónde vamos.
        </p>
    </div>

    {{-- Origen --}}
    <div class="flex flex-col md:flex-row items-center gap-10 mb-16">
        <div class="md:w-1/2">
            <h2 class="text-2xl font-bold text-green-500">¿Cómo empezamos?</h2>
            <p class="'text-gray-600' 'text-white' leading-relaxed mb-4">
                Incognito Group nació en Málaga, Santander, como una idea entre personas apasionadas
                por el arte, la comunicación y la tecnología. Lo que comenzó como proyectos pequeños
                para amigos y conocidos, fue creciendo hasta convertirse en una agencia creativa
                con presencia regional.
            </p>
            <p class="'text-gray-600' 'text-white' leading-relaxed">
                Desde el inicio, nuestra filosofía fue clara: calidad sin pretextos, creatividad sin límites
                y compromiso con cada cliente, sin importar el tamaño del proyecto.
            </p>
        </div>
        <div class="md:w-1/2 bg-gray-100 dark:bg-gray-800 rounded-2xl p-10 text-center">
            <span class="text-7xl">🎯</span>
            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm italic">
                "Crear con propósito, comunicar con impacto."
            </p>
        </div>
    </div>

    {{-- Misión y Visión --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
        <div class="bg-gray-900 dark:bg-gray-700 rounded-2xl p-8 text-white">
            <div class="text-3xl mb-4">🧭</div>
            <h3 class="text-xl font-bold mb-3">Nuestra Misión</h3>
            <p class="text-gray-300 leading-relaxed">
                Brindar soluciones creativas integrales que conecten a las marcas con sus audiencias
                a través de producción audiovisual, musical, diseño y manufactura, con altos estándares
                de calidad y compromiso humano.
            </p>
        </div>
        <div class="bg-green-600 rounded-2xl p-8 text-white">
            <div class="text-3xl mb-4">🚀</div>
            <h3 class="text-xl font-bold mb-3">Nuestra Visión</h3>
            <p class="text-green-100 leading-relaxed">
                Ser la agencia creativa de referencia en la región de García Rovira y Santander,
                expandiendo nuestro impacto a nivel nacional con una plataforma digital que conecte
                talento creativo con quienes lo necesitan.
            </p>
        </div>
    </div>

    {{-- Línea de tiempo --}}
    <div class="mb-16">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-10">Nuestro camino</h2>

        <div class="relative border-l-2 border-gray-200 dark:border-gray-700 pl-8 space-y-10">

            <div class="relative">
                <span class="absolute '-left-[41px]' w-5 h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-900"></span>
                <p class="text-sm text-green-500 font-semibold mb-1">2020</p>
                <h4 class="text-lg font-semibold text-white-800 dark:text-white mb-1">Los primeros proyectos</h4>
                <p class="text-gray-500 dark:text-gray-400 text-sm">
                    Fundados Por Cesar Ortiz Design