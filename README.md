# Integración de Mercado Pago Checkout Pro Con PHP y Javascript

Este repositorio contiene ejemplos de integración de Mercado Pago Checkout Pro en PHP y JavaScript. Se divide en dos carpetas: una para la implementación básica y otra para la personalización avanzada.

## Requerimientos 📋

- Cuenta de Mercado Pago y Credenciales
- PHP 8.2 o superior.
  - cURL
  - OpenSSL
  - Certificado SSL
- Composer

## Implementación Básica 💳

La carpeta [integracion-simple](integracion-simple) contiene un ejemplo sencillo de cómo integrar Mercado Pago Checkout Pro en tu sitio web usando PHP y JavaScript.

En el archivo `index.php` agrega tu ACCESS_TOKEN 

```
MercadoPagoConfig::setAccessToken("PROD_ACCESS_TOKEN");
```

También agrega tu PUBLIC_KEY 

```
const mp = new MercadoPago('YOUR_PUBLIC_KEY', {
    locale: 'es-MX'
 });
 ```

![Integracion simple](screenshots/integracion-simple.jpg)

**Link del vídeo:** [https://youtu.be/Otv0sFh10hw](https://youtu.be/Otv0sFh10hw)

## Personalización Avanzada ⚙️

La carpeta [integracion-avanzada](integracion-avanzada) contiene un ejemplo de cómo personalizar Mercado Pago Checkout Pro para mejorar la experiencia del usuario.

![Integracion avanzada](screenshots/integracion-avanzada.jpg)

En el archivo `index.php` agrega tu ACCESS_TOKEN 

```
MercadoPagoConfig::setAccessToken("PROD_ACCESS_TOKEN");
```

También agrega tu PUBLIC_KEY 

```
const mp = new MercadoPago('YOUR_PUBLIC_KEY', {
    locale: 'es-MX'
 });
 ```

**Link del vídeo:** [https://youtu.be/pCYpPqGoUqM](https://youtu.be/pCYpPqGoUqM)

 ## Autores ✒️
- **Marco Robles** - *Desarrollo* - [mroblesdev](https://github.com/mroblesdev)

## Licencia 📄

Este proyecto está bajo la Licencia MIT License - mira el archivo [LICENSE](LICENSE) para más detalles.

## Expresiones de Gratitud 🎁

* Comenta a otros sobre este proyecto 📢
* Invita una cerveza 🍺 o un café ☕ [Da clic aquí](https://www.paypal.com/paypalme/markorobles?locale.x=es_XC.) 
* Da las gracias públicamente 🤓.