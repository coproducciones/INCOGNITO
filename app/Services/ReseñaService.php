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
        $data['fecha'] = $data['fecha'] ?? now();

        return $this->repository->create($data);
    }

    /**
     * Actualiza una reseña desde el módulo administrativo.
     */
    public function update(
        Reseña $reseña,
        array $data
    ): Reseña {
        return $this->repository->update(
            $reseña,
            $data
        );
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
        $productos = Producto::query()
            ->whereHas(
                'detallesPedido',
                function (Builder $detalleQuery) use ($usuarioId) {
                    $detalleQuery->whereHas(
                        'pedido',
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
                    );
                }
            )
            ->orderBy('nombre')
            ->get();

        /*
         * Se excluyen los productos que ya fueron reseñados.
         * El repositorio centraliza la comprobación de duplicados.
         */
        return $productos
            ->filter(
                function (Producto $producto) use ($usuarioId) {
                    return !$this->repository
                        ->existsForUsuarioProducto(
                            $usuarioId,
                            (int) $producto->getKey()
                        );
                }
            )
            ->values();
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
        $productoId = (int) $data['id_producto'];

        /*
         * Validar nuevamente la compra y evitar reseñas duplicadas.
         */
        if (!$this->puedeResenarProducto(
            $usuarioId,
            $productoId
        )) {
            throw ValidationException::withMessages([
                'id_producto' =>
                    'No puedes reseñar este producto. Debes tener un pedido completado que lo incluya y no haberlo reseñado anteriormente.',
            ]);
        }

        /*
         * Obtener el usuario autenticado y su ficha de cliente.
         *
         * Si no existe una ficha asociada, se crea una básica.
         * Esto requiere que clientes.id_usuario exista y permita
         * guardar el identificador del usuario.
         */
        $usuario = Usuario::findOrFail($usuarioId);

        $cliente = Cliente::firstOrCreate(
            [
                'id_usuario' => $usuarioId,
            ],
            [
                'nombre' => $usuario->nombre,
            ]
        );

        /*
         * Los campos sensibles se construyen en el servidor.
         * El usuario no puede elegir otro id_usuario o id_cliente.
         */
        return $this->repository->create([
            'id_usuario' => $usuarioId,
            'id_producto' => $productoId,
            'id_cliente' => $cliente->id_cliente,
            'calificacion' => (int) $data['calificacion'],
            'comentario' => $data['comentario'] ?? null,
            'fecha' => now(),
        ]);
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
        if ((int) $reseña->id_usuario !== $usuarioId) {
            abort(403);
        }

        return $this->repository->update(
            $reseña,
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
        if ((int) $reseña->id_usuario !== $usuarioId) {
            abort(403);
        }

        return $this->repository->delete($reseña);
    }
}