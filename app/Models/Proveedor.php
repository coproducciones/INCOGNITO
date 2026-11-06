<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use SoftDeletes;

    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    public const CREATED_AT = 'creado_en';
    public const UPDATED_AT = 'actualizado_en';
    public const DELETED_AT = 'eliminado_en';

    protected $fillable = [
        'id_usuario', 'especialidad', 'telefono', 'whatsapp', 'descripcion', 'foto_url',
    ];

    protected $casts = [
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
        'eliminado_en' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    /**
     * Categorías a las que pertenece este proveedor.
     * Relación muchos a muchos mediante proveedor_categorias.
     */
    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Categoria::class,
            'proveedor_categorias',
            'id_proveedor',
            'id_categoria',
            'id_proveedor',
            'id'
        );
    }

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_proveedor', 'id_proveedor');
    }

    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_proveedor', 'id_proveedor');
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        $numero = preg_replace('/\D+/', '', (string) $this->whatsapp);

        if ($numero === '') {
            return null;
        }

        // Un celular colombiano de 10 dígitos (3XXXXXXXXX) necesita el
        // indicativo 57 para que wa.me abra el chat correctamente.
        if (strlen($numero) === 10 && str_starts_with($numero, '3')) {
            $numero = '57' . $numero;
        }

        return "https://wa.me/{$numero}";
    }

    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->whereHas('disponibilidades', function (Builder $q) {
            $q->where('fecha', '>=', now()->toDateString())
                ->where('disponible', true);
        });
    }
    public function contenidos(): \Illuminate\Database\Eloquent\Relations\HasMany
{
    return $this->hasMany(
        \App\Models\Contenido::class,
        'id_proveedor',
        'id_proveedor'
    );
}
}
