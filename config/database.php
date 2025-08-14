<?php
// Database configuration for Hostinger
class Database {
    private $host = 'localhost';
    private $db_name = 'u225998063_hurrra';
    private $username = 'u225998063_seccc';
    private $password = '123456Tubb';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Create database tables
function createTables() {
    $database = new Database();
    $db = $database->getConnection();
    
    // Users table
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        balance_tl DECIMAL(15,2) DEFAULT 0.00,
        balance_usd DECIMAL(15,2) DEFAULT 0.00,
        balance_btc DECIMAL(15,8) DEFAULT 0.00000000,
        balance_eth DECIMAL(15,8) DEFAULT 0.00000000,
        is_admin TINYINT(1) DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $db->exec($query);
    
    // Markets table
    $query = "CREATE TABLE IF NOT EXISTS markets (
        id INT AUTO_INCREMENT PRIMARY KEY,
        symbol VARCHAR(20) NOT NULL,
        name VARCHAR(100) NOT NULL,
        price DECIMAL(15,8) NOT NULL,
        change_24h DECIMAL(10,4) NOT NULL,
        volume_24h DECIMAL(20,2) NOT NULL,
        high_24h DECIMAL(15,8) NOT NULL,
        low_24h DECIMAL(15,8) NOT NULL,
        market_cap DECIMAL(20,2) DEFAULT 0,
        category ENUM('crypto_tl', 'crypto_usd', 'forex') DEFAULT 'crypto_tl',
        logo_url VARCHAR(255),
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $db->exec($query);
    
    // Transactions table
    $query = "CREATE TABLE IF NOT EXISTS transactions (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        type ENUM('buy', 'sell') NOT NULL,
        symbol VARCHAR(20) NOT NULL,
        amount DECIMAL(15,8) NOT NULL,
        price DECIMAL(15,8) NOT NULL,
        total DECIMAL(15,2) NOT NULL,
        fee DECIMAL(15,2) DEFAULT 0.00,
        status ENUM('pending', 'completed', 'cancelled') DEFAULT 'completed',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $db->exec($query);
    
    // Deposits table
    $query = "CREATE TABLE IF NOT EXISTS deposits (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        amount DECIMAL(15,2) NOT NULL,
        method ENUM('iban', 'papara') NOT NULL,
        reference VARCHAR(100),
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        admin_note TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        processed_at TIMESTAMP NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $db->exec($query);
    
    // Withdrawals table
    $query = "CREATE TABLE IF NOT EXISTS withdrawals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        amount DECIMAL(15,2) NOT NULL,
        method ENUM('iban', 'papara') NOT NULL,
        iban_info TEXT,
        papara_info VARCHAR(100),
        status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
        admin_note TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        processed_at TIMESTAMP NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $db->exec($query);
    
    // Activity logs table
    $query = "CREATE TABLE IF NOT EXISTS activity_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        action VARCHAR(100) NOT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";
    $db->exec($query);
    
    // System parameters table
    $query = "CREATE TABLE IF NOT EXISTS system_parameters (
        parameter_name VARCHAR(50) PRIMARY KEY,
        parameter_value VARCHAR(255) NOT NULL,
        description TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $db->exec($query);
    
    // Insert default parameters
    $query = "INSERT IGNORE INTO system_parameters (parameter_name, parameter_value, description) VALUES 
              ('trading_currency', '1', 'Base trading currency: 1=TL, 2=USD'),
              ('usdtry_rate', '27.45', 'Current USD/TRY exchange rate'),
              ('rate_last_update', '0', 'Last exchange rate update timestamp')";
    $db->exec($query);
    
    // Check if is_admin column exists, if not add it
    $query = "SHOW COLUMNS FROM users LIKE 'is_admin'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $column_exists = $stmt->fetch();
    
    if (!$column_exists) {
        $query = "ALTER TABLE users ADD COLUMN is_admin TINYINT(1) DEFAULT 0";
        $db->exec($query);
        echo "Added is_admin column to users table.<br>";
    }
    
    // Insert sample admin user
    $query = "INSERT IGNORE INTO users (username, email, password, is_admin, balance_tl) 
              VALUES ('admin', 'admin@exchange.com', ?, 1, 1000000.00)";
    $stmt = $db->prepare($query);
    $stmt->execute([password_hash('admin123', PASSWORD_DEFAULT)]);
    
    echo "Database tables created successfully!";
}
?>
