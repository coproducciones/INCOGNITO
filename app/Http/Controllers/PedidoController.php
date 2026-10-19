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
use App\Models\Proveedor;
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

    public function misPedidos(): View
    {
        $pedidos = $this->service->misPedidos((int) Auth::id());

        return view('Pedidos.index', [
            'pedidos' => $pedidos,
            'modoMiCuenta' => true,
        ]);
    }

    public function miPedido(int $pedido): View
    {
        $pedido = $this->service->miPedido($pedido, (int) Auth::id());

        return view('Pedidos.show', [
            'pedido' => $pedido,
            'modoMiCuenta' => true,
        ]);
    }

    public function index(): View
    {
        $pedidos = $this->repository->all();

        return view('Pedidos.index', compact('pedidos'));
    }

    public function create(): View
    {
        $usuarios = Usuario::query()->orderBy('nombre')->get();

        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('Pedidos.create', compact('usuarios', 'productos'));
    }

    public function store(PedidoStoreRequest $request): RedirectResponse
    {
        $pedido = $this->service->crear($request->validated());

        return redirect()
            ->route('pedidos.show', ['pedido' => $pedido->id_pedido])
            ->with('success', "Pedido #{$pedido->id_pedido} creado correctamente.");
    }

    public function show(Pedido $pedido): View
    {
        $pedido = $this->repository->find($pedido->id_pedido);

        $productos = Producto::with('categoria')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        $estados = EstadoGeneral::query()
            ->where('tipo', 'PEDIDO')
            ->orderBy('nombre')
            ->get();

        return view('Pedidos.show', compact('pedido', 'productos', 'estados'));
    }

    public function edit(Pedido $pedido): View
    {
        $pedido = $this->repository->find($pedido->id_pedido);
        $usuarios = Usuario::query()->orderBy('nombre')->get();

        $estados = EstadoGeneral::query()
            ->where('tipo', 'PEDIDO')
            ->orderBy('nombre')
            ->get();

        return view('Pedidos.edit', compact('pedido', 'usuarios', 'estados'));
    }

    public function update(
        PedidoUpdateRequest $request,
        Pedido $pedido
    ): RedirectResponse {
        $this->repository->update($pedido, $request->validated());

        return redirect()
            ->route('pedidos.show', ['pedido' => $pedido->id_pedido])
            ->with('success', 'Pedido actualizado correctamente.');
    }

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

    public function storeDetalle(
        DetallePedidoStoreRequest $request,
        Pedido $pedido
    ): RedirectResponse {
        $this->service->agregarDetalle($pedido, $request->validated());

        return back()->with('success', 'Producto agregado correctamente al pedido.');
    }

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

        return back()->with('success', 'Cantidad actualizada correctamente.');
    }

    public function destroyDetalle(
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {
        $this->service->eliminarDetalle($pedido, $detalle);

        return back()->with('success', 'Producto eliminado correctamente del pedido.');
    }

    public function destroy(Pedido $pedido): RedirectResponse
    {
        $idPedido = $pedido->id_pedido;

        $this->service->eliminarDefinitivamente($pedido);

        return redirect()
            ->route('pedidos.index')
            ->with('success', "Pedido #{$idPedido} eliminado definitivamente.");
    }

    public function cancelarMiPedido(int $pedido): RedirectResponse
    {
        $pedidoPropio = $this->service->miPedido($pedido, (int) Auth::id());

        $this->service->cancelar($pedidoPropio);

        return redirect()
            ->route('mi-cuenta.pedidos')
            ->with('success', "El pedido #{$pedido} fue cancelado correctamente.");
    }

    public function actualizarDetalleMiPedido(
        Request $request,
        int $pedido,
        int $detalle
    ): RedirectResponse {
        $pedidoPropio = $this->service->miPedido($pedido, (int) Auth::id());

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

    public function eliminarDetalleMiPedido(
        int $pedido,
        int $detalle
    ): RedirectResponse {
        $pedidoPropio = $this->service->miPedido($pedido, (int) Auth::id());

        $this->service->eliminarDetalle($pedidoPropio, $detalle);

        return redirect()
            ->route('mi-cuenta.pedidos.show', $pedidoPropio->id_pedido)
            ->with('success', 'Producto eliminado del pedido.');
    }

    /**
 * Abre WhatsApp con un mensaje preparado para un proveedor.
 *
 * No envía el mensaje automáticamente.
 * El usuario debe confirmar el envío en WhatsApp.
 */
public function whatsappProveedor(
    Pedido $pedido,
    int $proveedor
): RedirectResponse {
    // Consultamos el pedido con sus relaciones necesarias.
    $pedido = Pedido::query()
        ->with([
            'usuario',
            'detalles.producto.proveedor',
        ])
        ->findOrFail($pedido->id_pedido);

    // Buscamos el proveedor seleccionado.
    $proveedor = Proveedor::query()
        ->findOrFail($proveedor);

    // Conservamos únicamente los productos de este proveedor.
    $detallesProveedor = $pedido->detalles->filter(
        fn ($detalle) =>
            (int) ($detalle->producto?->id_proveedor) ===
            (int) $proveedor->id_proveedor
    );

    // Evitamos preparar mensajes para productos ajenos al proveedor.
    if ($detallesProveedor->isEmpty()) {
        abort(
            404,
            'Este proveedor no tiene productos asociados a este pedido.'
        );
    }

    // Preferimos el número de WhatsApp y usamos el teléfono como alternativa.
    $telefono = $proveedor->whatsapp
        ?: $proveedor->telefono
        ?: '';

    // Quitamos espacios, signos y caracteres que no sean números.
    $telefono = preg_replace('/\D+/', '', $telefono);

    // Normalizamos un celular colombiano de diez dígitos.
    if (
        strlen($telefono) === 10 &&
        str_starts_with($telefono, '3')
    ) {
        $telefono = '57' . $telefono;
    }

    // Aceptamos números que ya tengan el indicativo internacional.
    if (str_starts_with($telefono, '00')) {
        $telefono = substr($telefono, 2);
    }

    // Validamos que exista un número de destino razonable.
    if (
        strlen($telefono) < 11 ||
        strlen($telefono) > 15
    ) {
        return back()->with(
            'error',
            'El proveedor no tiene un número de WhatsApp válido.'
        );
    }

    // Preparamos los datos principales del pedido.
    $mensaje = [
        'Hola, te comparto los detalles del pedido #' .
            $pedido->id_pedido . '.',
        '',
        'Cliente: ' . (
            $pedido->usuario?->nombre ?? 'No especificado'
        ),
        'Productos solicitados:',
    ];

    // Agregamos únicamente los productos que atiende este proveedor.
    foreach ($detallesProveedor as $detalle) {
        $nombre = $detalle->producto?->nombre
            ?? 'Producto no disponible';

        $cantidad = (int) $detalle->cantidad;

        $mensaje[] = '- ' . $nombre . ' x ' . $cantidad;
    }

    $mensaje[] = '';
    $mensaje[] = 'Por favor, confirma la disponibilidad y los siguientes pasos.';

    // Codificamos el texto para incluirlo de forma segura en el enlace.
    $texto = implode("\n", $mensaje);

    $url = 'https://wa.me/' . $telefono .
        '?text=' . rawurlencode($texto);

    // Abre WhatsApp con el destinatario y el mensaje preparado.
    return redirect()->away($url);
}
}
