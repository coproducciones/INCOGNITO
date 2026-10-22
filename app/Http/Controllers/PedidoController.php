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
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Repositories\PedidoRepository;
use App\Services\PedidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PedidoController extends Controller
{
    public function __construct(
        private PedidoRepository $repository,
        private PedidoService $service,
    ) {}

    /**
     * Pedidos del usuario autenticado.
     */
    public function misPedidos(): View
    {
        $pedidos = $this->service->misPedidos((int) Auth::id());

        return view('Pedidos.index', [
            'pedidos' => $pedidos,
            'modoMiCuenta' => true,
        ]);
    }

    /**
     * Detalle de un pedido del usuario autenticado.
     */
    public function miPedido(int $pedido): View
    {
        $pedido = $this->service->miPedido(
            $pedido,
            (int) Auth::id()
        );

        // Los productos y sus proveedores se obtienen desde este pedido.
        $pedido->loadMissing([
            'usuario',
            'estado',
            'detalles.producto.categoria',
            'detalles.producto.proveedor',
            'eventos.estado',
        ]);

        $proveedores = $pedido->detalles
            ->map(fn ($detalle) => $detalle->producto?->proveedor)
            ->filter()
            ->unique('id_proveedor')
            ->values();

        return view('Pedidos.show', [
            'pedido' => $pedido,
            'modoMiCuenta' => true,
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * Listado administrativo.
     */
    public function index(): View
    {
        $pedidos = $this->repository->all();

        return view('Pedidos.index', compact('pedidos'));
    }

    /**
     * Formulario de creación administrativa.
     */
    public function create(): View
    {
        $usuarios = Usuario::query()
            ->orderBy('nombre')
            ->get();

        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('Pedidos.create', compact('usuarios', 'productos'));
    }

    /**
     * Crear pedido desde administración.
     */
    public function store(PedidoStoreRequest $request): RedirectResponse
    {
        $pedido = $this->service->crear($request->validated());

        return redirect()
            ->route('pedidos.show', ['pedido' => $pedido->id_pedido])
            ->with('success', "Pedido #{$pedido->id_pedido} creado correctamente.");
    }

    /**
     * Detalle administrativo.
     */
    public function show(Pedido $pedido): View
    {
        $pedido = $this->repository->find($pedido->id_pedido);

        $pedido->loadMissing([
            'usuario',
            'estado',
            'detalles.producto.categoria',
            'detalles.producto.proveedor',
            'eventos.estado',
        ]);

        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $estados = EstadoGeneral::query()
            ->where('tipo', 'PEDIDO')
            ->orderBy('nombre')
            ->get();

        return view('Pedidos.show', compact(
            'pedido',
            'productos',
            'estados'
        ));
    }

    /**
     * Editar pedido administrativo.
     */
    public function edit(Pedido $pedido): View
    {
        $pedido = $this->repository->find($pedido->id_pedido);

        $usuarios = Usuario::query()
            ->orderBy('nombre')
            ->get();

        $estados = EstadoGeneral::query()
            ->where('tipo', 'PEDIDO')
            ->orderBy('nombre')
            ->get();

        return view('Pedidos.edit', compact(
            'pedido',
            'usuarios',
            'estados'
        ));
    }

    /**
     * Actualizar pedido administrativo.
     */
    public function update(
        PedidoUpdateRequest $request,
        Pedido $pedido
    ): RedirectResponse {
        $this->repository->update($pedido, $request->validated());

        return redirect()
            ->route('pedidos.show', ['pedido' => $pedido->id_pedido])
            ->with('success', 'Pedido actualizado correctamente.');
    }

    /**
     * Cambiar estado y registrar el evento correspondiente.
     */
    public function updateEstado(
        EstadoPedidoUpdateRequest $request,
        Pedido $pedido
    ): RedirectResponse {
        $this->service->cambiarEstado(
            $pedido,
            (int) $request->id_estado,
            $request->comentario
        );

        return back()->with('success', 'Estado del pedido actualizado.');
    }

    /**
     * Agregar producto al pedido administrativo.
     */
    public function storeDetalle(
        DetallePedidoStoreRequest $request,
        Pedido $pedido
    ): RedirectResponse {
        $this->service->agregarDetalle(
            $pedido,
            $request->validated()
        );

        return back()->with(
            'success',
            'Producto agregado correctamente al pedido.'
        );
    }

    /**
     * Modificar cantidad desde administración.
     */
    public function updateDetalle(
        DetallePedidoUpdateRequest $request,
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {
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

    /**
     * Eliminar detalle desde administración.
     */
    public function destroyDetalle(
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {
        $this->service->eliminarDetalle($pedido, $detalle);

        return back()->with(
            'success',
            'Producto eliminado correctamente del pedido.'
        );
    }

    /**
     * Eliminar pedido definitivamente.
     */
    public function destroy(Pedido $pedido): RedirectResponse
    {
        $idPedido = $pedido->id_pedido;

        $this->service->eliminarDefinitivamente($pedido);

        return redirect()
            ->route('pedidos.index')
            ->with(
                'success',
                "Pedido #{$idPedido} eliminado definitivamente."
            );
    }

    /**
     * Cancelar un pedido propio.
     */
    public function cancelarMiPedido(int $pedido): RedirectResponse
    {
        $pedidoPropio = $this->service->miPedido(
            $pedido,
            (int) Auth::id()
        );

        $this->service->cancelar($pedidoPropio);

        return redirect()
            ->route('mi-cuenta.pedidos')
            ->with(
                'success',
                "El pedido #{$pedido} fue cancelado correctamente."
            );
    }

    /**
     * Actualizar la cantidad de un detalle de un pedido propio.
     */
    public function actualizarDetalleMiPedido(
        Request $request,
        int $pedido,
        int $detalle
    ): RedirectResponse {
        $pedidoPropio = $this->service->miPedido(
            $pedido,
            (int) Auth::id()
        );

        $data = $request->validate([
            'cantidad' => ['required', 'integer', 'min:1'],
        ]);

        $this->service->modificarDetalle(
            $pedidoPropio,
            $detalle,
            ['cantidad' => (int) $data['cantidad']]
        );

        return redirect()
            ->route('mi-cuenta.pedidos.show', $pedidoPropio->id_pedido)
            ->with('success', 'Cantidad actualizada correctamente.');
    }

    /**
     * Eliminar un detalle de un pedido propio.
     */
    public function eliminarDetalleMiPedido(
        int $pedido,
        int $detalle
    ): RedirectResponse {
        $pedidoPropio = $this->service->miPedido(
            $pedido,
            (int) Auth::id()
        );

        $this->service->eliminarDetalle($pedidoPropio, $detalle);

        return redirect()
            ->route('mi-cuenta.pedidos.show', $pedidoPropio->id_pedido)
            ->with('success', 'Producto eliminado del pedido.');
    }

    /**
     * Preparar el mensaje y abrir WhatsApp para un proveedor del pedido.
     *
     * El mensaje no se envía automáticamente: el usuario lo confirma
     * desde WhatsApp.
     */
    public function whatsappProveedor(
        Pedido $pedido,
        int $proveedor
    ): RedirectResponse {
        // Recargar el pedido con sus relaciones.
        $pedido->load([
            'usuario',
            'detalles.producto.proveedor',
        ]);

        // Comprobar que el pedido pertenezca al usuario autenticado.
        abort_unless(
            Auth::check()
                && (int) $pedido->id_usuario === (int) Auth::id(),
            403,
            'No tienes permiso para contactar proveedores de este pedido.'
        );

        // Obtener el proveedor solicitado.
        $proveedorModel = Proveedor::query()->findOrFail($proveedor);

        // Filtrar los productos de ese proveedor que están en este pedido.
        $detallesProveedor = $pedido->detalles->filter(
            fn ($detalle) =>
                (int) ($detalle->producto?->id_proveedor)
                === (int) $proveedorModel->id_proveedor
        );

        abort_if(
            $detallesProveedor->isEmpty(),
            404,
            'Este proveedor no tiene productos asociados a este pedido.'
        );

        // Priorizar WhatsApp y usar el teléfono como alternativa.
        $telefono = (string) (
            $proveedorModel->whatsapp
            ?: $proveedorModel->telefono
            ?: ''
        );

        // Conservar únicamente los dígitos.
        $telefono = preg_replace('/\D+/', '', $telefono) ?? '';

        // Para celulares colombianos de diez dígitos, agregar +57.
        if (
            strlen($telefono) === 10
            && str_starts_with($telefono, '3')
        ) {
            $telefono = '57' . $telefono;
        }

        // Normalizar el prefijo internacional 00.
        if (str_starts_with($telefono, '00')) {
            $telefono = substr($telefono, 2);
        }

        // Validar longitud internacional del número.
        if (strlen($telefono) < 11 || strlen($telefono) > 15) {
            return redirect()
                ->route('mi-cuenta.pedidos.show', $pedido->id_pedido)
                ->with(
                    'error',
                    'El proveedor no tiene un número válido. Verifica el campo WhatsApp o teléfono en su perfil.'
                );
        }

        // Construir el mensaje con los datos de este pedido.
        $mensaje = [
            'Hola, te comparto los detalles del pedido #'
                . $pedido->id_pedido . '.',
            '',
            'Cliente: ' . ($pedido->usuario?->nombre ?? 'Cliente'),
            'Productos solicitados:',
        ];

        foreach ($detallesProveedor as $detalle) {
            $nombre = $detalle->producto?->nombre
                ?? 'Producto no disponible';

            $cantidad = (int) $detalle->cantidad;

            $mensaje[] = '- ' . $nombre . ' x ' . $cantidad;
        }

        $mensaje[] = '';
        $mensaje[] = 'Por favor, confirma la disponibilidad y los siguientes pasos.';

        $texto = rawurlencode(implode("\n", $mensaje));

        // URL correcta: sin corchetes ni paréntesis de Markdown.
        $url = 'https://wa.me/' . $telefono . '?text=' . $texto;

        return redirect()->away($url);
    }
}