<?php

require '../vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

$url = 'http://127.0.0.1:8000/payment/callback';
$data = [
    'status' => [
        'status' => 'APPROVED',
        'date' => '2024-06-17T10:00:00Z'
    ],
    'requestId' => '123456',
    'signature' => 'test_signature'
];

try {
    $response = $client->post($url, [
        'headers' => ['Content-Type' => 'application/json'],
        'json' => $data
    ]);

    echo "Solicitud enviada correctamente: " . $response->getBody();
} catch (Exception $e) {
    echo "Error al enviar la solicitud: " . $e->getMessage();
}
