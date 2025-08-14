<?php
require_once 'includes/functions.php';

// Require login for wallet
requireLogin();

$page_title = t('wallet');
$error = '';
$success = '';

$user_id = $_SESSION['user_id'];

// Handle deposit/withdrawal requests
if ($_POST) {
    if (isset($_POST['deposit'])) {
        $amount = (float)($_POST['amount'] ?? 0);
        $method = $_POST['method'] ?? '';
        $reference = sanitizeInput($_POST['reference'] ?? '');
        
        if ($amount < MIN_DEPOSIT_AMOUNT) {
            $error = getCurrentLang() == 'tr' ? 
                'Minimum para yatırma tutarı ' . MIN_DEPOSIT_AMOUNT . ' TL' : 
                'Minimum deposit amount is ' . MIN_DEPOSIT_AMOUNT . ' TL';
        } elseif (!in_array($method, ['iban', 'papara'])) {
            $error = getCurrentLang() == 'tr' ? 'Geçersiz ödeme yöntemi' : 'Invalid payment method';
        } else {
            $database = new Database();
            $db = $database->getConnection();
            
            $query = "INSERT INTO deposits (user_id, amount, method, reference) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            
            if ($stmt->execute([$user_id, $amount, $method, $reference])) {
                $success = t('deposit_request_sent');
                logActivity($user_id, 'deposit_request', "Amount: $amount TL, Method: $method");
            } else {
                $error = getCurrentLang() == 'tr' ? 'Bir hata oluştu' : 'An error occurred';
            }
        }
    }
    
    if (isset($_POST['withdraw'])) {
        $amount = (float)($_POST['amount'] ?? 0);
        $method = $_POST['method'] ?? '';
        $iban_info = sanitizeInput($_POST['iban_info'] ?? '');
        $papara_info = sanitizeInput($_POST['papara_info'] ?? '');
        
        $balance_tl = getUserBalance($user_id, 'tl');
        
        if ($amount < MIN_WITHDRAWAL_AMOUNT) {
            $error = getCurrentLang() == 'tr' ? 
                'Minimum para çekme tutarı ' . MIN_WITHDRAWAL_AMOUNT . ' TL' : 
                'Minimum withdrawal amount is ' . MIN_WITHDRAWAL_AMOUNT . ' TL';
        } elseif ($amount > $balance_tl) {
            $error = t('insufficient_balance');
        } elseif (!in_array($method, ['iban', 'papara'])) {
            $error = getCurrentLang() == 'tr' ? 'Geçersiz ödeme yöntemi' : 'Invalid payment method';
        } elseif ($method == 'iban' && empty($iban_info)) {
            $error = getCurrentLang() == 'tr' ? 'IBAN bilgisi gerekli' : 'IBAN information required';
        } elseif ($method == 'papara' && empty($papara_info)) {
            $error = getCurrentLang() == 'tr' ? 'Papara bilgisi gerekli' : 'Papara information required';
        } else {
            $database = new Database();
            $db = $database->getConnection();
            
            $query = "INSERT INTO withdrawals (user_id, amount, method, iban_info, papara_info) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            
            if ($stmt->execute([$user_id, $amount, $method, $iban_info, $papara_info])) {
                $success = t('withdrawal_request_sent');
                logActivity($user_id, 'withdrawal_request', "Amount: $amount TL, Method: $method");
            } else {
                $error = getCurrentLang() == 'tr' ? 'Bir hata oluştu' : 'An error occurred';
            }
        }
    }
}

// Get user balances
$balance_tl = getUserBalance($user_id, 'tl');
$balance_usd = getUserBalance($user_id, 'usd');
$balance_btc = getUserBalance($user_id, 'btc');
$balance_eth = getUserBalance($user_id, 'eth');

// Get recent deposits and withdrawals
$database = new Database();
$db = $database->getConnection();

