<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /** Página principal pública. */
    public function index()
    {
        $imagenesRespaldo = [
            'https://images.unsplash.com/photo-1549490349-8643362247b5?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1492619375914-88005aa9e8fb?auto=format&fit=crop&w=1000&q=85',
            'https://images.unsplash.com/photo-1531058020387-3be344556be6?auto=format&fit=crop&w=1000&q=85',
        ];

        // La tabla contenido compartida no tiene columnas publicado ni id_proveedor.
        // Cargamos los contenidos vinculados a cada categoría y sus archivos multimedia.
        $categorias = Categoria::query()
            ->withCount('productos')
            ->with(['contenidos.media' => function ($query) {
                $query->whereNotNull('id_contenido')
                    ->whereNotNull('url')
                    ->orderByDesc('destacado')
                    ->orderByDesc('id');
            }])
            ->orderBy('nombre')
            ->get()
            ->map(function ($categoria) use ($imagenesRespaldo) {
                $archivos = $categoria->contenidos
                    ->flatMap(fn ($contenido) => $contenido->media)
                    ->filter(fn ($archivo) => filled($archivo->url))
                    ->sortByDesc('destacado')
                    ->values();

                $archivo = $archivos->first();

                if ($archivo) {
                    $categoria->multimedia_portada = $archivo->url_publica;
                    $categoria->tipo_portada = strtolower(trim((string) $archivo->tipo));
                } else {
                    $categoria->multimedia_portada = $imagenesRespaldo[array_rand($imagenesRespaldo)];
                    $categoria->tipo_portada = 'imagen';
                }

                return $categoria;
            });

        $productos = Producto::query()
            ->with(['categoria', 'media' => function ($query) {
                $query->whereNotNull('url')
                    ->orderByDesc('destacado')
                    ->orderByDesc('id');
            }])
            ->where('activo', true)
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.index', compact('categorias', 'productos'));
    }
}
