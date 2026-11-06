<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Multimedia;

class Producto extends Model
{
    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'id_proveedor',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Productos visibles en el catálogo público: activos y que no pertenezcan
     * a un proveedor eliminado. Los productos sin proveedor asignado se
     * mantienen visibles (son del catálogo propio de la empresa).
     */
    public function scopePublicos(Builder $query): Builder
    {
        return $query
            ->where('activo', true)
            ->where(function (Builder $filtro) {
                $filtro->whereNull('id_proveedor')
                    ->orWhereHas('proveedor');
            });
    }

    /**
     * Enlace de WhatsApp para consultar por este producto.
     * Usa el WhatsApp del proveedor y, si no tiene, el de la empresa.
     */
    public function whatsappConsultaUrl(): string
    {
        $urlProveedor = $this->proveedor?->whatsapp_url;

        if ($urlProveedor) {
            $mensaje = 'Hola, vi el producto «' . $this->nombre
                . '» en Incógnito Group Design y quiero más información.';

            return $urlProveedor . '?text=' . rawurlencode($mensaje);
        }

        $mensaje = 'Hola, Incognito Group Design. Quiero información sobre: '
            . $this->nombre . '.';

        return 'https://wa.me/' . config('services.whatsapp.empresa_numero')
            . '?text=' . rawurlencode($mensaje);
    }

    /** Un producto pertenece a una categoría. */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(
            Categoria::class,
            'categoria_id',
            'id'
        );
    }

    /** Un producto pertenece a un proveedor. */
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(
            Proveedor::class,
            'id_proveedor',
            'id_proveedor'
        );
    }

    /** Un producto puede aparecer en varios detalles de pedido. */
    public function detallesPedido(): HasMany
    {
        return $this->hasMany(
            DetallePedido::class,
            'id_producto',
            'id'
        );
    }

    /**
     * Un producto puede tener varios archivos multimedia
     * (imágenes u otros recursos asociados).
     */
    public function media(): HasMany
    {
        return $this->hasMany(
            Multimedia::class,
            'id_producto',
            'id'
        );
    }

    /** Un producto puede recibir reseñas de distintos usuarios. */
    public function resenas(): HasMany
    {
        return $this->hasMany(
            Reseña::class,
            'id_producto',
            'id'
        );
    }
}
