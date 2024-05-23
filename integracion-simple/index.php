<?php

/**
 * Integración básica de Checkout Pro de Mercado Pago
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

// Crea una preferencia de pago con los detalles del producto y otras configuraciones
$preference = $client->create([
    "items" => [
        [
            "id" => "DEP-0001",
            "title" => "Balon de Futbol",
            "quantity" => 1,
            "unit_price" => 550
        ]
    ],

    // Descripción que aparecerá en el extracto de la tarjeta del comprador
    "statement_descriptor" => "MI TIENDA",

    // Referencia externa para identificar la transacción en el sistema del vendedor
    "external_reference" => "CDP001",
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
    <link href="css/styles.css" rel="stylesheet" />

    <!-- SDK MercadoPago.js -->
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>

<body>
    <section class="py-2">
        <div class="container px-4 px-lg-5 my-3">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="images/balon.jpg" alt="Balón" /></div>
                <div class="col-md-6">
                    <div class="small mb-1">SKU: DEP-0001</div>
                    <h1 class="display-5 fw-bolder">Balón de Futbol</h1>
                    <div class="fs-5 mb-5">
                        <span>$550.00</span>
                    </div>
                    <p class="lead">Elaborado con altos estándares de calidad, 4 capas que permite mayor duración.</p>
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