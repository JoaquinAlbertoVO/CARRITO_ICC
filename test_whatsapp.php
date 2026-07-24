<?php

/**
 * SCRIPT DE PRUEBA: Meta Cloud API (WhatsApp)
 * Instrucciones:
 * 1. Pon tu número de celular personal (con código de país, ej: 51999999999) en $celular_destino.
 * 2. Abre este archivo en tu navegador (ej: http://localhost/CARRITO/test_whatsapp.php).
 * 3. Revisa tu WhatsApp, ¡deberías recibir el mensaje "hello_world" de Meta!
 */

// 1. TU NÚMERO DE CELULAR (Debe estar registrado en "Paso 1. Probar" en la web de Meta)
$celular_destino = "51912010934"; // Ej: "51999999999" (Sin el +)

// 2. TUS CREDENCIALES (Copiadas del paso anterior)
$token_meta = "EAAVxfGCeEeoBR3OWIQgmjr1MgnZBBSFfIDhqfhVmArIdgzY2ZAxWSoehUBQ4NMV5ArnYasVZCfFZBcjQTri1i7mVjFaZC3gjzoDGa0dqyiOOVPXpj0MESiLdyj6JQKQf4DwZC5j70NBPQS51a8Up30S8mfJDJML6GFi07P72ZAOcra9yDZAokSs4qmZC9VoiaBcdz14mtsUwbPPL16SCZAGjnMGie0HqKBoJVVQhZCcQUcP7PKhuOpRwIEipXpf0aECpt1XhZCZBxxGYFOKozjJZBUE2oZCO7TJgpMZD";
$phone_number_id = "1201135759751770";

// URL oficial de Meta Graph API
$url_meta = "https://graph.facebook.com/v19.0/" . $phone_number_id . "/messages";

// El cuerpo del mensaje. Por defecto, Meta aprueba una plantilla llamada "hello_world" para pruebas.
$data = [
    "messaging_product" => "whatsapp",
    "to" => $celular_destino,
    "type" => "template",
    "template" => [
        "name" => "hello_world",
        "language" => [
            "code" => "en_US" // El hello_world por defecto viene en inglés
        ]
    ]
];

// Iniciamos la petición cURL
$ch = curl_init($url_meta);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer " . $token_meta,
    "Content-Type: application/json"
]);

// Ejecutamos y capturamos respuesta
$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Mostramos el resultado en pantalla
echo "<h1>Prueba de WhatsApp - Meta Cloud API</h1>";
if ($httpcode == 200) {
    echo "<h2 style='color:green;'>¡Petición enviada con éxito! (Código 200)</h2>";
    echo "<p>Revisa tu celular, debería haberte llegado un mensaje de WhatsApp.</p>";
} else {
    echo "<h2 style='color:red;'>Hubo un problema enviando el mensaje (Código $httpcode)</h2>";
}

echo "<h3>Respuesta detallada de Meta:</h3>";
echo "<pre style='background:#f4f4f4; padding:10px; border-radius:5px;'>" . json_encode(json_decode($response), JSON_PRETTY_PRINT) . "</pre>";

?>
