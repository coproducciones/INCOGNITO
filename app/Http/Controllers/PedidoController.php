<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidoStoreRequest;
use App\Http\Requests\PedidoUpdateRequest;
use App\Http\Requests\EstadoPedidoUpdateRequest;

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
    /**
     * Dependencias del controlador.
     */
    public function __construct(
        private PedidoRepository $repository,
        private PedidoService $service,
    ) {}

    /**
     * Muestra todos los pedidos.
     */
    public function index(): View
    {
        $pedidos = $this->repository->all();

        return view(
            'Pedidos.index',
            compact('pedidos')
        );
    }

    /**
     * Muestra el formulario para crear un pedido.
     */
    public function create(): View
    {
        $usuarios = Usuario::orderBy('nombre')
            ->get();

        return view(
            'Pedidos.create',
            compact('usuarios')
        );
    }

    /**
     * Guarda un nuevo pedido.
     */
    public function store(
        PedidoStoreRequest $request
    ): RedirectResponse {

        $pedido = $this->service->crear(
            $request->validated()
        );

        return redirect()
            ->route('pedidos.index')
            ->with(
                'success',
                "Pedido #{$pedido->id_pedido} creado correctamente."
            );
    }

    /**
     * Muestra un pedido específico.
     */
    public function show(
        Pedido $pedido
    ): View {

        $pedido = $this->repository->find(
            $pedido->id_pedido
        );

        $productos = Producto::where(
            'activo',
            true
        )
            ->orderBy('nombre')
            ->get();

        $estados = EstadoGeneral::where(
            'tipo',
            'PEDIDO'
        )
            ->orderBy('nombre')
            ->get();

        return view(
            'Pedidos.show',
            compact(
                'pedido',
                'productos',
                'estados'
            )
        );
    }

    /**
     * Muestra el formulario para editar un pedido.
     */
    public function edit(
        Pedido $pedido
    ): View {

        $pedido = $this->repository->find(
            $pedido->id_pedido
        );

        $usuarios = Usuario::orderBy('nombre')
            ->get();

        $estados = EstadoGeneral::where(
            'tipo',
            'PEDIDO'
        )
            ->orderBy('nombre')
            ->get();

        return view(
            'Pedidos.edit',
            compact(
                'pedido',
                'usuarios',
                'estados'
            )
        );
    }

    /**
     * Actualiza un pedido.
     */
    public function update(
        PedidoUpdateRequest $request,
        Pedido $pedido
    ): RedirectResponse {

        $this->repository->update(
            $pedido,
            $request->validated()
        );

        return redirect()
            ->route(
                'pedidos.show',
                [
                    'pedido' => $pedido->id_pedido,
                ]
            )
            ->with(
                'success',
                'Pedido actualizado correctamente.'
            );
    }

    /**
     * Cambia el estado de un pedido.
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

        return back()->with(
            'success',
            'Estado del pedido actualizado.'
        );
    }

    /**
     * Elimina un pedido.
     */
    public function destroy(
        Pedido $pedido
    ): RedirectResponse {

        $idPedido = $pedido->id_pedido;

        $pedido->delete();

        return redirect()
            ->route('pedidos.index')
            ->with(
                'success',
                "Pedido #{$idPedido} eliminado correctamente."
            );
    }
}