<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Multimedia extends Model
{
    protected $table = 'multimedia';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'url',
        'tipo',
        'destacado',
        'id_producto',
        'id_contenido',
    ];

    protected $casts = [
        'destacado' => 'boolean',
    ];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }

    public function contenido(): BelongsTo
    {
        return $this->belongsTo(
            Contenido::class,
            'id_contenido',
            'id_contenido'
        );
    }

    public function getUrlPublicaAttribute(): string
    {
        $ruta = (string) $this->url;

        if (Str::startsWith($ruta, ['http://', 'https://', '//'])) {
            return $ruta;
        }

        return Storage::disk('public')->url($ruta);
    }
}