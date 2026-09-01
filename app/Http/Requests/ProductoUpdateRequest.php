<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoUpdateRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación.
     */
    public function rules(): array
    {
        return [
            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],

            'nombre' => [
                'required',
                'string',
                'min:3',
                'max:80',
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:255',
            ],

            'precio' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'activo' => [
                'boolean',
            ],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'categoria_id.required' => 'Debes seleccionar una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no existe.',

            'nombre.required' => 'El nombre del producto es obligatorio.',
            'nombre.string' => 'El nombre del producto debe ser texto.',
            'nombre.min' => 'El nombre debe tener mínimo 3 caracteres.',
            'nombre.max' => 'El nombre no puede superar los 80 caracteres.',

            'descripcion.string' => 'La descripción debe ser texto.',
            'descripcion.max' => 'La descripción no puede superar los 255 caracteres.',

            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.min' => 'El precio no puede ser negativo.',

            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',

            'activo.boolean' => 'El estado del producto no es válido.',
        ];
    }

    /**
     * Limpiar datos antes de validar.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'nombre' => trim($this->nombre),

            'descripcion' => $this->descripcion
                ? trim($this->descripcion)
                : null,
        ]);
    }
}