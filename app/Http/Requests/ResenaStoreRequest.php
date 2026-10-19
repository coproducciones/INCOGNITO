<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida los datos enviados al crear una reseña
 * desde el módulo administrativo.
 *
 * El cliente asociado no se recibe desde el formulario:
 * se determina en el servicio utilizando el usuario
 * al que se atribuye la reseña.
 */
class ResenaStoreRequest extends FormRequest
{
    /**
     * Determina si la petición está autorizada.
     *
     * La autorización administrativa se controla mediante
     * los permisos definidos en las rutas.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Define las reglas de validación para crear una reseña.
     *
     * IMPORTANTE:
     * No se incluye id_cliente porque ese valor se obtiene
     * en el servidor y no debe depender del formulario.
     */
    public function rules(): array
    {
        return [
            /*
             * Usuario al que se atribuye la reseña.
             */
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id',
            ],

            /*
             * Producto que está siendo reseñado.
             */
            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id',
            ],

            /*
             * Calificación de una a cinco estrellas.
             */
            'calificacion' => [
                'required',
                'integer',
                'between:1,5',
            ],

            /*
             * Comentario escrito por el usuario.
             * Se permite omitirlo según las reglas actuales
             * del proyecto.
             */
            'comentario' => [
                'nullable',
                'string',
                'max:2000',
            ],

            /*
             * Respuesta opcional asociada a la reseña.
             */
            'respuesta' => [
                'nullable',
                'string',
                'max:2000',
            ],

            /*
             * Fecha opcional.
             * Si no se envía, el servicio utiliza la fecha actual.
             */
            'fecha' => [
                'nullable',
                'date',
            ],
        ];
    }

    /**
     * Personaliza los nombres de los atributos que aparecen
     * en los mensajes de validación.
     */
    public function attributes(): array
    {
        return [
            'id_usuario' => 'usuario',
            'id_producto' => 'producto',
            'calificacion' => 'calificación',
            'comentario' => 'comentario',
            'respuesta' => 'respuesta',
            'fecha' => 'fecha',
        ];
    }
}