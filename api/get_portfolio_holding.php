<?php
require_once '../includes/functions.php';

// Set content type to JSON
header('Content-Type: application/json');

// Enable CORS if needed
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// Check if user is logged in
if (!isLoggedIn()) {
    echo json_encode([
        'success' => false,
        'error' => 'User not logged in'
    ]);
    exit();
}

try {
    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['symbol'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Symbol parameter required'
        ]);
        exit();
    }
    
    $symbol = $input['symbol'];
    $user_id = $_SESSION['user_id'];
    
    // Get portfolio holding for this symbol
    $holding = getPortfolioHolding($user_id, $symbol);
    
    if ($holding && $holding['quantity'] > 0) {
        echo json_encode([
            'success' => true,
            'holding' => [
                'symbol' => $holding['symbol'],
                'quantity' => (float)$holding['quantity'],
                'avg_price' => (float)$holding['avg_price'],
                'total_invested' => (float)$holding['total_invested'],
                'created_at' => $holding['created_at'],
                'updated_at' => $holding['updated_at']
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No holding found for this symbol'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ]);
}
?>
