<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'empresa',
        'logo_url',
    ];

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
