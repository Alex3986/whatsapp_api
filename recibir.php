// Constantes
define('ACCESS_TOKEN', 'EAAa9J6ZC5RmQBAJujmHUW0xMYp76DDiBv8fmlNfY5niiINw3EjXSzyPZBZA8Fh0NG6gNaUTGctxDvvFkEHV82UG9cbDTt5ZB1shGGXNHROJJSnaUHjSkeYBzfPN3dGcH0IWiI45gL1YKYDWilHUZBoPsboD7NeUd9JsBcP9b0ZB3XcWdH6tq2EnhTGx6XRb5N3lC5KoDuy9V4ZCpdNNFSAcXsBh5gjWZBVIZD');
define('VERIFY_TOKEN', 'AlexChido');
define('CALLBACK_URL', 'https://script.google.com/macros/s/AKfycbw5IlMSUWpmsnIVyTxJT8X5v-LqQ-l6JQ8c2ThYRKyII9W5cHa1BvWm8TdW6ojCm5kKgw/exec');
define('FIELDS', ['telefono', 'nombre', 'mensaje', 'timestamp']);

// Función que se ejecuta cuando se realiza una petición GET
function doGet($e) {
return ContentService::createTextOutput('Hola, este es el webhook de mi app de WhatsApp.');
}

// Función que se ejecuta cuando se realiza una petición POST
function doPost($e) {
if (!isset($e['postData'])) {
// Si no hay postData, devuelve un error o haz algo para manejar esta situación
return;
}

$data = json_decode($e['postData'], true);

// Comprobamos que el token de verificación es correcto
if ($data['object'] == 'page') {
if (isset($data['entry'][0]['messaging'])) {
$messaging = $data['entry'][0]['messaging'][0];
$senderId = $messaging['sender']['id'];
$recipientId = $messaging['recipient']['id'];
$timestamp = $messaging['timestamp'];
$message = $messaging['message'];

php
Copy code
  // Obtenemos la información que nos interesa de cada mensaje
  $telefono = str_replace('whatsapp:', '', $senderId);
  $nombre = $message['from']['name'];
  $mensaje = $message['text'];

  // Creamos un array con la información obtenida
  $info = [
    'telefono' => $telefono,
    'nombre' => $nombre,
    'mensaje' => $mensaje,
    'timestamp' => $timestamp
  ];

  // Imprimimos la información en la consola de Google Apps Script
  console.log($info);
}
}

return ContentService::createTextOutput('Evento recibido');
}
