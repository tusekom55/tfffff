<?php
// TEST API - Hiç fonksiyon çağırmayan
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Sadece test response döndür
echo json_encode([
    'success' => false,
    'error' => 'No holding found for this symbol',
    'test' => true,
    'api_working' => true
]);
exit;
?>
