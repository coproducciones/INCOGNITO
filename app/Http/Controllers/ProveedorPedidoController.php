<?php

namespace App\Http\Controllers;

use App\Models\EstadoGeneral;
use App\Models\Proveedor;
use App\Services\PedidoProveedorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controlador encargado de gestionar los pedidos recibidos
 * por el proveedor autenticado.
 *
 * Permite:
 * - Consultar los pedidos que contienen sus productos.
 * - Consultar el detalle de cada pedido.
 * - Actualizar el estado de sus productos dentro del pedido.
 *
 * La validación de pertenencia de cada pedido se delega
 * al servicio PedidoProveedorService.
 */
class ProveedorPedidoController extends Controller
{
    /**
     * Servicio encargado de consultar y actualizar
     * los pedidos correspondientes a cada proveedor.
     *
     * @param PedidoProveedorService $service
     */
    public function __construct(
        private PedidoProveedorService $service
    ) {
    }

    /**
     * Muestra el listado de pedidos que contienen
     * productos del proveedor autenticado.
     *
     * @return View
     */
    public function index(): View
    {
        // Obtener el perfil del proveedor autenticado.
        $proveedor = $this->proveedorAutenticado();

        // Consultar únicamente los pedidos que le corresponden.
        $pedidos = $this->service->listar($proveedor);

        return view(
            'Pedidos.Proveedor.index',
            compact('pedidos')
        );
    }

    /**
     * Muestra el detalle de un pedido específico.
     *
     * El servicio comprueba que el pedido contenga
     * productos pertenecientes al proveedor autenticado.
     *
     * También obtiene el estado particular del proveedor
     * y su historial de actualizaciones.
     *
     * @param int $pedido Identificador del pedido.
     * @return View
     */
    public function show(int $pedido): View
    {
        // Obtener el proveedor autenticado.
        $proveedor = $this->proveedorAutenticado();

        // Obtener el pedido y verificar su pertenencia.
        $pedido = $this->service->obtenerPedido(
            $proveedor,
            $pedido
        );

        // Obtener el nombre del estado actual del proveedor.
        $estadoActualNombre = $pedido->estadoProveedor
            ?->estado
            ?->nombre ?? 'Pendiente';

        /*
         * ----------------------------------------------------------
         * DETERMINAR EL SIGUIENTE ESTADO
         * ----------------------------------------------------------
         *
         * Flujo permitido:
         *
         * Pendiente  -> Confirmado
         * Confirmado -> En proceso
         * En proceso -> Completado
         *
         * El proveedor no puede saltarse etapas.
         */

        $siguienteNombre = [
            'Pendiente'  => 'Confirmado',
            'Confirmado' => 'En proceso',
            'En proceso' => 'Completado',
        ][$estadoActualNombre] ?? null;

        // Buscar el registro del siguiente estado permitido.
        $estadoSiguiente = $siguienteNombre
            ? EstadoGeneral::query()
                ->where('tipo', 'PEDIDO')
                ->where('nombre', $siguienteNombre)
                ->first()
            : null;

        return view(
            'Pedidos.Proveedor.show',
            compact(
                'pedido',
                'proveedor',
                'estadoActualNombre',
                'estadoSiguiente'
            )
        );
    }

    /**
     * Actualiza el estado de los productos del proveedor
     * dentro de un pedido específico.
     *
     * La actualización se ejecuta mediante el servicio,
     * que verifica la pertenencia del pedido, valida
     * el flujo de estados y registra el historial.
     *
     * @param Request $request Datos enviados por el formulario.
     * @param int $pedido Identificador del pedido.
     * @return RedirectResponse
     */
    public function updateEstado(
        Request $request,
        int $pedido
    ): RedirectResponse {

        // Obtener el perfil del proveedor autenticado.
        $proveedor = $this->proveedorAutenticado();

        // Validar los datos recibidos desde el formulario.
        $data = $request->validate([
            'id_estado' => [
                'required',
                'integer',
                'exists:estado_general,id_estado',
            ],

            'comentario' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        // Obtener el identificador del usuario autenticado.
        $usuarioId = (int) Auth::id();

        // Ejecutar la actualización mediante el servicio.
        $this->service->actualizarEstado(
            $proveedor,
            $pedido,
            (int) $data['id_estado'],
            $usuarioId,
            $data['comentario'] ?? null
        );

        // Regresar al detalle del pedido con un mensaje.
        return redirect()
            ->route('proveedor.pedidos.show', $pedido)
            ->with(
                'success',
                'El estado de tus productos en este pedido fue actualizado.'
            );
    }

    /**
     * Obtiene el perfil de proveedor asociado al usuario
     * que inició sesión.
     *
     * Si el usuario no tiene un perfil de proveedor,
     * se rechaza el acceso.
     *
     * @return Proveedor
     */
    private function proveedorAutenticado(): Proveedor
    {
        // Obtener el usuario autenticado.
        $usuario = Auth::user();

        // Obtener su perfil de proveedor.
        $proveedor = $usuario?->proveedor;

        // Comprobar que exista un perfil válido.
        abort_unless(
            $proveedor instanceof Proveedor,
            403,
            'Esta cuenta no tiene un perfil de proveedor asociado.'
        );

        return $proveedor;
    }
}
