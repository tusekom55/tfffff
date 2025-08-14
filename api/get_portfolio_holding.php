<?php
// MINIMAL CLEAN API
ob_start();
error_reporting(0);
ini_set('display_errors', 0);

@session_start();
@include_once '../includes/functions.php';

ob_end_clean();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Simple function check
if (!function_exists('isLoggedIn')) {
    echo '{"success":false,"error":"Functions not loaded"}';
    exit;
}

if (!isLoggedIn()) {
    echo '{"success":false,"error":"User not logged in"}';
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['symbol'])) {
    echo '{"success":false,"error":"Symbol parameter required"}';
    exit;
}

$symbol = $input['symbol'];
$user_id = $_SESSION['user_id'];

$holding = getPortfolioHolding($user_id, $symbol);

if ($holding && isset($holding['quantity']) && $holding['quantity'] > 0) {
    echo json_encode([
        'success' => true,
        'holding' => [
            'symbol' => $holding['symbol'],
            'quantity' => (float)$holding['quantity'],
            'avg_price' => (float)$holding['avg_price'],
            'total_invested' => (float)$holding['total_invested']
        ]
    ]);
} else {
    echo '{"success":false,"error":"No holding found for this symbol"}';
}
?>
