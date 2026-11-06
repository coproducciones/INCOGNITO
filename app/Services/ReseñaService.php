<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Reseña;
use App\Models\Usuario;
use App\Repositories\ReseñaRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;

class ReseñaService
{
    /**
     * Repositorio encargado del acceso a los datos de las reseñas.
     */
    public function __construct(
        private ReseñaRepository $repository
    ) {
    }

    /**
     * Obtiene todas las reseñas registradas.
     */
    public function getAll()
    {
        return $this->repository->all();
    }

    /**
     * Obtiene una reseña por su identificador.
     */
    public function getById(int $id): Reseña
    {
        return $this->repository->findOrFail($id);
    }

    /**
     * Registra una reseña desde el módulo administrativo.
     *
     * Si no se proporciona una fecha, se utiliza la fecha actual.
     */
    public function create(array $data): Reseña
    {
        return DB::transaction(function () use ($data) {
            // La ficha de cliente se resuelve en el servidor a partir
            // del usuario elegido por el administrador.
            $cliente = $this->clienteDeUsuario((int) $data['id_usuario']);

            $data['id_cliente'] = $cliente->id_cliente;
            $data['fecha'] = $data['fecha'] ?? now();

            return $this->repository->create($data);
        });
    }

    /**
     * Actualiza una reseña desde el módulo administrativo.
     */
    public function update(
        Reseña $reseña,
        array $data
    ): Reseña {
        return DB::transaction(function () use ($reseña, $data) {
            // Si la administración cambia el usuario de la reseña,
            // también se sincroniza la ficha de cliente relacionada.
            $usuarioId = (int) ($data['id_usuario'] ?? $reseña->id_usuario);
            $cliente = $this->clienteDeUsuario($usuarioId);
            $data['id_cliente'] = $cliente->id_cliente;

            return $this->repository->update($reseña, $data);
        });
    }

    /**
     * Elimina una reseña desde el módulo administrativo.
     */
    public function delete(Reseña $reseña): bool
    {
        return $this->repository->delete($reseña);
    }

    /**
     * Obtiene las reseñas asociadas a un producto.
     */
    public function getByProducto(int $id)
    {
        return $this->repository->forProducto($id);
    }

    /*
    |--------------------------------------------------------------------------
    | MIS RESEÑAS
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene las reseñas del usuario autenticado.
     */
    public function misResenas(int $usuarioId)
    {
        return $this->repository->forUsuario($usuarioId);
    }

