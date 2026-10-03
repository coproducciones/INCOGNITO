<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetallePedidoStoreRequest;
use App\Http\Requests\DetallePedidoUpdateRequest;
use App\Http\Requests\EstadoPedidoUpdateRequest;
use App\Http\Requests\PedidoStoreRequest;
use App\Http\Requests\PedidoUpdateRequest;

use App\Models\EstadoGeneral;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Usuario;

use App\Repositories\PedidoRepository;
use App\Services\PedidoService;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PedidoController extends Controller
{
    /*
     * =========================================================
     * DEPENDENCIAS
     * =========================================================
     */

    public function __construct(
        private PedidoRepository $repository,
        private PedidoService $service,
    ) {}


    /*
     * =========================================================
     * LISTADO
     * =========================================================
     */

    public function index(): View
    {
        /*
         * Obtenemos todos los pedidos.
         */

        $pedidos = $this->repository->all();


        /*
         * Mostramos la vista.
         */

        return view(
            'Pedidos.index',
            compact('pedidos')
        );
    }


    /*
     * =========================================================
     * FORMULARIO DE CREACIÓN
     * =========================================================
     */

    public function create(): View
    {
        /*
         * Usuarios disponibles.
         */

        $usuarios = Usuario::query()
            ->orderBy('nombre')
            ->get();


        /*
         * Productos activos disponibles.
         *
         * Cargamos también su categoría.
         */

        $productos = Producto::with(
            'categoria'
        )
            ->where(
                'activo',
                true
            )
            ->orderBy('nombre')
            ->get();


        /*
         * Enviamos ambas colecciones
         * a create.blade.php.
         */

        return view(
            'Pedidos.create',
            compact(
                'usuarios',
                'productos'
            )
        );
    }


    /*
     * =========================================================
     * GUARDAR PEDIDO
     * =========================================================
     */

    public function store(
        PedidoStoreRequest $request
    ): RedirectResponse {

        /*
         * Validamos y creamos todo:
         *
         * pedido
         * detalles
         * total
         * evento
         */

        $pedido = $this->service->crear(
            $request->validated()
        );


        /*
         * Después de crear el pedido,
         * mostramos directamente su detalle.
         */

        return redirect()
            ->route(
                'pedidos.show',
                [
                    'pedido' =>
                        $pedido->id_pedido,
                ]
            )
            ->with(
                'success',
                "Pedido #{$pedido->id_pedido} creado correctamente."
            );
    }


    /*
     * =========================================================
     * MOSTRAR PEDIDO
     * =========================================================
     */

    public function show(
        Pedido $pedido
    ): View {

        /*
         * Buscamos nuevamente el pedido
         * utilizando nuestro Repository.
         *
         * Esto permite cargar todas sus relaciones.
         */

        $pedido = $this->repository->find(
            $pedido->id_pedido
        );


        /*
         * Productos activos disponibles
         * para agregar al pedido.
         */

        $productos = Producto::with(
            'categoria'
        )
            ->where(
                'activo',
                true
            )
            ->orderBy('nombre')
            ->get();


        /*
         * Estados disponibles para pedidos.
         */

        $estados = EstadoGeneral::query()
            ->where(
                'tipo',
                'PEDIDO'
            )
            ->orderBy('nombre')
            ->get();


        /*
         * Mostramos la vista.
         */

        return view(
            'Pedidos.show',
            compact(
                'pedido',
                'productos',
                'estados'
            )
        );
    }


    /*
     * =========================================================
     * FORMULARIO DE EDICIÓN
     * =========================================================
     */

    public function edit(
        Pedido $pedido
    ): View {

        /*
         * Cargamos el pedido completo.
         */

        $pedido = $this->repository->find(
            $pedido->id_pedido
        );


        /*
         * Usuarios disponibles.
         */

        $usuarios = Usuario::query()
            ->orderBy('nombre')
            ->get();


        /*
         * Estados disponibles.
         */

        $estados = EstadoGeneral::query()
            ->where(
                'tipo',
                'PEDIDO'
            )
            ->orderBy('nombre')
            ->get();


        /*
         * Mostramos el formulario.
         */

        return view(
            'Pedidos.edit',
            compact(
                'pedido',
                'usuarios',
                'estados'
            )
        );
    }


    /*
     * =========================================================
     * ACTUALIZAR PEDIDO
     * =========================================================
     */

    public function update(
        PedidoUpdateRequest $request,
        Pedido $pedido
    ): RedirectResponse {

        /*
         * Actualizamos la información principal.
         */

        $this->repository->update(
            $pedido,
            $request->validated()
        );


        /*
         * Regresamos al detalle.
         */

        return redirect()
            ->route(
                'pedidos.show',
                [
                    'pedido' =>
                        $pedido->id_pedido,
                ]
            )
            ->with(
                'success',
                'Pedido actualizado correctamente.'
            );
    }


    /*
     * =========================================================
     * CAMBIAR ESTADO
     * =========================================================
     */

    public function updateEstado(
        EstadoPedidoUpdateRequest $request,
        Pedido $pedido
    ): RedirectResponse {

        /*
         * El cambio de estado pasa por el Service.
         */

        $this->service->cambiarEstado(
            $pedido,
            (int) $request->id_estado,
            $request->comentario
        );


        return back()->with(
            'success',
            'Estado del pedido actualizado.'
        );
    }


    /*
     * =========================================================
     * AGREGAR PRODUCTO
     * =========================================================
     */

    public function storeDetalle(
        DetallePedidoStoreRequest $request,
        Pedido $pedido
    ): RedirectResponse {

        /*
         * El Service se encarga de:
         *
         * - comprobar estado
         * - comprobar producto
         * - comprobar stock
         * - calcular subtotal
         * - recalcular total
         */

        $this->service->agregarDetalle(
            $pedido,
            $request->validated()
        );


        return back()->with(
            'success',
            'Producto agregado correctamente al pedido.'
        );
    }


    /*
     * =========================================================
     * MODIFICAR PRODUCTO
     * =========================================================
     */

    public function updateDetalle(
        DetallePedidoUpdateRequest $request,
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {

        /*
         * Modificamos únicamente la cantidad.
         */

        $this->service->modificarDetalle(
            $pedido,
            $detalle,
            $request->validated()
        );


        return back()->with(
            'success',
            'Cantidad actualizada correctamente.'
        );
    }


    /*
     * =========================================================
     * ELIMINAR PRODUCTO
     * =========================================================
     */

    public function destroyDetalle(
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {

        /*
         * Eliminamos el detalle.
         */

        $this->service->eliminarDetalle(
            $pedido,
            $detalle
        );


        return back()->with(
            'success',
            'Producto eliminado correctamente del pedido.'
        );
    }


    /*
     * =========================================================
     * ELIMINAR PEDIDO
     * =========================================================
     */

    public function destroy(
        Pedido $pedido
    ): RedirectResponse {

        /*
         * Guardamos el ID antes de eliminar.
         */

        $idPedido =
            $pedido->id_pedido;


        /*
         * Soft delete.
         */

        $pedido->delete();


        /*
         * Volvemos al listado.
         */

        return redirect()
            ->route('pedidos.index')
            ->with(
                'success',
                "Pedido #{$idPedido} eliminado correctamente."
            );
    }
}