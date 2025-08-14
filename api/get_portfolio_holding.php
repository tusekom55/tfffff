<?php
// Error logging - sadece log'a yaz, output'a çıkarma
error_reporting(E_ALL);
ini_set('display_errors', 0);  // Output'a error yazdırma
ini_set('log_errors', 1);      // Log'a yaz

try {
    require_once '../includes/functions.php';
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Failed to load functions: ' . $e->getMessage()
    ]);
    exit();
}

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

try {
    // Session start if needed
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    if (!isLoggedIn()) {
        echo json_encode([
            'success' => false,
            'error' => 'User not logged in'
        ]);
        exit();
    }

    // Get POST data
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['symbol'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Symbol parameter required',
            'debug' => [
                'input' => $input,
                'raw_input' => file_get_contents('php://input')
            ]
        ]);
        exit();
    }
    
    $symbol = $input['symbol'];
    $user_id = $_SESSION['user_id'];
    
    // Debug bilgisi
    $debug_info = [
        'symbol' => $symbol,
        'user_id' => $user_id,
        'session_data' => $_SESSION
    ];
    
    // Get portfolio holding for this symbol
    $holding = getPortfolioHolding($user_id, $symbol);
    
    if ($holding && isset($holding['quantity']) && $holding['quantity'] > 0) {
        echo json_encode([
            'success' => true,
            'holding' => [
                'symbol' => $holding['symbol'],
                'quantity' => (float)$holding['quantity'],
                'avg_price' => (float)$holding['avg_price'],
                'total_invested' => (float)$holding['total_invested'],
                'created_at' => $holding['created_at'] ?? '',
                'updated_at' => $holding['updated_at'] ?? ''
            ],
            'debug' => $debug_info
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'No holding found for this symbol',
            'debug' => array_merge($debug_info, [
                'holding_data' => $holding,
                'holding_exists' => $holding ? true : false
            ])
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ]);
} catch (Error $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Fatal error: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>
