<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'nombre',
        'empresa',
        'logo_url',
    ];

    /**
     * Un cliente puede estar asociado a una cuenta de usuario.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'id_usuario',
            'id'
        );
    }

    /**
     * Un cliente puede tener muchas reseñas.
     *
     * reseña.id_cliente
     *       ↓
     * clientes.id_cliente
     */
    public function reseñas(): HasMany
    {
        return $this->hasMany(
            Reseña::class,
            'id_cliente',
            'id_cliente'
        );
    }
}
