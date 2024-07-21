<?php

/**
 * Integración avanzada de Checkout Pro de Mercado Pago
 * usando el SDK versión 3 para PHP y el SDK JS versión 2
 *
 * @author mroblesdev
 */

// Desactiva la notificación de errores deprecados en PHP
error_reporting(~E_DEPRECATED);

// Carga el autoload de Composer para gestionar dependencias
require_once 'vendor/autoload.php';

// Importa las clases necesarias del SDK de MercadoPago
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

// Agrega credenciales ACCESS_TOKEN
MercadoPagoConfig::setAccessToken("PROD_ACCESS_TOKEN");

// Crea una instancia del cliente de preferencias de MercadoPago
$client = new PreferenceClient();

// Define las URLs de retorno para los diferentes estados de pago
$backUrls = [
    "success" => "https://www.tu-sitio/success",
    "failure" => "http://www.tu-sitio/failure",
    "pending" => "http://www.tu-sitio/pending"
];

// Crea una preferencia de pago con los detalles del producto y otras configuraciones
$preference = $client->create([
    "items" => [
        [ // Primer producto
            "id" => "DEP-0001",
            "title" => "Balon de Futbol",
            "description" => "Balon para jugar futbol", // Opcional
            "picture_url" => "https://codigosdeprogramacion.com/contact/images/paquete.jpg",  // Opcional
            "category_id" => "Deportes",  // Opcional
            "quantity" => 1,
            "currency_id" => "MXN", // Opcional
            "unit_price" => 550
        ],
        [ // Segundo producto
            "id" => "DEP-0002",
            "title" => "Tenis deportivo",
            "quantity" => 1,
            "unit_price" => 1200
        ]
    ],
    // Información del comprador
    "payer" => [
        "name" => "Test",
        "surname" => "User",
        "email" => "your_test_email@example.com",
        "phone" => [
            "area_code" => "11",
            "number" => "4444-4444"
        ],
        "identification" => [
            "type" => "CPF",
            "number" => "19119119100"
        ],
        "address" => [
            "zip_code" => "06233200",
            "street_name" => "Street",
            "street_number" => "123"
        ]
    ],
    // URLs de retorno configuradas anteriormente
    "back_urls" => $backUrls,
    // Configura la redirección automática en caso de que el pago sea aprobado
    "auto_return" => "approved",
    // Modo binario de pago (true significa que solo se aceptan pagos completos y no se permite un estado pendiente)
    "binary_mode" => true,
    // Referencia externa para identificar la transacción en el sistema del vendedor
    "external_reference" => "CDP001",
    // Descripción que aparecerá en el extracto de la tarjeta del comprador
    "statement_descriptor" => "MI TIENDA CDP",
    // Configuración de métodos de pago
    "payment_methods" => [
        // Métodos de pago excluidos (por ejemplo, American Express)
        "excluded_payment_methods" => [
            [
                "id" => "amex"
            ]
        ],
        // Tipos de pago excluidos (por ejemplo, transferencia bancaria)
        "excluded_payment_types" => [
            [
                "id" => "bank_transfer"
            ]
        ],
        // Número máximo de cuotas permitido
        "installments" => 12
    ],
    // Configuración de envíos
    "shipments" => [
        "cost" => 250,
        "mode" => "not_specified",
    ],
]);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mercado Pago Checkout Pro</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="images/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- SDK MercadoPago.js -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <section class="py-2">
        <div class="container px-4 px-lg-5 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="images/paquete.jpg" alt="Balón" /></div>
                <div class="col-md-6">
                    <div class="small mb-1">SKU: DEP-0002</div>
                    <h1 class="display-5 fw-bolder">Tenis deportivos + Balón de Futbol</h1>
                    <div class="fs-5 mb-3">
                        <span>Precio: $1,750.00</span>
                        <br>
                        <small class="text-success">Envío: $250.00</small>
                    </div>
                    <ul>
                        <li>Tenis sport ligeros en un tono azul con blanco profundo son la elección perfecta para aquellos que buscan estilo y rendimiento. </li>
                        <li>Balón de futbol elaborado con altos estándares de calidad, 4 capas que permite mayor duración.
                        </li>
                    </ul>

                    <div class="d-flex">
                        <!-- Contenedor del botón -->
                        <div id="wallet_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Inicializa el objeto MercadoPago con el PUBLIC_KEY
        const mp = new MercadoPago('YOUR_PUBLIC_KEY', {
            locale: 'es-MX'
        });

        // Crea un componente de billetera de MercadoPago en el contenedor con id "wallet_container"
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: '<?php echo $preference->id; ?>',
                redirectMode: 'self'
            },
            customization: {
                texts: {
                    action: "pay",
                    valueProp: 'security_safety',
                },
            },
        });
    </script>
</body>

</html>