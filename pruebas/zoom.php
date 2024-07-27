<?php

// Configuración de la aplicación en el Marketplace de Zoom
$apiKey = 'SkUzIsAZREe68VwbOgZYIQ';
$apiSecret = 'mMlfPweFsUiEBRTKcn6OIpzEI7c33ViOP16U';

// Crear el token JWT
$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
$payload = json_encode(['iss' => $apiKey, 'exp' => strtotime('+30 seconds')]);
$base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
$base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
$signature = hash_hmac('sha256', $base64UrlHeader . '.' . $base64UrlPayload, $apiSecret, true);
$base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
$jwtToken = $base64UrlHeader . '.' . $base64UrlPayload . '.' . $base64UrlSignature;

// Configurar los datos de la reunión
$meetingData = [
    'topic' => 'Mi reunión de ejemplo',
    'type' => 2,
    'start_time' => '2024-03-19T09:00:00Z',
    'duration' => 60,
    'timezone' => 'America/Santiago'
];

// Programar la reunión usando la API de Zoom
$url = 'https://api.zoom.us/v2/users/me/meetings';
$headers = [
    'Authorization: Bearer ' . $jwtToken,
    'Content-Type: application/json'
];

$ch = curl_init($url);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => json_encode($meetingData),
    CURLOPT_RETURNTRANSFER => true
]);
$response = curl_exec($ch);
curl_close($ch);

// Verificar la respuesta
if ($response) {
    $responseData = json_decode($response, true);
    if (isset($responseData['id'])) {
        echo 'Reunión programada exitosamente' . PHP_EOL;
        echo 'ID de reunión: ' . $responseData['id'] . PHP_EOL;
    } else {
        echo 'Error al programar la reunión: ' . $response . PHP_EOL;
    }
} else {
    echo 'Error al realizar la solicitud a la API de Zoom' . PHP_EOL;
}
