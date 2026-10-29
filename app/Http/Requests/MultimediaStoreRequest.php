<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class MultimediaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->tienePermiso('multimedia.crear');
    }

    public function rules(): array
    {
        return [
            'archivo' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,webp,gif,mp4,webm,pdf',
                'max:10240',
            ],
            'tipo' => [
                'required',
                Rule::in(['imagen', 'video', 'documento']),
            ],
            'id_producto' => [
                'nullable',
                'integer',
                'exists:productos,id',
            ],
            'id_contenido' => [
                'nullable',
                'integer',
                'exists:contenido,id_contenido',
            ],
            'destacado' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            $producto = $this->filled('id_producto');
            $contenido = $this->filled('id_contenido');

            if ($producto === $contenido) {
                $validator->errors()->add(
                    'destino',
                    'Debes seleccionar exactamente un producto o un contenido.'
                );
            }

            $archivo = $this->file('archivo');
            $tipo = $this->input('tipo');

            if ($archivo && $tipo) {
                $mime = $archivo->getMimeType() ?? '';

                $tipoValido = match ($tipo) {
                    'imagen' => str_starts_with($mime, 'image/'),
                    'video' => str_starts_with($mime, 'video/'),
                    'documento' => $mime === 'application/pdf',
                    default => false,
                };

                if (!$tipoValido) {
                    $validator->errors()->add(
                        'tipo',
                        'El tipo seleccionado no coincide con el archivo que subiste.'
                    );
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'archivo.required' => 'Selecciona un archivo de tu dispositivo.',
            'archivo.mimes' => 'El archivo debe ser JPG, PNG, WEBP, GIF, MP4, WEBM o PDF.',
            'archivo.max' => 'El archivo no puede superar los 10 MB.',
            'tipo.in' => 'Selecciona un tipo de recurso válido.',
            'id_producto.exists' => 'El producto seleccionado no existe.',
            'id_contenido.exists' => 'El contenido seleccionado no existe.',
        ];
    }
}