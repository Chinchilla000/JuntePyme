<?php

// Datos recibidos
$requestId = "65488906";
$status = "APPROVED";
$dateString = "2022-03-29T16:43:54-05:00";
$secretKey = "SnZP3D63n3I9dH9O";

// Concatenar los valores para el hash
$stringToHash = "{$requestId}{$status}{$dateString}{$secretKey}";

// Generar la firma calculada usando SHA-1
$computedSignature = sha1($stringToHash);

// Imprimir la cadena concatenada y la firma calculada
echo "String para hash: {$stringToHash}\n";
echo "Firma calculada: {$computedSignature}\n";

// Firma recibida (ejemplo)
$receivedSignature = "c12b9e8b1780effffe2dd6c27f6fe2d67dace6ce";

// Comparar la firma recibida con la firma calculada
if ($receivedSignature === $computedSignature) {
    echo "Firma válida\n";
} else {
    echo "Firma inválida\n";
    echo "Firma recibida: {$receivedSignature}\n";
    echo "Firma calculada: {$computedSignature}\n";
}
?>
