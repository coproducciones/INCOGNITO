<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolStoreRequest;
use App\Http\Requests\RolUpdateRequest;
use App\Models\Permiso;
use App\Models\Rol;
use App\Services\RolService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RolController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CONSTRUCTOR
    |--------------------------------------------------------------------------
    */

    public function __construct(
        private readonly RolService $service
    ) {}


    /*
    |--------------------------------------------------------------------------
    | LISTAR ROLES
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $roles = $this->service->listar();

        return view(
            'Roles.index',
            compact('roles')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO PARA CREAR ROL
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        /*
         * Obtenemos todos los permisos disponibles.
         */

        $permisos = Permiso::query()
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get();

        return view(
            'Roles.create',
            compact('permisos')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR NUEVO ROL
    |--------------------------------------------------------------------------
    */

    public function store(
        RolStoreRequest $request
    ): RedirectResponse {

        $data = $request->validated();

        /*
         * Los permisos pertenecen a la tabla intermedia
         * rol_permiso, no directamente a roles.
         */

        $permisos = $data['permisos'] ?? [];

        unset($data['permisos']);


        /*
         * Creamos el rol y asignamos sus permisos.
         */

        $this->service->crearConPermisos(
            $data,
            $permisos
        );

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Rol creado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO PARA EDITAR ROL
    |--------------------------------------------------------------------------
    |
    | Enviamos:
    |
    | - El rol.
    | - Todos los permisos disponibles.
    | - Los permisos actuales vienen cargados dentro del rol.
    |
    */

    public function edit(Rol $rol): View
    {
        /*
         * Obtenemos el rol junto con sus permisos actuales.
         */

        $rol = $this->service->obtener(
            $rol->id_rol
        );


        /*
         * Obtenemos todos los permisos disponibles.
         */

        $permisos = Permiso::query()
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get();


        return view(
            'Roles.edit',
            compact(
                'rol',
                'permisos'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR ROL
    |--------------------------------------------------------------------------
    */

    public function update(
        RolUpdateRequest $request,
        Rol $rol
    ): RedirectResponse {

        $data = $request->validated();


        /*
         * Extraemos los permisos.
         */

        $permisos = $data['permisos'] ?? [];

        unset($data['permisos']);


        /*
         * Actualizamos el rol y sus permisos.
         */

        $this->service->actualizarConPermisos(
            $rol,
            $data,
            $permisos
        );


        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Rol actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR ROL
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Rol $rol
    ): RedirectResponse {

        try {

            $this->service->eliminar($rol);

        } catch (\RuntimeException $e) {

            return back()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Rol eliminado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR PERMISOS DEL ROL
    |--------------------------------------------------------------------------
    */

    public function permisos(Rol $rol): View
    {
        $rol = $this->service->obtener(
            $rol->id_rol
        );

        $permisos = Permiso::query()
            ->orderBy('modulo')
            ->orderBy('nombre')
            ->get();

        return view(
            'Roles.permisos',
            compact(
                'rol',
                'permisos'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SINCRONIZAR PERMISOS
    |--------------------------------------------------------------------------
    */

    public function syncPermisos(
        Rol $rol,
        Request $request
    ): RedirectResponse {
        $datos = $request->validate([
            'permisos' => ['sometimes', 'array'],
            'permisos.*' => [
                'integer',
                'distinct',
                'exists:permisos,id_permiso',
            ],
        ]);

        $this->service->sincronizarPermisos(
            $rol,
            $datos['permisos'] ?? []
        );


        return redirect()
            ->route(
                'roles.permisos',
                ['rol' => $rol->id_rol]
            )
            ->with(
                'success',
                'Permisos del rol actualizados correctamente.'
            );
    }
}
