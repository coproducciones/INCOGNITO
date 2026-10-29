<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(
            Usuario::class,
            'id_usuario',
            'id'
        );
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(
            Reseña::class,
            'id_cliente',
            'id_cliente'
        );
    }
}