$query = "SELECT * FROM deposits WHERE user_id = ? ORDER BY created_at DESC LIMIT 10";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$deposits = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM withdrawals WHERE user_id = ? ORDER BY created_at DESC LIMIT 10";
$stmt = $db->prepare($query);
$stmt->execute([$user_id]);
$withdrawals = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="container">
    <div class="row">
        <!-- Wallet Overview -->
        <div class="col-12 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h4 class="mb-0"><?php echo t('wallet'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-lira-sign fa-2x text-primary mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatNumber($balance_tl); ?></div>
                                <small class="text-muted">Türk Lirası</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fas fa-dollar-sign fa-2x text-success mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatNumber($balance_usd); ?></div>
                                <small class="text-muted">US Dollar</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fab fa-bitcoin fa-2x text-warning mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatPrice($balance_btc); ?></div>
                                <small class="text-muted">Bitcoin</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="text-center p-3 bg-light rounded">
                                <i class="fab fa-ethereum fa-2x text-info mb-2"></i>
                                <div class="h4 mb-1"><?php echo formatPrice($balance_eth); ?></div>
                                <small class="text-muted">Ethereum</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Deposit/Withdraw Forms -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($success): ?>
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo $success; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Deposit/Withdraw Tabs -->
                    <ul class="nav nav-pills nav-fill mb-3" id="walletTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="deposit-tab" data-bs-toggle="pill" data-bs-target="#deposit" type="button">
                                <i class="fas fa-plus me-1"></i><?php echo t('deposit'); ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdraw-tab" data-bs-toggle="pill" data-bs-target="#withdraw" type="button">
                                <i class="fas fa-minus me-1"></i><?php echo t('withdraw'); ?>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="walletTabsContent">
                        <!-- Deposit Form -->
                        <div class="tab-pane fade show active" id="deposit" role="tabpanel">
                            <form method="POST" action="">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Yatırılacak Tutar' : 'Deposit Amount'; ?></label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" name="amount" step="0.01" 
                                               min="<?php echo MIN_DEPOSIT_AMOUNT; ?>" required>
                                        <span class="input-group-text">TL</span>
                                    </div>
                                    <small class="text-muted">
                                        <?php echo getCurrentLang() == 'tr' ? 'Minimum:' : 'Minimum:'; ?> 
                                        <?php echo MIN_DEPOSIT_AMOUNT; ?> TL
                                    </small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Ödeme Yöntemi' : 'Payment Method'; ?></label>
                                    <select class="form-select" name="method" required>
                                        <option value=""><?php echo getCurrentLang() == 'tr' ? 'Seçiniz' : 'Select'; ?></option>
                                        <option value="iban">IBAN (Banka Havalesi)</option>
                                        <option value="papara">Papara</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label"><?php echo getCurrentLang() == 'tr' ? 'Referans/Açıklama' : 'Reference/Description'; ?></label>
                                    <input type="text" class="form-control" name="reference" 
                                           placeholder="<?php echo getCurrentLang() == 'tr' ? 'İşlem referansı veya açıklama' : 'Transaction reference or description'; ?>">
                                </div>
                                
                                <button type="submit" name="deposit" class="btn btn-success w-100">
                                    <i class="fas fa-plus me-2"></i><?php echo t('deposit'); ?>
                                </button>
                            </form>
                            
                            <!-- Deposit Instructions -->
                            <div class="mt-4 p-3 bg-info bg-opacity-10 border border-info rounded">
                                <h6 class="text-info"><?php echo getCurrentLang() == 'tr' ? 'Para Yatırma Talimatları' : 'Deposit Instructions'; ?></h6>
                                <small class="text-muted">
                                    <strong>IBAN:</strong> TR12 3456 7890 1234 5678 90<br>
                                    <strong>Hesap Adı:</strong> GlobalBorsa Ltd.<br>
                                    <strong>Papara No:</strong> 1234567890<br>
                                    <br>
                                    <?php echo getCurrentLang() == 'tr' ? 
                                        'Havale/EFT açıklama kısmına kullanıcı adınızı yazınız.' : 
                                        'Please include your username in the transfer description.'; ?>
                                </small>
                            </div>
                        </div>
                        
                        <!-- Modern Withdraw Form -->
                        <div class="tab-pane fade" id="withdraw" role="tabpanel">
                            <!-- Withdrawal Method Selection -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <div class="withdraw-method-card active" data-method="bank" onclick="selectWithdrawMethod('bank')">
                                        <div class="text-center p-3">
                                            <i class="fas fa-university fa-2x text-primary mb-2"></i>
                                            <h6>Banka Havalesi</h6>
                                            <small class="text-muted">1-2 iş günü</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="withdraw-method-card" data-method="papara" onclick="selectWithdrawMethod('papara')">
                                        <div class="text-center p-3">
                                            <img src="https://www.papara.com/images/papara-logo.png" alt="Papara" style="height: 32px;" class="mb-2">
                                            <h6>Papara</h6>
                                            <small class="text-muted">Anında işlem</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="withdraw-method-card" data-method="crypto" onclick="selectWithdrawMethod('crypto')">
                                        <div class="text-center p-3">
                                            <i class="fab fa-bitcoin fa-2x text-warning mb-2"></i>
                                            <h6>Kripto Para</h6>
                                            <small class="text-muted">Network ücreti</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form method="POST" action="" id="withdrawForm">
                                <!-- Kullanıcı Bilgileri -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Ad Soyad</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">TC Kimlik No</label>
                                        <input type="text" class="form-control" name="tc_number" pattern="[0-9]{11}" 
                                               placeholder="12345678901" maxlength="11" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Telefon Numarası</label>
                                        <input type="tel" class="form-control" name="phone" 
                                               placeholder="+90 555 123 45 67" required>
                                    </div>
                                </div>

                                <!-- Tutar Seçimi -->
                                <div class="mb-3">
                                    <label class="form-label">Çekilecek Tutar</label>
                                    <div class="input-group">
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustAmount(-10)">-10</button>
                                        <input type="number" class="form-control text-center" name="amount" id="withdrawAmount" 
                                               step="10" min="<?php echo MIN_WITHDRAWAL_AMOUNT; ?>" max="<?php echo $balance_tl; ?>" 
                                               value="<?php echo MIN_WITHDRAWAL_AMOUNT; ?>" required>
                                        <button type="button" class="btn btn-outline-secondary" onclick="adjustAmount(10)">+10</button>
                                        <span class="input-group-text">TL</span>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">
                                            Kullanılabilir: <?php echo formatNumber($balance_tl); ?> TL
                                        </small>
                                        <button type="button" class="btn btn-link btn-sm p-0" onclick="setMaxAmount()">
                                            Tümünü Çek
                                        </button>
                                    </div>
                                </div>

                                <!-- Banka Havalesi Detayları -->
                                <div id="bankDetails" class="withdraw-details">
                                    <h6 class="mb-3">🏦 Banka Seçiniz</h6>
                                    <div class="row g-2 mb-3">
                                        <div class="col-4">
                                            <div class="bank-option" data-bank="ziraat" onclick="selectBank('ziraat')">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Ziraat_Bankas%C4%B1_logo.svg/120px-Ziraat_Bankas%C4%B1_logo.svg.png" alt="Ziraat" class="bank-logo">
                                                <small>Ziraat Bankası</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bank-option" data-bank="akbank" onclick="selectBank('akbank')">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/Akbank_logo.svg/120px-Akbank_logo.svg.png" alt="Akbank" class="bank-logo">
                                                <small>Akbank</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bank-option" data-bank="garanti" onclick="selectBank('garanti')">
                                                <img src="https://upload.wikimedia.org/wikipedia/tr/thumb/4/4b/Garanti_BBVA_logo.svg/120px-Garanti_BBVA_logo.svg.png" alt="Garanti" class="bank-logo">
                                                <small>Garanti BBVA</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bank-option" data-bank="isbank" onclick="selectBank('isbank')">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/0/0e/İş_Bankası_logo.svg/120px-İş_Bankası_logo.svg.png" alt="İş Bankası" class="bank-logo">
                                                <small>İş Bankası</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bank-option" data-bank="vakifbank" onclick="selectBank('vakifbank')">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8a/VakifBank_logo.svg/120px-VakifBank_logo.svg.png" alt="VakıfBank" class="bank-logo">
                                                <small>VakıfBank</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="bank-option" data-bank="halkbank" onclick="selectBank('halkbank')">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/Halkbank_logo.svg/120px-Halkbank_logo.svg.png" alt="Halkbank" class="bank-logo">
                                                <small>Halkbank</small>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="selected_bank" id="selectedBank">
                                    <div class="mb-3">
                                        <label class="form-label">IBAN</label>
                                        <input type="text" class="form-control" name="iban_info" 
                                               placeholder="TR00 0000 0000 0000 0000 0000 00" maxlength="32" required>
                                    </div>
                                </div>

                                <!-- Papara Detayları -->
                                <div id="paparaDetails" class="withdraw-details" style="display: none;">
                                    <h6 class="mb-3">📱 Papara Bilgileri</h6>
                                    <div class="text-center mb-3">
                                        <img src="https://www.papara.com/images/papara-logo.png" alt="Papara" style="height: 60px;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Papara Hesap No</label>
                                        <input type="text" class="form-control" name="papara_info" 
                                               placeholder="1234567890">
                                    </div>
                                </div>

                                <!-- Kripto Para Detayları -->
                                <div id="cryptoDetails" class="withdraw-details" style="display: none;">
                                    <h6 class="mb-3">₿ Kripto Para Seçiniz</h6>
                                    <div class="row g-2 mb-3">
                                        <div class="col-4">
                                            <div class="crypto-option" data-crypto="bitcoin" onclick="selectCrypto('bitcoin')">
                                                <i class="fab fa-bitcoin fa-2x text-warning"></i>
                                                <small>Bitcoin (BTC)</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="crypto-option" data-crypto="ethereum" onclick="selectCrypto('ethereum')">
                                                <i class="fab fa-ethereum fa-2x text-info"></i>
                                                <small>Ethereum (ETH)</small>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="crypto-option" data-crypto="usdt" onclick="selectCrypto('usdt')">
                                                <div class="crypto-logo">₮</div>
                                                <small>Tether (USDT)</small>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="selected_crypto" id="selectedCrypto">
                                    <div class="mb-3">
                                        <label class="form-label">Wallet Adresi</label>
                                        <input type="text" class="form-control" name="crypto_address" 
                                               placeholder="Kripto para cüzdan adresinizi girin">
                                    </div>
                                    <div class="alert alert-warning">
                                        <small>
                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                            Network ücretleri çekim tutarından düşülecektir.
                                        </small>
                                    </div>
                                </div>

                                <input type="hidden" name="method" id="selectedMethod" value="bank">
                                
                                <div class="mb-3">
                                    <div class="alert alert-info">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Para çekme işlemi admin onayı gerektirir. İşlem süresi 1-3 iş günüdür.
                                        </small>
                                    </div>
                                </div>
                                
                                <button type="submit" name="withdraw" class="btn btn-danger w-100" id="withdrawButton">
                                    <i class="fas fa-minus me-2"></i>Para Çek
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transaction History -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><?php echo t('transaction_history'); ?></h5>
                </div>
                <div class="card-body">
                    <!-- History Tabs -->
                    <ul class="nav nav-tabs nav-fill mb-3" id="historyTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="deposits-tab" data-bs-toggle="tab" data-bs-target="#deposits" type="button">
                                <?php echo getCurrentLang() == 'tr' ? 'Para Yatırma' : 'Deposits'; ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="withdrawals-tab" data-bs-toggle="tab" data-bs-target="#withdrawals" type="button">
                                <?php echo getCurrentLang() == 'tr' ? 'Para Çekme' : 'Withdrawals'; ?>
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="historyTabsContent">
                        <!-- Deposits History -->
                        <div class="tab-pane fade show active" id="deposits" role="tabpanel">
                            <?php if (empty($deposits)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-plus-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted">
                                    <?php echo getCurrentLang() == 'tr' ? 'Henüz para yatırma işlemi yok' : 'No deposit history yet'; ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tarih' : 'Date'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tutar' : 'Amount'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Yöntem' : 'Method'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Durum' : 'Status'; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($deposits as $deposit): ?>
                                        <tr>
                                            <td><?php echo date('d.m.Y H:i', strtotime($deposit['created_at'])); ?></td>
                                            <td><?php echo formatNumber($deposit['amount']); ?> TL</td>
                                            <td><?php echo strtoupper($deposit['method']); ?></td>
                                            <td>
                                                <?php
                                                $status_class = $deposit['status'] == 'approved' ? 'success' : 
                                                              ($deposit['status'] == 'rejected' ? 'danger' : 'warning');
                                                ?>
                                                <span class="badge bg-<?php echo $status_class; ?>">
                                                    <?php echo t($deposit['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Withdrawals History -->
                        <div class="tab-pane fade" id="withdrawals" role="tabpanel">
                            <?php if (empty($withdrawals)): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-minus-circle fa-2x text-muted mb-3"></i>
                                <p class="text-muted">
                                    <?php echo getCurrentLang() == 'tr' ? 'Henüz para çekme işlemi yok' : 'No withdrawal history yet'; ?>
                                </p>
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tarih' : 'Date'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Tutar' : 'Amount'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Yöntem' : 'Method'; ?></th>
                                            <th><?php echo getCurrentLang() == 'tr' ? 'Durum' : 'Status'; ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($withdrawals as $withdrawal): ?>
                                        <tr>
                                            <td><?php echo date('d.m.Y H:i', strtotime($withdrawal['created_at'])); ?></td>
                                            <td><?php echo formatNumber($withdrawal['amount']); ?> TL</td>
                                            <td><?php echo strtoupper($withdrawal['method']); ?></td>
                                            <td>
                                                <?php
                                                $status_class = $withdrawal['status'] == 'approved' ? 'success' : 
                                                              ($withdrawal['status'] == 'rejected' ? 'danger' : 'warning');
                                                ?>
                                                <span class="badge bg-<?php echo $status_class; ?>">
                                                    <?php echo t($withdrawal['status']); ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern Wallet Styles -->
<style>
.withdraw-method-card, .bank-option, .crypto-option {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.withdraw-method-card:hover, .bank-option:hover, .crypto-option:hover {
    border-color: #007bff;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.15);
    transform: translateY(-2px);
}

.withdraw-method-card.active, .bank-option.active, .crypto-option.active {
    border-color: #007bff;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.withdraw-method-card.active h6, .withdraw-method-card.active small,
.bank-option.active small, .crypto-option.active small {
    color: white !important;
}

.bank-logo {
    height: 40px;
    width: auto;
    max-width: 80px;
    object-fit: contain;
    margin-bottom: 0.5rem;
}

.bank-option, .crypto-option {
    text-align: center;
    padding: 1rem;
    margin-bottom: 0.5rem;
}

.crypto-logo {
    font-size: 2rem;
    font-weight: bold;
    color: #28a745;
    margin-bottom: 0.5rem;
}

.withdraw-details {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.amount-adjuster {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .withdraw-method-card {
        margin-bottom: 1rem;
    }
    
    .bank-option, .crypto-option {
        padding: 0.75rem;
    }
    
    .bank-logo {
        height: 30px;
    }
}
</style>

<script>
const maxAmount = <?php echo $balance_tl; ?>;
const minAmount = <?php echo MIN_WITHDRAWAL_AMOUNT; ?>;

// Withdrawal method selection
function selectWithdrawMethod(method) {
    // Update UI
    document.querySelectorAll('.withdraw-method-card').forEach(card => {
        card.classList.remove('active');
    });
    document.querySelector(`[data-method="${method}"]`).classList.add('active');
    
    // Show/hide details sections
    document.getElementById('bankDetails').style.display = method === 'bank' ? 'block' : 'none';
    document.getElementById('paparaDetails').style.display = method === 'papara' ? 'block' : 'none';
    document.getElementById('cryptoDetails').style.display = method === 'crypto' ? 'block' : 'none';
    
    // Update hidden field
    document.getElementById('selectedMethod').value = method;
    
    // Update form validation
    updateFormValidation(method);
}

// Bank selection
function selectBank(bank) {
    document.querySelectorAll('.bank-option').forEach(option => {
        option.classList.remove('active');
    });
    document.querySelector(`[data-bank="${bank}"]`).classList.add('active');
    document.getElementById('selectedBank').value = bank;
}

// Crypto selection
function selectCrypto(crypto) {
    document.querySelectorAll('.crypto-option').forEach(option => {
        option.classList.remove('active');
    });
    document.querySelector(`[data-crypto="${crypto}"]`).classList.add('active');
    document.getElementById('selectedCrypto').value = crypto;
}

// Amount adjustment
function adjustAmount(change) {
    const amountInput = document.getElementById('withdrawAmount');
    let currentAmount = parseFloat(amountInput.value) || minAmount;
    let newAmount = currentAmount + change;
    
    // Bounds checking
    if (newAmount < minAmount) newAmount = minAmount;
    if (newAmount > maxAmount) newAmount = maxAmount;
    
    amountInput.value = newAmount;
    updateWithdrawButton();
}

// Set maximum amount
function setMaxAmount() {
    document.getElementById('withdrawAmount').value = maxAmount;
    updateWithdrawButton();
}

// Update withdraw button based on amount
function updateWithdrawButton() {
    const amount = parseFloat(document.getElementById('withdrawAmount').value) || 0;
    const button = document.getElementById('withdrawButton');
    
    if (amount < minAmount) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Minimum ' + minAmount + ' TL';
        button.className = 'btn btn-secondary w-100';
    } else if (amount > maxAmount) {
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Yetersiz Bakiye';
        button.className = 'btn btn-secondary w-100';
    } else {
        button.disabled = false;
        button.innerHTML = '<i class="fas fa-minus me-2"></i>Para Çek (' + amount.toLocaleString('tr-TR') + ' TL)';
        button.className = 'btn btn-danger w-100';
    }
}

// Form validation based on selected method
function updateFormValidation(method) {
    const ibanInput = document.querySelector('input[name="iban_info"]');
    const paparaInput = document.querySelector('input[name="papara_info"]');
    const cryptoAddressInput = document.querySelector('input[name="crypto_address"]');
    
    // Reset all requirements
    [ibanInput, paparaInput, cryptoAddressInput].forEach(input => {
        if (input) input.required = false;
    });
    
    // Set requirements based on method
    switch(method) {
        case 'bank':
            if (ibanInput) ibanInput.required = true;
            break;
        case 'papara':
            if (paparaInput) paparaInput.required = true;
            break;
        case 'crypto':
            if (cryptoAddressInput) cryptoAddressInput.required = true;
            break;
    }
}

// TC Kimlik validation
document.querySelector('input[name="tc_number"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); // Only numbers
    if (this.value.length > 11) {
        this.value = this.value.substring(0, 11);
    }
});

// Phone number formatting
document.querySelector('input[name="phone"]').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, '');
    if (value.startsWith('90')) {
        value = value.substring(2);
    }
    if (value.length > 0) {
        if (value.length <= 3) {
            this.value = '+90 ' + value;
        } else if (value.length <= 6) {
            this.value = '+90 ' + value.substring(0, 3) + ' ' + value.substring(3);
        } else if (value.length <= 8) {
            this.value = '+90 ' + value.substring(0, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6);
        } else {
            this.value = '+90 ' + value.substring(0, 3) + ' ' + value.substring(3, 6) + ' ' + value.substring(6, 8) + ' ' + value.substring(8, 10);
        }
    }
});

// IBAN formatting
document.querySelector('input[name="iban_info"]').addEventListener('input', function() {
    let value = this.value.replace(/\s/g, '').toUpperCase();
    if (!value.startsWith('TR')) {
        value = 'TR' + value.replace(/TR/g, '');
    }
    
    // Format with spaces every 4 characters
    let formatted = '';
    for (let i = 0; i < value.length; i += 4) {
        if (i > 0) formatted += ' ';
        formatted += value.substr(i, 4);
    }
    
    this.value = formatted;
});

// Amount input listener
document.getElementById('withdrawAmount').addEventListener('input', updateWithdrawButton);

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateWithdrawButton();
});

// Legacy method selector (for old form compatibility)
if (document.getElementById('withdrawMethod')) {
    document.getElementById('withdrawMethod').addEventListener('change', function() {
        const method = this.value;
        const ibanInfo = document.getElementById('ibanInfo');
        const paparaInfo = document.getElementById('paparaInfo');
        
        if (method === 'iban') {
            ibanInfo.style.display = 'block';
            paparaInfo.style.display = 'none';
            ibanInfo.querySelector('textarea').required = true;
            paparaInfo.querySelector('input').required = false;
        } else if (method === 'papara') {
            ibanInfo.style.display = 'none';
            paparaInfo.style.display = 'block';
            ibanInfo.querySelector('textarea').required = false;
            paparaInfo.querySelector('input').required = true;
        } else {
            ibanInfo.style.display = 'none';
            paparaInfo.style.display = 'none';
            ibanInfo.querySelector('textarea').required = false;
            paparaInfo.querySelector('input').required = false;
        }
    });
}
</script>

<?php include 'includes/footer.php'; ?>