    /**
     * Busca una reseña y comprueba que pertenezca al usuario indicado.
     */
    public function miResena(
        int $reseñaId,
        int $usuarioId
    ): Reseña {
        return $this->repository->findForUsuario(
            $reseñaId,
            $usuarioId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | PRODUCTOS DISPONIBLES PARA RESEÑAR
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene los productos que el usuario puede reseñar.
     *
     * Condiciones:
     * 1. El producto debe estar incluido en un pedido del usuario.
     * 2. El pedido debe tener un estado de tipo PEDIDO y nombre
     *    "completado", sin distinguir mayúsculas ni espacios externos.
     * 3. El usuario no debe haber reseñado ya ese producto.
     *
     * Las relaciones utilizadas corresponden a los modelos:
     * Producto -> detallesPedido -> pedido -> estado.
     */
    public function productosParaResenar(int $usuarioId)
    {
        return Producto::query()
            ->whereHas(
                'detallesPedido.pedido',
                function (Builder $pedidoQuery) use ($usuarioId) {
                    $pedidoQuery
                        ->where('id_usuario', $usuarioId)
                        ->whereHas(
                            'estado',
                            function (Builder $estadoQuery) {
                                $estadoQuery
                                    ->where('tipo', 'PEDIDO')
                                    ->whereRaw(
                                        'LOWER(TRIM(nombre)) = ?',
                                        ['completado']
                                    );
                            }
                        );
                }
            )
            // La exclusión se ejecuta en SQL, no con una consulta
            // adicional por cada producto recuperado.
            ->whereDoesntHave(
                'resenas',
                fn (Builder $resenaQuery) => $resenaQuery
                    ->where('id_usuario', $usuarioId)
            )
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Comprueba si el usuario puede reseñar un producto.
     *
     * La comprobación se repite en el servidor al guardar la reseña;
     * no se confía únicamente en los productos mostrados en la vista.
     */
    public function puedeResenarProducto(
        int $usuarioId,
        int $productoId
    ): bool {
        $pedidoValido = Pedido::query()
            ->where('id_usuario', $usuarioId)
            ->whereHas(
                'estado',
                function (Builder $estadoQuery) {
                    $estadoQuery
                        ->where('tipo', 'PEDIDO')
                        ->whereRaw(
                            'LOWER(TRIM(nombre)) = ?',
                            ['completado']
                        );
                }
            )
            ->whereHas(
                'detalles',
                function (Builder $detalleQuery) use ($productoId) {
                    $detalleQuery->where(
                        'id_producto',
                        $productoId
                    );
                }
            )
            ->exists();

        if (!$pedidoValido) {
            return false;
        }

        return !$this->repository->existsForUsuarioProducto(
            $usuarioId,
            $productoId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREAR MI RESEÑA
    |--------------------------------------------------------------------------
    */

    /**
     * Registra una reseña para un producto comprado por el usuario.
     *
     * El identificador del cliente se obtiene en el servidor.
     * Nunca se toma del formulario enviado por el navegador.
     */
    public function crearMiResena(
        int $usuarioId,
        array $data
    ): Reseña {
        return DB::transaction(function () use ($usuarioId, $data) {
            $productoId = (int) $data['id_producto'];

            // Revalidar en el servidor la compra completada y el duplicado.
            if (!$this->puedeResenarProducto($usuarioId, $productoId)) {
                throw ValidationException::withMessages([
                    'id_producto' =>
                        'No puedes reseñar este producto. Debes tener un pedido completado que lo incluya y no haberlo reseñado anteriormente.',
                ]);
            }

            $cliente = $this->clienteDeUsuario($usuarioId);

            // Los identificadores de propietario se generan en servidor.
            return $this->repository->create([
                'id_usuario' => $usuarioId,
                'id_producto' => $productoId,
                'id_cliente' => $cliente->id_cliente,
                'calificacion' => (int) $data['calificacion'],
                'comentario' => $data['comentario'] ?? null,
                'fecha' => now(),
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR MI RESEÑA
    |--------------------------------------------------------------------------
    */

    /**
     * Actualiza la calificación y el comentario de una reseña propia.
     *
     * El usuario no puede cambiar el producto ni la titularidad
     * de la reseña desde este método.
     */
    public function actualizarMiResena(
        Reseña $reseña,
        int $usuarioId,
        array $data
    ): Reseña {
        // La búsqueda ya está limitada por id_usuario: una URL manipulada
        // no permite modificar reseñas de otra cuenta.
        $reseñaPropia = $this->repository->findForUsuario(
            (int) $reseña->getKey(),
            $usuarioId
        );

        return $this->repository->update(
            $reseñaPropia,
            [
                'calificacion' => (int) $data['calificacion'],
                'comentario' => $data['comentario'] ?? null,
            ]
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR MI RESEÑA
    |--------------------------------------------------------------------------
    */

    /**
     * Elimina una reseña únicamente si pertenece al usuario.
     */
    public function eliminarMiResena(
        Reseña $reseña,
        int $usuarioId
    ): bool {
        // El registro se recupera exclusivamente dentro del conjunto propio.
        $reseñaPropia = $this->repository->findForUsuario(
            (int) $reseña->getKey(),
            $usuarioId
        );

        return $this->repository->delete($reseñaPropia);
    }

    /**
     * Lista únicamente las reseñas de productos pertenecientes al proveedor.
     */
    public function resenasDelProveedor(int $proveedorId)
    {
        return Reseña::query()
            ->with(['usuario', 'producto'])
            ->whereHas('producto', function (Builder $query) use ($proveedorId): void {
                $query->where('id_proveedor', $proveedorId);
            })
            ->orderByDesc('fecha')
            ->paginate(15)
            ->withQueryString();
    }

    /**
     * Guarda exclusivamente la respuesta del proveedor.
     * No modifica comentario, calificación, usuario ni producto.
     */
    public function responderComoProveedor(
        Reseña $reseña,
        int $proveedorId,
        string $respuesta
    ): Reseña {
        $reseñaPropia = Reseña::query()
            ->whereKey($reseña->getKey())
            ->whereHas('producto', function (Builder $query) use ($proveedorId): void {
                $query->where('id_proveedor', $proveedorId);
            })
            ->firstOrFail();

        $reseñaPropia->respuesta = trim($respuesta);
        $reseñaPropia->save();

        return $reseñaPropia->refresh()->load(['usuario', 'producto']);
    }

    /**
     * Obtiene o crea la ficha de cliente vinculada a una cuenta.
     * Nunca acepta un id_cliente enviado por el navegador.
     */
    private function clienteDeUsuario(int $usuarioId): Cliente
    {
        $usuario = Usuario::query()->findOrFail($usuarioId);

        return Cliente::query()->firstOrCreate(
            ['id_usuario' => $usuarioId],
            ['nombre' => $usuario->nombre]
        );
    }
}