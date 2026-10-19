<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResenaStoreRequest;
use App\Http\Requests\ResenaUpdateRequest;
use App\Http\Requests\MiResenaStoreRequest;
use App\Http\Requests\MiResenaUpdateRequest;
use App\Models\Producto;
use App\Models\Reseña;
use App\Models\Usuario;
use App\Services\ReseñaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Gestiona las reseñas del catálogo y las reseñas personales.
 *
 * Administración:
 * - Consultar reseñas.
 * - Crear, editar y eliminar reseñas mediante el panel autorizado.
 *
 * Mi cuenta:
 * - Consultar las reseñas del usuario autenticado.
 * - Reseñar productos elegibles de sus pedidos.
 * - Editar o eliminar únicamente sus propias reseñas.
 */
class ReseñaController extends Controller
{
    /**
     * Servicio que concentra las reglas de negocio
     * y las operaciones de persistencia de las reseñas.
     */
    public function __construct(
        private ReseñaService $service
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | RESEÑAS DE MI CUENTA
    |--------------------------------------------------------------------------
    */

    /**
     * Muestra las reseñas del usuario autenticado.
     */
    public function misResenas(): View
    {
        $usuarioId = (int) Auth::id();

        $resenas = $this->service->misResenas($usuarioId);

        return view('Reseñas.index', [
            'resenas' => $resenas,
            'modoMiCuenta' => true,
        ]);
    }

    /**
     * Muestra los productos que el usuario puede reseñar.
     *
     * La consulta debe devolver únicamente productos
     * asociados a pedidos completados del usuario y que
     * todavía no hayan sido reseñados por él.
     */
    public function createMiResena(): View
    {
        $usuarioId = (int) Auth::id();

        $productos = $this->service
            ->productosParaResenar($usuarioId);

        return view('Reseñas.create', [
            'productos' => $productos,
            'modoMiCuenta' => true,
        ]);
    }

    /**
     * Registra una reseña para el usuario autenticado.
     *
     * El identificador del usuario se obtiene de la sesión.
     * Nunca debe aceptarse desde un campo del formulario.
     */
    public function storeMiResena(
        MiResenaStoreRequest $request
    ): RedirectResponse {
        $this->service->crearMiResena(
            (int) Auth::id(),
            $request->validated()
        );

        return redirect()
            ->route('mi-cuenta.resenas')
            ->with(
                'success',
                'Tu reseña fue registrada correctamente.'
            );
    }

    /**
     * Muestra el formulario para editar una reseña propia.
     *
     * El servicio debe comprobar que la reseña pertenece
     * al usuario autenticado.
     */
    public function editMiResena(Reseña $reseña): View
    {
        $reseña = $this->service->miResena(
            $reseña->getKey(),
            (int) Auth::id()
        );

        return view('Reseñas.edit', [
            'reseña' => $reseña,
            'modoMiCuenta' => true,
        ]);
    }

    /**
     * Actualiza una reseña propia.
     */
    public function updateMiResena(
        MiResenaUpdateRequest $request,
        Reseña $reseña
    ): RedirectResponse {
        $this->service->actualizarMiResena(
            $reseña,
            (int) Auth::id(),
            $request->validated()
        );

        return redirect()
            ->route('mi-cuenta.resenas')
            ->with(
                'success',
                'Tu reseña fue actualizada correctamente.'
            );
    }

    /**
     * Elimina una reseña propia.
     */
    public function destroyMiResena(
        Reseña $reseña
    ): RedirectResponse {
        $this->service->eliminarMiResena(
            $reseña,
            (int) Auth::id()
        );

        return redirect()
            ->route('mi-cuenta.resenas')
            ->with(
                'success',
                'Tu reseña fue eliminada correctamente.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | ADMINISTRACIÓN DE RESEÑAS
    |--------------------------------------------------------------------------
    */

    /**
     * Muestra todas las reseñas para su gestión administrativa.
     */
    public function index(): View
    {
        $resenas = $this->service->getAll();

        return view('Reseñas.index', [
            'resenas' => $resenas,
        ]);
    }

    /**
     * Muestra el formulario administrativo de creación.
     *
     * El administrador selecciona el usuario asociado y
     * el producto. No se solicita un cliente adicional.
     */
    public function create(): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        $productos = Producto::orderBy('nombre')->get();

        return view('Reseñas.create', [
            'usuarios' => $usuarios,
            'productos' => $productos,
            'modoMiCuenta' => false,
        ]);
    }

    /**
     * Guarda una reseña creada desde la administración.
     *
     * ResenaStoreRequest y ReseñaService deben estar
     * adaptados para no exigir id_cliente si el modelo
     * de datos no necesita esa relación.
     */
    public function store(
        ResenaStoreRequest $request
    ): RedirectResponse {
        $this->service->create($request->validated());

        return redirect()
            ->route('reseñas.index')
            ->with(
                'success',
                'Reseña creada correctamente.'
            );
    }

    /**
     * Muestra el detalle de una reseña.
     */
    public function show(Reseña $reseña): View
    {
        // El servicio puede cargar las relaciones del modelo.
        $reseña = $this->service->getById(
            $reseña->getKey()
        );

        return view('Reseñas.show', [
            'reseña' => $reseña,
        ]);
    }

    /**
     * Muestra el formulario administrativo de edición.
     *
     * No se carga una lista de clientes porque el formulario
     * ya no permite asignar manualmente un cliente.
     */
    public function edit(Reseña $reseña): View
    {
        $reseña = $this->service->getById(
            $reseña->getKey()
        );

        $usuarios = Usuario::orderBy('nombre')->get();

        $productos = Producto::orderBy('nombre')->get();

        return view('Reseñas.edit', [
            'reseña' => $reseña,
            'usuarios' => $usuarios,
            'productos' => $productos,
            'modoMiCuenta' => false,
        ]);
    }

    /**
     * Actualiza una reseña desde la administración.
     */
    public function update(
        ResenaUpdateRequest $request,
        Reseña $reseña
    ): RedirectResponse {
        $this->service->update(
            $reseña,
            $request->validated()
        );

        return redirect()
            ->route('reseñas.show', $reseña)
            ->with(
                'success',
                'Reseña actualizada correctamente.'
            );
    }

    /**
     * Elimina una reseña desde la administración.
     */
    public function destroy(
        Reseña $reseña
    ): RedirectResponse {
        $this->service->delete($reseña);

        return redirect()
            ->route('reseñas.index')
            ->with(
                'success',
                'Reseña eliminada correctamente.'
            );
    }
}