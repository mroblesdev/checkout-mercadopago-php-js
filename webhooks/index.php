<?php

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

require_once 'vendor/autoload.php';

// Importa la clase de Mercado Pago
MercadoPagoConfig::setAccessToken("PROD_ACCESS_TOKEN");

// Obtén el contenido de la notificación
$notification = file_get_contents("php://input");

// Decodifica el JSON recibido
$data = json_decode($notification, true);

// Verifica que la notificación tenga el tipo de evento esperado
if (isset($data['type']) && $data['type'] == 'payment') {

    // Obtén el ID del pago
    $payment_id = $data['data']['id'];

    // Obtén los detalles del pago desde la API de Mercado Pago
    $paymentClient = new PaymentClient();

    try {
        $payment = $paymentClient->get($payment_id);

        // Datos del pago (puedes reemplazar esto con los datos que obtuviste del pago)
        $paymentData = [
            'id'          => $payment->id,
            'estatus'     => $payment->status,
            'importe'     => $payment->transaction_amount,
            'moneda'      => $payment->currency_id,
            'metodo_pago' => $payment->payment_type_id,
            'fecha'       => $payment->date_created,
            'modo'        => $payment->live_mode,
        ];

        // Convierte los datos a una cadena JSON
        $paymentDataJson = json_encode($paymentData, JSON_PRETTY_PRINT);

        // Ruta del archivo donde se guardará la información del pago
        $file_path = 'payment_info.txt';

        // Abre el archivo para escribir (creará el archivo si no existe)
        $file = fopen($file_path, 'a');

        // Escribe la información del pago en el archivo
        fwrite($file, 'NOTIFICACIÓN: ' . json_encode($data, JSON_PRETTY_PRINT) . PHP_EOL);
        fwrite($file, 'PAGO: ' . json_encode($payment, JSON_PRETTY_PRINT) . PHP_EOL);
        fwrite($file, 'PAGO PROCESADO: ' . $paymentDataJson . PHP_EOL);

        // Cierra el archivo
        fclose($file);
    } catch (Exception $e) {
        error_log($e->getMessage());
    }
}

// Responde a Mercado Pago con un código 200 OK
http_response_code(200);
