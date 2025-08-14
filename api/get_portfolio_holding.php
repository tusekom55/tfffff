<?php
// STEP BY STEP API BUILD
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    // Step 1: Session
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }
    
    // Step 2: Include functions with error check
    if (!function_exists('isLoggedIn')) {
        require_once '../includes/functions.php';
    }
    
    // Step 3: Login check
    if (!function_exists('isLoggedIn') || !isLoggedIn()) {
        echo json_encode([
            'success' => false,
            'error' => 'User not logged in',
            'step' => 'login_check_failed'
        ]);
        exit;
    }
    
    // Step 4: Get input
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input || !isset($input['symbol'])) {
        echo json_encode([
            'success' => false,
            'error' => 'Symbol parameter required',
            'step' => 'input_validation_failed'
        ]);
        exit;
    }
    
    $symbol = $input['symbol'];
    $user_id = $_SESSION['user_id'];
    
    // Step 5: Portfolio check
    if (function_exists('getPortfolioHolding')) {
        $holding = getPortfolioHolding($user_id, $symbol);
        
        if ($holding && isset($holding['quantity']) && $holding['quantity'] > 0) {
            echo json_encode([
                'success' => true,
                'holding' => [
                    'symbol' => $holding['symbol'],
                    'quantity' => (float)$holding['quantity'],
                    'avg_price' => (float)$holding['avg_price'],
                    'total_invested' => (float)$holding['total_invested']
                ],
                'step' => 'portfolio_found'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'No holding found for this symbol',
                'step' => 'no_holding_found',
                'user_id' => $user_id,
                'symbol' => $symbol
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'getPortfolioHolding function not found',
            'step' => 'function_missing'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Exception: ' . $e->getMessage(),
        'step' => 'exception_caught'
    ]);
} catch (Error $e) {
    echo json_encode([
        'success' => false,
        'error' => 'Fatal Error: ' . $e->getMessage(),
        'step' => 'fatal_error_caught'
    ]);
}
?>
