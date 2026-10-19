<?php

namespace App\Services;

use App\Models\Pedido;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Envía notificaciones a los proveedores mediante la API oficial
 * de WhatsApp Cloud de Meta.
 *
 * La plantilla de WhatsApp debe estar aprobada y tener una variable
 * {{1}} en el cuerpo para recibir el resumen del pedido.
 */
class WhatsAppCloudService
{
    /**
     * Envía una notificación a cada proveedor de los productos del pedido.
     *
     * @return array<int, array{enviado: bool, mensaje: string}>
     */
    public function notificarProveedores(int $pedidoId): array
    {
        $pedido = Pedido::query()
            ->with([
                'usuario',
                'detalles.producto.proveedor',
            ])
            ->findOrFail($pedidoId);

        // Agrupa los productos para enviar un mensaje por proveedor.
        $grupos = $pedido->detalles->groupBy(
            fn ($detalle) => $detalle->producto?->id_proveedor
                ?? $detalle->producto?->proveedor?->id_proveedor
                ?? 'sin_proveedor'
        );

        $resultados = [];

        foreach ($grupos as $proveedorId => $detalles) {
            $proveedor = $detalles->first()->producto?->proveedor;

            if (!$proveedor || $proveedorId === 'sin_proveedor') {
                $resultados[] = [
                    'enviado' => false,
                    'mensaje' => 'WhatsApp pendiente: uno o más productos no tienen proveedor asignado.',
                ];

                continue;
            }

            // Intenta usar WhatsApp y, si está vacío, utiliza el teléfono.
            $telefono = $proveedor->whatsapp
                ?: $proveedor->telefono
                ?: null;

            if (!$telefono) {
                $resultados[] = [
                    'enviado' => false,
                    'mensaje' => "WhatsApp pendiente: el proveedor #{$proveedorId} no tiene teléfono configurado.",
                ];

                continue;
            }

            try {
                $mensaje = $this->crearMensaje(
                    $pedido,
                    $proveedor,
                    $detalles
                );

                $this->enviarPlantilla($telefono, $mensaje);

                $resultados[] = [
                    'enviado' => true,
                    'mensaje' => "Meta aceptó la solicitud de WhatsApp para el proveedor #{$proveedorId}.",
                ];
            } catch (\Throwable $exception) {
                Log::warning(
                    'Falló el envío de WhatsApp al proveedor.',
                    [
                        'pedido_id' => $pedido->id_pedido,
                        'proveedor_id' => $proveedorId,
                        'error' => $exception->getMessage(),
                    ]
                );

                $resultados[] = [
                    'enviado' => false,
                    'mensaje' => "WhatsApp pendiente para proveedor #{$proveedorId}: {$exception->getMessage()}",
                ];
            }
        }

        return $resultados;
    }

    /**
     * Envía una plantilla aprobada mediante WhatsApp Cloud API.
     */
    private function enviarPlantilla(
        string $telefono,
        string $mensaje
    ): void {
        $token = config('services.whatsapp.token');
        $phoneNumberId = config('services.whatsapp.phone_number_id');
        $template = config(
            'services.whatsapp.order_template',
            'pedido_nuevo'
        );
        $language = config(
            'services.whatsapp.template_language',
            'es_CO'
        );
        $apiVersion = config(
            'services.whatsapp.api_version',
            'v23.0'
        );

        if (!$token || !$phoneNumberId) {
            throw new RuntimeException(
                'Faltan WHATSAPP_ACCESS_TOKEN o WHATSAPP_PHONE_NUMBER_ID en el archivo .env o en config/services.php.'
            );
        }

        /*
         * Normaliza el teléfono:
         * 3114531914     -> 573114531914
         * 573114531914   -> 573114531914
         * 00573114531914 -> 573114531914
         */
        $destino = preg_replace('/\D+/', '', $telefono);

        if (!$destino) {
            throw new RuntimeException(
                'El teléfono del proveedor está vacío o no es válido.'
            );
        }

        // Convierte un celular colombiano de 10 dígitos a formato internacional.
        if (
            strlen($destino) === 10
            && str_starts_with($destino, '3')
        ) {
            $destino = '57' . $destino;
        }

        // Convierte el prefijo internacional 00 al formato sin 00.
        if (str_starts_with($destino, '00')) {
            $destino = substr($destino, 2);
        }

        // Comprueba que el número esté en un formato internacional razonable.
        if (
            strlen($destino) < 11
            || strlen($destino) > 15
        ) {
            throw new RuntimeException(
                'El teléfono del proveedor no tiene un formato internacional válido. Para Colombia, utiliza el indicativo 57.'
            );
        }

        $respuesta = Http::withToken($token)
            ->acceptJson()
            ->timeout(15)
            ->post(
                "https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages",
                [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $destino,
                    'type' => 'template',
                    'template' => [
                        'name' => $template,
                        'language' => [
                            'code' => $language,
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => [
                                    [
                                        'type' => 'text',
                                        'text' => mb_substr(
                                            $mensaje,
                                            0,
                                            900
                                        ),
                                    ],
                                ],
                            ],
                        ],
                    ],
                ]
            );

        if ($respuesta->failed()) {
            throw new RuntimeException(
                'Meta rechazó el mensaje: '
                . mb_substr((string) $respuesta->body(), 0, 500)
            );
        }

        // Registra el identificador de Meta para facilitar el diagnóstico.
        Log::info('Meta aceptó la solicitud de WhatsApp.', [
            'destino' => $destino,
            'message_id' => $respuesta->json('messages.0.id'),
        ]);
    }

    /**
     * Construye el texto que se inserta en la variable {{1}}.
     */
    private function crearMensaje(
        $pedido,
        $proveedor,
        $detalles
    ): string {
        $fecha = $pedido->fecha_pedido;

        if ($fecha instanceof \DateTimeInterface) {
            $fechaTexto = $fecha->format('d/m/Y H:i');
        } elseif ($fecha) {
            $fechaTexto = Carbon::parse($fecha)->format('d/m/Y H:i');
        } else {
            $fechaTexto = now()->format('d/m/Y H:i');
        }

        $lineas = [
            'Nuevo pedido #' . $pedido->id_pedido,
            'Cliente: ' . ($pedido->usuario?->nombre ?? 'No especificado'),
            'Fecha: ' . $fechaTexto,
            'Productos:',
        ];

        foreach ($detalles as $detalle) {
            $nombre = $detalle->producto?->nombre
                ?? 'Producto no disponible';

            $lineas[] = '- ' . $nombre . ' x ' . (int) $detalle->cantidad;
        }

        $lineas[] = 'Total del pedido: $'
            . number_format((float) $pedido->total, 0, ',', '.');

        $lineas[] = 'Por favor, confirma la disponibilidad y los siguientes pasos.';

        return implode("\n", $lineas);
    }
}