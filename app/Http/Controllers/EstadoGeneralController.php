<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstadoGeneralStoreRequest;
use App\Http\Requests\EstadoGeneralUpdateRequest;
use App\Models\EstadoGeneral;
use App\Services\EstadoGeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador encargado de gestionar los estados generales.
 *
 * Permite listar, crear, editar, actualizar y eliminar estados
 * mediante los métodos proporcionados por EstadoGeneralService.
 */
class EstadoGeneralController extends Controller
{
    /**
     * Constructor del controlador.
     *
     * Inyecta el servicio encargado de gestionar los estados generales.
     */
    public function __construct(private EstadoGeneralService $service)
    {
    }

    /**
     * Muestra el listado de estados generales.
     *
     * @return View Vista con la lista de estados.
     */
    public function index(): View
    {
        return view('Estados.index', [
            'estados' => $this->service->listar()
        ]);
    }

    /**
     * Muestra el formulario para registrar un nuevo estado.
     *
     * @return View Vista del formulario de creación.
     */
    public function create(): View
    {
        return view('Estados.create');
    }

    /**
     * Almacena un nuevo estado general.
     *
     * Obtiene los datos validados mediante el Form Request
     * y los envía al servicio para realizar el registro.
     *
     * @param EstadoGeneralStoreRequest $request Solicitud con los datos validados.
     * @return RedirectResponse Redirección al listado de estados.
     */
    public function store(EstadoGeneralStoreRequest $request): RedirectResponse
    {
        $this->service->crear($request->validated());

        return redirect()
            ->route('estados.index')
            ->with('success', 'Estado creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un estado existente.
     *
     * @param EstadoGeneral $estado Modelo del estado que se va a editar.
     * @return View Vista del formulario de edición.
     */
    public function edit(EstadoGeneral $estado): View
    {
        return view('Estados.edit', compact('estado'));
    }

    /**
     * Actualiza la información de un estado general.
     *
     * Obtiene los datos validados y los envía al servicio
     * para realizar la actualización correspondiente.
     *
     * @param EstadoGeneralUpdateRequest $request Solicitud con los datos validados.
     * @param EstadoGeneral $estado Modelo del estado que se va a actualizar.
     * @return RedirectResponse Redirección al listado de estados.
     */
    public function update(
        EstadoGeneralUpdateRequest $request,
        EstadoGeneral $estado
    ): RedirectResponse {
        $this->service->actualizar($estado, $request->validated());

        return redirect()
            ->route('estados.index')
            ->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Elimina un estado general.
     *
     * Si ocurre una excepción RuntimeException durante
     * la eliminación, retorna a la página anterior mostrando
     * el mensaje de error correspondiente.
     *
     * @param EstadoGeneral $estado Modelo del estado que se va a eliminar.
     * @return RedirectResponse Redirección con el resultado de la operación.
     */
    public function destroy(EstadoGeneral $estado): RedirectResponse
    {
        try {
            $this->service->eliminar($estado);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect()
            ->route('estados.index')
            ->with('success', 'Estado eliminado correctamente.');
    }
}
