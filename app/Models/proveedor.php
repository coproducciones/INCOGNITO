<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'id_usuario',
        'especialidad',
        'telefono',
        'whatsapp',
        'descripcion',
        'foto_url',
    ];

    protected $casts = [
        'creado_en' => 'datetime',
        'actualizado_en' => 'datetime',
        'eliminado_en' => 'datetime',
    ];

    /** El proveedor está asociado a un usuario de la plataforma. */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

    /** Un proveedor puede ofrecer varios productos. */
    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'id_proveedor', 'id_proveedor');
    }

    /** Horarios y disponibilidad del proveedor. */
    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidad::class, 'id_proveedor', 'id_proveedor');
    }

    /** Devuelve el enlace directo al chat de WhatsApp, si hay número registrado. */
    public function getWhatsappUrlAttribute(): ?string
    {
        $numero = preg_replace('/\D+/', '', (string) $this->whatsapp);

        return $numero !== '' ? "https://wa.me/{$numero}" : null;
    }

    /** Filtra proveedores con disponibilidad vigente. */
    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->whereHas('disponibilidades', function (Builder $q) {
            $q->where('fecha', '>=', now()->toDateString())
                ->where('disponible', true);
        });
    }
}
