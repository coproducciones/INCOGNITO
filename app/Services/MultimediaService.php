<?php

namespace App\Services;

use App\Models\Multimedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class MultimediaService
{
    public function getAll(): Collection
    {
        return Multimedia::query()
            ->with(['producto', 'contenido'])
            ->latest('id')
            ->get();
    }

    public function create(array $data): Multimedia
    {
        /** @var UploadedFile $archivo */
        $archivo = $data['archivo'];

        $ruta = $archivo->store('multimedia', 'public');

        try {
            return DB::transaction(function () use ($data, $ruta) {
                return Multimedia::create([
                    'url' => $ruta,
                    'tipo' => $data['tipo'],
                    'destacado' => (bool) ($data['destacado'] ?? false),
                    'id_producto' => $data['id_producto'] ?? null,
                    'id_contenido' => $data['id_contenido'] ?? null,
                ]);
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($ruta);

            throw $exception;
        }
    }

    public function update(Multimedia $media, array $data): Multimedia
    {
        $rutaAnterior = $media->url;
        $rutaNueva = null;

        if (
            isset($data['archivo'])
            && $data['archivo'] instanceof UploadedFile
        ) {
            $rutaNueva = $data['archivo']->store('multimedia', 'public');
        }

        try {
            DB::transaction(function () use ($media, $data, $rutaNueva): void {
                $media->update([
                    'url' => $rutaNueva ?? $media->url,
                    'tipo' => $data['tipo'],
                    'destacado' => (bool) ($data['destacado'] ?? false),
                    'id_producto' => $data['id_producto'] ?? null,
                    'id_contenido' => $data['id_contenido'] ?? null,
                ]);
            });
        } catch (Throwable $exception) {
            if ($rutaNueva !== null) {
                Storage::disk('public')->delete($rutaNueva);
            }

            throw $exception;
        }

        if (
            $rutaNueva !== null
            && $rutaAnterior !== $rutaNueva
            && $this->esRutaLocal($rutaAnterior)
        ) {
            Storage::disk('public')->delete($rutaAnterior);
        }

        return $media->refresh();
    }

    public function delete(Multimedia $media): bool
    {
        $ruta = $media->url;

        DB::transaction(function () use ($media): void {
            $media->delete();
        });

        if ($this->esRutaLocal($ruta)) {
            Storage::disk('public')->delete($ruta);
        }

        return true;
    }

    private function esRutaLocal(?string $ruta): bool
    {
        if (!$ruta || Str::startsWith($ruta, ['http://', 'https://', '//'])) {
            return false;
        }

        return Str::startsWith($ruta, 'multimedia/');
    }
}